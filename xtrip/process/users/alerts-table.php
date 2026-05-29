<?php
// Database connection - adjust path as necessary
require_once '../../config/conn.php';

// Define your web root for building absolute URLs
$web_root = '/ltaw_final/';

// Include utility functions, especially format_timestamp()
// Adjust include path as per your folder structure
// Make sure this file contains the format_timestamp() function
$functions_path = '../../global-includes/page-titles.php'; 
if (file_exists($functions_path)) {
    include_once $functions_path;
} else {
    // If missing, define a simple fallback for format_timestamp()
    function format_timestamp($timestamp) {
        return date('Y-m-d H:i:s', strtotime($timestamp));
    }
}

// Retrieve user_id securely from GET
$user_id = $_GET['user_id'] ?? null;
if (!$user_id) {
    echo '<tr><td colspan="5" class="text-danger">Error: Invalid request - User ID missing</td></tr>';
    exit;
}

// Prepare SQL to select events with current tripwire status and product info
$sql = "
SELECT te.*, ltwo.tripwire_status AS current_status, ltwp.product_name
FROM tripwire_events_tbl te
LEFT JOIN laser_tripwire_owners_tbl ltwo ON te.device_id = ltwo.device_id
LEFT JOIN laser_tripwire_products_tbl ltwp ON ltwp.device_id = te.device_id
WHERE ltwo.owner = :user_id
ORDER BY te.event_time DESC
";

$get_alerts = $conn->prepare($sql);
$get_alerts->execute([':user_id' => $user_id]);

// Output table rows
if ($get_alerts->rowCount() > 0) :
    while ($alert_data = $get_alerts->fetch(PDO::FETCH_ASSOC)) :

        // Image handling (fallback)
        $captured_image = $alert_data['captured_image'] ?? '';
        if (empty($captured_image) || 
            !file_exists($_SERVER['DOCUMENT_ROOT'] . $web_root . $captured_image)) {
            $image_to_show = $web_root . 'uploads/no-preview-img.jpg';
        } else {
            $image_to_show = $web_root . $captured_image;
        }

        // Get current tripwire status (Safe / Detected)
        $tripwire_status = $alert_data['current_status'] ?? 'Unknown';
        $badge_class = ($tripwire_status === 'Safe') ? 'badge bg-success' : 'badge bg-danger';

        // Escape outputs
        $device_id = htmlspecialchars($alert_data['device_id'] ?? '');
        $product_name = htmlspecialchars($alert_data['product_name'] ?? 'Unknown Device');
        $event_time = htmlspecialchars(format_timestamp($alert_data['event_time'] ?? ''));

        ?>

        <tr>
            <td>
                <img 
                    src="<?php echo htmlspecialchars($image_to_show); ?>" 
                    class="rounded-circle" 
                    alt="Captured Image" 
                    width="40" 
                    height="40" 
                    data-bs-toggle="modal" 
                    data-bs-target="#capturedImageView" 
                    onclick="setModalImage('<?php echo htmlspecialchars($image_to_show); ?>')"
                >
            </td>
            <td class="fw-bold"><?php echo $device_id; ?></td>
            <td><?php echo $product_name; ?></td>
            <td><?php echo $event_time; ?></td>
            <td><span class="<?php echo $badge_class; ?>"><?php echo htmlspecialchars($tripwire_status); ?></span></td>
        </tr>

    <?php
    endwhile;
else :
    ?>
    <tr>
        <td colspan="5" class="text-center">No Tripwire Events Found</td>
    </tr>
<?php
endif;
?>