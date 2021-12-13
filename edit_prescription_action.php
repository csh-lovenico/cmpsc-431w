<?php
require 'Config.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$username = Config::$username;
$password = Config::$password;
$host = Config::$ip;
$dbname = Config::$database;
$id = "";
$page = 1;
$func = 1;

if (isset($_GET['id'])) {
    $id = $_GET['id'];
}
if (isset($_GET['func'])) {
    $func = $_GET['func'];
}
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
} catch (PDOException $e) {
    die("Could not connect to the database $dbname :" . $e->getMessage());
}
header('Content-Type: application/json');

$min = ($page - 1) * 10;

if ($func == 1) {
    $pre_id = 0;
    if (isset($_GET['pre_id'])) {
        $pre_id = $_GET['pre_id'];
    }
    get_data($pre_id, $pdo, $min);
} else if ($func == 2) {
    $pre_id = 0;
    if (isset($_GET['pre_id'])) {
        $pre_id = $_GET['pre_id'];
    }
    delete($pre_id, $pdo);
}

function delete($pre_id, $pdo) {

    try {
        $sql = $pdo->prepare('DELETE FROM prescription WHERE prescription_id = :pid');
        $sql->bindParam(':pid', $pre_id, PDO::PARAM_INT);
        $sql->execute();
        echo (1);
    } catch (Exception $e) {
        $result = array(['error' => 500, 'message' => $e->getMessage()]);
    }

}

function get_data($pre_id, $pdo, $min) {
    try {

        $sql = $pdo->prepare('SELECT d.drug_id, d.price, d.name, d.stock, d.`usage`, p.number FROM drug d, prescription p 
                WHERE d.drug_id = p.drug_id AND p.attendence_id = :preid limit :min,10');
        $sql->bindParam(':min', $min, PDO::PARAM_INT);
        $sql->bindParam(':preid', $pre_id, PDO::PARAM_INT);
        $q = $sql->execute();
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $result = $sql->fetchAll();
    } catch (Exception $e) {
        $result = array(['error' => 500, 'message' => $e->getMessage()]);
    }

    echo json_encode($result);
}

