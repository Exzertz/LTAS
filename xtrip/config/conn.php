<?php
    date_default_timezone_set("Asia/Manila");
    session_start();

    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "ltaw_final";

    try {
        $dsn = "mysql:host=$host;dbname=$database;charset=utf8mb4";
        $conn = new PDO($dsn, $username, $password);

        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    }

    catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
        exit();
    }

?>