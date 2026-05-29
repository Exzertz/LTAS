<main class="main" id="main">

    <?php
    include_once "../global-includes/page-titles.php";
    ?>

    <div class="row">

        <div class="col-12 col-lg-12 col-xxl-12 d-flex">


            <div class="card flex-fill">

                <div class="card-header bg-dark ">
                    <h5 class="card-title mb-0 text-white fs-4 py-3 px-1 d-flex justify-content-between">
                        My Devices

                        <button class="btn btn-outline-light" data-bs-toggle="modal" data-bs-target="#add-new-device">
                            <i class="bi bi-plus"></i> Add New Device
                        </button>
                    </h5>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover my-0 text-center datatable custom-table">

                        <thead>
                            <tr>
                                <th> Tripwire Location </th>
                                <th> Device ID </th>
                                <th> Product Name </th>
                                <th> Model Name </th>
                                <th> Version </th>
                                <th> Description </th>
                                <th> Installed At </th>
                                <th> Action </th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php
                            $get_devices = $conn->prepare("SELECT
                                                                        ltwp.*,
                                                                        ltwo.*
                                                                    FROM laser_tripwire_products_tbl ltwp
                                                                    LEFT JOIN laser_tripwire_owners_tbl ltwo
                                                                    ON ltwp.device_id = ltwo.device_id
                                                                    WHERE ltwo.owner = :user_id
                                                                    ORDER BY ltwo.registered_at DESC
                                                                    ");
                            $get_devices->execute([":user_id" => $user_id]);

                            if ($get_devices->rowCount() > 0) {
                                while ($device_data = $get_devices->fetch()) {
                                    
                                    $tripwire_location = $device_data["device_location"];

                                    if (empty($tripwire_location) || !file_exists($tripwire_location_path . $tripwire_location)) {
                                        $tripwire_location = "no-preview-img.jpg";
                                    }

                            ?>
                                    <tr>

                                        <td>
                                            <img
                                                src="<?php echo htmlspecialchars($tripwire_location_path . $tripwire_location); ?>"
                                                class="rounded-circle"
                                                alt="Tripwire Location"
                                                width="40" height="40"
                                                data-bs-toggle="modal"
                                                data-bs-target="#tripwireLocationView"
                                                onclick="setModalImage('<?php echo htmlspecialchars($tripwire_location_path . $tripwire_location); ?>')">
                                        </td>

                                        <!-- Image Modal -->
                                        <div class="modal fade" id="tripwireLocationView" tabindex="-1" aria-hidden="true">

                                            <div class="modal-dialog modal-md modal-dialog-centered">

                                                <div class="modal-content bg-transparent border-0">

                                                    <button type="button" class="btn-close btn-close-white ms-auto me-2 mt-2" data-bs-dismiss="modal" aria-label="Close"></button>

                                                    <img
                                                        class="img-fluid rounded"
                                                        id="tripwireLocation"
                                                        alt="Tripwire Location">

                                                </div>

                                            </div>
                                        </div>

                                        <script>
                                            function setModalImage(src) {
                                                document.getElementById('tripwireLocation').src = src;
                                            }
                                        </script>

                                        <td class="fw-bold">
                                            <?php echo htmlspecialchars($device_data["device_id"]); ?>
                                        </td>

                                        <td>
                                            <?php echo htmlspecialchars($device_data["product_name"]); ?>
                                        </td>

                                        <td>
                                            <?php echo htmlspecialchars($device_data["model_name"]); ?>
                                        </td>

                                        <td>
                                            <?php echo htmlspecialchars($device_data["version"]); ?>
                                        </td>

                                        <td>
                                            <?php echo htmlspecialchars($device_data["description"] ?? "N/A"); ?>
                                        </td>

                                        <td>
                                            <?php echo htmlspecialchars(format_timestamp($device_data["registered_at"])); ?>
                                        </td>

                                        <td>
                                            <form action="../../process/users/device-management.php" method="POST" id="remove-device-form">
                                                <input type="hidden" name="device-id" value="<?php echo htmlspecialchars(base64_encode($device_data["device_id"])); ?>">
                                                <input type="hidden" name="remove-device" value="1">

                                                <button
                                                    type="submit"
                                                    class="btn btn-danger btn-sm"
                                                    onclick="confirmAction(
                                                    event, 
                                                    this.form, 
                                                    'remove-device-form',
                                                    'Remove Device?', 
                                                    'warning',
                                                    'Are you sure you want to remove this device: <?php echo htmlspecialchars($device_data['product_name']); ?>?',
                                                    'Delete',
                                                    '#dc3545'
                                                    )"
                                                    title="Delete Product">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </td>

                                    </tr>     

                                <?php
                                }
                            } 
                            
                            else {
                                ?>
                                <tr>
                                    <td colspan="8"> No Install Devices </td>
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

</main>

<!-- Modal -->
<div class="modal fade" id="add-new-device" tabindex="-1" aria-labelledby="addDeviceModal">

    <div class="modal-dialog modal-md modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header bg-secondary text-white">
                <h5 class="modal-title fw-bold" id="addDeviceModal"> Add New Device </h5>
                <button type="button" class="btn-close p-3" style="transform: scale(2);" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Form Start -->
            <form action="../../process/users/device-management.php" method="POST" enctype="multipart/form-data" autocomplete="off">

                <div class="modal-body">

                    <div class="container-fluid">

                        <!-- Image Preview -->
                        <div class="mb-3 text-center">
                            <img id="img-preview" src="<?php echo htmlspecialchars($tripwire_location_path . "no-preview-img.jpg"); ?>" alt="Image Preview"
                                class="img-fluid rounded border" style="max-height: 180px; object-fit: cover;">
                        </div>

                        <!-- Image Upload -->
                        <div class="mb-3">
                            <label for="upload-pic" class="form-label"> Tripwire Location Image(Optional): </label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-image"></i></span>
                                <input class="form-control" type="file" id="upload-item-pic" name="location-image" accept="image/*">
                            </div>
                        </div>

                        <!-- Device ID -->
                        <div class="row mb-3">

                            <div class="col-md-12">
                                <label for="deviceId" class="form-label"> Device ID: </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-cpu"></i></span>
                                    <input type="text" class="form-control" id="deviceId" name="device-id" placeholder="Enter Device ID" required>
                                </div>
                            </div>

                        </div>


                    </div>

                </div>

                <!-- Footer -->
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success custom-add-btn" name="add-new-device">
                        <i class="bi bi-plus-circle me-1"></i> Add Device
                    </button>

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> Cancel </button>
                </div>

            </form>
            <!-- Form End -->

        </div>

    </div>

</div>
<!-- End Modal -->

<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById('upload-item-pic').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const preview = document.getElementById('img-preview');
            if (file) {
                preview.src = URL.createObjectURL(file);
            }
        });
    })
</script>