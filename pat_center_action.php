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

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
} catch (PDOException $e) {
    die("Could not connect to the database $dbname :" . $e->getMessage());
}

$func = $_GET['func'];
if ($func == 1) {
    $doctor_id = $_GET['user_id'];
    $cou = $_GET['mode'];
    get_allergy_his($pdo, $doctor_id, $cou % 2);
} else if ($func == 2) {
    get_medical_his_data();
} else if ($func == 3) {
    $doctor_id = $_GET['user_id'];
    delete_allergy_his($pdo, $doctor_id);
} else if ($func == 4) {
    delete_medical_his_data();
}


function delete_allergy_his($pdo, $doctor_id, $mode) {

}

function delete_medical_his_data($pdo, $doctor_id, $mode) {

}

function get_allergy_his() {
    $user_id = $_GET['user_id'];
    echo ($user_id);
}

function get_medical_his_data($pdo, $doctor_id)
{
    $user_id = $_GET['user_id'];
    try {
        $sql = $pdo->prepare('SELECT app_date as date, P.patient_id, CONCAT(fname,\' \', mname,\' \', lname) as patient_name FROM appointment A, patient P where P.patient_id = A.patient_id AND doctor_id = "' . $doctor_id . '" order by app_date limit 10 ');
        $q = $sql->execute([]);
        $sql->setFetchMode(PDO::FETCH_ASSOC);

        $content = array();
        $count = 0;
        while ($row = $sql->fetch()):
            $content['"'.$count.'"'] = array();
            array_push($content['"'.$count.'"'], array("app_date" => $row['date'], "patient_name" => $row['patient_name'], "pat_id" => $row['patient_id']));
            ++$count;
        endwhile;
        $ret = json_encode($content);
        echo $ret;

    } catch (PDOException $e) {
        echo $sql->queryString . $e->getMessage();
    }
}
?>
