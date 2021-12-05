<?php

?>

<html lang="en">
<head>
    <title>Doctor register
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
        </div>
    </nav>
</header>
<div class="container">
    <div class="row">
        <h2>Doctor Register</h2>
    </div>
    <div class="row">
        <div class="col-md-8">
            <form action="register_action.php" method="post">
                <div style="display: none">
                    <select id="role" name="role">
                        <option selected value="0">
                            Doctor
                        </option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="fname">First name</label>
                    <input class="form-control" id="fname" type="text" name="fname">
                </div>
                <div class="mb-3">
                    <label class="form-label" for="mname">Middle name</label>
                    <input class="form-control" id="mname" type="text" name="mname">
                </div>
                <div class="mb-3">
                    <label class="form-label" for="lname">Last name</label>
                    <input class="form-control" id="lname" type="text" name="lname">
                </div>
                <div class="mb-3">
                    <label class="form-label" for="department">Department</label>
                    <select class="form-select" id="department">
                        <option selected>Open this select menu</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="level">Level</label>
                    <select class="form-select" id="level">
                        <option selected>Open this select menu</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="email">Email</label>
                    <input class="form-control" id="email" type="email" name="email">
                </div>
                <div class="mb-3">
                    <label class="form-label" for="password">Password</label>
                    <input class="form-control" id="password" type="password" name="password">
                </div>
                <div class="mb-3">
                    <button class="btn btn-primary" type="submit">Register</button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
