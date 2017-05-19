<?php
$dsn = 'mysql:host=localhost;dbname=renanpro_contador';
$user = 'renanpro_od';
$password = 'ondadura2017';
try {
    $conn = new PDO($dsn, $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo $e->getMessage();
}
?>