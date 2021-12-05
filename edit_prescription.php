<?php
?>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Appointment Details
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
        <div class="col-md-10">
            <table class="table">
                <tr>
                    <th scope="row">Date</th>
                    <td>2021-12-02</td>
                </tr>
                <tr>
                    <th scope="row">Comment</th>
                    <td>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis lacinia, justo in commodo gravida,
                        felis tortor porttitor odio, id imperdiet diam turpis quis urna. Nam quis velit sit amet sem
                        vestibulum ullamcorper consectetur vitae nibh. Maecenas volutpat sodales eros, non pellentesque
                        leo iaculis at. Fusce pharetra sed tellus at blandit.
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <div class="row">
        <h2>Patient info</h2>
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
        <h2>Doctor info</h2>
    </div>
    <div class="row">
        <div class="col-md-6">
            <table class="table table-borderless">
                <tr>
                    <th scope="row">Name
                    </th>
                    <td>Maki Nishikino</td>
                </tr>
                <tr>
                    <th scope="row">Department
                    </th>
                    <td>---</td>
                </tr>
                <tr>
                    <th scope="row">Level
                    </th>
                    <td>---</td>
                </tr>
            </table>

        </div>
    </div>
    <div class="row">
        <h2>Prescription</h2>
    </div>
    <div class="row">
        <div class="col-md-10">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">Medicine name</th>
                    <th scope="col">Count</th>
                    <th scope="col">Total Price</th>
                    <th scope="col">Description</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>Health Potion</td>
                    <td>5</td>
                    <td>$10.00</td>
                    <td>Some description</td>
                    <td>
                        <button type="button" class="btn btn-sm btn-danger">Delete</button>
                    </td>
                </tr>
                <tr>
                    <td>Lemon juice</td>
                    <td>5</td>
                    <td>$15.00</td>
                    <td>Another description</td>
                    <td>
                        <button type="button" class="btn btn-sm btn-danger">Delete</button>
                    </td>
                </tr>
                </tbody>
            </table>
            <div class="mb-3">
                <button type="button" class="btn btn-primary">Add medicine</button>
            </div>
        </div>
    </div>
</div>
</body>
</html>
