<?php
    require_once "../../config/conn.php";
    require_once "../../config/checkers.php";
    require_once "../../config/format-time.php";
    require_once "../../config/mailer.php";

    if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["set-appointment"])) {
        $inquiry_id = htmlspecialchars(trim(base64_decode($_POST["inquiry-id"])));
        $address = htmlspecialchars($_POST["address"]);
        $phone_number = htmlspecialchars(trim($_POST["phone-number"]));
        $appointment_date = htmlspecialchars(trim($_POST["appointment-date"]));
        $appointment_time = htmlspecialchars($_POST["appointment-time"]);

        if(empty($inquiry_id) || empty($address) || empty($phone_number) || empty($appointment_date) || empty($appointment_time)) {
            $_SESSION["alert-status"] = json_encode([
                "icon" => "error",
                "title" => "Missing Fields!",
                "text" => "Please fill out the required fields! Please try again."
            ]);

            header("Location: ../../pages/admin/home.php?page=inquiries");
            exit();
        }

        else if(!preg_match($cellphone_pattern, $phone_number)) {
            $_SESSION["alert-status"] = json_encode([
                "icon" => "error",
                "title" => "Invalid Cellphone Number!",
                "text" => "Invalid cellphone number format! Please try again."
            ]);

            header("Location: ../../pages/admin/home.php?page=inquiries");
            exit();
        }

        else if(!is_valid_appointment_date($appointment_date)) {
            $_SESSION["alert-status"] = json_encode([
                "icon" => "error",
                "title" => "Invalid Appointment Date!",
                "text" => "Invalid appointment date format and must be a future date! Please try again."
            ]);

            header("Location: ../../pages/admin/home.php?page=inquiries");
            exit();
        }

        else if(!is_valid_appointment_time($appointment_time)) {
            $_SESSION["alert-status"] = json_encode([
                "icon" => "error",
                "title" => "Invalid Appointment Time!",
                "text" => "Invalid appointment time format and must between 8:00 AM and 4:00 PM! Please try again."
            ]);

            header("Location: ../../pages/admin/home.php?page=inquiries");
            exit();
        }

        else {

           try {
                $conn->beginTransaction();

                $check_inquiry = $conn->prepare("SELECT * FROM inquiries_tbl WHERE inquiry_id = :inquiry_id LIMIT 1");
                $check_inquiry->execute([":inquiry_id" => $inquiry_id]);

                if($check_inquiry->rowCount() === 1) {
                    $inquiry_data = $check_inquiry->fetch(PDO::FETCH_OBJ);

                    $update_inquiry = $conn->prepare("UPDATE inquiries_tbl
                                                    SET phone_number = :phone_number,
                                                    full_address = :full_addres,
                                                    inquire_status = :inquire_status,
                                                    appointment_date = :appointment_date,
                                                    appointment_time = :appointment_time
                                                    WHERE inquiry_id = :inquiry_id 
                                                    ");
                    $update_inquiry->execute([
                        ":phone_number" => $phone_number,
                        ":full_addres" => $address,
                        ":inquire_status" => "In Progress",
                        ":appointment_date" => $appointment_date,
                        ":appointment_time" => $appointment_time,
                        ":inquiry_id" => $inquiry_id
                    ]);

                    $email_address = $inquiry_data->email_address;
                    $full_name = $inquiry_data->full_name;
                    $service_type = $inquiry_data->service_type;
                    $address = $inquiry_data->full_address;
                    $formatted_date = format_date($appointment_date);
                    $formatted_time = format_time($appointment_time);

                    update_appointment_details($email_address, $full_name, $phone_number, $service_type, $address, $formatted_date, $formatted_time);
                
                    $conn->commit();
                    
                    $_SESSION["alert-status"] = json_encode([
                        "icon" => "success",
                        "title" => "Appointment Added!",
                        "text" => "Appointment added successfully!"
                    ]);

                    header("Location: ../../pages/admin/home.php?page=inquiries");
                    exit();
                }

                else {
                    $_SESSION["alert-status"] = json_encode([
                        "icon" => "error",
                        "title" => "Invalid Inquiry!",
                        "text" => "Inquiry not found! Please try again."
                    ]);

                    header("Location: ../../pages/admin/home.php?page=inquiries");
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

                header("Location: ../../pages/admin/home.php?page=inquiries");
                exit();
           }

        }
    }

    else if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["mark-as-done"])) {
        $inquiry_id = htmlspecialchars(trim(base64_decode($_POST["inquiry-id"])));

        if(empty($inquiry_id)) {
            $_SESSION["alert-status"] = json_encode([
                "icon" => "error",
                "title" => "Invalid Inquiry ID!",
                "text" => "Inquiry ID not found! Please try again."
            ]);

            header("Location: ../../pages/admin/home.php?page=inquiries");
            exit();
        }

        else {
            try {
                $conn->beginTransaction();

                $update_inquiry = $conn->prepare("UPDATE inquiries_tbl SET inquire_status = :inquire_status WHERE inquiry_id = :inquiry_id");
                $update_inquiry->execute([
                    ":inquire_status" => "Completed",
                    ":inquiry_id" => $inquiry_id
                ]);

                $_SESSION["alert-status"] = json_encode([
                    "icon" => "success",
                    "title" => "Inquire Complete!",
                    "text" => "Inquiry completed successfully!"
                ]);

                $conn->commit();

                header("Location: ../../pages/admin/home.php?page=inquiries");
                exit();
            }

            catch(PDOException $e) {
                $conn->rollBack();

                $_SESSION["alert-status"] = json_encode([
                    "icon" => "error",
                    "title" => "Unknown Error Occured!",
                    "text" => "An unknown error occured! Please try again."
                ]);

                header("Location: ../../pages/admin/home.php?page=inquiries");
                exit();
            }
        }
    }

    else if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["delete-inquiry"])) {
        $inquiry_id = htmlspecialchars(trim(base64_decode($_POST["inquiry-id"])));

        if(empty($inquiry_id)) {
            $_SESSION["alert-status"] = json_encode([
                "icon" => "error",
                "title" => "Invalid Inquiry ID!",
                "text" => "Inquiry ID not found! Please try again."
            ]);

            header("Location: ../../pages/admin/home.php?page=inquiries");
            exit();
        }

        else {
            try {
                $conn->beginTransaction();

                $delete_inquiry = $conn->prepare("DELETE FROM inquiries_tbl WHERE inquiry_id = :inquiry_id");
                $delete_inquiry->execute([":inquiry_id" => $inquiry_id]);

                $_SESSION["alert-status"] = json_encode([
                    "icon" => "success",
                    "title" => "Inquiry Deleted!",
                    "text" => "Inquiry deleted successfully!"
                ]);

                $conn->commit();

                header("Location: ../../pages/admin/home.php?page=inquiries");
                exit();
            }

            catch(PDOException $e) {
                $conn->rollBack();

                $_SESSION["alert-status"] = json_encode([
                    "icon" => "error",
                    "title" => "Unknown Error Occured!",
                    "text" => "An unknown error occured! Please try again."
                ]);

                header("Location: ../../pages/admin/home.php?page=inquiries");
                exit();
            }
        }
    }
?>