<?php
    require_once "../../config/conn.php";
    require_once "../../config/checkers.php";

    // Add
    if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["add-new-tripwire"])) {
        $file_location = "../../uploads/product-images/";

        $product_img = $_FILES["product-image"]["name"];
        $product_tmp_name = $_FILES["product-image"]["tmp_name"];

        $file_extension = strtolower(pathinfo($product_img, PATHINFO_EXTENSION));

        $device_id = htmlspecialchars($_POST["device-id"]);
        $product_name = htmlspecialchars($_POST["product-name"]);
        $product_model = htmlspecialchars($_POST["product-model"]);
        $product_version = htmlspecialchars($_POST["product-version"]);
        $product_description = htmlspecialchars($_POST["product-description"]);

        if(empty($device_id) || empty($product_name) || empty($product_model) || empty($product_version)) {
            $_SESSION["alert-status"] = json_encode([
                "icon" => "error",
                "title" => "Missing Fields!",
                "text" => "Please fill out the required fields! Please try again."
            ]);

            header("Location: ../../pages/admin/home.php?page=laser-tripwire");
            exit();
        }

        else if(!in_array($file_extension, $allowed_img_format)) {
            $_SESSION["alert-status"] = json_encode([
                "icon" => "error",
                "title" => "Invalid Format!",
                "text" => "Invalid image format! Please try again."
            ]);

            header("Location: ../../pages/admin/home.php?page=laser-tripwire");
            exit();
        }

        else {
            try {
                $conn->beginTransaction();

                $check_product = $conn->prepare("SELECT * FROM laser_tripwire_products_tbl WHERE device_id = :device_id LIMIT 1");
                $check_product->execute([":device_id" => $device_id]);

                if($check_product->rowCount() === 0) {

                    $unique_filename = 'laser_tripwire_' . $item_name . '_' . uniqid() . '.' . $file_extension;

                    $add_product = $conn->prepare("INSERT INTO laser_tripwire_products_tbl(device_id, product_image, product_name, model_name, version, description)
                                                VALUES(:device_id, :product_image, :product_name, :product_model, :version, :description)
                                                ");
                    $add_product->execute([
                        ":device_id" => $device_id,
                        ":product_image" => $unique_filename,
                        ":product_name" => $product_name,
                        ":product_model" => $product_model,
                        ":version" => $product_version,
                        ":description" => $product_description ? $product_description : NULL
                    ]);

                    $file_path = $file_location . $unique_filename;
                    move_uploaded_file($product_tmp_name, $file_path);

                    $conn->commit();

                    $_SESSION["alert-status"] = json_encode([
                        "icon" => "success",
                        "title" => "Product Added!",
                        "text" => "Product added successfully!"
                    ]);

                    header("Location: ../../pages/admin/home.php?page=laser-tripwire");
                    exit();
                }

                else {
                    $_SESSION["alert-status"] = json_encode([
                        "icon" => "error",
                        "title" => "Product Exists!",
                        "text" => "This product already exists! Please try again."
                    ]);

                    header("Location: ../../pages/admin/home.php?page=laser-tripwire");
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

                header("Location: ../../pages/admin/home.php?page=laser-tripwire");
                exit();
            }
        }

    }

    // Update
    else if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["update-product"])) {
       
        $device_id = htmlspecialchars(base64_decode($_POST["device-id"]));
        $product_name = htmlspecialchars($_POST["product-name"]);
        $product_model = htmlspecialchars($_POST["product-model"]);
        $product_version = htmlspecialchars($_POST["product-version"]);
        $product_description = htmlspecialchars($_POST["product-description"]);

        if(empty($device_id) || empty($product_name) || empty($product_model) || empty($product_version)) {
            $_SESSION["alert-status"] = json_encode([
                "icon" => "error",
                "title" => "Missing Fields!",
                "text" => "Please fill out the required fields! Please try again."
            ]);

            header("Location: ../../pages/admin/home.php?page=laser-tripwire");
            exit();
        }

        else {
            try {
                $conn->beginTransaction();

                $check_product = $conn->prepare("SELECT * FROM laser_tripwire_products_tbl WHERE device_id = :device_id LIMIT 1");
                $check_product->execute([":device_id" => $device_id]);

                if($check_product->rowCount() === 1) {

                    $update_product = $conn->prepare("UPDATE laser_tripwire_products_tbl
                                                    SET product_name = :product_name,
                                                    model_name = :model_name,
                                                    version = :version,
                                                    description = :description
                                                    WHERE device_id = :device_id
                                                    ");

                    $update_product->execute([
                        ":product_name" => $product_name,
                        ":model_name" => $product_model,
                        ":version" => $product_version,
                        ":description" => $product_description ? $product_description : NULL,
                        ":device_id" => $device_id
                    ]);
         
                    $conn->commit();

                    $_SESSION["alert-status"] = json_encode([
                        "icon" => "success",
                        "title" => "Product Updated!",
                        "text" => "Laser tripwire updated successfully!"
                    ]);

                    header("Location: ../../pages/admin/home.php?page=laser-tripwire");
                    exit();
                }

                else {
                    $_SESSION["alert-status"] = json_encode([
                        "icon" => "error",
                        "title" => "Invalid Product!",
                        "text" => "This laser tripwire does not exist! Please try again."
                    ]);

                    header("Location: ../../pages/admin/home.php?page=laser-tripwire");
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

                header("Location: ../../pages/admin/home.php?page=laser-tripwire");
                exit();
            }
        }
    }

    // Delete
    else if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["delete-product"])) {
        $device_id = htmlspecialchars(base64_decode($_POST["device-id"]));

        if(empty($device_id)) {
            $_SESSION["alert-status"] = json_encode([
                "icon" => "error",
                "title" => "Missing Fields!",
                "text" => "Please fill out the required fields! Please try again."
            ]);

            header("Location: ../../pages/admin/home.php?page=laser-tripwire");
            exit();
        }

        else {
            try {
                $conn->beginTransaction();

                $check_product = $conn->prepare("SELECT * FROM laser_tripwire_products_tbl WHERE device_id = :device_id LIMIT 1");
                $check_product->execute([":device_id" => $device_id]);

                if($check_product->rowCount() === 1) {

                    $delete_product = $conn->prepare("DELETE FROM laser_tripwire_products_tbl WHERE device_id = :device_id");
                    $delete_product->execute([":device_id" => $device_id]);
         
                    $conn->commit();

                    $_SESSION["alert-status"] = json_encode([
                        "icon" => "success",
                        "title" => "Product Delete!",
                        "text" => "Laser tripwire deleted successfully!"
                    ]);

                    header("Location: ../../pages/admin/home.php?page=laser-tripwire");
                    exit();
                }

                else {
                    $_SESSION["alert-status"] = json_encode([
                        "icon" => "error",
                        "title" => "Invalid Product!",
                        "text" => "This laser tripwire does not exist! Please try again."
                    ]);

                    header("Location: ../../pages/admin/home.php?page=laser-tripwire");
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

                header("Location: ../../pages/admin/home.php?page=laser-tripwire");
                exit();
            }
        }
    }
    
?>