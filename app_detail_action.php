<?php
require 'Config.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set('America/New_York');
$username = Config::$username;
$password = Config::$password;
$host = Config::$ip;
$dbname = Config::$database;
$keyword = "";
$page = 1;
session_start();
$cou = $_GET['cou'];
$appid = $_GET['appid'];
if (isset($_GET['keyword'])) {
    $keyword = $_GET['keyword'];
}
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
} catch (PDOException $e) {
    die("Could not connect to the database $dbname :" . $e->getMessage());
}

header('Content-Type: application/json');

$min = ($page - 1) * 10;

try {
    $sql = '';
    if ($cou % 2 == 0) {
        $sql = $pdo->prepare('select d.drug_id as did, p.prescription_id as pid, d.name as dname,p.number as dnum, d.`usage` as dusage, d.price as dprice from attendence a,prescription p,drug d
where a.attendance_id=p.attendence_id and p.drug_id=d.drug_id and a.attendance_id=:aid order by dname desc');
        $q = $sql->execute(['aid' => $appid]);
    } else {
        $sql = $pdo->prepare('select d.drug_id as did, p.prescription_id as pid, d.name as dname,p.number as dnum, d.`usage` as dusage, d.price as dprice from attendence a,prescription p,drug d
where a.attendance_id=p.attendence_id and p.drug_id=d.drug_id and a.attendance_id=:aid order by dname asc');
        $q = $sql->execute(['aid' => $appid]);
    }
    $q = $sql->execute();
    $sql->setFetchMode(PDO::FETCH_ASSOC);

    $result = $sql->fetchAll();
} catch (Exception $e) {
    $result = array(['error' => 500, 'message' => $e->getMessage()]);
}

echo json_encode($result);