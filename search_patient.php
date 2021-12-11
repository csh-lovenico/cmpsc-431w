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
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Search Patient</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
            crossorigin="anonymous"></script>
    <script src="js/search_patient.js"></script>
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
        <div class="col">
            <h2>Select a patient</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <form action="search_patient.php" method="get" class="d-flex">
                <input class="form-control me-2" name="patient_name" id="patient_name"
                       type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success" type="submit" onclick=search_patient_by_name()>Search</button>
            </form>
        </div>

    </div>
    <div class="row">
        <div class="col-md-10">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>Name &nbsp;<a href="#">Sort by name...</a></th>
                    <th>Age</th>
                    <th>Email</th>
                    <th></th>
                </tr>
                </thead>
                    <tbody id="search_patient_table_body"></tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
