<?php 
require_once __DIR__ . '/../config/conn.php';

header("Content-Type: application/json");

// Allow only POST method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['status'=>'error', 'message'=>'Method Not Allowed. Use POST']);
    exit;
}

// Helper function to send JSON response and exit
function sendResponse($status, $message, $extra = [], $httpCode = null) {
    if ($httpCode === null) {
        $httpCode = $status === "success" ? 200 : 400;
    }
    http_response_code($httpCode);
    echo json_encode(array_merge(["status" => $status, "message" => $message], $extra));
    exit;
}

try {
    if (empty($_POST['device_id']) || empty($_POST['event_time'])) {
        sendResponse("error", "Missing required fields (device_id, event_time).");
    }

    $device_id = trim($_POST['device_id']);
    $event_time = trim($_POST['event_time']);

    if (!strtotime($event_time)) {
        sendResponse("error", "Invalid event_time format.");
    }

    if (!isset($_FILES['captured_image']) || $_FILES['captured_image']['error'] !== UPLOAD_ERR_OK) {
        sendResponse("error", "Image upload failed or missing file.");
    }

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mimeType = $finfo->file($_FILES['captured_image']['tmp_name']);
    if ($mimeType !== 'image/jpeg') {
        sendResponse("error", "Invalid image format. Only JPEG images allowed.");
    }

    $uploadsDir = __DIR__ . '/../uploads/captured-images/';
    if (!file_exists($uploadsDir) && !mkdir($uploadsDir, 0777, true)) {
        sendResponse("error", "Failed to create upload directory.");
    }

    $checkDevice = $conn->prepare("SELECT device_id FROM laser_tripwire_products_tbl WHERE device_id = ?");
    $checkDevice->execute([$device_id]);
    if ($checkDevice->rowCount() == 0) {
        sendResponse("error", "Device ID not found. Please register the device first.");
    }

    $timestamp = date("Y-m-d_H-i-s");
    $randomSuffix = bin2hex(random_bytes(4));
    $filename = "laser_tripwire_{$device_id}_{$timestamp}_{$randomSuffix}.jpeg";
    $targetFilePath = $uploadsDir . $filename;

    if (!move_uploaded_file($_FILES['captured_image']['tmp_name'], $targetFilePath)) {
        sendResponse("error", "Failed to save uploaded image.");
    }

    $relativePath = 'uploads/captured-images/' . $filename;

    $insertEvent = $conn->prepare("
        INSERT INTO tripwire_events_tbl (device_id, event_time, captured_image)
        VALUES (?, ?, ?)
    ");
    $insertEvent->execute([$device_id, $event_time, $relativePath]);

    sendResponse("success", "Image uploaded successfully.", ["file_path" => $relativePath]);

} catch (Exception $e) {
    sendResponse("error", "Exception: " . $e->getMessage());
}
?>