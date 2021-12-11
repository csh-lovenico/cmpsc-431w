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
$sql = $pdo->prepare('SELECT 
       a.attendence_date as attendence_date,
       dc.fname as dfname, dc.mname as dmname, dc.lname as dlname,
       m.disease_name as disease_name, m.description as description, m.medical_history_id as medical_history_id,
       al.allergy_name as allergy_name, al.description as adescription, al.id as allergy_history_id,
       p.fname as fname, p.mname as mname, p.lname as lname, p.patient_id as patient_id
        FROM attendence a, patient p, medical_history m,allergy_history al, doctor dc
limit 1');
$q = $sql->execute([]);
$sql->setFetchMode(PDO::FETCH_ASSOC);
?>
<?php while ($row = $sql->fetch()): ?>
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
        <p>Hello, <?php echo htmlspecialchars($row['fname']).' '. htmlspecialchars($row['mname']). ' ' .htmlspecialchars($row['lname']) ?></p>
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
                    <th scope="col">Date  &nbsp;<a href="#">Sort by date</a></th>
                    <th scope="col">Doctor</th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><?php echo htmlspecialchars($row['attendence_date']); ?></td>
                    <td><?php echo htmlspecialchars($row['dfname']).' '. htmlspecialchars($row['dmname']). ' ' .htmlspecialchars($row['dlname']) ?></td>
                    <td>
                        <div>
                            <button type="button" class="btn btn-sm btn-secondary">Detail</button>
                        </div>
                    </td>
                </tr>
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
            <tbody>
            <tr>
                <td><?php echo htmlspecialchars($row['disease_name']); ?></td>
                <td><?php echo htmlspecialchars($row['description']); ?></td>
                <td>
                    <?php echo '<form action="pat_center_medical_history_delete.php" method="post"><input class="btn btn-sm btn-danger" type="submit" value="Delete"><input type="hidden" name="medical_history_id" value="' . htmlspecialchars($row['medical_history_id']) . '"></form>'; ?>


                </td>
            </tr>
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
                    '<input type="hidden" name="patient_id" value="' . htmlspecialchars($row['patient_id']) . '">'
                ; ?>
                <input class="btn btn-primary" type="submit" value="Add disease record">
            </form>
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
            <tbody>
            <tr>
                <td><?php echo htmlspecialchars($row['allergy_name']); ?></td>
                <td><?php echo htmlspecialchars($row['adescription']); ?></td>
                <td>
                    <?php echo '<form action="pat_center_allergy_history_delete.php" method="post"><input class="btn btn-sm btn-danger" type="submit" value="Delete"><input type="hidden" name="allergy_history_id" value="' . htmlspecialchars($row['allergy_history_id']) . '"></form>'; ?>
                </td>
            </tr>
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
                '<input type="hidden" name="patient_id" value="' . htmlspecialchars($row['patient_id']) . '">'
                ; ?>
                <input class="btn btn-primary" type="submit" value="Add allergy record">
            </form>
        </div>
    </div>
    <?php endwhile; ?>
    <?php
    } catch(PDOException $e) {
        echo $sql->queryString . "<br>" . $e->getMessage();
    }
    $conn = null;
    ?>

</div>
</body>
</html>
