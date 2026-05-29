<?php
    require_once "config/conn.php";

    if(!isset($_GET["reset-token"]) || !isset($_GET["user-id"])) {
        header("Location: index.php");
        exit();
    }

    else {
        $reset_token = htmlspecialchars(trim($_GET["reset-token"]));
        $user_id = htmlspecialchars(trim($_GET["user-id"]));

        $check_token_expiry = $conn->prepare("SELECT * FROM user_accounts_tbl WHERE reset_password_token = :token AND user_id = :user_id LIMIT 1");
        $check_token_expiry->execute([
            ":token" => $reset_token,
            ":user_id" => $user_id
        ]);

        if($check_token_expiry->rowCount() === 1) {
            $token_data = $check_token_expiry->fetch(PDO::FETCH_OBJ);

            if(strtotime($token_data->password_token_expiry) > time()) {
                $full_name = $token_data->first_name . " " . $token_data->last_name;
                $link_expiry = $token_data->password_token_expiry;
            }

            else {
                header("Location: index.php");
                exit();
            }
        }

        else {
            header("Location: index.php");
            exit();
        }
    }
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title> LTAS | Laser Tripwire System </title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500&family=Roboto:wght@500;700;900&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">


    <!-- Libraries Stylesheet -->
    <link href="assets/landing-page/lib/animate/animate.min.css" rel="stylesheet">
    <link href="assets/landing-page/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="assets/landing-page/lib/lightbox/css/lightbox.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="assets/landing-page/css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="assets/landing-page/css/style.css" rel="stylesheet">
    <link href="assets/landing-page/css/custom-style.css" rel="stylesheet">
</head>

<body>

    <!-- Main -->

    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">

        <div class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">

            <div class="d-flex align-items-center justify-content-center w-100">

                <div class="row justify-content-center w-100">
                    <div class="col-md-8 col-lg-6 col-xxl-3">
                        <div class="card mb-0">

                            <div class="card-body">

                                <a href="" class="text-nowrap logo-img text-center d-block py-3 w-100">
                                    <img src="assets/landing-page/img/carousel-3.jpg" width="180" alt="Logo">
                                </a>

                                <h5 class="text-center text-dark p-3"> Reset User Password </h5>

                                <form action="process/users/user-auth.php" method="POST" class="text-dark">

                                    <input type="hidden" name="user-id" value="<?php echo htmlspecialchars($user_id); ?>">
                                    <input type="hidden" name="reset-token" value="<?php echo htmlspecialchars($reset_token); ?>">

                                    <div class="mb-3">

                                        <p class="mb-0" style="font-size: 13px;">
                                            Reset Password for: <strong><?php echo htmlspecialchars($full_name); ?></strong>
                                        </p>

                                        <p class="mb-0" style="font-size: 13px;">
                                            The link will expire at: 
                                            <strong>
                                                <?php echo htmlspecialchars(date("M. d, Y, h:i:s A", strtotime($link_expiry))); ?>
                                            </strong>
                                        </p>
                                    </div>

                                    <hr>

                                    <!-- Password -->
                                    <div class="mb-3">

                                        <label for="password" class="form-label"> Password: </label>

                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="bi bi-key-fill"></i>
                                            </span>
                                            <input type="password" class="form-control reset-password" id="password" name="password" placeholder="Enter password"pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,16}$" title="Password must be 8–16 characters long, and include at least 1 uppercase letter, 1 lowercase letter, 1 digit, and 1 special character." required>
                                        </div>

                                    </div>

                                    <!-- Confirm Password -->
                                    <div class="mb-4">

                                        <label for="confirm_password" class="form-label"> Confirm Password: </label>

                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="bi bi-key"></i>
                                            </span>
                                            <input type="password" class="form-control reset-password" id="confirm_password" name="confirm-password" placeholder="Re-enter password" required>
                                        </div>

                                    </div>


                                    <div class="d-flex align-items-center justify-content-between mb-4">

                                        <div class="form-check">
                                            <input class="form-check-input primary" type="checkbox" id="show-passwords" onclick="togglePasswords('reset-password')">
                                            <label class="form-check-label text-dark" for="show-passwords">
                                                Show Password
                                            </label>
                                        </div>

                                    </div>

                                    <input type="submit" name="reset-password" value="Reset Password" class="btn btn-primary w-100 btn-sm mb-2 py-2 rounded-2 custom-confirm-button">

                                </form>

                            </div>

                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- End Main -->

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>

    <script src="assets/landing-page/lib/wow/wow.min.js"></script>
    <script src="assets/landing-page/lib/easing/easing.min.js"></script>
    <script src="assets/landing-page/lib/waypoints/waypoints.min.js"></script>
    <script src="assets/landing-page/lib/counterup/counterup.min.js"></script>
    <script src="assets/landing-page/lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="assets/landing-page/lib/isotope/isotope.pkgd.min.js"></script>
    <script src="assets/landing-page/lib/lightbox/js/lightbox.min.js"></script>

    <!-- Template Javascript -->
    <script src="assets/landing-page/js/main.js"></script>
    <script src="assets/global/js/passwords.js"></script>

    <!-- SweetAlert CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <?php if (isset($_SESSION["alert-status"]) && $_SESSION["alert-status"] !== ""): ?>
        <script>
            const notification = <?php echo $_SESSION["alert-status"]; ?>;
            Swal.fire({
                icon: notification.icon || 'info',
                title: notification.title || '',
                text: notification.text || '',
                showConfirmButton: false,
                timer: 3000
            });
        </script>

        <?php unset($_SESSION["alert-status"]); ?>
    <?php endif; ?>

</body>

</html>