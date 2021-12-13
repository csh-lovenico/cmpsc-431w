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
    $pid = $_GET['pid'];
    get_allergy_his($pdo, $pid);
} else if ($func == 2) {
    $pid = $_GET['pid'];
    get_medical_his_data($pdo, $pid);
} else if ($func == 3) {
    $id = $_GET['idd'];
    delete_allergy_his($pdo, $id);
} else if ($func == 4) {
    $id = $_GET['idd'];
    delete_medical_his_data($pdo, $id);
} else if ($func == 5) {
    $pid = $_GET['pid'];
    $desc = $_GET["adesc"];
    $aname = $_GET["aname"];
    add_allergy_his($pdo, $pid, $desc, $aname);
} else if ($func == 6) {
    $pid = $_GET['pid'];
    $desc = $_GET["desc"];
    $name = $_GET["name"];
    add_medical_his_data($pdo, $pid, $desc, $name);
} else if ($func == 7) {
    $pid = $_GET['pid'];
    $cou = $_GET["cou"];
    load_app_his($pdo, $pid, $cou % 2);
}

function load_app_his($pdo, $pid, $mode) {
    try {
        if ($mode == 0) {
            $sql = $pdo->prepare('SELECT a.attendance_id as aid, a.attendence_date as adate,d.fname as dfname, d.mname as dmname, d.lname as dlname FROM attendence a,patient p,doctor d 
        WHERE a.patient_id = p.patient_id and a.doctor_id = d.doctor_id and p.patient_id = :patient_id order by adate desc');
            $q = $sql->execute(['patient_id' => $pid]);
        } else {
            $sql = $pdo->prepare('SELECT a.attendance_id as aid, a.attendence_date as adate,d.fname as dfname, d.mname as dmname, d.lname as dlname FROM attendence a,patient p,doctor d 
        WHERE a.patient_id = p.patient_id and a.doctor_id = d.doctor_id and p.patient_id = :patient_id order by adate asc');
            $q = $sql->execute(['patient_id' => $pid]);
        }

        $result = $sql->fetchAll();
        $ret = json_encode($result);
        echo $ret;
    } catch (PDOException $e) {
        echo $sql->queryString . $e->getMessage();
    }
}

function add_allergy_his($pdo, $pid, $desc, $aname)
{
    try {
        $sql = $pdo->prepare('INSERT into allergy_history(patient_id, allergy_name, description) VALUES (:patient_id,:allergy_name,:description)');
        $sql->execute(["patient_id" => $pid, "allergy_name" => $aname, "description" => $desc]);
        echo(0);
    } catch (PDOException $e) {
        echo $sql->queryString . $e->getMessage();
    }
}

function add_medical_his_data($pdo, $pid, $desc, $name)
{
    try {
        $sql = $pdo->prepare('INSERT into medical_history(patient_id, disease_name, description) VALUES (:patient_id,:disease_name,:description)');
        $sql->execute(["patient_id" => $pid, "disease_name" => $name, "description" => $desc]);
        echo(0);
    } catch (PDOException $e) {
        echo $sql->queryString . $e->getMessage();
    }
}

function delete_allergy_his($pdo, $aid)
{
    try {
        $sql = $pdo->prepare('DELETE FROM allergy_history WHERE id = :aid');
        $sql->execute(["aid" => $aid]);
        echo(0);
    } catch (PDOException $e) {
        echo $sql->queryString . $e->getMessage();
    }
}

function delete_medical_his_data($pdo, $mid)
{
    try {
        $sql = $pdo->prepare('DELETE FROM medical_history WHERE medical_history_id = :aid');
        $sql->execute(["aid" => $mid]);
        echo(0);
    } catch (PDOException $e) {
        echo $sql->queryString . $e->getMessage();
    }
}

function get_allergy_his($pdo, $pid)
{
    try {
        $sql = $pdo->prepare('SELECT ah.id as id, ah.allergy_name as ahname, ah.description as ahdesc FROM patient p ,allergy_history ah where p.patient_id = ah.patient_id and p.patient_id = :patient_id');
        $q = $sql->execute(['patient_id' => $pid]);

        $result = $sql->fetchAll();
        $ret = json_encode($result);
        echo $ret;
    } catch (PDOException $e) {
        echo $sql->queryString . $e->getMessage();
    }
}

function get_medical_his_data($pdo, $pid)
{
    try {
        $sql = $pdo->prepare('SELECT mh.medical_history_id as id, mh.disease_name as mhname, mh.description as mhdesc, mh.medical_history_id as mhid FROM patient p,medical_history mh where p.patient_id = mh.patient_id and p.patient_id = :patient_id');
        $q = $sql->execute(['patient_id' => $pid]);

        $result = $sql->fetchAll();
        $ret = json_encode($result);
        echo $ret;
    } catch (PDOException $e) {
        echo $sql->queryString . $e->getMessage();
    }
}

?>
