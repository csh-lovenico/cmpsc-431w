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

<!DOCTYPE html>
<html lang="en">
<head>
    <title>User register</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
            crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
<p>
    <?php
    $sql = $pdo->prepare('INSERT INTO patient(patient_id, fname, mname, lname, address_id, gender, password, birthday, email) VALUES(:patient_id,:fname,:mname,:lname,0,:gender,:password,:birthday,:email)');
    try {
    $success = $sql->execute(['patient_id' => $_POST["patient_id"], 'fname' => $_POST["fname"], 'mname' => $_POST["mname"], 'lname' => $_POST["lname"], 'gender' => '', 'password' => $_POST["password"], 'birthday' => $_POST["birthday"], 'email' => $_POST["email"]]);
    if (!$success) {
        throw new PDOException('cannot insert data');
    }

    echo "New record created successfully";
    ?>
<p>You will be redirected in 3 seconds</p>
<script>
    let timer = setTimeout(function () {
        window.location.replace('login.php');
    }, 3000);
</script>
<?php
} catch (PDOException $e) {
    echo $sql->queryString . "<br>" . $e->getMessage();
}
$conn = null;
?>

</body>

</html>


