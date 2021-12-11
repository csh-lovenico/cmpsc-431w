<?php
require 'Config.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$username = Config::$username;
$password = Config::$password;
$host = Config::$ip;
$dbname = Config::$database;

if (!isset($_GET['docid']) || !isset($_GET['patid'])) {
    die('invalid query string');
}

$doc_id = $_GET['docid'];
$pat_id = $_GET['patid'];

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
} catch (PDOException $e) {
    die("Could not connect to the database $dbname :" . $e->getMessage());
}

try {
    $sql = $pdo->prepare('insert into appointment(doctor_id, patient_id, app_date) VALUES (:did,:pid,:date)');
    $sql->execute(['did' => $doc_id, 'pid' => $pat_id, 'date' => date('YYYY-mm-dd')]);

} catch (PDOException $e) {
    $result = array('success' => false, 'message' => $e->getMessage());
    echo $sql->queryString . "<br>" . $e->getMessage();
}

echo 'success';