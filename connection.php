<?php
function Connect() {
    try {
        // Database credentials for the contact manager
        $host = "localhost";
        $dbname = "contact_manager";
        $username = "root";
        $password = "";

        $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        // Set PDO error mode to exception for better error handling
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $conn;
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
        die();
    }
}
?>
