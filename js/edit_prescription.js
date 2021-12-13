function getEle(id) {
    return document.getElementById(id);
}

function get_data() {
    var pre_id = getEle("pre_id").innerHTML;

    //alert(pre_id)
    var request = new XMLHttpRequest();
    request.open("GET","edit_prescription_action.php?func=" + 1 + "&pre_id=" + pre_id); //async
    request.send();
    request.onreadystatechange = function() {
        if(request.readyState === 4) {
            if(request.status === 200) {
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
                        '                    <td id="tdd">\n' +
                        '                        <form action="edit_prescription_delect.php" method="post">' +
                        '                            <input className="btn btn-sm btn-danger" type="submit" value="Delete"><input type="hidden" name="prescription_id" value="' + pre_id + '">' +
                        '                        </form>\n' +
                        '                    </td>\n' +
                        '                </tr>'
                }
                obj.innerHTML = table;
            }
            else {
                alert("error occured: " + request.status);
            }
        }
    }
}