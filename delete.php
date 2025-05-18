<?php
require 'connection.php';
$connect = Connect();

if(!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

try {
    $check_query = "SELECT id FROM contacts WHERE id = :id";
    $check_statement = $connect->prepare($check_query);
    $check_statement->bindParam(':id', $id, PDO::PARAM_INT);
    $check_statement->execute();

    if($check_statement->rowCount() == 0) {
        header('Location: index.php');
        exit;
    }

    $delete_query = "DELETE FROM contacts WHERE id = :id";
    $delete_statement = $connect->prepare($delete_query);
    $delete_statement->bindParam(':id', $id, PDO::PARAM_INT);
    $delete_statement->execute();

    header('Location: index.php?success=deleted');
    exit;
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
    echo "<br><a href='index.php'>Back to Contacts</a>";
    die();
}
?>
