<main class="main" id="main">

    <?php
    include_once "../global-includes/page-titles.php";
    ?>

    <section class="section dashboard">

        <div class="row">

            <div class="col-xl-12 col-xxl-12 d-flex">

                <div class="w-100">

                    <div class="row">

                        <div class="col-xxl-4 col-md-6">

                            <a href="home.php?page=user-accounts">

                                <div class="card info-card sales-card">

                                    <div class="card-body">
                                        <h5 class="card-title"> User Accounts </span></h5>

                                        <div class="d-flex align-items-center">

                                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                <i class="bi bi-person-check"></i>
                                            </div>

                                            <div class="ps-3">

                                                <h6> <?php echo htmlspecialchars($users_count); ?> </h6>
                                                <span class="text-muted small pt-2 ps-1"> Verified Accounts </span>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </a>

                        </div>

                        <div class="col-xxl-4 col-md-6">

                            <a href="home.php?page=inquiries">

                                <div class="card info-card customers-card">

                                    <div class="card-body">
                                        <h5 class="card-title"> Emailed Inquiries </span></h5>

                                        <div class="d-flex align-items-center">

                                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                <i class="bi bi-envelope-check"></i>
                                            </div>

                                            <div class="ps-3">

                                                <h6> <?php echo htmlspecialchars($inquiry_count); ?> </h6>
                                                <span class="text-muted small pt-2 ps-1"> Incomplete Inquiries </span>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </a>

                        </div>

                        <div class="col-xxl-4 col-md-6">

                            <a href="home.php?page=laser-tripwire">

                                <div class="card info-card sales-card">

                                    <div class="card-body">
                                        <h5 class="card-title"> Laser Tripwire </span></h5>

                                        <div class="d-flex align-items-center">

                                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                <i class="bi bi-box-seam"></i>
                                            </div>

                                            <div class="ps-3">

                                                <h6> <?php echo htmlspecialchars($ltw_count); ?> </h6>
                                                <span class="text-muted small pt-2 ps-1"> Total Products </span>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </a>

                        </div>

                    </div>

                </div>

            </div>

            <!-- <div class="col-xl-6 col-md-12">

                <a href="home.php?page=user-accounts">

                    <div class="card flex-fill w-100">

                        <div class="card-header">

                            <h5 class="card-title mb-0 text-dark"> User Occupations Chart </h5>

                        </div>

                        <div class="card-body py-3">

                            <div class="chart chart-sm">

                                <canvas id="user-occupations-chart"></canvas>

                            </div>

                        </div>

                    </div>

                </a>

            </div>

            <div class="col-xl-6 col-md-12">

                <a href="home.php?page=user-accounts">

                    <div class="card flex-fill w-100">

                        <div class="card-header">

                            <h5 class="card-title mb-0 text-dark"> User Gender Chart </h5>

                        </div>

                        <div class="card-body py-3">

                            <div class="chart chart-sm">

                                <canvas id="user-gender-chart"></canvas>

                            </div>

                        </div>

                    </div>

                </a>

            </div> -->

        </div>

        <div class="row">

            <a href="home.php?page=inquiries">

                <div class="col-12 col-lg-12 col-xxl-12 d-flex">


                    <div class="card flex-fill">

                        <div class="card-header bg-dark">
                            <h5 class="card-title mb-0 text-white fs-4 py-3 px-1"> Inquiries Today </h5>
                        </div>

                        <table class="table table-hover my-0 text-center align-center datatable custom-table">

                            <thead>
                                <tr>
                                    <th> Name </th>
                                    <th> Email Address </th>
                                    <th> Address </th>
                                    <th> Phone Number </th>
                                    <th> Type of Service </th>
                                    <th> Status </th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $get_inquiries = $conn->prepare("SELECT
                                                                    *
                                                                FROM inquiries_tbl
                                                                WHERE inquire_status = :inquire_status AND DATE(inquired_at) = CURDATE()
                                                                ORDER BY inquired_at DESC
                                                                    ");
                                $get_inquiries->execute([":inquire_status" => "Pending"]);

                                if ($get_inquiries->rowCount() > 0) {
                                    while ($inquiry_data = $get_inquiries->fetch()) {

                                ?>
                                        <tr>

                                            <td class="fw-bold">
                                                <?php echo htmlspecialchars($inquiry_data["full_name"]); ?>
                                            </td>

                                            <td class="fw-bold">
                                                <?php echo htmlspecialchars($inquiry_data["email_address"]); ?>
                                            </td>

                                            <td>
                                                <?php echo htmlspecialchars($inquiry_data["full_address"]); ?>
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

                                        </tr>

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

            </a>

        </div>

    </section>

</main>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // User Occupations Chart (Doughnut)
        new Chart(document.getElementById("user-occupations-chart"), {
            type: "pie",
            data: {
                labels: ["Employed", "Self-Employed", "Student", "Unemployed", "Others"],
                datasets: [{
                    label: "Users",
                    data: [45, 25, 80, 10, 5],
                    backgroundColor: [
                        "#0d6efd", // blue
                        "#6610f2", // purple
                        "#198754", // green
                        "#ffc107", // yellow
                        "#dc3545" // red
                    ],
                    hoverOffset: 10
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false
                    },
                    title: {
                        display: true,
                        text: 'User Occupations'
                    }
                }
            }
        });

        // User Gender Chart (Doughnut)
        new Chart(document.getElementById("user-gender-chart"), {
            type: "pie",
            data: {
                labels: ["Male", "Female", "Others"],
                datasets: [{
                    label: "Users",
                    data: [65, 55, 3],
                    backgroundColor: [
                        "#0d6efd", // blue
                        "#e83e8c", // pink
                        "#6c757d" // gray
                    ],
                    hoverOffset: 10
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false
                    },
                    title: {
                        display: true,
                        text: 'User Gender'
                    }
                }
            }
        });
    });
</script>