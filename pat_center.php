<?php
?>
<html lang="en">
<head>
    <title>User Center</title>
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
        <h1>User Center</h1>
    </div>
    <div class="row">
        <p>Hello, Nico Yazawa</p>
        <div class="mb-3">
            <button class="btn btn-primary">Edit profile</button>
        </div>
    </div>
    <div class="row">
        <h2>Appointment History</h2>
    </div>
    <div class="row">
        <div class="col-md-10">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">Date  &nbsp;<a href="#">Sort by date</a></th>
                    <th scope="col">Doctor</th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>2021-12-01</td>
                    <td>Maki Nishikino</td>
                    <td>
                        <div>
                            <button type="button" class="btn btn-sm btn-secondary">Detail</button>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <h2>Medical history</h2>
    </div>
    <div class="col-md-10">
        <table class="table">
            <thead>
            <tr>
                <th scope="col">Disease name</th>
                <th scope="col">Description</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>Disease1</td>
                <td>Desc1</td>
                <td>
                    <button type="button" class="btn btn-sm btn-danger">Delete</button>
                </td>
            </tr>
            </tbody>
        </table>
        <div class="mb-3">
            <label>Name</label>
            <input type="text">
            <label>Description</label>
            <textarea class="form-control" type=""></textarea>
            <button type="button" class="btn btn-primary">Add disease record</button>
        </div>
    </div>
    <div class="row">
        <h2>Allergy history</h2>
    </div>
    <div class="col-md-10">
        <table class="table">
            <thead>
            <tr>
                <th scope="col">Allergy name</th>
                <th scope="col">Description</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>Allergy2</td>
                <td>Desc2</td>
                <td>
                    <button type="button" class="btn btn-sm btn-danger">Delete</button>
                </td>
            </tr>
            </tbody>
        </table>
        <div class="mb-3">
            <form>
                <label>Name</label>
                <input type="text">
                <label>Description</label>
                <textarea class="form-control" type="text"></textarea>
                <button type="button" class="btn btn-primary">Add allergy record</button>
            </form>
        </div>
    </div>

</div>
</body>
</html>
