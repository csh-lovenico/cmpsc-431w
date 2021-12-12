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
if(!isset($_SESSION['role'])||$_SESSION['role']!=0){
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
} catch (PDOException $e) {

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
<div class="row">
    <h1>Create prescription</h1>
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
        </table>
    </div>
</div>
<div class="row">
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
            <input type="submit" class="btn btn-primary" value="Submit">
        </form>
    </div>
</div>
</body>
</html>

