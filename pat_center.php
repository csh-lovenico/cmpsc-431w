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
if (!isset($_SESSION['user_id'])) {
    die('invalid user id');
}
$patient_id = $_SESSION['user_id'];

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
} catch (PDOException $e) {
    die("Could not connect to the database $dbname :" . $e->getMessage());
}
?>
<html lang="en">
<head>
    <title>User Center</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
            crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
<?php
try {
//$sql = $pdo->prepare('SELECT
//       a.attendence_date as attendence_date,
//       dc.fname as dfname, dc.mname as dmname, dc.lname as dlname,
//       m.disease_name as disease_name, m.description as description, m.medical_history_id as medical_history_id,
//       al.allergy_name as allergy_name, al.description as adescription, al.id as allergy_history_id,
//       p.fname as fname, p.mname as mname, p.lname as lname, p.patient_id as patient_id
//        FROM attendence a, patient p, medical_history m,allergy_history al, doctor dc
//        WHERE p.patient_id = :patient_id');
    $sql = $pdo->prepare('SELECT fname,mname,lname FROM patient where patient_id = :patient_id');
    $q = $sql->execute(['patient_id' => $patient_id]);
    $sql->setFetchMode(PDO::FETCH_ASSOC);
    $row = $sql->fetch();
} catch (PDOException $e) {
    echo $sql->queryString . "<br>" . $e->getMessage();
}
?>
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
    <div class="row">
        <p>
            Hello, <?php echo htmlspecialchars($row['fname']) . ' ' . htmlspecialchars($row['mname']) . ' ' . htmlspecialchars($row['lname']) ?></p>
        <div class="mb-3">
            <button class="btn btn-primary">Edit profile</button>
        </div>
    </div>
    <div class="row">
        <h2>Appointment History</h2>
    </div>
    <?php
    try {
        $sql = $pdo->prepare('SELECT a.attendance_id as aid, a.attendence_date as adate,d.fname as dfname, d.mname as dmname, d.lname as dlname FROM attendence a,patient p,doctor d 
        WHERE a.patient_id = p.patient_id and a.doctor_id = d.doctor_id and p.patient_id = :patient_id');
        $q = $sql->execute(['patient_id' => $patient_id]);
    } catch (PDOException $e) {
        echo $sql->queryString . "<br>" . $e->getMessage();
    }
    ?>
    <div class="row">
        <div class="col-md-10">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">Date &nbsp;<a href="#">Sort by date</a></th>
                    <th scope="col">Doctor</th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody>
                <?php while ($row = $sql->fetch()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['adate']); ?></td>
                        <td><?php echo htmlspecialchars($row['dfname']) . ' ' . htmlspecialchars($row['dmname']) . ' ' . htmlspecialchars($row['dlname']) ?></td>
                        <td>
                            <div>
                                <button type="button" class="btn btn-sm btn-secondary"
                                        onclick="location.href='app_detail.php?id=<?php echo $row['aid'] ?>'">Details
                                </button>
                            </div>
                        </td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <h2>Medical history</h2>
    </div>
    <?php
    try {
        $sql = $pdo->prepare('SELECT mh.disease_name as mhname, mh.description as mhdesc, mh.medical_history_id as mhid FROM patient p,medical_history mh where p.patient_id = mh.patient_id and p.patient_id = :patient_id');
        $q = $sql->execute(['patient_id' => $patient_id]);
    } catch (PDOException $e) {
        echo $sql->queryString . "<br>" . $e->getMessage();
    }
    ?>
    <div class="col-md-10">
        <table class="table">
            <thead>
            <tr>
                <th scope="col">Disease name</th>
                <th scope="col">Description</th>
            </tr>
            </thead>
            <tbody>
            <?php while ($row = $sql->fetch()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['mhname']); ?></td>
                    <td><?php echo htmlspecialchars($row['mhdesc']); ?></td>
                    <td>
                        <?php echo '<form action="pat_center_medical_history_delete.php" method="post"><input class="btn btn-sm btn-danger" type="submit" value="Delete"><input type="hidden" name="medical_history_id" value="' . htmlspecialchars($row['mhid']) . '"></form>'; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
        <div class="mb-3">
            <form action="pat_center_medical_history_insert.php" method="post">
                <label>Name</label>
                <input class="form-control" type="text" id="disease_name" name="disease_name" value="">
                <label>Description</label>
                <input class="form-control" type="text" id="description" name="description" value="">
                <br>
                <?php echo
                    '<input type="hidden" name="patient_id" value="' . $patient_id . '">'; ?>
                <input class="btn btn-primary" type="submit" value="Add disease record">
            </form>
        </div>
    </div>
    <div class="row">
        <h2>Allergy history</h2>
    </div>
    <?php
    try {
        $sql = $pdo->prepare('SELECT ah.id as ahid, ah.allergy_name as ahname, ah.description as ahdesc FROM patient p ,allergy_history ah where p.patient_id = ah.patient_id and p.patient_id = :patient_id');
        $q = $sql->execute(['patient_id' => $patient_id]);
    } catch (PDOException $e) {
        echo $sql->queryString . "<br>" . $e->getMessage();
    }
    ?>
    <div class="col-md-10">
        <table class="table">
            <thead>
            <tr>
                <th scope="col">Allergy name</th>
                <th scope="col">Description</th>
            </tr>
            </thead>
            <tbody>
            <?php while ($row = $sql->fetch()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['ahname']); ?></td>
                    <td><?php echo htmlspecialchars($row['ahdesc']); ?></td>
                    <td>
                        <?php echo '<form action="pat_center_allergy_history_delete.php" method="post"><input class="btn btn-sm btn-danger" type="submit" value="Delete"><input type="hidden" name="allergy_history_id" value="' . htmlspecialchars($row['ahid']) . '"></form>'; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
        <div class="mb-3">
            <form action="pat_center_allergy_history_insert.php" method="post">
                <label>Name</label>
                <input class="form-control" type="text" id="allergy_name" name="allergy_name" value="">
                <label>Description</label>
                <input class="form-control" type="text" id="adescription" name="adescription" value="">
                <br>
                <?php echo
                    '<input type="hidden" name="patient_id" value="' . $patient_id . '">'; ?>
                <input class="btn btn-primary" type="submit" value="Add allergy record">
            </form>
        </div>
    </div>
</div>
</body>
</html>
