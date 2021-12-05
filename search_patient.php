<?php
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
        <h2>Select a patient</h2>
    </div>
    <div class="row">
        <div class="col-md-10">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Email</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>Nico Yazawa</td>
                    <td>17</td>
                    <td>example@example.com</td>
                    <td>
                        <button class="btn btn-sm btn-primary">Select</button>
                    </td>
                </tr>
                <tr>
                    <td>Rin Hoshizora</td>
                    <td>15</td>
                    <td>example2@example.com</td>
                    <td>
                        <button class="btn btn-sm btn-primary">Select</button>
                    </td>
                </tr>
                <tr>
                    <td>Keke Tang</td>
                    <td>15</td>
                    <td>example3@example.com</td>
                    <td>
                        <button class="btn btn-sm btn-primary">Select</button>
                    </td>
                </tr>
                <tr>
                    <td>Emma Verde</td>
                    <td>17</td>
                    <td>example4@example.com</td>
                    <td>
                        <button class="btn btn-sm btn-primary">Select</button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
