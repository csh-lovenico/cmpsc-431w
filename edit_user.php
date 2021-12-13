<?php
require 'Config.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$username = Config::$username;
$password = Config::$password;
$host = Config::$ip;
$dbname = Config::$database;

if (!isset($_GET['pid'])) {
    die('specify pid');
}
$pid = $_GET['pid'];

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
} catch (PDOException $e) {
    die("Could not connect to the database $dbname :" . $e->getMessage());
}

try {
    $sql = $pdo->prepare('select * from patient where patient_id = :pid');
    $sql->execute(['pid' => $pid]);
    $pat_info = $sql->fetch();
} catch (PDOException $e) {

}
?>

<html lang="en">
<head>
    <title>User register
    </title>
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
<div class="container">
    <div class="row">
        <h2>Edit profile</h2>
    </div>
    <div class="row">
        <div class="col-md-8">
            <form>
                <div class="mb-3">
                    <label class="form-label" for="fname">First name</label>
                    <input class="form-control" required id="fname" type="text" value="<?php echo $pat_info['fname'] ?>"
                           name="fname">
                </div>
                <div class="mb-3">
                    <label class="form-label" for="mname">Middle name</label>
                    <input class="form-control" id="mname" type="text" value="<?php echo $pat_info['mname'] ?>"
                           name="mname">
                </div>
                <div class="mb-3">
                    <label class="form-label" for="lname">Last name</label>
                    <input class="form-control" required id="lname" type="text" value="<?php echo $pat_info['lname'] ?>"
                           name="lname">
                </div>
                <div class="mb-3">
                    <label class="form-label" for="email">Email</label>
                    <input class="form-control" required id="email" type="email"
                           value="<?php echo $pat_info['email'] ?>" name="email">
                </div>
                <div class="mb-3">
                    <label class="form-label" for="password">Password</label>
                    <input class="form-control" required id="password" type="password"
                           value="<?php echo $pat_info['password'] ?>" name="password">
                </div>
                <div class="mb-3">
                    <label class="form-label" for="birthday">Birthday</label>
                    <input class="form-control" required id="birthday" type="date"
                           value="<?php echo $pat_info['birthday'] ?>" name="birthday">
                </div>
                <div class="mb-3">
                    <label class="form-label" for="gender">Gender</label>
                    <select id="gender" required class="form-control" name="gender">
                        <option <?php if ($pat_info['gender'] == 'female') {
                            echo 'selected';
                        } ?> value="female">
                            Female
                        </option>
                        <option <?php if ($pat_info['gender'] == 'male') {
                            echo 'selected';
                        } ?> value="male">
                            Male
                        </option>
                        <option <?php if ($pat_info['gender'] == 'non-binary') {
                            echo 'selected';
                        } ?> value="non-binary">
                            Non-binary
                        </option>
                    </select>
                </div>

                <div class="mb-3">
                    <button class="btn btn-primary" type="submit">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
