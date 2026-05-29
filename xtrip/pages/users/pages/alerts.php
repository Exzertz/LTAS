<main class="main" id="main">
    <?php
    include_once "../global-includes/page-titles.php";

    // Define your web root relative URL for building absolute paths
    $web_root = '/ltaw_final/';
    $uploads_folder = 'uploads/captured-images/';

    // Assuming $conn and $user_id are properly initialized here
    $get_alerts = $conn->prepare("
        SELECT 
            te.*,
            ltwo.tripwire_status AS current_status,
            ltwp.product_name
        FROM tripwire_events_tbl te
        LEFT JOIN laser_tripwire_owners_tbl ltwo ON te.device_id = ltwo.device_id
        LEFT JOIN laser_tripwire_products_tbl ltwp ON ltwp.device_id = te.device_id
        WHERE ltwo.owner = :user_id
        ORDER BY te.event_time DESC
    ");
    $get_alerts->execute([":user_id" => $user_id]);
    ?>

    <div class="row">
        <div class="col-12 col-lg-12 col-xxl-12 d-flex">
            <div class="card flex-fill">
                <div class="card-header bg-dark">
                    <h5 class="card-title mb-0 text-white fs-4 py-3 px-1"> Tripwire Alerts </h5>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover my-0 text-center align-center datatable custom-table">
                        <thead>
                            <tr>
                                <th> Captured Image </th>
                                <th> Device ID </th>
                                <th> Device Name </th>
                                <th> Date and Time </th>
                                <th> Tripwire Status </th>
                            </tr>
                        </thead>

                        <tbody>
                                <?php
                                $get_alerts = $conn->prepare("SELECT 
                                                                        te.*, ltwo.*, ltwp.*
                                                                    FROM tripwire_events_tbl te
                                                                    LEFT JOIN laser_tripwire_owners_tbl ltwo 
                                                                    ON te.device_id = ltwo.device_id
                                                                    LEFT JOIN laser_tripwire_products_tbl ltwp
                                                                    ON ltwp.device_id = te.device_id
                                                                    WHERE ltwo.owner = :user_id
                                                                    ORDER BY te.event_time DESC
                                                                        ");
                                $get_alerts->execute([":user_id" => $user_id]);

                                if ($get_alerts->rowCount() > 0) {
                                    while ($alert_data = $get_alerts->fetch()) {                               

                                        $captured_image = $alert_data["captured_image"];
                                        $tripwire_status = $alert_data["tripwire_status"];

                                        if (empty($captured_image) || !file_exists("../../" . $captured_image)) {
                                            $captured_image = "no-preview-img.jpg";
                                        }

                                        if ($tripwire_status === "Safe") {
                                            $badge = "badge bg-success";
                                        } else {
                                            $badge = "badge bg-danger";
                                        }

                                ?>
                                        <tr>

                                            <td>
                                                <img
                                                    src="../../<?php echo htmlspecialchars($captured_image); ?>"
                                                    class="rounded-circle"
                                                    alt="Captured Image"
                                                    width="40" height="40"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#capturedImageView"
                                                    onclick="setModalImage('../../<?php echo htmlspecialchars($captured_image); ?>')">
                                            </td>

                                            <!-- Image Modal -->
                                            <div class="modal fade" id="capturedImageView" tabindex="-1" aria-hidden="true">

                                                <div class="modal-dialog modal-md modal-dialog-centered">

                                                    <div class="modal-content bg-transparent border-0">

                                                        <button type="button" class="btn-close btn-close-white ms-auto me-2 mt-2" data-bs-dismiss="modal" aria-label="Close"></button>

                                                        <img
                                                            class="img-fluid rounded"
                                                            id="capturedImage"
                                                            alt="Captured Image">

                                                    </div>

                                                </div>
                                            </div>

                                            <script>
                                                function setModalImage(src) {
                                                    document.getElementById('capturedImage').src = src;
                                                }
                                            </script>

                                            <td class="fw-bold">
                                                <?php echo htmlspecialchars($alert_data["device_id"]); ?>
                                            </td>

                                            <td>
                                                <?php echo htmlspecialchars($alert_data["product_name"]); ?>
                                            </td>

                                            <td>
                                                <?php echo htmlspecialchars(format_timestamp($alert_data["event_time"])); ?>
                                            </td>

                                            <td>
                                                <span class="<?php echo htmlspecialchars($badge); ?>">
                                                    <?php echo htmlspecialchars($tripwire_status); ?>
                                                </span>
                                            </td>

                                        </tr>

                                    <?php
                                    }
                                } else {
                                    ?>
                                    <tr>
                                        <td colspan="5"> No Tripwire Events </td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                    </table>
                </div>

                <!-- Image Modal (outside table to persist through refreshes) -->
                <div class="modal fade" id="capturedImageView" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-md modal-dialog-centered">
                        <div class="modal-content bg-transparent border-0">
                            <button type="button" class="btn-close btn-close-white ms-auto me-2 mt-2" data-bs-dismiss="modal" aria-label="Close"></button>
                            <img class="img-fluid rounded" id="capturedImage" alt="Captured Image">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function setModalImage(src) {
            document.getElementById('capturedImage').src = src;
        }

        function refreshTable() {
            fetch('/ltaw_final/process/users/alerts-table.php?user_id=<?php echo $user_id; ?>&timestamp=' + new Date().getTime())
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.text();
                })
                .then(html => {
                    document.querySelector("table tbody").innerHTML = html;
                    // Reset modal image to avoid stale data
                    document.getElementById('capturedImage').src = '';
                })
                .catch(error => {
                    console.error('Error refreshing table:', error);
                });
        }

        // Refresh every 10 seconds
        setInterval(refreshTable, 10000);
    </script>
</main>
