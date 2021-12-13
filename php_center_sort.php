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
    <script src="js/pat_center.js"></script>
</head>
<body onload=load_data()>
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
            <a class="d-flex" href="logout.php">Logout</a>
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
            <button class="btn btn-primary" onclick="location.href='edit_user.php?pid=<?php echo $patient_id ?>'">Edit
                profile
            </button>
        </div>
    </div>
    <div class="row">
        <h2>Appointment History</h2>
    </div>
    <?php
    try {
        $sql = $pdo->prepare('SELECT a.attendance_id as aid, a.attendence_date as adate,d.fname as dfname, d.mname as dmname, d.lname as dlname FROM attendence a,patient p,doctor d 
        WHERE a.patient_id = p.patient_id and a.doctor_id = d.doctor_id and p.patient_id = :patient_id order by a.attendence_date');
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
                    <th scope="col">Date &nbsp;<a href="pat_center_sort.php">Sort by date</a></th>
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
    <div class="col-md-10">
        <table class="table">
            <thead>
            <tr>
                <th scope="col">Disease name</th>
                <th scope="col">Description</th>
            </tr>
            </thead>
            <tbody id="med_his"></tbody>
        </table>
        <div class="mb-3">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#medicalRecordModal">
                Add disease record
            </button>
        </div>
    </div>
    <div class="row">
        <h2>Allergy history</h2>
    </div>
    <div class="col-md-10">
        <table class="table">
            <thead>
            <tr>
                <th scope="col">Allergy name</th>
                <th scope="col">Description</th>
            </tr>
            </thead>
            <tbody id="all_his"></tbody>
        </table>
        <div class="mb-3">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#allergyRecordModal">
                Add allergy record
            </button>
        </div>
    </div>
</div>

<!--medical record modal-->
<div class="modal fade" id="medicalRecordModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="pat_center_medical_history_insert.php" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add disease record</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input name="patient_id" readonly style="display: none" value="<?php echo $patient_id ?>">
                    <div class="mb-3">
                        <label class="form-label" for="disease_name">Name</label>
                        <input class="form-control" id="disease_name" name="disease_name">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="description">Description</label>
                        <textarea class="form-control" id="description" name="description"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" onclick=add_medical_his() class="btn btn-primary" data-bs-dismiss="modal">
                        Add
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--allergy record modal-->
<div class="modal fade" id="allergyRecordModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="pat_center_allergy_history_insert.php" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add allergy record</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input name="patient_id" readonly style="display: none" value="<?php echo $patient_id ?>">
                    <div class="mb-3">
                        <label class="form-label" for="allergy_name">Name</label>
                        <input class="form-control" id="allergy_name" name="allergy_name">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="adescription">Description</label>
                        <textarea class="form-control" id="adescription" name="adescription"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" onclick=add_allergy_his() data-bs-dismiss="modal" class="btn btn-primary">
                        Add
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<p style="display: none" id="pid"><?php echo $patient_id ?></p>
</body>
</html>
