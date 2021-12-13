function getEle(id) {
    return document.getElementById(id);
}

function delete_data() {
    var pre_id = getEle("prescriptionid").innerHTML;

    var request = new XMLHttpRequest();
    request.open("GET", "edit_prescription_action.php?func=" + 2 + "&pre_id=" + pre_id); //async
    request.send();
    request.onreadystatechange = function () {
        if (request.readyState === 4) {
            if (request.status === 200) {
                get_data();
            } else {
                alert("error occured: " + request.status);
            }
        }
    }
}

function get_data() {
    var pre_id = getEle("pre_id").innerHTML;
    var request = new XMLHttpRequest();
    request.open("GET", "edit_prescription_action.php?func=" + 1 + "&pre_id=" + pre_id); //async
    request.send();
    request.onreadystatechange = function () {
        if (request.readyState === 4) {
            if (request.status === 200) {
                var a = JSON.parse(request.response);
                var obj = getEle("medicine_detail");
                var table = '';
                for (var k in a) {

                    table += `                <tr>
                    <td>${a[k].name}</td>
                    <td>${a[k].number}</td>
                    <td>${a[k].price}</td>
                    <td>${a[k].usage}</td>
                    <td style="display:none">${a[k].prescription_id}</td>
                    <td>
                     <input class="btn btn-sm btn-danger" onclick=delete_data() type="button" value="Delete"><input type="hidden" name="prescription_id" value="${pre_id}">
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