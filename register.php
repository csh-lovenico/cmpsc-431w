<?php

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
        </div>
    </nav>
</header>
<div class="container">
    <div class="row">
        <h2>User register</h2>
    </div>
    <div class="row">
        <div class="col-md-8">

                <div style="display: none">
                    <select id="role" readonly="readonly" name="role">
                        <option selected value="1">
                            Patient
                        </option>
                    </select>
                </div>

                <div class="mb-3">
                <form action="register_insert.php" method="post">
                    <label for="patient_id" class="form-label">id</label>
                    <input class="form-control" id="patient_id" type="text" name="patient_id" value="">
                    <br>
                    <label class="form-label">First name</label>
                    <input class="form-control" id="fname" type="text" name="fname" value="">
               <br>
                    <label class="form-label">Middle name</label>
                    <input class="form-control" id="mname" type="text" name="mname" value="">
                <br>
                    <label class="form-label">Last name</label>
                    <input class="form-control" required id="lname" type="text" name="lname" value="">
                <br>
                    <label class="form-label">Email</label>
                    <input class="form-control" required id="email" type="email" name="email" value="">
                <br>
                    <label class="form-label">Password</label>
                    <input class="form-control" required id="password" type="password" name="password" value="">
                <br>
                    <label class="form-label">Birthday</label>
                    <input class="form-control" required id="birthday" type="date" name="birthday" value="">
                    <br>
                    <input class="btn btn-primary" type="submit" value="Register">
                </form>
                </div>
        </div>
    </div>
</div>
</body>
</html>
