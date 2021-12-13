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
$did = $_SESSION['user_id'];
$cou = $_GET['cou'];
if (isset($_GET['keyword'])) {
    $keyword = $_GET['keyword'];
}
if (isset($_GET['page'])) {
    $page = $_GET['page'];
}
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
} catch (PDOException $e) {
    die("Could not connect to the database $dbname :" . $e->getMessage());
}

header('Content-Type: application/json');

$min = ($page - 1) * 10;

try {
    if ($keyword != "") {
        $sql = '';
        if ($cou % 2 == 0) {
            $sql = $pdo->prepare('SELECT p.patient_id as patient_id,p.fname as fname,p.mname as mname,p.lname as lname, birthday, p.email as email FROM patient p,appointment a,doctor d 
where (p.fname like :keyword or p.mname like :keyword or p.lname like :keyword)
and a.patient_id=p.patient_id and a.doctor_id = d.doctor_id and d.doctor_id=:did and a.app_date=:date order by fname desc
limit :min,10');
        } else {
            $sql = $pdo->prepare('SELECT p.patient_id as patient_id,p.fname as fname,p.mname as mname,p.lname as lname, birthday, p.email as email FROM patient p,appointment a,doctor d 
where (p.fname like :keyword or p.mname like :keyword or p.lname like :keyword)
and a.patient_id=p.patient_id and a.doctor_id = d.doctor_id and d.doctor_id=:did and a.app_date=:date order by fname asc
limit :min,10');
        }
        $sql->bindParam(':min', $min, PDO::PARAM_INT);
        $sql->bindParam(':did', $did, PDO::PARAM_STR);
        $date = date('Y-m-d');
        $sql->bindParam(':date', $date, PDO::PARAM_STR);
        $str = $keyword . '%';
        $sql->bindParam(':keyword', $str, PDO::PARAM_STR);
    } else {
        if ($cou % 2 == 0) {
            $sql = $pdo->prepare('SELECT p.patient_id as patient_id,p.fname as fname,p.mname as mname,p.lname as lname, birthday, p.email as email FROM patient p,doctor d,appointment a
where a.patient_id=p.patient_id and a.doctor_id = d.doctor_id and d.doctor_id=:did and a.app_date=:date order by fname desc
limit :min , 10');
        } else {
            $sql = $pdo->prepare('SELECT p.patient_id as patient_id,p.fname as fname,p.mname as mname,p.lname as lname, birthday, p.email as email FROM patient p,doctor d,appointment a
where a.patient_id=p.patient_id and a.doctor_id = d.doctor_id and d.doctor_id=:did and a.app_date=:date order by fname asc
limit :min , 10');
        }
        $sql->bindParam(':did', $did, PDO::PARAM_STR);
        $date = date('Y-m-d');
        $sql->bindParam(':date', $date, PDO::PARAM_STR);
        $sql->bindParam(':min', $min, PDO::PARAM_INT);
    }
    $q = $sql->execute();
    $sql->setFetchMode(PDO::FETCH_ASSOC);

    $result = $sql->fetchAll();
} catch (Exception $e) {
    $result = array(['error' => 500, 'message' => $e->getMessage()]);
}

echo json_encode($result);
