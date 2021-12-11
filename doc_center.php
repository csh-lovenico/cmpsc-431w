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
?>
<html lang="en">
<head>
    <title>Doctor Center</title>
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
        </div>
    </nav>
</header>
<div class="container">
    <div class="row">
        <h1>User Center</h1>
    </div>
    <?php
    try {
        session_start();
        $doctor_id = $_SESSION['user_id'];
        echo $doctor_id;
        $sql = $pdo->prepare('SELECT fname, mname, lname FROM doctor where doctor_id = "'.$doctor_id.'"');
        $q = $sql->execute([]);
        $sql->setFetchMode(PDO::FETCH_ASSOC);
    ?>
    <div class="row">
        <p>Hello, Maki Nishikino</p>
        <?php while ($row = $sql->fetch()): ?>
            <p>Hello, <?php echo $row['fname'].' '.$row['mname'].' '.$row['lname'] ?></p>
        <?php endwhile; ?>
        <div class="mb-3">
            <button class="btn btn-primary">Edit profile</button>
        </div>
    </div>

    <div class="row">
        <h2>Appointment History</h2>
    </div>
    <div class="row">
        <div class="col-md-10">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">Date &nbsp;<a href="#">Sort by date</a></th>
                    <th scope="col">Patient</th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>2021-12-01</td>
                    <td>Nico Yazawa</td>
                    <td>
                        <div>
                            <button type="button" class="btn btn-sm btn-secondary">Detail</button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>2021-11-23</td>
                    <td>Lanzhu Zhong</td>
                    <td>
                        <div>
                            <button type="button" class="btn btn-sm btn-secondary">Detail</button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>2021-10-31</td>
                    <td>Ruby Kurosawa</td>
                    <td>
                        <div>
                            <button type="button" class="btn btn-sm btn-secondary">Detail</button>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
            <div class="mb-3">
                <button type="button" onclick="window.location.href='search_patient.php'" class="btn btn-primary">Add
                    appointment record
                </button>
            </div>
        </div>
    </div>
        <?php
    } catch(PDOException $e) {
        echo $sql->queryString . $e->getMessage();
    }
    $conn = null;
    ?>
</div>
</body>
</html>