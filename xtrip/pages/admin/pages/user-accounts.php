<main class="main" id="main">

    <?php
        include_once "../global-includes/page-titles.php";
    ?>

    <div class="row">

        <div class="col-12 col-lg-12 col-xxl-12 d-flex">


            <div class="card flex-fill">

                <div class="card-header bg-dark">
                    <h5 class="card-title mb-0 text-white fs-4 py-3 px-1"> User Accounts </h5>
                </div>

                <table class="table table-hover my-0 text-center datatable custom-table">

                    <thead>
                        <tr>
                            <th> Profile Picture </th>
                            <th> Name </th>
                            <th> Email Address </th>
                            <th> Address </th>
                            <th> Owned Laser Tripwire </th>
                            <th> Details </th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php
                        $get_user_accounts = $conn->prepare("SELECT
                                                                        ua.*, ui.*, 
                                                                        COUNT(o.device_id) AS 'owned_tripwire'
                                                                    FROM user_accounts_tbl ua
                                                                    LEFT JOIN user_info_tbl ui
                                                                    ON ua.user_id = ui.user_id
                                                                    LEFT JOIN laser_tripwire_owners_tbl o
                                                                    ON ua.user_id = o.owner
                                                                    WHERE ua.verified_account = :verified
                                                                    GROUP BY ua.user_id
                                                                    ORDER BY created_at DESC     
                                                                    ");
                        $get_user_accounts->execute([":verified" => "Yes"]);

                        if ($get_user_accounts->rowCount() > 0) {
                            while ($user_data = $get_user_accounts->fetch()) {
                                $user_profile_picture = $user_data["profile_picture"];

                                if (empty($user_profile_picture) || !file_exists($image_path . $user_profile_picture)) {
                                    $user_profile_picture = "default-img.png";
                                }
                        ?>
                                <tr>
                                    <td>
                                        <img src="<?php echo htmlspecialchars($image_path . $user_profile_picture); ?>" class="rounded-circle" alt="User Profile Picture" width="40" height="40">
                                    </td>

                                    <td class="fw-bold">
                                        <?php echo htmlspecialchars($user_data["first_name"] . " " . $user_data["last_name"]);; ?>
                                    </td>

                                    <td class="fw-bold">
                                        <?php echo htmlspecialchars($user_data["email_address"]); ?>
                                    </td>

                                    <td>
                                        <?php echo htmlspecialchars($user_data["address"]); ?>
                                    </td>

                                    <td>
                                        <?php echo htmlspecialchars($user_data["owned_tripwire"]); ?>
                                    </td>

                                    <td>
                                        <button class="btn btn-outline-dark btn-sm" title="User Details" data-bs-target="#user-account-<?php echo htmlspecialchars($user_data["user_id"]); ?>" data-bs-toggle="modal">
                                            <i class="bi bi-person-circle"></i>
                                        </button>
                                    </td>
                                </tr>

                                <!-- Modal -->
                                <div class="modal fade" id="user-account-<?php echo htmlspecialchars($user_data["user_id"]); ?>" tabindex="-1" aria-labelledby="viewAccountLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                                        <div class="modal-content">

                                            <!-- Header -->
                                            <div class="modal-header bg-dark text-white">
                                                <h5 class="modal-title" id="viewAccountLabel">Account Information</h5>
                                                <span class="ms-auto small">User ID: <?php echo htmlspecialchars($user_data["user_id"]); ?></span>
                                                <button type="button" class="btn-close ms-2 fs-1" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>

                                            <!-- Body -->
                                            <div class="modal-body">
                                                <div class="container-fluid">

                                                    <div class="row mb-4 mt-3">

                                                        <!-- Profile Picture -->
                                                        <div class="col-md-3 text-center">
                                                            <img src="<?php echo htmlspecialchars($image_path . $user_profile_picture); ?>"
                                                                alt="Profile Picture"
                                                                class="img-fluid rounded-circle border"
                                                                width="180" height="180">
                                                        </div>

                                                        <!-- User Info -->
                                                        <div class="col-md-9">
                                                            <div class="row g-3">

                                                                <div class="col-md-4">
                                                                    <label class="form-label"> First Name </label>
                                                                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($user_data["first_name"]); ?>" readonly>
                                                                </div>

                                                                <div class="col-md-4">
                                                                    <label class="form-label"> Middle Name </label>
                                                                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($user_data["middle_name"]); ?>" readonly>
                                                                </div>

                                                                <div class="col-md-4">
                                                                    <label class="form-label"> Last Name </label>
                                                                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($user_data["last_name"]); ?>" readonly>
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <label class="form-label"> Email Address </label>
                                                                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($user_data["email_address"]); ?>" readonly>
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <label class="form-label"> User ID </label>
                                                                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($user_data["user_id"]); ?>" readonly>
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <label class="form-label"> Gender </label>
                                                                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($user_data["gender"]); ?>" readonly>
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <label class="form-label"> Address </label>
                                                                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($user_data["address"]); ?>" readonly>
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <label class="form-label"> Phone Number </label>
                                                                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($user_data["cellphone_number"]); ?>" readonly>
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <label class="form-label"> Telephone Number </label>
                                                                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($user_data["telephone_number"]); ?>" readonly>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                            <!-- Footer -->
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan="6"> No Accounts Data </td>
                            </tr>
                        <?php
                        }
                        ?>

                    </tbody>

                </table>

            </div>


        </div>

    </div>
    
</main>