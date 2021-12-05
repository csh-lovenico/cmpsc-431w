<?php
?>
<html lang="en">
<head>
    <title>User Login</title>
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
<div class="container h-75">
    <div class="row justify-content-center align-content-center h-100">
        <div class="col-lg-4 col-md-7 col-sm-10">
            <h2 class="h2">User Login</h2>
            <form class="" action="login_action.php" method="post">
                <div class="form-floating mb-3">
                    <select name="role" class="form-select" id="role" required>
                        <option value="" disabled style="display: none" selected>Select...</option>
                        <option value="0">Doctor</option>
                        <option value="1">Patient</option>
                    </select>
                    <label for="role">Login as</label>
                </div>
                <div class="form-floating mb-3">
                    <input required class="form-control" name="username" type="text" id="username"
                           placeholder="username">
                    <label for="username">Username</label>
                </div>
                <div class="form-floating mb-3">
                    <input required class="form-control" name="password" type="password" id="password"
                           placeholder="password">
                    <label for="password">Password</label>
                </div>
                <div class="mb-3 d-grid gap-2">
                    <button type="submit" class="btn btn-primary">Login</button>
                </div>
                <div class="mb-3 d-grid gap-2">
                    <button type="button" onclick="window.location.href='register.php'" class="btn btn-secondary">
                        Register
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
