<?php
require 'Config.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$username = Config::$username;
$password = Config::$password;
$host = Config::$ip;
$dbname = Config::$database;

session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 0) {
    die('invalid operation');
}

// TODO: Uncomment this before submission
$pid = $_GET['pid'];
$did = $_SESSION['user_id'];

// TODO: Delete this before submission
//$pid = 'pat0';
//$did = 'doc0';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
} catch (PDOException $e) {
    die("Could not connect to the database $dbname :" . $e->getMessage());
}

try {
    $sql = $pdo->prepare('select * from patient where patient_id=:pid');
    $sql->execute(['pid' => $pid]);
    $pat_info = $sql->fetch();

    $sql = $pdo->prepare('select disease_name, description from patient p,medical_history m
where m.patient_id = p.patient_id and p.patient_id=:pid');
    $sql->execute(['pid' => $pid]);
    $mh_info = $sql->fetchAll();

    $sql = $pdo->prepare('select allergy_name,description from patient p, allergy_history a 
where p.patient_id=a.patient_id and p.patient_id=:pid');
    $sql->execute(['pid' => $pid]);
    $ah_info = $sql->fetchAll();
} catch (PDOException $e) {
    echo $sql->queryString . "<br>" . $e->getMessage();
}

?>
<html lang="en">
<head>
    <title>Create prescription</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
            crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="js/create_pres_action.js"></script>
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
        <div class="col-md-6">
            <h1>Create prescription</h1>
            <h1></h1>
            <h1></h1>
            <h1></h1>
        </div>
    </div>
    <div class="row">
        <h2></h2>
        <h2></h2>
        <h2>Patient info</h2>
        <h2></h2>
        <h2></h2>

    </div>
    <div class="row">
        <div class="col-md-6">
            <table class="table table-borderless">
                <tr>
                    <th scope="row">Name
                    </th>
                    <td><?php echo htmlspecialchars($pat_info['fname']) . ' ' . htmlspecialchars($pat_info['mname']) . ' ' . htmlspecialchars($pat_info['lname']) ?></td>
                </tr>
                <tr>
                    <th scope="row">Age
                    </th>
                    <td><?php echo 2021 - substr(htmlspecialchars($pat_info['birthday']), 0, 4); ?></td>
                </tr>
                <tr>
                    <th scope="row">Birthday
                    </th>
                    <td><?php echo htmlspecialchars($pat_info['birthday']); ?></td>
                </tr>
                <tr>
                    <th scope="row">Gender
                    </th>
                    <td><?php echo htmlspecialchars($pat_info['gender']); ?></td>
                </tr>

            </table>
        </div>
    </div>
    <div class="row">
        <h2>Medical History</h2>
        <div class="col-md-10">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">Disease name</th>
                    <th scope="col">Description</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($mh_info as $mh_record) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($mh_record['disease_name']); ?></td>
                        <td><?php echo htmlspecialchars($mh_record['description']); ?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="row">
        <h2>Allergy History</h2>
        <div class="col-md-10">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">Allergy name</th>
                    <th scope="col">Description</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($ah_info as $ah_record) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($ah_record['allergy_name']); ?></td>
                        <td><?php echo htmlspecialchars($ah_record['description']); ?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="row">
        <h2></h2>
        <h2>
            Add comment
        </h2>
    </div>
    <div class="row">
        <div class="col-6">
            <form method="post" action="create_pres_action.php?pid=<?php echo $pid ?>">
                <div class="mb-3">
                    <textarea class="form-control" id="comment" name="comment"></textarea>
                </div>
                <input type="button" class="btn btn-primary" onclick=submit_comment() value="Submit">
            </form>
        </div>
    </div>
</div>
<p style="display: none" id="pid"><?php echo $pid ?></p>
</body>
</html>

