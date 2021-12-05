<?php
require 'Config.php';
$email = Config::$username;
$password = Config::$password;
$host = Config::$ip;
$dbname = Config::$database;

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $email, $password);
} catch (PDOException $e) {
    die("Could not connect to the database $dbname :" . $e->getMessage());
}
?>
<!doctype html>
<html lang="en">
<head>
    <title>User login</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
            crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
<p>
    <?php
    if ($_POST['role'] == null)
        echo "invalid operation";
    else {
        $role = $_POST['role'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        if ($role == 0) {
            echo "doctor<br>";
            $sql = $pdo->prepare("SELECT 1 FROM doctor WHERE email=:email AND password=:password");
            $sql->execute(['username' => $email, 'password' => $password]);
            $sql->setFetchMode(PDO::FETCH_ASSOC);
            $count = $sql->rowCount();
            if ($count == 0) {
                echo 'invalid username or password<br>';
            }
            echo "count: $count";
        } else if ($role == 1) {
            echo "patient<br>";
//            $sql = $pdo->prepare("SELECT 1 FROM patient WHERE doctor_id=:username AND password=:password");
//            $sql->execute(['username' => $username, 'password' => $password]);
//            $sql->setFetchMode(PDO::FETCH_ASSOC);
//            $count = $sql->rowCount();
//            echo "count: $count";
        }
        echo "<br>" . $_POST['username'] . " " . $_POST['password'];
    }
    ?>
</p>
</body>
</html>
