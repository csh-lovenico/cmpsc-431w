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
    <title>Search Patient</title>
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
        <div class="col">
            <h2>Select a patient</h2>
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
                <?php
                try {
                    $sql = $pdo->prepare('SELECT fname, mname, lname, birthday, email FROM patient limit 10');
                    $q = $sql->execute([]);
                    $sql->setFetchMode(PDO::FETCH_ASSOC);
                ?>
                <tbody>
                <?php while ($row = $sql->fetch()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['fname']).' '. htmlspecialchars($row['mname']). ' ' .htmlspecialchars($row['lname']) ?></td>
                        <td><?php echo 2021 - substr(htmlspecialchars($row['birthday']), 0, 4); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><button class="btn btn-sm btn-primary">Select</button></td>
                    </tr>
                <?php endwhile; ?>
                </tbody>

                </tbody>

                <?php
                } catch(PDOException $e) {
                    echo $sql . "<br>" . $e->getMessage();
                }
                $conn = null;
                ?>
            </table>
        </div>
    </div>
</div>
</body>
</html>
