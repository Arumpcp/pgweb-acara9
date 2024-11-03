<?php
$host = 'localhost';
$dbname = 'acara_9';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Menghapus data berdasarkan ID
    $id = $_GET['id'];
    $query = $pdo->prepare("DELETE FROM locations WHERE id = :id");
    $query->bindParam(':id', $id, PDO::PARAM_INT);
    if ($query->execute()) {
        echo "success";
    } else {
        echo "error";
    }
} catch (PDOException $e) {
    echo "error";
}
?>
