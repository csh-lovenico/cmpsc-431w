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

                    table += '' +
                        '                <tr>\n' +
                        '                    <td>' + a[k].name + '</td>\n' +
                        '                    <td>' + a[k].number + '</td>\n' +
                        '                    <td>' + a[k].price + '</td>\n' +
                        '                    <td>' + a[k].usage + '</td>\n' +
                        '                    <td id="prescriptionid" style="display:none">' + a[k].prescription_id + '</td>\n' +
                        '                    <td id="tdd">\n' +
                        '                        <form action="edit_prescription_delect.php" method="post">' +
                        '                            <input class="btn btn-sm btn-danger" onclick=delete_data() type="button" value="Delete"><input type="hidden" name="prescription_id" value="' + pre_id + '">' +
                        '                        </form>\n' +
                        '                    </td>\n' +
                        '                </tr>'
                }
                obj.innerHTML = table;
            } else {
                alert("error occured: " + request.status);
            }
        }
    }
}