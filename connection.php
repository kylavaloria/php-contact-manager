<?php
function Connect() {
    try {
        $host = "localhost";
        $dbname = "contact_manager";
        $username = "root";
        $password = "";

        $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $conn;
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
        die();
    }
}
?>
