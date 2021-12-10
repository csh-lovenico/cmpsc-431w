<?php
$a = "eeeeeee";
require 'Config.php';
$b = Config::$ip

?>
<!doctype html>
<html lang="en">
<head>
    <title>hello</title>
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
            <span class="navbar-brand mb-0 h1">Hospital Name</span>
        </div>
    </nav>
</header>
redirecting...
<?php
session_start();
if (!isset($_SESSION['role'])) {
    ?>
    <script>
        function go() {
            location.href = 'login.php';
        }

        go();
    </script>
<?php
} elseif ($_SESSION['role'] == 0){
?>
    <script>
        function go() {
            location.href = 'doc_center.php';
        }

        go();
    </script>
<?php


} elseif ($_SESSION['role'] == 1) {
?>
    <script>
        function go() {
            location.href = 'pat_center.php';
        }

        go();
    </script>
    <?php
}
?>
</body>
</html>

