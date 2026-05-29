<?php
    require_once "../../config/conn.php";
    require_once "../../config/mailer.php";
    require_once "../../config/checkers.php";

    // Login
    if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["admin-login"])) {
        $email_address = filter_var($_POST["email-address"], FILTER_SANITIZE_EMAIL);
        $password = htmlspecialchars(trim($_POST["password"]));

        if(empty($email_address) || empty($password)) {
            $_SESSION["alert-status"] = json_encode([
                "icon" => "error",
                "title" => "Missing Fields!",
                "text" => "Please fill out the required fields! Please try again."
            ]);

            header("Location: ../../index.php");
            exit();
        }

        else if(!filter_var($email_address, FILTER_VALIDATE_EMAIL)) {
            $_SESSION["alert-status"] = json_encode([
                "icon" => "error",
                "title" => "Invalid Email Address!",
                "text" => "Invalid email address format! Please try again."
            ]);

            header("Location: ../../index.php");
            exit();
        }

        else {
            try {
                $conn->beginTransaction();

                $check_account = $conn->prepare("SELECT * FROM admin_accounts_tbl WHERE email_address = :email_address LIMIT 1");
                $check_account->execute([":email_address" => $email_address]);

                if($check_account->rowCount() === 1) {
                    $account_details = $check_account->fetch(PDO::FETCH_OBJ);

                    if(password_verify($password, $account_details->admin_password)) {

                        $admin_id = $account_details->admin_id;

                        $conn->commit();

                        $_SESSION["admin-id"] = $admin_id;
                        header("Location: ../../pages/admin/home.php");
                        exit();
                    }

                    else {
                        $_SESSION["alert-status"] = json_encode([
                            "icon" => "error",
                            "title" => "Invalid Account!",
                            "text" => "Invalid email address or password! Please try again."
                        ]);

                        header("Location: ../../index.php");
                        exit();
                    }
                }

                else {
                    $_SESSION["alert-status"] = json_encode([
                        "icon" => "error",
                        "title" => "Invalid Account!",
                        "text" => "Invalid email address or password! Please try again."
                    ]);

                    header("Location: ../../index.php");
                    exit();
                }
            }

            catch(PDOException $e) {
                $conn->rollBack();

                $_SESSION["alert-status"] = json_encode([
                    "icon" => "error",
                    "title" => "Unknown Error!",
                    "text" => "An unknown error occured! Please try again."
                ]);

                header("Location: ../../index.php");
                exit();
            }
        }
    }

    // Reset Password
    else if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["verify-admin-account"])) {
        $email_address = filter_var($_POST["email-address"], FILTER_SANITIZE_EMAIL);

        if(empty($email_address)) {
            $_SESSION["alert-status"] = json_encode([
                "icon" => "error",
                "title" => "Missing Fields!",
                "text" => "Please fill out the required fields! Please try again."
            ]);

            header("Location: ../../index.php");
            exit();
        }

        else if(!filter_var($email_address, FILTER_VALIDATE_EMAIL)) {
            $_SESSION["alert-status"] = json_encode([
                "icon" => "error",
                "title" => "Invalid Email Address!",
                "text" => "Invalid email address format! Please try again."
            ]);

            header("Location: ../../index.php");
            exit();
        }

        else {
            try {
                $conn->beginTransaction();

                $check_account = $conn->prepare("SELECT * FROM admin_accounts_tbl WHERE email_address = :email_address LIMIT 1");
                $check_account->execute([":email_address" => $email_address]);

                if($check_account->rowCount() === 1) {
                    $account_data = $check_account->fetch(PDO::FETCH_OBJ);
                    $admin_id = $account_data->admin_id;
                    $full_name = $account_data->first_name . " " . $account_data->last_name;

                    $reset_token = generate_verification_token();
                    $token_expiry = generate_expiry_time(5);

                    $reset_password_link = "http://localhost/ltaw_final/reset-admin-password.php?reset-token=$reset_token&admin-id=$admin_id";

                    if(send_reset_password_link($email_address, $full_name, $reset_password_link)) {

                        $update_account = $conn->prepare("UPDATE admin_accounts_tbl
                                                        SET reset_password_token = :token,
                                                        password_token_expiry = :expiry
                                                        WHERE admin_id = :admin_id
                                                        ");
                        $update_account->execute([
                            ":token" => $reset_token,
                            ":expiry" => $token_expiry,
                            ":admin_id" => $admin_id
                        ]);

                        $conn->commit();

                        $_SESSION["alert-status"] = json_encode([
                            "icon" => "success",
                            "title" => "Reset Link Sent!",
                            "text" => "The password reset link has been sent to your email address!"
                        ]);

                        header("Location: ../../index.php");
                        exit();
                    }
                    
                    else {
                        $_SESSION["alert-status"] = json_encode([
                            "icon" => "error",
                            "title" => "Mail Failed!",
                            "text" => "Failed to send the password reset link. Please try again later."
                        ]);

                        header("Location: ../../index.php");
                        exit();
                    }
                }

                else {
                    $_SESSION["alert-status"] = json_encode([
                        "icon" => "error",
                        "title" => "Invalid Email Address!",
                        "text" => "This account does not exists! Please try again."
                    ]);

                    header("Location: ../../index.php");
                    exit();
                }
            }

            catch(PDOException $e) {
                $conn->rollBack();

                $_SESSION["alert-status"] = json_encode([
                    "icon" => "error",
                    "title" => "Unknown Error!",
                    "text" => "An unknown error occured! Please try again."
                ]);

                header("Location: ../../index.php");
                exit();
            }
        }
    }

    // Reset Password
    else if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["reset-password"])) {
        $admin_id = htmlspecialchars(trim($_POST["admin-id"]));
        $token = htmlspecialchars(trim($_POST["reset-token"]));
        $password = htmlspecialchars(trim($_POST["password"]));
        $confirm_password = htmlspecialchars(trim($_POST["confirm-password"]));

        if(empty($admin_id) || empty($token) || empty($password) || empty($confirm_password)) {
            $_SESSION["alert-status"] = json_encode([
                "icon" => "error",
                "title" => "Missing Fields!",
                "text" => "Please fill out the required fields! Please try again."
            ]);

            header("Location: ../../reset-admin-password.php?reset-token=$token&admin-id=$admin_id");
            exit();
        }

        else if(!preg_match($password_pattern, $password)) {
            $_SESSION["alert-status"] = json_encode([
                "icon" => "error",
                "title" => "Invalid Pattern",
                "text" => "Invalid password pattern! Please try again."
            ]);

            header("Location: ../../reset-admin-password.php?reset-token=$token&admin-id=$admin_id");
            exit();
        }

        else if($password !== $confirm_password) {
            $_SESSION["alert-status"] = json_encode([
                "icon" => "error",
                "title" => "Password Mismatch!",
                "text" => "Passwords do not match! Please try again."
            ]);

            header("Location: ../../reset-admin-password.php?reset-token=$token&admin-id=$admin_id");
            exit();
        }

        else {
            try {
                $check_account = $conn->prepare("SELECT * FROM admin_accounts_tbl WHERE reset_password_token = :token AND admin_id = :admin_id LIMIT 1");
                $check_account->execute([
                    ":token" => $token,
                    ":admin_id" => $admin_id
                ]);

                if($check_account->rowCount() === 1) {
                    $token_data = $check_account->fetch(PDO::FETCH_OBJ);

                    if(strtotime($token_data->password_token_expiry) > time()) {
                        $reset_password = $conn->prepare("UPDATE admin_accounts_tbl
                                                        SET admin_password = :admin_password,
                                                        reset_password_token = NULL,
                                                        password_token_expiry = NULL
                                                        WHERE admin_id = :admin_id
                                                        ");
                        $reset_password->execute([
                            ":admin_password" => password_hash($password, PASSWORD_BCRYPT),
                            ":admin_id" => $admin_id
                        ]);

                        $_SESSION["alert-status"] = json_encode([
                            "icon" => "success",
                            "title" => "Password Reset!",
                            "text" => "Password has been reset!"
                        ]);

                        header("Location: ../../index.php");
                        exit();
                    }

                    else {
                        $_SESSION["alert-status"] = json_encode([
                            "icon" => "error",
                            "title" => "Link Expired!",
                            "text" => "The link is already expired! Please try again."
                        ]);

                        header("Location: ../../index.php");
                        exit();
                    }
                }

                else {
                    $_SESSION["alert-status"] = json_encode([
                        "icon" => "error",
                        "title" => "Invalid Account!",
                        "text" => "Account not found! Please try again."
                    ]);

                    header("Location: ../../index.php");
                    exit();
                }
            }

            catch(PDOException $e) {
                $_SESSION["alert-status"] = json_encode([
                    "icon" => "error",
                    "title" => "Unknown Error!",
                    "text" => "An unknown error occured! Please try again."
                ]);

                header("Location: ../../reset-admin-password.php?reset-token=$token&admin-id=$admin_id");
                exit();
            }
        }
    }

    else {
        header("Location: ../../index.php");
        exit();
    }
?>