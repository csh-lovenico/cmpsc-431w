<?php
$keyword = "";
$page = 1;
if (isset($_GET['keyword'])) {
    $keyword = $_GET['keyword'];
}
if (isset($_GET['page'])) {
    $page = $_GET['page'];
}
if (!isset($_GET['appid'])) {
    die('must specify attendance id(sample: ?appid=111)');
}

$app_id = $_GET['appid'];
?>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Search Medicine</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
            crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="js/search_medicine_action.js"></script>
</head>
<body onload=search_drug_by_name()>
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
        <div class="col-4">
            <h2>Select a medicine</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <form class="d-flex">
                <input class="form-control me-2" name="keyword" id="keyword"
                       type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success" onclick=search_drug_by_name() type="button">Search</button>
            </form>
        </div>

    </div>

    <div class="row">
        <div class="col-md-10">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>Name&nbsp;<button class="btn btn-sm btn-outline-secondary">Sort by name...</button></th>
                    <th>Price</th>
                    <th>In stock</th>
                    <th>Usage</th>
                    <th></th>
                    <th></th>
                </tr>
                </thead>
                <tbody id="search_medicine_table_body">
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="selectMedicineModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Medicine name</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addMedicineForm" method="post">
                <div class="modal-body">
                    <table class="table">
                        <tr style="display: none">
                            <th scope="row">Id</th>
                            <td id="medicineId">233</td>
                        </tr>
                        <tr>
                            <th scope="row">Price</th>
                            <td id="medicinePrice">$000</td>
                        </tr>
                        <tr>
                            <th scope="row">In stock</th>
                            <td id="medicineInStock">99</td>
                        </tr>
                        <tr>
                            <th scope="row">Usage</th>
                            <td id="medicineUsage">99</td>
                        </tr>
                    </table>
                    <label for="quantity" class="form-label">Quantity:</label>
                    <input id="quantity" required name="quantity" class="form-control" min="1" type="number">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick=add_drug()>Add medicine</button>
                </div>
            </form>
        </div>
    </div>
    <p id="app_id"><?php echo $app_id ?></p>
</div>
<script>
    let selectMedicineModal = document.getElementById('selectMedicineModal');
    selectMedicineModal.addEventListener('show.bs.modal', function (event) {
        // Button that triggered the modal
        let button = event.relatedTarget;
        // Extract info from data-bs-* attributes
        let index = button.getAttribute('data-bs-index');

        // Update the modal's content.
        let modalTitle = document.getElementById('modalTitle');
        let medicineId = document.getElementById('medicineId');
        let medicinePrice = document.getElementById('medicinePrice');
        let medicineInStock = document.getElementById('medicineInStock');
        let medicineUsage = document.getElementById('medicineUsage');
        let addMedicineForm = document.getElementById('addMedicineForm');

        addMedicineForm.action = `add_medicine.php?appid=<?php echo $app_id?>&drugid=${medicine_list[index].drug_id}`;
        modalTitle.textContent = medicine_list[index].name;
        medicineId.textContent = medicine_list[index].drug_id;
        medicinePrice.textContent = '$' + medicine_list[index].price;
        medicineInStock.textContent = medicine_list[index].stock;
        medicineUsage.textContent = medicine_list[index].usage;
    })
</script>
</body>
</html>
