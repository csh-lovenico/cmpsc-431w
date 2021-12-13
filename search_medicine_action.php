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
$func = 1;

if (isset($_GET['keyword'])) {
    $keyword = $_GET['keyword'];
}
if (isset($_GET['page'])) {
    $page = $_GET['page'];
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
    search($keyword, $pdo, $min);
} else if ($func == 2) {
    $att_id = 0; $drug_id = 0; $num = 0;
    if (isset($_GET['appid'])) {
        $att_id = $_GET['appid'];
    }
    if (isset($_GET['drugid'])) {
        $drug_id = $_GET['drugid'];
    }
    if (isset($_GET['num'])) {
        $num = $_GET['num'];
    }
    //$drug_id = '"'.$drug_id.'"';
    //$att_id = '"'.$att_id.'"';
    select_drug($att_id, $drug_id, $num, $pdo);
}

function select_drug($att_id, $drug_id, $num, $pdo) {

    try {
        $pdo->beginTransaction();

        $sql = $pdo->prepare('SELECT stock from drug WHERE drug_id = :drugid ');
        $sql->execute(['drugid' => $drug_id]);
        $val = $sql->fetch();
        if ($val['stock'] >= $num) {
            $sql = $pdo->prepare('UPDATE drug SET stock = stock - :val WHERE drug_id = :drugid and stock - :val > 0');
            $sql->bindParam(':val', $num, PDO::PARAM_INT);
            $sql->bindParam(':drugid', $drug_id, PDO::PARAM_STR);
            $sql->execute();

            $sql = $pdo->prepare('insert into prescription(attendence_id, drug_id, number) VALUES (:attid,:drugid,:num)');
            $sql->bindParam(':num', $num, PDO::PARAM_INT);
            $sql->bindParam(':drugid', $drug_id, PDO::PARAM_STR);
            $sql->bindParam(':attid', $att_id, PDO::PARAM_STR);
            $sql->execute();

            $pdo->commit();
            echo (1);
        } else {
            $pdo->rollback();
            echo (0);
        }

    } catch (Exception $e) {
        $result = array(['error' => 500, 'message' => $e->getMessage()]);
    }

}

function search($keyword, $pdo, $min) {
    try {
        if ($keyword != "") {
            $sql = $pdo->prepare('SELECT drug_id, price, name, stock, company_name, `usage` FROM drug where drug.name like :keyword limit :min,10');
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
}

