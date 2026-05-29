<?php
require_once '../../config/conn.php'; // adjust path to your DB connection

header('Content-Type: application/json');

// Read JSON body
$raw = file_get_contents('php://input');
$data = json_decode($raw, true);

// --- DEBUG: log every request ---
file_put_contents(__DIR__ . '/debug.log', date('Y-m-d H:i:s') . ' ' . $raw . PHP_EOL, FILE_APPEND);

if (!isset($data['device_id']) || !isset($data['tripwire_status'])) {
    http_response_code(400);
    echo json_encode(['message' => 'Missing fields']);
    exit;
}

$device_id       = trim($data['device_id']);       // remove spaces
$tripwire_status = trim($data['tripwire_status']); // remove spaces
$event_time      = date('Y-m-d H:i:s');

try {
    // INSERT ... ON DUPLICATE KEY UPDATE with unique placeholders
    $stmt = $conn->prepare("
        INSERT INTO tripwire_events_tbl (device_id, tripwire_status, event_time)
        VALUES (:device_id, :tripwire_status, :event_time)
        ON DUPLICATE KEY UPDATE
            tripwire_status = :tripwire_status_upd,
            event_time = :event_time_upd
    ");

    $stmt->execute([
        ':device_id'            => $device_id,
        ':tripwire_status'      => $tripwire_status,
        ':event_time'           => $event_time,
        ':tripwire_status_upd'  => $tripwire_status,
        ':event_time_upd'       => $event_time
    ]);

    echo json_encode(['message' => 'Inserted/Updated']);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['message' => 'DB Error: ' . $e->getMessage()]);
}
