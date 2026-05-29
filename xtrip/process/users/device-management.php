<?php
    require_once "../../config/conn.php";
    require_once "../../config/checkers.php";

    // Install Device
    if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["add-new-device"])) {
        $file_location = "../../uploads/tripwire-locations/";

        $location_img = $_FILES["location-image"]["name"];
        $location_tmp_name = $_FILES["location-image"]["tmp_name"];

        $file_extension = strtolower(pathinfo($location_img, PATHINFO_EXTENSION));

        $user_id = htmlspecialchars(trim($_SESSION["user-id"]));
        $device_id = htmlspecialchars($_POST["device-id"]);

        if(empty($device_id)) {
            $_SESSION["alert-status"] = json_encode([
                "icon" => "error",
                "title" => "Missing Fields!",
                "text" => "Please fill out the required fields! Please try again."
            ]);

            header("Location: ../../pages/users/home.php?page=my-devices");
            exit();
        }

        else {
            try {
                $conn->beginTransaction();

                $check_device = $conn->prepare("SELECT * FROM laser_tripwire_products_tbl WHERE device_id = :device_id LIMIT 1");
                $check_device->execute([":device_id" => $device_id]);

                if($check_device->rowCount() === 1) {

                    $check_installed_device = $conn->prepare("SELECT * FROM laser_tripwire_owners_tbl WHERE device_id = :device_id LIMIT 1");
                    $check_installed_device->execute([":device_id" => $device_id]);

                    if($check_installed_device->rowCount() === 0) {

                        $unique_filename = 'device_location_' . $device_id . '_' . uniqid() . '.' . $file_extension;

                        $install_device = $conn->prepare("INSERT INTO laser_tripwire_owners_tbl(device_id, device_location, owner)
                                                        VALUES(:device_id, :device_location, :user_id) 
                                                        ");

                        $install_device->execute([
                            ":device_id" => $device_id,
                            ":device_location" => $unique_filename,
                            ":user_id" => $user_id
                        ]);

                        $file_path = $file_location . $unique_filename;
                        move_uploaded_file($location_tmp_name, $file_path);

                        $conn->commit();

                        $_SESSION["alert-status"] = json_encode([
                            "icon" => "success",
                            "title" => "Device Installed!",
                            "text" => "Laser tripwire installed successfully!"
                        ]);

                        header("Location: ../../pages/users/home.php?page=my-devices");
                        exit();
                    }

                    else {
                        $_SESSION["alert-status"] = json_encode([
                            "icon" => "error",
                            "title" => "Device Already Installed!",
                            "text" => "This laser tripwire is already installed! Please try again."
                        ]);

                        header("Location: ../../pages/users/home.php?page=my-devices");
                        exit();
                    }
                }

                else {
                    $_SESSION["alert-status"] = json_encode([
                        "icon" => "error",
                        "title" => "Device Not Exist!",
                        "text" => "Invalid device ID! Please try again."
                    ]);

                    header("Location: ../../pages/users/home.php?page=my-devices");
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

                header("Location: ../../pages/users/home.php?page=my-devices");
                exit();
            }
        }
    }

    // Remove Device
    if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["remove-device"])) {
        $device_id = htmlspecialchars(trim(base64_decode($_POST["device-id"])));

        if(empty($device_id)) {
            $_SESSION["alert-status"] = json_encode([
                "icon" => "error",
                "title" => "Missing Fields!",
                "text" => "Please fill out the required fields! Please try again."
            ]);

            header("Location: ../../pages/users/home.php?page=my-devices");
            exit();
        }

        else {
            try {
                $conn->beginTransaction();

                $check_device = $conn->prepare("SELECT * FROM laser_tripwire_owners_tbl WHERE device_id = :device_id LIMIT 1");
                $check_device->execute([":device_id" => $device_id]);

                if($check_device->rowCount() === 1) {

                    $delete_product = $conn->prepare("DELETE FROM laser_tripwire_owners_tbl WHERE device_id = :device_id");
                    $delete_product->execute([":device_id" => $device_id]);
         
                    $conn->commit();

                    $_SESSION["alert-status"] = json_encode([
                        "icon" => "success",
                        "title" => "Device Delete!",
                        "text" => "Laser tripwire deleted successfully!"
                    ]);

                    header("Location: ../../pages/users/home.php?page=my-devices");
                    exit();
                }

                else {
                    $_SESSION["alert-status"] = json_encode([
                        "icon" => "error",
                        "title" => "Invalid Device!",
                        "text" => "This laser tripwire does not exist! Please try again."
                    ]);

                    header("Location: ../../pages/users/home.php?page=my-devices");
                    exit();
                }
            }

            catch(PDOException $e) {
                $conn->rollBack();
                $_SESSION["alert-status"] = json_encode([
                    "icon" => "error",
                    "title" => "Unknown Error!",
                    "text" => "An unknown error occured! Please try again." . $e->getMessage()
                ]);

                header("Location: ../../pages/users/home.php?page=my-devices");
                exit();
            }
        }
    }

    // Turn Off Device
    if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["turn-off-device"])) {
        $device_id = htmlspecialchars(trim(base64_decode($_POST["device-id"])));

        if(empty($device_id)) {
            $_SESSION["alert-status"] = json_encode([
                "icon" => "error",
                "title" => "Missing Fields!",
                "text" => "Please fill out the required fields! Please try again."
            ]);

            header("Location: ../../pages/users/home.php?page=dashboard");
            exit();
        }

        else {
            try {
                $conn->beginTransaction();

                $check_device = $conn->prepare("SELECT * FROM laser_tripwire_owners_tbl WHERE device_id = :device_id LIMIT 1");
                $check_device->execute([":device_id" => $device_id]);

                if($check_device->rowCount() === 1) {

                    $update_tripwire_status = $conn->prepare("UPDATE laser_tripwire_owners_tbl SET tripwire_status = :tripwire_status WHERE device_id = :device_id");
                    $update_tripwire_status->execute([":tripwire_status" => "Safe", ":device_id" => $device_id]);
         
                    $conn->commit();

                    $_SESSION["alert-status"] = json_encode([
                        "icon" => "success",
                        "title" => "Device Turned Off!",
                        "text" => "Laser tripwire turned off successfully!"
                    ]);

                    header("Location: ../../pages/users/home.php?page=dashboard");
                    exit();
                }

                else {
                    $_SESSION["alert-status"] = json_encode([
                        "icon" => "error",
                        "title" => "Invalid Device!",
                        "text" => "This laser tripwire does not exist! Please try again."
                    ]);

                    header("Location: ../../pages/users/home.php?page=dashboard");
                    exit();
                }
            }

            catch(PDOException $e) {
                $conn->rollBack();
                $_SESSION["alert-status"] = json_encode([
                    "icon" => "error",
                    "title" => "Unknown Error!",
                    "text" => "An unknown error occured! Please try again." . $e->getMessage()
                ]);

                header("Location: ../../pages/users/home.php?page=dashboard");
                exit();
            }
        }
    }
?>