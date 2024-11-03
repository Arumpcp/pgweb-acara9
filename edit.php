<?php
$host = 'localhost';
$dbname = 'acara9';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Mengupdate data berdasarkan ID
    $id = $_GET['id'];
    $name = $_GET['name'];
    $query = $pdo->prepare("UPDATE locations SET name = :name WHERE id = :id");
    $query->bindParam(':id', $id, PDO::PARAM_INT);
    $query->bindParam(':name', $name, PDO::PARAM_STR);
    if ($query->execute()) {
        echo "success";
    } else {
        echo "error";
    }
} catch (PDOException $e) {
    echo "error";
}
?>
