function getEle(id) {
    return document.getElementById(id);
}

var pat_name = '';
let medicine_list = [];

function search_drug_by_name() {
    var patient_name = getEle("keyword").value;
    pat_name = patient_name;
    var request = new XMLHttpRequest();
    request.open("GET", "search_medicine_action.php?keyword=" + patient_name + "&page=" + 1 + "&func=" + 1); //async
    request.send();
    request.onreadystatechange = function () {
        if (request.readyState === 4) {
            if (request.status === 200) {
                //alert(request.response)
                var a = JSON.parse(request.response);
                medicine_list = a;
                //alert(request.response)
                var obj = getEle("search_medicine_table_body");
                var table = '';

                for (var k in a) {
                    table += `                <tr >
                    <td >${a[k].name}</td>
                    <td >${a[k].price}</td>
                    <td >${a[k].stock}</td>
                    <td  style="display:none">${a[k].drug_id}</td>
                    <td >${a[k].usage}</td>
                    <td >
                        <div >
                            <button type="button" data-bs-toggle="modal" data-bs-target="#selectMedicineModal" data-bs-index="${k}" class="btn btn-sm btn-secondary">Select</button>
                        </div>
                    </td>
                </tr>`
                }
                obj.innerHTML = table;
            } else {
                alert("error occured: " + request.status);
            }
        }
    }
}

function add_drug() {
    var num = getEle("quantity").value;
    var drug_id = getEle("medicineId").innerHTML;
    var app_id = getEle("app_id").innerHTML;

    var request = new XMLHttpRequest();
    request.open("GET", "search_medicine_action.php?appid=" + app_id + "&drugid=" + drug_id + "&func=" + 2 + "&num=" + num); //async
    request.send();
    request.onreadystatechange = function () {
        if (request.readyState === 4) {
            if (request.status === 200) {

            } else {
                alert("error occured: " + request.status);
            }
        }
    }
}