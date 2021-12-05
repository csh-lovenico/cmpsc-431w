<?php
?>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
        <h2>Basic info</h2>
    </div>
    <div class="row">
        <div class="col-md-6">
            <table class="table table-borderless">
                <tr>
                    <th scope="row">Name
                    </th>
                    <td>Nico Yazawa</td>
                </tr>
                <tr>
                    <th scope="row">Age
                    </th>
                    <td>17</td>
                </tr>
                <tr>
                    <th scope="row">Birthday
                    </th>
                    <td>07-22</td>
                </tr>
            </table>
        </div>
    </div>
    <div class="row">
        <h2>Medical history</h2>
    </div>
    <div class="row">
        <div class="col-md-8">
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
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <h2>Allergy history</h2>
    </div>
    <div class="row">
        <div class="col-md-8">
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
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 mb-3">
            <label for="comment" class="form-label">Comment</label>
            <textarea class="form-control" name="comment" id="comment"></textarea>
        </div>
    </div>
    <div class="row">
        <div class="mb-3">
            <button class="btn btn-primary">Add appointment record</button>
            <button class="btn btn-secondary">Back</button>
        </div>
    </div>
</div>
</body>
</html>
