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
    sort_apportment_history($pdo, $doctor_id, $cou % 2);
} else if ($func == 2) {
    add_apportment_record();
} else if ($func == 3) {
    $doctor_id = $_GET['user_id'];
    get_apportment_record($pdo, $doctor_id);
}




function sort_apportment_history($pdo, $doctor_id, $mode) {
    if ($mode == 0) {
        $user_id = $_GET['user_id'];
        try {
            $sql = $pdo->prepare('SELECT app_date, CONCAT(fname, mname, lname) as patient_name FROM appointment A, patient P where P.patient_id = A.patient_id AND doctor_id = "' . $doctor_id . '" order by app_date desc limit 10 ');
            $q = $sql->execute([]);
            $sql->setFetchMode(PDO::FETCH_ASSOC);

            $content = array();
            $count = 0;
            while ($row = $sql->fetch()):
                $content['"'.$count.'"'] = array();
                array_push($content['"'.$count.'"'], array("app_date" => $row['app_date'], "patient_name" => $row['patient_name']));
                ++$count;
            endwhile;
            $ret = json_encode($content);
            echo $ret;

        } catch (PDOException $e) {
            echo $sql->queryString . $e->getMessage();
        }
    } else {
        $user_id = $_GET['user_id'];
        try {
            $sql = $pdo->prepare('SELECT app_date, CONCAT(fname, mname, lname) as patient_name FROM appointment A, patient P where P.patient_id = A.patient_id AND doctor_id = "' . $doctor_id . '" order by app_date limit 10 ');
            $q = $sql->execute([]);
            $sql->setFetchMode(PDO::FETCH_ASSOC);

            $content = array();
            $count = 0;
            while ($row = $sql->fetch()):
                $content['"'.$count.'"'] = array();
                array_push($content['"'.$count.'"'], array("app_date" => $row['app_date'], "patient_name" => $row['patient_name']));
                ++$count;
            endwhile;
            $ret = json_encode($content);
            echo $ret;

        } catch (PDOException $e) {
            echo $sql->queryString . $e->getMessage();
        }
    }
}

function add_apportment_record() {
    $user_id = $_GET['user_id'];
    echo ($user_id);
}

function get_apportment_record($pdo, $doctor_id)
{
    $user_id = $_GET['user_id'];
    try {
        $sql = $pdo->prepare('SELECT app_date as date, CONCAT(fname, mname, lname) as patient_name FROM appointment A, patient P where P.patient_id = A.patient_id AND doctor_id = "' . $doctor_id . '" order by app_date limit 10 ');
        $q = $sql->execute([]);
        $sql->setFetchMode(PDO::FETCH_ASSOC);

        $content = array();
        $count = 0;
        while ($row = $sql->fetch()):
            $content['"'.$count.'"'] = array();
            array_push($content['"'.$count.'"'], array("app_date" => $row['date'], "patient_name" => $row['patient_name']));
            ++$count;
        endwhile;
        $ret = json_encode($content);
        echo $ret;

    } catch (PDOException $e) {
        echo $sql->queryString . $e->getMessage();
    }
}
?>
