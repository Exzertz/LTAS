<?php

    // PHP Mailer Configurations
    define("MAILER_HOST", "smtp.hostinger.com");
    define("MAILER_NAME", "Laser Tripwire Support Team");
    define("MAILER_USERNAME", "teambrb.support@lasertripwire.online");
    define("MAILER_PASSWORD", "TeamBRB123!");
    define("MAILER_PORT", 465);

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require "PHPMailer/src/Exception.php";
    require "PHPMailer/src/PHPMailer.php";
    require "PHPMailer/src/SMTP.php";

    function verify_account($email, $full_name, $link) {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->SMTPAuth = true;
            $mail->Host = MAILER_HOST;

            $mail->Username = MAILER_USERNAME;
            $mail->Password = MAILER_PASSWORD;
            $mail->SMTPSecure = "ssl";
            $mail->Port = MAILER_PORT;

            $mail->setFrom(MAILER_USERNAME, MAILER_NAME);
            $mail->addAddress($email, $full_name);

            $mail->isHTML(true);
            $mail->Subject = "LTAS: Verify Account";
            $mail->Body = "
                Greetings, <b>$full_name</b>! <br><br>

                Thank you for registering with us. To complete your account setup, please verify your email address by clicking the link below:<br><br>

                Click here to verify your account: <a href='$link' target='_blank'>Verify Account</a>
                
                <br><br>

                Once verified, you will be able to log in and access all features of this website.<br><br>

                Regards, <br>
                <b>Laser Tripwire Support Team</b>
            ";

            $mail->send();

            return ["success" => true, "message" => "Email sent successfully."];
        } 
        
        catch (Exception $e) {
            error_log("Error: " . $mail->ErrorInfo);
            return ["success" => false, "message" => "Error in sending email! Please try again."];
        }
    }

    function send_welcome_message($email, $full_name) {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->SMTPAuth = true;
            $mail->Host = MAILER_HOST;

            $mail->Username = MAILER_USERNAME;
            $mail->Password = MAILER_PASSWORD;
            $mail->SMTPSecure = "ssl";
            $mail->Port = MAILER_PORT;

            $mail->setFrom(MAILER_USERNAME, MAILER_NAME);
            $mail->addAddress($email, $full_name);

            $mail->isHTML(true);
            $mail->Subject = "LTAS: Account Verification Complete";
            $mail->Body = "
                Hello, <b>$full_name</b>! <br><br>

                Your account has been successfully verified. We are excited to have you on board! <br><br>
                
                You can now log in and start exploring all the features we have to offer.<br><br>

                Click here to login: <a href='http://localhost/ltaw_final/index.php' target='_blank'><b>Click here to log in</b></a><br><br>

                If you have any questions or need assistance, feel free to contact our support team anytime.<br><br>

                Welcome again, and thank you for joining us!<br><br>

                Regards, <br>
                <b>Laser Tripwire Support Team</b>
            ";

            $mail->send();

            return ["success" => true, "message" => "Email sent successfully."];
        } 
        
        catch (Exception $e) {
            error_log("Error: " . $mail->ErrorInfo);
            return ["success" => false, "message" => "Error in sending email! Please try again."];
        }
    }

    function send_reset_password_link($email, $full_name, $link) {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->SMTPAuth = true;
            $mail->Host = MAILER_HOST;

            $mail->Username = MAILER_USERNAME;
            $mail->Password = MAILER_PASSWORD;
            $mail->SMTPSecure = "ssl";
            $mail->Port = MAILER_PORT;

            $mail->setFrom(MAILER_USERNAME, MAILER_NAME);
            $mail->addAddress($email, $full_name);

            $mail->isHTML(true);
            $mail->Subject = "LTAS: Reset Password";
            $mail->Body = "
                Greetings, <b>$full_name</b>! <br><br>

                We received a request to reset the <b>password</b> of your account. Please use the reset password link below to reset your password. <br><br>

                Your reset password link is: <a href='$link' target='_blank'>Click here to reset password</a>
                
                <br><br>

                Steps in resetting your password: <br>
                1. Enter your <b>New Password</b> and <b>Confirm New Password</b>. <br>
                2. Click <b>Reset Password</b>. <br><br>

                Note: <br>
                1. This password reset link is valid only for the next <b>5 minutes</b>. <br>
                2. If you didn't request this, please ignore this email or contact our support team immediately. <br><br>

                Regards, <br>
                <b>Laser Tripwire Support Team</b>
            ";

            $mail->send();

            return ["success" => true, "message" => "Email sent successfully."];
        } 
        
        catch (Exception $e) {
            error_log("Error: " . $mail->ErrorInfo);
            return ["success" => false, "message" => "Error in sending email! Please try again."];
        }
    }

    function send_inquiry_details($email, $full_name, $phone_number, $service_type, $address) {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->SMTPAuth = true;
            $mail->Host = MAILER_HOST;

            $mail->Username = MAILER_USERNAME;
            $mail->Password = MAILER_PASSWORD;
            $mail->SMTPSecure = "ssl";
            $mail->Port = MAILER_PORT;

            $mail->setFrom(MAILER_USERNAME, MAILER_NAME);
            $mail->addAddress($email, $full_name);

            $mail->isHTML(true);
            $mail->Subject = "LTAS: Inquiry Sent";
            $mail->Body = "
                Hello, <b>$full_name</b>! <br><br>

                Thank you for reaching out on us! <br><br>
                
                The following below are your inquiry details.<br><br>

               <b>Phone Number: $phone_number</b><br>
               <b>Full Address: $address</b><br>
               <b>Service Type: $service_type</b><br><br>

                We will contact you withing 2-3 days based on your contact information provided.<br><br>

                Once again, thank you for your patience and understanding!<br><br>

                Regards, <br>
                <b>Laser Tripwire Support Team</b>
            ";

            $mail->send();

            return ["success" => true, "message" => "Email sent successfully."];
        } 
        
        catch (Exception $e) {
            error_log("Error: " . $mail->ErrorInfo);
            return ["success" => false, "message" => "Error in sending email! Please try again."];
        }
    }

    function update_appointment_details($email, $full_name, $phone_number, $service_type, $address, $date, $time) {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->SMTPAuth = true;
            $mail->Host = MAILER_HOST;

            $mail->Username = MAILER_USERNAME;
            $mail->Password = MAILER_PASSWORD;
            $mail->SMTPSecure = "ssl";
            $mail->Port = MAILER_PORT;

            $mail->setFrom(MAILER_USERNAME, MAILER_NAME);
            $mail->addAddress($email, $full_name);

            $mail->isHTML(true);
            $mail->Subject = "LTWS: Appointment Details";
            $mail->Body = "
                Hello, <b>$full_name</b>! <br><br>

                Thank you for connecting and confirming your appointment with us! <br><br>
                
                The following below are your UPDATE appointment details.<br><br>

               <b>Phone Number: $phone_number</b><br>
               <b>Full Address: $address</b><br>
               <b>Service Type: $service_type</b><br>
               <b>Date: $date</b><br>
               <b>Time: $time</b><br><br>

                We will contact you again during the day of your appointment.<br><br>

                Once again, thank you for your patience and understanding!<br><br>

                Regards, <br>
                <b>Laser Tripwire Support Team</b>
            ";

            $mail->send();

            return ["success" => true, "message" => "Email sent successfully."];
        } 
        
        catch (Exception $e) {
            error_log("Error: " . $mail->ErrorInfo);
            return ["success" => false, "message" => "Error in sending email! Please try again."];
        }
    }
?>