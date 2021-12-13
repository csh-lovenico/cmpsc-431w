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
<!DOCTYPE html>
<html lang="en">
<head>
    <title>PHP MySQL Query Data Demo</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
            crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

</head>
<body>
<p>
    <?php
    //    $sql = 'INSERT INTO allergy_history (patient_id, allergy_name, description) ';
    //    $sql = $sql . 'VALUES ("' . $patient_id . '","' . $_POST["allergy_name"] . '","' . $_POST["adescription"] . '")';
    //    $sql = $pdo->prepare('INSERT into allergy_history(patient_id, allergy_name, description) VALUES (:patient_id,:allergy_name,:description)');
    try {
    $sql = $pdo->prepare('INSERT into allergy_history(patient_id, allergy_name, description) VALUES (:patient_id,:allergy_name,:description)');
    //    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    //    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //    $conn->exec($sql);
    $sql->execute(["patient_id" => $patient_id, "allergy_name" => $_POST["allergy_name"], "description" => $_POST["adescription"]]);
    echo "New record created successfully";
    ?>
<p>You will be redirected in 3 seconds</p>
<script>
    var timer = setTimeout(function () {
        window.location = 'pat_center.php'
    }, 3000);
</script>
<?php
} catch (PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}
$conn = null;
?>
</body>
</html>
