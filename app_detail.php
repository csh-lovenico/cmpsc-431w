<?php
require 'Config.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$username = Config::$username;
$password = Config::$password;
$host = Config::$ip;
$dbname = Config::$database;

if (!isset($_GET['id'])) {
    die('invalid id<br>sample: app_detail.php?id=1');
}

$app_id = $_GET['id'];
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
} catch (PDOException $e) {
    die("Could not connect to the database $dbname :" . $e->getMessage());
}
?>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php
    try {
        session_start();
        $patientId = $_SESSION['user_id'];

        $sql = $pdo->prepare('SELECT a.attendence_date as attendence_date, 
            a.comment as comment,a.attendance_id as attendance_id,
            p.fname as fname, p.mname as mname, p.lname as lname, p.birthday as birthday,p.patient_id as patient_id,
            d.dname as dname, 
            dc.fname as dfname, dc.mname as dmname, dc.lname as dlname,
            l.level_name as level_name
            FROM attendence a, patient p, department d,level l,doctor dc
            WHERE a.patient_id=p.patient_id and a.doctor_id=dc.doctor_id and dc.department_id = d.department_id and l.level_id = dc.level and attendance_id=:aid');

        $q = $sql->execute(['aid' => $app_id]);
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $result = $sql->fetchAll();
    } catch (PDOException $e) {
        echo $sql->queryString . "<br>" . $e->getMessage();
    }
    ?>

    <title>Appointment Details
    </title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
            crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
<header>
    <nav class="navbar navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand m-0 h1" href="index.php">Hospital Name</a>
            <a class="d-flex" href="logout.php">Logout</a>
        </div>
    </nav>
</header>
<div class="container">
    <div class="row">
        <h2>Basic info</h2>
    </div>

    <div class="row">
        <div class="col-md-10">
            <table class="table">
                <!--                --><?php //while ($row = $sql->fetch()): ?>
                <tr>
                    <th scope="row">Date</th>
                    <td><?php echo htmlspecialchars($result[0]['attendence_date']); ?></td>
                </tr>
                <tr>
                    <th scope="row">Comment</th>
                    <td><?php echo htmlspecialchars($result[0]['comment']); ?>
                    </td>
                </tr>

            </table>
        </div>
    </div>

    <div class="row">
        <h2>Patient info</h2>
    </div>
    <div class="row">
        <div class="col-md-6">
            <table class="table table-borderless">
                <tr>
                    <th scope="row">Name
                    </th>
                    <td><?php echo htmlspecialchars($result[0]['fname']) . ' ' . htmlspecialchars($result[0]['mname']) . ' ' . htmlspecialchars($result[0]['lname']) ?></td>
                </tr>
                <tr>
                    <th scope="row">Age
                    </th>
                    <td><?php echo 2021 - substr(htmlspecialchars($result[0]['birthday']), 0, 4); ?></td>
                </tr>
                <tr>
                    <th scope="row">Birthday
                    </th>
                    <td><?php echo htmlspecialchars($result[0]['birthday']); ?></td>
                </tr>
            </table>
        </div>
    </div>
    <div class="row">
        <h2>Doctor info</h2>
    </div>


    <div class="row">
        <div class="col-md-6">
            <table class="table table-borderless">
                <tr>
                    <th scope="row">Name
                    </th>
                    <td>
                        <?php echo htmlspecialchars($result[0]['dfname']) . ' ' . htmlspecialchars($result[0]['dmname']) . ' ' . htmlspecialchars($result[0]['dlname']) ?>
                    </td>
                </tr>
                <tr>
                    <th scope="row">Department
                    </th>
                    <td><?php echo htmlspecialchars($result[0]['dname']); ?></td>
                </tr>
                <tr>
                    <th scope="row">Level
                    </th>
                    <td><?php echo htmlspecialchars($result[0]['level_name']); ?></td>
                </tr>
            </table>

        </div>
    </div>
    <div class="row">
        <h2>Prescription</h2>
    </div>
    <div class="row">
        <div class="col-md-10">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">Medicine name &nbsp;<a href="#">Sort by name...</a></th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Total Price</th>
                    <th scope="col">Description</th>
                </tr>
                </thead>
                <?php
                try {
                    $patientId = $_SESSION['user_id'];
                    $sql = $pdo->prepare('SELECT dr.name as drname, dr.usage as description, dr.price as price,
                        pre.number as num, pre.prescription_id as prescription_id
                        FROM prescription pre, drug dr
                        WHERE  dr.drug_id = pre.drug_id and attendence_id=:aid');
                    $q = $sql->execute(['aid' => $app_id]);
                    $sql->setFetchMode(PDO::FETCH_ASSOC);
                    $result = $sql->fetchAll();
                } catch (PDOException $e) {
                    echo $sql->queryString . "<br>" . $e->getMessage();
                }?>
                <tbody>
                <?php foreach ($result as $value) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($value['drname']); ?></td>
                        <td><?php echo htmlspecialchars($value['num']); ?></td>
                        <td><?php echo htmlspecialchars($value['price']); ?></td>
                        <td><?php echo htmlspecialchars($value['description']); ?></td>
                    </tr>
                <?php } ?>
                </tbody>
                <?php

                ?>
            </table>
        </div>
    </div>
</div>
</body>
</html>
