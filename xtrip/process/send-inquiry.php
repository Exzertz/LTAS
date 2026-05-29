<?php
    require_once "../config/conn.php";
    require_once "../config/checkers.php";
    require_once "../config/mailer.php";

    if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["submit-inquiry"])) {
        $full_name = htmlspecialchars($_POST["full-name"]);
        $email_address = filter_var($_POST["email-address"], FILTER_SANITIZE_EMAIL);
        $phone_number = htmlspecialchars(trim($_POST["phone-number"]));
        $service_type = htmlspecialchars($_POST["service-type"]);
        $address = htmlspecialchars($_POST["address"]);

        if(empty($full_name) || empty($email_address) || empty($phone_number) || empty($service_type) || empty($address)) {
            $_SESSION["alert-status"] = json_encode([
                "icon" => "error",
                "title" => "Missing Fields!",
                "text" => "Please fill out the required fields! Please try again."
            ]);

            header("Location: ../index.php");
            exit();
        }

        else if(!filter_var($email_address, FILTER_VALIDATE_EMAIL)) {
            $_SESSION["alert-status"] = json_encode([
                "icon" => "error",
                "title" => "Invalid Email Address!",
                "text" => "Invalid email address format! Please try again."
            ]);

            header("Location: ../index.php");
            exit();
        }

        else if(!preg_match($cellphone_pattern, $phone_number)) {
            $_SESSION["alert-status"] = json_encode([
                "icon" => "error",
                "title" => "Invalid Phone Number!",
                "text" => "Invalid phone number format! Please try again."
            ]);

            header("Location: ../index.php");
            exit();
        }

        else if(!in_array($service_type, $allowed_services)) {
            $_SESSION["alert-status"] = json_encode([
                "icon" => "error",
                "title" => "Invalid Service!",
                "text" => "Invalid service type! Please try again."
            ]);

            header("Location: ../index.php");
            exit();
        }

        else {
            try {
                $insert_inquiry = $conn->prepare("INSERT INTO inquiries_tbl(full_name, email_address, phone_number, service_type, full_address)
                                                VALUES(:full_name, :email_address, :phone_number, :service_type, :address)
                                                ");
                $insert_inquiry->execute([
                    ":full_name" => $full_name,
                    ":email_address" => $email_address,
                    ":phone_number" => $phone_number,
                    ":service_type" => $service_type,
                    ":address" => $address
                ]);

                send_inquiry_details($email_address, $full_name, $phone_number, $service_type, $address);
                
                $_SESSION["alert-status"] = json_encode([
                    "icon" => "success",
                    "title" => "Inquiry Sent!",
                    "text" => "Inquiry successfully! Please check your inbox for your inquiry details."
                ]);

                header("Location: ../index.php");
                exit();
            }
            catch(PDOException $e) {
                $_SESSION["alert-status"] = json_encode([
                    "icon" => "error",
                    "title" => "Unknown Error!",
                    "text" => "An unknown error occured! Please try again."
                ]);

                header("Location: ../index.php");
                exit();
            }
        }
    }
?>