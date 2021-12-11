<?php
require 'Config.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$username = Config::$username;
$password = Config::$password;
$host = Config::$ip;
$dbname = Config::$database;

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
$sql = $pdo->prepare('SELECT a.attendence_date as attendence_date, 
       a.comment as comment,
       p.fname as fname, p.mname as mname, p.lname as lname, p.birthday as birthday,
       d.dname as dname, 
       dc.fname as dfname, dc.mname as dmname, dc.lname as dlname,
       l.level_name as level_name,
       dr.name as drname, dr.usage as description, dr.price as price,
       pre.number as num, pre.prescription_id as prescription_id
        FROM attendence a, patient p, department d,level l,doctor dc, prescription pre, drug dr
    limit 1');
$q = $sql->execute([]);
$sql->setFetchMode(PDO::FETCH_ASSOC);
?>
<?php while ($row = $sql->fetch()): ?>
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
                    <td><?php echo htmlspecialchars($row['attendence_date']); ?></td>
                </tr>
                <tr>
                    <th scope="row">Comment</th>
                    <td><form class="d-flex"><input class="form-control me-2" type="text"><input type="submit" class="btn btn-sm btn-primary"></form>
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
                    <td><?php echo htmlspecialchars($row['fname']).' '. htmlspecialchars($row['mname']). ' ' .htmlspecialchars($row['lname']) ?></td>
                    </td>
                </tr>
                <tr>
                    <th scope="row">Age
                    </th>
                    <td><?php echo 2021 - substr(htmlspecialchars($row['birthday']), 0, 4); ?></td>
                </tr>
                <tr>
                    <th scope="row">Birthday
                    </th>
                    <td><?php echo htmlspecialchars($row['birthday']); ?></td>
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
                    <td><?php echo htmlspecialchars($row['dfname']).' '. htmlspecialchars($row['dmname']). ' ' .htmlspecialchars($row['dlname']) ?></td>
                </tr>
                <tr>
                    <th scope="row">Department
                    </th>
                    <td><?php echo htmlspecialchars($row['dname']); ?></td>
                </tr>
                <tr>
                    <th scope="row">Level
                    </th>
                    <td><?php echo htmlspecialchars($row['level_name']); ?></td>
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
                    <th scope="col">Count</th>
                    <th scope="col">Price</th>
                    <th scope="col">Description</th>
                </tr>
                </thead>
                <tbody>
                <tr>

                    <td><?php echo htmlspecialchars($row['drname']); ?></td>
                    <td><?php echo htmlspecialchars($row['num']); ?></td>
                    <td><?php echo htmlspecialchars($row['price']); ?></td>
                    <td><?php echo htmlspecialchars($row['description']); ?></td>
                    <td>
                            <?php echo '<form action="edit_prescription_delect.php" method="post"><input class="btn btn-sm btn-danger" type="submit" value="Delete"><input type="hidden" name="prescription_id" value="' . htmlspecialchars($row['prescription_id']) . '"></form>'; ?>

                    </td>
                </tr>
                </tbody>
            </table>
            <input class="btn btn-primary" type="button" value="Add medicine" action="search_medicine.php">




        </div>
    </div>
</div>
    <?php endwhile; ?>
    <?php
} catch(PDOException $e) {
    echo $sql->queryString . "<br>" . $e->getMessage();
}
$conn = null;
?>
</body>
</html>
