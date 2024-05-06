<?php
$host = 'postgres';
$user = 'db_user';
$pass = 'db_password';
$db = 'test_database';

try {
    $conn = new PDO("pgsql:host=$host;dbname=$db", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    die();
}
?>
