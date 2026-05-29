<?php

    function generateUserId($length = 12) {
        $random_numbers = "";

        for($i = 0; $i < $length; $i++) {
            $random_numbers .= mt_rand(0, 9);
        }
        
        return "user@" . $random_numbers;
    }

    function generate_verification_token($length = 16) {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomToken = '';

        for ($i = 0; $i < $length; $i++) {
            $randomToken .= $characters[random_int(0, $charactersLength - 1)];
        }
    
        return $randomToken;
    }

    function generate_expiry_time($minutes) {
         $expiry_time = date("Y-m-d H:i:s", strtotime("+$minutes minutes"));

         return $expiry_time;
    }

    function is_valid_appointment_date($date) {
        // Validate date format strictly
        $dateObject = DateTime::createFromFormat('Y-m-d', $date);
        $is_valid_format = $dateObject && $dateObject->format('Y-m-d') === $date;

        if (!$is_valid_format) {
            return false;
        }

        // Get today's date at midnight
        $today = new DateTime();
        $today->setTime(0, 0, 0);  // Strip time for accurate comparison

        // Get the appointment date
        $appointment_date = DateTime::createFromFormat('Y-m-d', $date);
        
        // Must be at least tomorrow
        return $appointment_date > $today;
    }

    function is_valid_appointment_time($time) {
        // Validate format
        $timeObject = DateTime::createFromFormat('H:i', $time);
        $is_valid_format = $timeObject && $timeObject->format('H:i') === $time;

        if (!$is_valid_format) {
            return false;
        }

        // Define working hours
        $start = DateTime::createFromFormat('H:i', '08:00');
        $end = DateTime::createFromFormat('H:i', '16:00');

        // Check if time is within range
        return $timeObject >= $start && $timeObject <= $end;
    }


    $allowed_img_format = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp', 'svg', 'tiff', 'ico', 'jfif'];

    $allowed_genders = ["Male", "Female", "Others"];
    $allowed_status = ["Single", "Married", "Divorced", "Widowed"];
    $allowed_occupations = ["Employed", "Self-Employed", "Student", "Unemployed", "Others"];

    $allowed_services = ["Order and Install", "Maintenance", "Repair"];

    $password_pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,16}$/';
    $cellphone_pattern = '/^(\+639|09)\d{9}$/';
    $telephone_pattern = '/^(\d{7}|0\d{9})?$/'; 
?>