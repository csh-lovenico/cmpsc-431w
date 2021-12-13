function getEle(id) {
    return document.getElementById(id);
}

var cou = 1;
function sort_app_record(user_id) {
    var request = new XMLHttpRequest();
    ++cou;
    request.open("GET","doc_center_action.php?func=" + 1 + "&user_id=" + user_id + "&mode=" + cou); //async
    request.send();
    request.onreadystatechange = function() {
        if(request.readyState === 4) {
            if(request.status === 200) {

                alert(request.response)
                var jsonStr = request.response.replace(new RegExp('\\"',"gm"), '"' );
                var a = JSON.parse(jsonStr);
                var obj = getEle("app_table_body");
                var table = '';

                for (var k in a) {
                    for (var j in a[k]) {
                        table += '' +
                            '                <tr>\n' +
                            '                    <td>' + a[k][j].app_date + '</td>\n' +
                            '                    <td>' + a[k][j].patient_name + '</td>\n' +
                            '                    <td style="display:none">' + a[k][j].pat_id + '</td>\n' +
                            '                    <td>\n' +
                            '                        <div>\n' +
                            '                            <button type="button" onclick=dirt_to_add_pres(this) class="btn btn-sm btn-secondary">Detail</button>\n' +
                            '                        </div>\n' +
                            '                    </td>\n' +
                            '                </tr>'
                    }
                }
                obj.innerHTML = table;
            }
            else {
                alert("error occured: " + request.status);
            }
        }
    }
}

function get_app_record(user_id) {
    var request = new XMLHttpRequest();
    request.open("GET","doc_center_action.php?func=" + 3 + "&user_id=" + user_id); //async
    request.send();
    request.onreadystatechange = function() {
        if(request.readyState === 4) {
            if(request.status === 200) {
                //alert(request.response)
                var jsonStr = request.response.replace(new RegExp('\\"',"gm"), '"' );
                var a = JSON.parse(jsonStr);
                var obj = getEle("app_table_body");
                var table = '';

                for (var k in a) {
                    for (var j in a[k]) {
                        table += '' +
                            '                <tr>\n' +
                            '                    <td>' + a[k][j].app_date + '</td>\n' +
                            '                    <td>' + a[k][j].patient_name + '</td>\n' +
                            '                    <td style="display:none">' + a[k][j].pat_id + '</td>\n' +
                            '                    <td id="tdd">\n' +
                            '                        <div>\n' +
                            '                            <button type="button" onclick=dirt_to_add_pres(this) class="btn btn-sm btn-secondary">Detail</button>\n' +
                            '                        </div>\n' +
                            '                    </td>\n' +
                            '                </tr>'
                    }
                }
                obj.innerHTML = table;
            }
            else {
                alert("error occured: " + request.status);
            }
        }
    }
}


function add_app_record(user_id) {
    var request = new XMLHttpRequest();
    request.open("GET","doc_center_action.php?func=" + 2 + "&user_id=" + user_id); //async
    request.send();
    request.onreadystatechange = function() {
        if(request.readyState === 4) {
            if(request.status === 200) {
                window.alert(request.response)
            }
            else {
                alert("error occured: " + request.status);
            }
        }
    }
}

function dirt_to_add_pres(_this) {
    var patid = _this.parentNode.parentNode.parentNode.cells[2].innerHTML;
    var docid = getEle("docinfo").innerHTML;
    var url = "edit_prescription.php?docid=" + docid + "&patid=" + patid;
    location.href = url;
}