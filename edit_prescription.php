<?php
require 'Config.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$username = Config::$username;
$password = Config::$password;
$host = Config::$ip;
$dbname = Config::$database;
$new_mode = false;

if (!isset($_GET['id'])) {
    die('must specify id');
}

$att_id = $_GET['id'];

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
    <title>Appointment Details
    </title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
            crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
<?php
try {
    $sql = $pdo->prepare('select a.attendence_date as adate, a.comment as acomment,
d.fname as dfname,d.mname as dmname,d.lname as dlname, l.level_name as dlvname, dp.dname as ddpname,
       p.fname as pfname,p.mname as pmname, p.lname as plname, p.birthday as pbday, p.gender as pgender
from attendence a,doctor d,patient p, level l, department dp
where d.department_id=dp.department_id and d.level=l.level_id and a.doctor_id=d.doctor_id and a.patient_id=p.patient_id and a.attendance_id=:aid');

    $q = $sql->execute(['aid' => $att_id]);
    $sql->setFetchMode(PDO::FETCH_ASSOC);
    $app_basic_info = $sql->fetch();

    $sql = $pdo->prepare('select d.drug_id as did, p.prescription_id as pid, d.name as dname,p.number as dnum, d.`usage` as dusage, d.price as dprice from attendence a,prescription p,drug d
where a.attendance_id=p.attendence_id and p.drug_id=d.drug_id and a.attendance_id=:aid');
    $q = $sql->execute(['aid' => $att_id]);
    $sql->setFetchMode(PDO::FETCH_ASSOC);
    $pres_info = $sql->fetchAll();
} catch (PDOException $e) {
    echo $sql->queryString . "<br>" . $e->getMessage();
}
?>
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
        <div class="col-md-8">
            <table class="table">
                <tr>
                    <th scope="row">Date</th>
                    <td><?php echo $app_basic_info['adate']; ?></td>
                </tr>
                <tr>
                    <th scope="row">Comment</th>
                    <td><?php echo $app_basic_info['acomment']; ?></td>
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
                    <td><?php echo htmlspecialchars($app_basic_info['pfname']) . ' ' . htmlspecialchars($app_basic_info['pmname']) . ' ' . htmlspecialchars($app_basic_info['plname']) ?></td>
                </tr>
                <tr>
                    <th scope="row">Age
                    </th>
                    <td><?php echo 2021 - substr(htmlspecialchars($app_basic_info['pbday']), 0, 4); ?></td>
                </tr>
                <tr>
                    <th scope="row">Birthday
                    </th>
                    <td><?php echo htmlspecialchars($app_basic_info['pbday']); ?></td>
                </tr>
                <tr>
                    <th scope="row">Gender
                    </th>
                    <td><?php echo htmlspecialchars($app_basic_info['pgender']); ?></td>
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
                    <td><?php echo htmlspecialchars($app_basic_info['dfname']) . ' ' . htmlspecialchars($app_basic_info['dmname']) . ' ' . htmlspecialchars($app_basic_info['dlname']) ?></td>
                </tr>
                <tr>
                    <th scope="row">Department
                    </th>
                    <td><?php echo htmlspecialchars($app_basic_info['ddpname']); ?></td>
                </tr>
                <tr>
                    <th scope="row">Level
                    </th>
                    <td><?php echo htmlspecialchars($app_basic_info['dlvname']); ?></td>
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
                    <th scope="col">Medicine name</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Price</th>
                    <th scope="col">Description</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($pres_info as $value) { ?>
                    <tr>

                        <td><?php echo htmlspecialchars($value['dname']); ?></td>
                        <td><?php echo htmlspecialchars($value['dnum']); ?></td>
                        <td><?php echo htmlspecialchars('$' . $value['dprice']); ?></td>
                        <td><?php echo htmlspecialchars($value['dusage']); ?></td>
                        <td>
                            <?php echo '<form action="edit_prescription_delect.php" method="post"><input class="btn btn-sm btn-danger" type="submit" value="Delete"><input type="hidden" name="prescription_id" value="' . htmlspecialchars($value['pid']) . '"></form>'; ?>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
            <input class="btn btn-primary me-3" type="button"
                   value="Add medicine" onclick="location.href='search_medicine.php?appid=<?php echo $att_id ?>'">
            <button class="btn btn-success me-3">Done</button>
        </div>
    </div>
</div>
</body>
</html>
