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
    <title>User register
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
$sql = $pdo->prepare('SELECT 
       p.fname as fname, p.mname as mname, p.lname as lname, p.birthday as birthday,
       m.disease_name as disease_name, m.description as description,
       a.allergy_name as allergy_name, a.description as adescription
        FROM patient p, medical_history m, allergy_history a  
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
        <div class="col-md-6">
            <table class="table table-borderless">
                <tr>
                    <th scope="row">Name
                    </th>
                    <td>
                        <?php echo htmlspecialchars($row['fname']).' '. htmlspecialchars($row['mname']). ' ' .htmlspecialchars($row['lname']) ?>
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
        <h2>Medical history</h2>
    </div>
    <div class="row">
        <div class="col-md-8">
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
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <h2>Allergy history</h2>
    </div>
    <div class="row">
        <div class="col-md-8">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col"><?php echo htmlspecialchars($row['allergy_name']); ?></th>
                    <th scope="col"><?php echo htmlspecialchars($row['adescription']); ?></th>
                </tr>
                </thead>
                <?php endwhile; ?>
                <?php
                } catch(PDOException $e) {
                    echo $sql->queryString . "<br>" . $e->getMessage();
                }
                $conn = null;
                ?>
                <tbody>
                <tr>
                    <td>Allergy2</td>
                    <td>Desc2</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 mb-3">
            <label for="comment" class="form-label">Comment</label>
            <textarea class="form-control" name="comment" id="comment"></textarea>
        </div>
    </div>
    <div class="row">
        <div class="mb-3">
            <button class="btn btn-primary">Add appointment record</button>
            <button class="btn btn-secondary">Back</button>
        </div>
    </div>
</div>

</body>
</html>
