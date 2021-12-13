<?php
if (!isset($_GET['id'])) {
    die('specify pid');
}
$pid = $_GET['id'];
$fname = $_GET['fname'];
$mname = $_GET['mname'];
$lname = $_GET['lname'];
$email = $_GET['email'];
$pat_passwd = $_GET['password'];
$birthday = $_GET['birthday'];
$gender = $_GET['gender'];

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

try {

    $sql = $pdo->prepare('update patient set fname=:fname,mname=:mname,lname=:lname,email=:email,password=:passwd,birthday=:birthday,gender=:gender
where patient_id=:pid');
    $sql->execute([':fname' => $fname, ':mname' => $mname, ':lname' => $lname, ':email' => $email, ':password' => $pat_passwd, ':birthday' => $birthday, ':gender' => $gender, ':pid' => $pid]);
    echo 'success';
} catch (PDOException $e) {
    echo $sql->queryString . $e->getMessage();

}
