<main class="main" id="main">

    <?php
    include_once "../global-includes/page-titles.php";
    ?>

    <div class="row">

        <div class="col-12 col-lg-12 col-xxl-12 d-flex">


            <div class="card flex-fill">

                <div class="card-header bg-dark">
                    <h5 class="card-title mb-0 text-white fs-4 py-3 px-1"> Email Inquiries </h5>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover my-0 text-center datatable custom-table">

                        <thead>
                            <tr>
                                <th> Name </th>
                                <th> Email Address </th>
                                <th> Phone Number </th>
                                <th> Type of Service </th>
                                <th> Status </th>
                                <th> Inquired At </th>
                                <th> Updated At </th>
                                <th> Appointment Date </th>
                                <th> Update </th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php
                            $get_inquiries = $conn->prepare("SELECT
                                                                        *
                                                                    FROM inquiries_tbl
                                                                    WHERE inquire_status != :inquire_status
                                                                    ORDER BY FIELD(inquire_status, 'Pending', 'In Progress'), updated_at DESC
                                                                        ");
                            $get_inquiries->execute([":inquire_status" => "Completed"]);

                            if ($get_inquiries->rowCount() > 0) {
                                while ($inquiry_data = $get_inquiries->fetch()) {

                                    if (!empty($inquiry_data["appointment_date"] && !empty($inquiry_data["appointment_time"]))) {
                                        $appointment_schedule = format_date($inquiry_data["appointment_date"]) . ", " . format_time($inquiry_data["appointment_time"]);
                                    } else {
                                        $appointment_schedule = "No Set";
                                    }

                            ?>
                                    <tr>

                                        <td class="fw-bold">
                                            <?php echo htmlspecialchars($inquiry_data["full_name"]); ?>
                                        </td>

                                        <td>
                                            <?php echo htmlspecialchars($inquiry_data["email_address"]); ?>
                                        </td>

                                        <td>
                                            <?php echo htmlspecialchars($inquiry_data["phone_number"]); ?>
                                        </td>

                                        <td>
                                            <?php echo htmlspecialchars($inquiry_data["service_type"]); ?>
                                        </td>

                                        <td>
                                            <?php
                                            if ($inquiry_data["inquire_status"] === "Pending") {
                                            ?>
                                                <span class="badge bg-warning">
                                                    <?php echo htmlspecialchars($inquiry_data["inquire_status"]); ?>
                                                </span>
                                            <?php
                                            } else {
                                            ?>
                                                <span class="badge bg-primary">
                                                    <?php echo htmlspecialchars($inquiry_data["inquire_status"]); ?>
                                                </span>
                                            <?php
                                            }
                                            ?>
                                        </td>

                                        <td>
                                            <?php echo htmlspecialchars(format_timestamp($inquiry_data["inquired_at"])); ?>
                                        </td>

                                        <td>
                                            <?php echo htmlspecialchars(format_timestamp($inquiry_data["inquired_at"])); ?>
                                        </td>

                                        <td>
                                            <?php echo htmlspecialchars($appointment_schedule); ?>
                                        </td>

                                        <td>
                                            <?php
                                            if ($inquiry_data["inquire_status"] === "Pending") {
                                            ?>
                                                <button class="btn btn-outline-primary btn-sm" title="Update Status" data-bs-target="#update-inquiry-<?php echo htmlspecialchars($inquiry_data["inquiry_id"]); ?>" data-bs-toggle="modal">
                                                    <i class="bi bi-pencil-square"></i>
                                                </button>
                                            <?php
                                            } else {
                                            ?>
                                                <button class="btn btn-outline-success btn-sm" title="View Appointment Details" data-bs-target="#view-details-<?php echo htmlspecialchars($inquiry_data["inquiry_id"]); ?>" data-bs-toggle="modal">
                                                    <i class="bi bi-info-circle"></i>
                                                </button>
                                            <?php
                                            }
                                            ?>

                                        </td>
                                    </tr>

                                    <!-- Update Modal -->
                                    <div class="modal fade" id="update-inquiry-<?php echo htmlspecialchars($inquiry_data["inquiry_id"]); ?>" tabindex="-1" aria-labelledby="updateInquiryLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-centered">
                                            <div class="modal-content">

                                                <!-- Header -->
                                                <div class="modal-header bg-dark text-white">
                                                    <h5 class="modal-title" id="updateInquiryLabel"> Update Inquiry Status </h5>
                                                    <span class="ms-auto small">Inquiry ID: <?php echo htmlspecialchars($inquiry_data["inquiry_id"]); ?></span>
                                                    <button type="button" class="btn-close ms-2 fs-1" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>

                                                <!-- Body -->
                                                <form action="../../process/admin/inquire-management.php" method="POST">
                                                    <div class="modal-body">

                                                        <input type="hidden" name="inquiry-id" value="<?php echo htmlspecialchars(base64_encode($inquiry_data["inquiry_id"])); ?>">

                                                        <div class="row mb-2">

                                                            <h5 class="fs-5 mb-2 fw-bold"> User Contact Information (Update if needed): </h5>

                                                            <div class="col-lg-6 col-md-12">
                                                                <label for="phone_number" class="mb-1"> Phone Number: </label>

                                                                <div class="input-group mb-3">
                                                                    <span class="input-group-text">
                                                                        <i class="bi bi-phone-fill"></i>
                                                                    </span>

                                                                    <input type="text" class="form-control" placeholder="Phone Number" id="phone_number"
                                                                        name="phone-number"
                                                                        value="<?php echo htmlspecialchars($inquiry_data["phone_number"]); ?>"
                                                                        required>

                                                                </div>
                                                            </div>

                                                            <div class="col-lg-6 col-md-12">
                                                                <label for="user_address" class="mb-1"> Full Address: </label>

                                                                <div class="input-group mb-3">
                                                                    <span class="input-group-text">
                                                                        <i class="bi bi-phone-fill"></i>
                                                                    </span>

                                                                    <input type="text" class="form-control" placeholder="Full Address" id="user_address"
                                                                        name="address"
                                                                        value="<?php echo htmlspecialchars($inquiry_data["full_address"]); ?>"
                                                                        required>

                                                                </div>
                                                            </div>

                                                        </div>

                                                        <div class="row mb-2">

                                                            <h5 class="fs-5 mb-2 fw-bold"> Appointment Date and Time: </h5>

                                                            <div class="col-lg-6 col-md-12">
                                                                <label for="date" class="mb-1"> Appointment Date: </label>

                                                                <div class="input-group mb-3">
                                                                    <span class="input-group-text">
                                                                        <i class="bi bi-calendar-date"></i>
                                                                    </span>

                                                                    <input type="date" class="form-control" placeholder="Appointment Date" id="date"
                                                                        min="<?php echo htmlspecialchars(date('Y-m-d', strtotime('+1 day'))); ?>"
                                                                        name="appointment-date" required>

                                                                </div>
                                                            </div>

                                                            <div class="col-lg-6 col-md-12">
                                                                <label for="time" class="mb-1"> Appointment Time: </label>

                                                                <div class="input-group mb-3">
                                                                    <span class="input-group-text">
                                                                        <i class="bi bi-clock"></i>
                                                                    </span>

                                                                    <input type="time" class="form-control" placeholder="Appointment Time" id="time"
                                                                        name="appointment-time" required>

                                                                </div>
                                                            </div>

                                                        </div>

                                                        <div class="row mb-2">
                                                            <div class="col-lg-12">
                                                                <button class="btn btn-primary w-100" type="submit" name="set-appointment">
                                                                    Set Appointment
                                                                </button>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </form>

                                                <!-- Footer -->
                                                <div class="modal-footer">

                                                    <form action="../../process/admin/inquire-management.php" method="POST" id="delete-inquiry">

                                                        <input type="hidden" name="inquiry-id" value="<?php echo htmlspecialchars(base64_encode($inquiry_data["inquiry_id"])); ?>">
                                                        <input type="hidden" name="delete-inquiry" value="1">

                                                        <button type="submit" 
                                                            class="btn btn-danger" 
                                                            title="Delete Inquiry"
                                                            onclick="confirmAction(
                                                                event,
                                                                this.form,
                                                                'delete-inquiry',
                                                                'Delete Inquiry?',
                                                                'warning',
                                                                'Are you sure do you want to delete this inquiry/appointment?',
                                                                'Delete',
                                                                '#dc3545'
                                                            )"
                                                            >
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>

                                                    <button type="button" class="btn btn-secondary" title="Close" data-bs-dismiss="modal">
                                                        <i class="bi bi-x-lg"></i>
                                                    </button>

                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <!-- View Details Modal -->
                                    <div class="modal fade" id="view-details-<?php echo htmlspecialchars($inquiry_data["inquiry_id"]); ?>" tabindex="-1" aria-labelledby="updateInquiryLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-centered">
                                            <div class="modal-content">

                                                <!-- Header -->
                                                <div class="modal-header bg-dark text-white">
                                                    <h5 class="modal-title" id="updateInquiryLabel"> Appointment Details </h5>
                                                    <span class="ms-auto small">Inquiry ID: <?php echo htmlspecialchars($inquiry_data["inquiry_id"]); ?></span>
                                                    <button type="button" class="btn-close ms-2 fs-1" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>

                                                <form action="../../process/admin/inquire-management.php" method="POST" id="mark-as-done-inquiry">
                                                    <div class="modal-body">

                                                        <input type="hidden" name="inquiry-id" value="<?php echo htmlspecialchars(base64_encode($inquiry_data["inquiry_id"])); ?>">
                                                        <input type="hidden" name="mark-as-done" value="1">

                                                        <div class="row mb-2">

                                                            <h5 class="fs-5 mb-2 fw-bold"> User Contact Information: </h5>

                                                            <div class="col-lg-6 col-md-12">
                                                                <label for="phone_number" class="mb-1"> Phone Number: </label>

                                                                <div class="input-group mb-3">
                                                                    <span class="input-group-text">
                                                                        <i class="bi bi-phone-fill"></i>
                                                                    </span>

                                                                    <input type="text" class="form-control" placeholder="Phone Number" id="phone_number" value="<?php echo htmlspecialchars($inquiry_data["phone_number"]); ?>" readonly disabled>

                                                                </div>
                                                            </div>

                                                            <div class="col-lg-6 col-md-12">
                                                                <label for="user_address" class="mb-1"> Full Address: </label>

                                                                <div class="input-group mb-3">
                                                                    <span class="input-group-text">
                                                                        <i class="bi bi-phone-fill"></i>
                                                                    </span>

                                                                    <input type="text" class="form-control" placeholder="Full Address" id="user_address" value="<?php echo htmlspecialchars($inquiry_data["full_address"]); ?>" readonly disabled>

                                                                </div>
                                                            </div>

                                                        </div>

                                                        <div class="row mb-2">

                                                            <h5 class="fs-5 mb-2 fw-bold"> Appointment Date and Time: </h5>

                                                            <div class="col-lg-6 col-md-12">
                                                                <label for="date" class="mb-1"> Appointment Date: </label>

                                                                <div class="input-group mb-3">
                                                                    <span class="input-group-text">
                                                                        <i class="bi bi-calendar-date"></i>
                                                                    </span>

                                                                    <input type="text" class="form-control" placeholder="Appointment Date" id="date" value="<?php echo htmlspecialchars(format_date($inquiry_data["appointment_date"])); ?>" readonly disabled>

                                                                </div>
                                                            </div>

                                                            <div class="col-lg-6 col-md-12">
                                                                <label for="time" class="mb-1"> Appointment Time: </label>

                                                                <div class="input-group mb-3">
                                                                    <span class="input-group-text">
                                                                        <i class="bi bi-clock"></i>
                                                                    </span>

                                                                    <input type="text" class="form-control" placeholder="Appointment Time" id="time" value="<?php echo htmlspecialchars(format_time($inquiry_data["appointment_time"])); ?>" readonly disabled>

                                                                </div>
                                                            </div>

                                                        </div>

                                                        <div class="row mb-2">
                                                            <div class="col-lg-12">
                                                                <button type="submit" 
                                                                class="btn btn-success w-100" 
                                                                title="Delete Inquiry"
                                                                onclick="confirmAction(
                                                                    event,
                                                                    this.form,
                                                                    'mark-as-done-inquiry',
                                                                    'Mark as Done Inquiry?',
                                                                    'warning',
                                                                    'Are you sure do you want to mark as done this inquiry/appointment?',
                                                                    'Mark as Done',
                                                                    '#198754'
                                                                )"
                                                                >
                                                                    Mark as Done
                                                                </button>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </form>

                                                <!-- Footer -->
                                                <div class="modal-footer">

                                                    <form action="../../process/admin/inquire-management.php" method="POST" id="delete-inquiry">

                                                        <input type="hidden" name="inquiry-id" value="<?php echo htmlspecialchars(base64_encode($inquiry_data["inquiry_id"])); ?>">
                                                        <input type="hidden" name="delete-inquiry" value="1">

                                                        <button type="submit" 
                                                            class="btn btn-danger" 
                                                            title="Delete Inquiry"
                                                            onclick="confirmAction(
                                                                event,
                                                                this.form,
                                                                'delete-inquiry',
                                                                'Delete Inquiry?',
                                                                'warning',
                                                                'Are you sure do you want to delete this inquiry/appointment?',
                                                                'Delete',
                                                                '#dc3545'
                                                            )"
                                                            >
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>

                                                    <button type="button" class="btn btn-secondary" title="Close" data-bs-dismiss="modal">
                                                        <i class="bi bi-x-lg"></i>
                                                    </button>

                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                <?php
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="8"> No Inquiries </td>
                                </tr>
                            <?php
                            }
                            ?>

                        </tbody>

                    </table>
                </div>

            </div>


        </div>

        <div class="col-12 col-lg-12 col-xxl-12 d-flex">


            <div class="card flex-fill">

                <div class="card-header bg-dark">
                    <h5 class="card-title mb-0 text-white fs-4 py-3 px-1"> Completed Appointments </h5>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover my-0 text-center datatable custom-table">

                        <thead>
                            <tr>
                                <th> Name </th>
                                <th> Email Address </th>
                                <th> Phone Number </th>
                                <th> Address </th>
                                <th> Type of Service </th>
                                <th> Status </th>
                                <th> Appointment Date </th>
                                <th> Completed At </th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php
                            $get_inquiries = $conn->prepare("SELECT
                                                                        *
                                                                    FROM inquiries_tbl
                                                                    WHERE inquire_status = :inquire_status
                                                                    ORDER BY updated_at DESC
                                                                        ");
                            $get_inquiries->execute([":inquire_status" => "Completed"]);

                            if ($get_inquiries->rowCount() > 0) {
                                while ($inquiry_data = $get_inquiries->fetch()) {

                                    $appointment_schedule = format_date($inquiry_data["appointment_date"]) . ", " . format_time($inquiry_data["appointment_time"]);

                            ?>
                                    <tr>

                                        <td class="fw-bold">
                                            <?php echo htmlspecialchars($inquiry_data["full_name"]); ?>
                                        </td>

                                        <td>
                                            <?php echo htmlspecialchars($inquiry_data["email_address"]); ?>
                                        </td>

                                        <td>
                                            <?php echo htmlspecialchars($inquiry_data["phone_number"]); ?>
                                        </td>

                                        <td>
                                            <?php echo htmlspecialchars($inquiry_data["full_address"]); ?>
                                        </td>

                                        <td>
                                            <?php echo htmlspecialchars($inquiry_data["service_type"]); ?>
                                        </td>

                                        <td> 
                                            <span class="badge bg-success">
                                                <?php echo htmlspecialchars($inquiry_data["inquire_status"]); ?>
                                            </span>
                                        </td>

                                        <td>
                                            <?php echo htmlspecialchars($appointment_schedule); ?>
                                        </td>

                                        <td>
                                            <?php echo htmlspecialchars(format_timestamp($inquiry_data["updated_at"])); ?>
                                        </td>

                                    </tr>

                                <?php
                                }
                            } 
                            
                            else {
                                ?>
                                <tr>
                                    <td colspan="8"> No Completed Inquiries </td>
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