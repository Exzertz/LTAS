<main class="main" id="main">

    <?php
    include_once "../global-includes/page-titles.php";
    ?>

    <section class="section dashboard">

        <div class="row">

            <div class="col-xl-12 col-xxl-12 d-flex card p-3">

                <h5 class="card-title fs-3"> My Devices </h5>

                <div class="w-100">

                    <div class="row">

                        <?php
                        $my_devices = $conn->prepare("SELECT * FROM laser_tripwire_owners_tbl WHERE owner = :user_id ORDER BY registered_at DESC");
                        $my_devices->execute([":user_id" => $user_id]);

                        if ($my_devices->rowCount() > 0) {
                            while ($device_data = $my_devices->fetch()) {
                                $tripwire_status = $device_data["tripwire_status"];

                                if ($tripwire_status === "Safe") {
                                    $bg_color = "bg-success";
                                } else {
                                    $bg_color = "bg-danger";
                                }
                        ?>

                                <div class="col-xxl-4 col-md-6">

                                    <div class="card info-card <?php echo htmlspecialchars($bg_color); ?> text-white">

                                        <div class="card-body">
                                            <h5 class="card-title text-white"> <?php echo htmlspecialchars($device_data["device_id"]); ?> </h5>

                                            <div class="d-flex align-items-center">

                                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-light text-dark">
                                                    <i class="bi bi-hdd-network"></i>
                                                </div>

                                                <div class="ps-3 d-flex justify-content-between gap-5">

                                                    <div class="container">
                                                        <span class="small pt-2 ps-1 text-white"> Status </span>
                                                        <h6 class="text-white"> <?php echo htmlspecialchars($tripwire_status); ?> </h6>
                                                    </div>

                                                    <div class="container d-flex align-items-center">

                                                        <?php
                                                        if ($tripwire_status === "Detected"):
                                                        ?>
                                                            <form action="../../process/users/device-management.php" method="POST" id="set-tripwire-status">
                                                                <input type="hidden" name="device-id" value="<?php echo htmlspecialchars(base64_encode($device_data["device_id"])); ?>">
                                                                <input type="hidden" name="turn-off-device" value="1">

                                                                <button
                                                                    type="submit"
                                                                    class="btn btn-outline-light rounded-circle btn-lg"
                                                                    onclick="confirmAction(
                                                                        event, 
                                                                        this.form, 
                                                                        'set-tripwire-status',
                                                                        'Turn Off Alert?', 
                                                                        'warning',
                                                                        'Are you sure you want to turn off alert of this device: <?php echo htmlspecialchars($device_data['device_id']); ?>?',
                                                                        'Turn Off',
                                                                        '#dc3545'
                                                                        )"
                                                                    title="Turn Off">
                                                                    <i class="bi bi-power"></i>
                                                                </button>
                                                            </form>
                                                        <?php
                                                        endif;
                                                        ?>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            <?php
                            }
                        } else {
                            ?>
                            <h5> No Devices Installed. </h1>
                            <?php
                        }
                            ?>

                    </div>

                </div>

            </div>

        </div>

        <div class="row">

            <div class="col-12 col-lg-12 col-xxl-12 d-flex">


                <div class="card flex-fill">

                    <div class="card-header bg-dark">
                        <h5 class="card-title mb-0 text-white fs-4 py-3 px-1"> Recent Alerts </h5>
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

                </div>


            </div>

        </div>

    </section>

</main>