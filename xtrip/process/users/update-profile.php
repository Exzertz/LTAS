<?php
    require_once "../../config/conn.php";
    require_once "../../config/checkers.php";

    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["update-profile"])) {

        $user_id = htmlspecialchars(trim($_SESSION["user-id"]));
        $first_name = htmlspecialchars($_POST["first-name"]);
        $middle_name = htmlspecialchars($_POST["middle-name"]);
        $last_name = htmlspecialchars($_POST["last-name"]);
        $gender = htmlspecialchars($_POST["gender"]);
        $civil_status = htmlspecialchars($_POST["civil-status"]);
        $phone_number = htmlspecialchars($_POST["phone-number"]);
        $telephone_number = htmlspecialchars($_POST["telephone-number"]);
        $address = htmlspecialchars($_POST["address"]);

        if(empty($user_id) || empty($first_name) || empty($last_name) || empty($gender) || empty($civil_status) || empty($phone_number) || empty($address)) {
            $_SESSION["alert-status"] = json_encode([
                "icon" => "error",
                "title" => "Unknown Error!",
                "text" => "An unknown error occured! Please try again."
            ]);

            header("Location: ../../pages/users/home.php?page=user-profile&update-profile=true");
            exit();
        } 
        
        else if (!in_array($gender, $allowed_genders)) {
            $_SESSION["alert-status"] = json_encode([
                "icon" => "error",
                "title" => "Invalid Gender!",
                "text" => "Invalid type of gender! Please try again."
            ]);

            header("Location: ../../pages/users/home.php?page=user-profile&update-profile=true");
            exit();
        } 
        
        else if (!in_array($civil_status, $allowed_status)) {
            $_SESSION["alert-status"] = json_encode([
                "icon" => "error",
                "title" => "Invalid Status!",
                "text" => "Invalid type of status! Please try again."
            ]);

            header("Location: ../../pages/users/home.php?page=user-profile&update-profile=true");
            exit();
        } 
        
        else if (!preg_match($cellphone_pattern, $phone_number)) {
            $_SESSION["alert-status"] = json_encode([
                "icon" => "error",
                "title" => "Invalid Phone Number!",
                "text" => "Invalid cellphone number format! Please try again."
            ]);

            header("Location: ../../pages/admin/home.php?page=user-profile&update-profile=true");
            exit();
        } 
        
        else if (!preg_match($telephone_pattern, $telephone_number)) {
            $_SESSION["alert-status"] = json_encode([
                "icon" => "error",
                "title" => "Invalid Telephone Number!",
                "text" => "Invalid telephone number format! Please try again."
            ]);

            header("Location: ../../pages/users/home.php?page=user-profile&update-profile=true");
            exit();
        } 
        
        else {
            try {

                $conn->beginTransaction();

                $update_account = $conn->prepare("UPDATE user_accounts_tbl
                                                        SET first_name = :first_name,
                                                        middle_name = :middle_name,
                                                        last_name = :last_name
                                                        WHERE user_id = :user_id
                                                        ");
                $update_account->execute([
                    ":first_name" => $first_name,
                    ":middle_name" => $middle_name,
                    ":last_name" => $last_name,
                    ":user_id" => $user_id
                ]);

                $update_profile = $conn->prepare("UPDATE user_info_tbl
                                                        SET gender = :gender,
                                                        civil_status = :civil_status,
                                                        cellphone_number = :cellphone_number,
                                                        telephone_number = :telephone_number,
                                                        address = :address
                                                        WHERE user_id = :user_id
                                                        ");
                $update_profile->execute([
                    ":gender" => $gender,
                    ":civil_status" => $civil_status,
                    ":cellphone_number" => $phone_number,
                    ":telephone_number" => $telephone_number,
                    ":address" => $address,
                    ":user_id" => $user_id
                ]);

                $conn->commit();

                $_SESSION["alert-status"] = json_encode([
                    "icon" => "success",
                    "title" => "Profile Updated!",
                    "text" => "Profile updated successfully!"
                ]);

                header("Location: ../../pages/users/home.php?page=user-profile&update-profile=true");
                exit();
            } 
            
            catch (PDOException $e) {
                $conn->rollBack();

                $_SESSION["alert-status"] = json_encode([
                    "icon" => "error",
                    "title" => "Unknown Error!",
                    "text" => "An unknown error occured! Please try again."
                ]);

                header("Location: ../../pages/users/home.php?page=user-profile&update-profile=true");
                exit();
            }
        }
    } 

    else if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["update-profile-picture"])) {

        $file_location = "../../uploads/user-images/";

        $user_id = htmlspecialchars(trim($_SESSION["user-id"]));
        $uploaded_photo = $_FILES["uploaded-photo"]["name"];
        $tmp_name = $_FILES["uploaded-photo"]["tmp_name"];

        $file_extension = strtolower(pathinfo($uploaded_photo, PATHINFO_EXTENSION));

        if (!in_array($file_extension, $allowed_img_format)) {
            $_SESSION["alert-status"] = json_encode([
                "icon" => "error",
                "title" => "Invalid File!",
                "text" => "Invalid file type! Please try again."
            ]);

            header("Location: ../../pages/users/home.php?page=user-profile&update-photo=true");
            exit();
        } 
        
        else {
            try {

                $unique_filename = 'user_' . $user_id . '_' . uniqid() . '.' . $file_extension;

                $update_profile_picture = $conn->prepare("UPDATE user_info_tbl SET profile_picture = :profile_picture WHERE user_id = :user_id");
                $update_profile_picture->execute([
                    ":profile_picture" => $unique_filename,
                    ":user_id" => $user_id
                ]);

                $file_path = $file_location . $unique_filename;
                move_uploaded_file($tmp_name, $file_path);

                $_SESSION["alert-status"] = json_encode([
                    "icon" => "success",
                    "title" => "Photo Updated!",
                    "text" => "Profile photo updated successfully!"
                ]);

                header("Location: ../../pages/users/home.php?page=user-profile&update-photo=true");
                exit();
            } 
            
            catch (PDOException $e) {
                $_SESSION["alert-status"] = json_encode([
                    "icon" => "error",
                    "title" => "Unknown Error!",
                    "text" => "An unknown error occured! Please try again."
                ]);

                header("Location: ../../pages/users/home.php?page=user-profile&update-photo=true");
                exit();
            }
        }
    } 

    else if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["update-password"])) {

        $user_id = htmlspecialchars(trim($_SESSION["user-id"]));
        $current_password = htmlspecialchars(trim($_POST["current-password"]));
        $new_password = htmlspecialchars(trim($_POST["new-password"]));
        $confirm_password = htmlspecialchars(trim($_POST["confirm-new-password"]));

        if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
            $_SESSION["alert-status"] = json_encode([
                "icon" => "error",
                "title" => "Unknown Error!",
                "text" => "An unknown error occured! Please try again."
            ]);

            header("Location: ../../pages/users/home.php?page=user-profile&update-password=true");
            exit();
        } 
        
        else if (!preg_match($password_pattern, $new_password)) {
            $_SESSION["alert-status"] = json_encode([
                "icon" => "error",
                "title" => "Invalid Pattern!",
                "text" => "Invalid password pattern! Please try again."
            ]);

            header("Location: ../../pages/users/home.php?page=user-profile&update-password=true");
            exit();
        } 
        
        else {
            if ($new_password === $confirm_password) {
                try {
                    $check_account = $conn->prepare("SELECT * FROM user_accounts_tbl WHERE user_id = :user_id LIMIT 1");
                    $check_account->execute([":user_id" => $user_id]);

                    if ($check_account->rowCount() === 1) {
                        $password_data = $check_account->fetch(PDO::FETCH_OBJ);

                        if (password_verify($current_password, $password_data->user_password)) {
                            $set_new_password = $conn->prepare("UPDATE user_accounts_tbl SET user_password = :new_password WHERE user_id = :user_id");
                            $set_new_password->execute([
                                ":new_password" => password_hash($new_password, PASSWORD_BCRYPT),
                                ":user_id" => $user_id
                            ]);

                            $change_update = $conn->prepare("UPDATE user_info_tbl
                                                            SET updated_at = CURRENT_TIMESTAMP()
                                                            WHERE user_id = :user_id");
                            $change_update->execute([":user_id" => $user_id]);

                            $_SESSION["alert-status"] = json_encode([
                                "icon" => "success",
                                "title" => "Password Updated!",
                                "text" => "Password updated successfully!"
                            ]);

                            header("Location: ../../pages/users/home.php?page=user-profile&update-password=true");
                            exit();
                        } 
                        
                        else {
                            $_SESSION["alert-status"] = json_encode([
                                "icon" => "error",
                                "title" => "Invalid Password!",
                                "text" => "Invalid current password! Please try again."
                            ]);

                            header("Location: ../../pages/users/home.php?page=user-profile&update-password=true");
                            exit();
                        }
                    } 
                    
                    else {
                        $_SESSION["alert-status"] = json_encode([
                            "icon" => "error",
                            "title" => "Invalid ACcount!",
                            "text" => "Accountn not found! Please try again."
                        ]);

                        header("Location: ../../pages/users/home.php?page=user-profile&update-password=true");
                        exit();
                    }
                } 
                
                catch (PDOException $e) {
                    $_SESSION["alert-status"] = json_encode([
                        "icon" => "error",
                        "title" => "Unknown Error!",
                        "text" => "An unknown error occured! Please try again."
                    ]);

                    header("Location: ../../pages/users/home.php?page=user-profile&update-password=true");
                    exit();
                }
            } 
            
            else {
                $_SESSION["alert-status"] = json_encode([
                    "icon" => "error",
                    "title" => "Password Mismatch!",
                    "text" => "Passwords do not match! Please try again."
                ]);

                header("Location: ../../pages/users/home.php?page=user-profile&update-password=true");
                exit();
            }
        }
    }

?>
