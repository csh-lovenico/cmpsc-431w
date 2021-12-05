<?php
require '../Config.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$username = Config::$username;
$password = Config::$password;
$host = Config::$ip;
$dbname = Config::$database;

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $sql = $pdo->prepare('SELECT lname, fname, loginid FROM users');
    $q = $sql->execute([]);
    $sql->setFetchMode(PDO::FETCH_ASSOC);
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
    <a href="../index.php">index</a>
        <div class="container" id="container">
            <h2>Current List of users</h2>
            <table class="table" border=1 cellspacing=5 cellpadding=5>
                <thead>
                    <tr>
                        <th>Last name</th>
                        <th>First name</th>
                        <th>Login ID</th>
                        <th>Delete?</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $sql->fetch()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['lname']) ?></td>
                            <td><?php echo htmlspecialchars($row['fname']); ?></td>
                            <td><?php echo htmlspecialchars($row['loginid']); ?></td>
                            <td><?php echo '<form action="delete.php" method="post"><input class="btn btn-danger" type="submit" value="DELETE"><input type="hidden" name="loginid" value="' . htmlspecialchars($row['loginid']) . '"></form>'; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
		<br><h2>Insert a new user:</h2>
		<form class="form-control" action="insert.php" method="post">
			<table>
				<tr><td>First name:</td><td><input class="form-control" type="text" id="fname" name="fname" value="?"></td></tr>
				<tr><td>Last name:</td><td><input class="form-control" type="text" id="lname" name="lname" value="?"></td></tr>
				<tr><td>Login ID:</td><td><input class="form-control" type="text" id="loginid" name="loginid" value="?"></td></tr>
			</table>
			<input class="btn btn-primary" type="submit" value="INSERT">
		</form>
		<br>
		<br><br><br>
    </body>
</div>
</html>
