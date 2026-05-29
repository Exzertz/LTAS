<?php
    require_once "../../config/conn.php";
    require_once "../../config/mailer.php";
    require_once "../../config/checkers.php";

    // Create Account
    if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["create-account"])) {
        
        $user_id = generateUserId();
        $first_name = htmlspecialchars($_POST["first-name"]);
        $middle_name = htmlspecialchars($_POST["middle-name"]);
        $last_name = htmlspecialchars($_POST["last-name"]);
        $gender = htmlspecialchars($_POST["gender"]);
        $status = htmlspecialchars($_POST["civil-status"]);
        $occupation = htmlspecialchars($_POST["occupation"]);
        $phone_number = htmlspecialchars(trim($_POST["phone-number"]));
        $telephone_number = htmlspecialchars(trim($_POST["telephone-number"]));
        $address = htmlspecialchars($_POST["address"]);
        $email_address = filter_var($_POST["email-address"], FILTER_SANITIZE_EMAIL);
        $password = htmlspecialchars(trim($_POST["password"]));
        $confirm_password = htmlspecialchars(trim($_POST["confirm-password"]));

        if(empty($first_name) || empty($last_name) || empty($gender) || empty($status) || empty($occupation) || empty($phone_number) || empty($address) || empty($email_address) || empty($password) || empty($confirm_password)) {
            $_SESSION["alert-status"] = json_encode([
                "icon" => "error",
                "title" => "Missing Fields!",
                "text" => "Please fill out the required fields! Please try again."
            ]);

            header("Location: ../../index.php");
            exit();
        }

        else if(!in_array($gender, $allowed_genders)) {
            $_SESSION["alert-status"] = json_encode([
                "icon" => "error",
                "title" => "Invalid Gender!",
                "text" => "Invalid gender type! Please try again."
            ]);

            header("Location: ../../index.php");
            exit();
        }

        else if(!in_array($status, $allowed_status)) {
            $_SESSION["alert-status"] = json_encode([
                "icon" => "error",
                "title" => "Invalid Status!",
                "text" => "Invalid status type! Please try again."
            ]);

            header("Location: ../../index.php");
            exit();
        }

        else if(!in_array($occupation, $allowed_occupations)) {
            $_SESSION["alert-status"] = json_encode([
                "icon" => "error",
                "title" => "Invalid Occupation!",
                "text" => "Invalid occupation type! Please try again."
            ]);

            header("Location: ../../index.php");
            exit();
        }

        else if(!preg_match($cellphone_pattern, $phone_number)) {
            $_SESSION["alert-status"] = json_encode([
                "icon" => "error",
                "title" => "Invalid Phone Number!",
                "text" => "Invalid phone number! Please try again."
            ]);

            header("Location: ../../index.php");
            exit();
        }

        else if(!empty($telephone_number) && !preg_match($telephone_pattern, $telephone_number)) {
            $_SESSION["alert-status"] = json_encode([
                "icon" => "error",
                "title" => "Invalid Telephone Number!",
                "text" => "Invalid telephone number! Please try again."
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

        else if(!preg_match($password_pattern, $password)) {
            $_SESSION["alert-status"] = json_encode([
                "icon" => "error",
                "title" => "Invalid Password Format!",
                "text" => "Invalid password format! Please try again."
            ]);

            header("Location: ../../index.php");
            exit();
        }

        else if($password !== $confirm_password) {
            $_SESSION["alert-status"] = json_encode([
                "icon" => "error",
                "title" => "Password Mismatch!",
                "text" => "Passwords don't match! Please try again."
            ]);

            header("Location: ../../index.php");
            exit();
        }

        else {
            try {
                $conn->beginTransaction();

                $check_existing_emails = $conn->prepare("SELECT * FROM user_accounts_tbl WHERE email_address = :email_address LIMIT 1");
                $check_existing_emails->execute([":email_address" => $email_address]);

                if($check_existing_emails->rowCount() === 0) {
                    $insert_account = $conn->prepare("INSERT INTO user_accounts_tbl(user_id, first_name, middle_name, last_name, email_address, user_password)
                                                    VALUES(:user_id, :first_name, :middle_name, :last_name, :email_address, :user_password) 
                                                    ");
                    $insert_account->execute([
                        ":user_id" => $user_id,
                        ":first_name" => $first_name,
                        ":middle_name" => $middle_name,
                        ":last_name" => $last_name,
                        ":email_address" => $email_address,
                        ":user_password" => password_hash($password, PASSWORD_BCRYPT)
                    ]);

                    $insert_account_info = $conn->prepare("INSERT INTO user_info_tbl(user_id, gender, civil_status, occupation, cellphone_number, telephone_number, address)
                                                        VALUES(:user_id, :gender, :civil_status, :occupation, :cellphone_number, :telephone_number, :address)
                                                        ");
                    $insert_account_info->execute([
                        ":user_id" => $user_id,
                        ":gender" => $gender,
                        ":civil_status" => $status,
                        ":occupation" => $occupation,
                        ":cellphone_number" => $phone_number,
                        ":telephone_number" => $telephone_number,
                        ":address" => $address
                    ]);

                    $full_name = $first_name . " " . $last_name;
                    $verification_token = generate_verification_token();
                    //$verification_link = "https://localhost/ltaw_final/process/users/verify-account.php?user-id=$user_id&verification-token=$verification_token&email-address=$email_address";

                    $verification_link = "http://lasertripwire.online/process/users/verify-account.php?user-id=$user_id&verification-token=$verification_token&email-address=$email_address";

                    $add_verification_token = $conn->prepare("UPDATE user_accounts_tbl SET verification_token = :token WHERE user_id = :user_id");
                    $add_verification_token->execute([
                        ":token" => $verification_token,
                        ":user_id" => $user_id
                    ]);

                    verify_account($email_address, $full_name, $verification_link);

                    $conn->commit();

                    $_SESSION["alert-status"] = json_encode([
                        "icon" => "question",
                        "title" => "Verify Account!",
                        "text" => "An account verification link has been sent to your email address: " . $email_address . ". Please check it now."
                    ]);

                    header("Location: ../../index.php");

                    exit();
                }

                else {
                    $_SESSION["alert-status"] = json_encode([
                        "icon" => "error",
                        "title" => "Existing Account!",
                        "text" => "This account is already exists! Please try again."
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

    // Login
    else if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["user-login"])) {
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

                $check_account = $conn->prepare("SELECT * FROM user_accounts_tbl WHERE email_address = :email_address LIMIT 1");
                $check_account->execute([":email_address" => $email_address]);

                if($check_account->rowCount() === 1) {
                    $account_details = $check_account->fetch(PDO::FETCH_OBJ);

                    if(password_verify($password, $account_details->user_password)) {

                        $user_id = $account_details->user_id;

                        if($account_details->verified_account === "Yes") {

                            $update_last_login = $conn->prepare("UPDATE user_accounts_tbl SET last_login = CURRENT_TIMESTAMP() WHERE user_id = :user_id");
                            $update_last_login->execute([":user_id" => $user_id]);

                            $conn->commit();

                            $_SESSION["user-id"] = $user_id;
                            header("Location: ../../pages/users/home.php");
                            exit();
                        }

                        else {
                            $_SESSION["alert-status"] = json_encode([
                                "icon" => "warning",
                                "title" => "Account Not Verified!",
                                "text" => "An account verification link has been sent to your email address: " . $email_address . ". Please check it now."
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
    else if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["verify-user-account"])) {
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

                $check_account = $conn->prepare("SELECT * FROM user_accounts_tbl WHERE email_address = :email_address LIMIT 1");
                $check_account->execute([":email_address" => $email_address]);

                if($check_account->rowCount() === 1) {
                    $account_data = $check_account->fetch(PDO::FETCH_OBJ);
                    $user_id = $account_data->user_id;
                    $full_name = $account_data->first_name . " " . $account_data->last_name;

                    $reset_token = generate_verification_token();
                    $token_expiry = generate_expiry_time(5);

                    //$reset_password_link = "http://localhost/ltaw_final/reset-user-password.php?reset-token=$reset_token&user-id=$user_id";
                    $reset_password_link = "https://lasertripwire.online/reset-user-password.php?reset-token=$reset_token&user-id=$user_id";

                    if(send_reset_password_link($email_address, $full_name, $reset_password_link)) {

                        $update_account = $conn->prepare("UPDATE user_accounts_tbl
                                                        SET reset_password_token = :token,
                                                        password_token_expiry = :expiry
                                                        WHERE user_id = :user_id
                                                        ");
                        $update_account->execute([
                            ":token" => $reset_token,
                            ":expiry" => $token_expiry,
                            ":user_id" => $user_id
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
        $user_id = htmlspecialchars(trim($_POST["user-id"]));
        $token = htmlspecialchars(trim($_POST["reset-token"]));
        $password = htmlspecialchars(trim($_POST["password"]));
        $confirm_password = htmlspecialchars(trim($_POST["confirm-password"]));

        if(empty($user_id) || empty($token) || empty($password) || empty($confirm_password)) {
            $_SESSION["alert-status"] = json_encode([
                "icon" => "error",
                "title" => "Missing Fields!",
                "text" => "Please fill out the required fields! Please try again."
            ]);

            header("Location: ../../reset-user-password.php?reset-token=$token&user-id=$user_id");
            exit();
        }

        else if(!preg_match($password_pattern, $password)) {
            $_SESSION["alert-status"] = json_encode([
                "icon" => "error",
                "title" => "Invalid Pattern",
                "text" => "Invalid password pattern! Please try again."
            ]);

            header("Location: ../../reset-user-password.php?reset-token=$token&user-id=$user_id");
            exit();
        }

        else if($password !== $confirm_password) {
            $_SESSION["alert-status"] = json_encode([
                "icon" => "error",
                "title" => "Password Mismatch!",
                "text" => "Passwords do not match! Please try again."
            ]);

            header("Location: ../../reset-user-password.php?reset-token=$token&user-id=$user_id");
            exit();
        }

        else {
            try {
                $check_account = $conn->prepare("SELECT * FROM user_accounts_tbl WHERE reset_password_token = :token AND user_id = :user_id LIMIT 1");
                $check_account->execute([
                    ":token" => $token,
                    ":user_id" => $user_id
                ]);

                if($check_account->rowCount() === 1) {
                    $token_data = $check_account->fetch(PDO::FETCH_OBJ);

                    if(strtotime($token_data->password_token_expiry) > time()) {
                        $reset_password = $conn->prepare("UPDATE user_accounts_tbl
                                                        SET user_password = :user_password,
                                                        reset_password_token = NULL,
                                                        password_token_expiry = NULL
                                                        WHERE user_id = :user_id
                                                        ");
                        $reset_password->execute([
                            ":user_password" => password_hash($password, PASSWORD_BCRYPT),
                            ":user_id" => $user_id
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

                header("Location: ../../reset-user-password.php?reset-token=$token&user-id=$admin_id");
                exit();
            }
        }
    }

    else {
        header("Location: ../../index.php");
        exit();
    }
?>