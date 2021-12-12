<?php
require 'Config.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$username = Config::$username;
$password = Config::$password;
$host = Config::$ip;
$dbname = Config::$database;
$keyword = "";
$page = 1;

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
        $sql = $pdo->prepare('SELECT drug_id, price, name, stock, company_name, `usage` FROM drug 
where drug.name like :keyword
limit :min,10');
        $sql->bindParam(':min', $min, PDO::PARAM_INT);
        $str = $keyword.'%';
        $sql->bindParam(':keyword', $str, PDO::PARAM_STR);
    } else {
        $sql = $pdo->prepare('SELECT drug_id, price, name, stock, company_name, `usage` FROM drug limit :min , 10');
        $sql->bindParam(':min', $min, PDO::PARAM_INT);
    }
    $q = $sql->execute();
    $sql->setFetchMode(PDO::FETCH_ASSOC);

    $result = $sql->fetchAll();
} catch (Exception $e) {
    $result = array(['error' => 500, 'message' => $e->getMessage()]);
}

echo json_encode($result);
