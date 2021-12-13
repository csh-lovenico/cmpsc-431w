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

session_start();
$doctor_id = $_SESSION['user_id'];
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
    <script src="js/doc_center.js"></script>
</head>
<body onload=get_app_record(<?php echo '"' . $doctor_id . '"'; ?>)>
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
        <h1>User Center</h1>
    </div>
    <?php
    try {
        $sql = $pdo->prepare('SELECT fname, mname, lname FROM doctor where doctor_id = :docid');
        $q = $sql->execute(['docid' => $doctor_id]);
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        ?>
        <div class="row">
            <?php $row = $sql->fetch(); ?>
            <p>Hello, <?php echo $row['fname'] . ' ' . $row['mname'] . ' ' . $row['lname'] ?></p>
        </div>

        <div class="row">
            <h2>Appointment History</h2>
        </div>
        <div class="row">
            <div class="col-md-10">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">Date &nbsp;<button
                                    class="btn btn-sm btn-outline-secondary"
                                    onclick=sort_app_record(<?php echo '"' . $doctor_id . '"'; ?>)>Sort by date
                            </button>
                        </th>
                        <th scope="col">Patient</th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody id="app_table_body"></tbody>
                </table>
                <div class="mb-3">

                    <button type="button" onclick="location.href='search_patient.php'" class="btn btn-primary">Add
                        appointment record
                    </button>
                </div>
            </div>
        </div>
        <?php
    } catch (PDOException $e) {
        echo $sql->queryString . $e->getMessage();
    }
    $conn = null;
    ?>

    <p id="docinfo" style="display:none"><?php echo $_SESSION['user_id'] ?></p>
</div>
</body>
</html>