function getEle(id) {
    return document.getElementById(id);
}

var patient_name = '';
function search_patient_by_name() {
    var patient_name = getEle("patient_name").value;
    var request = new XMLHttpRequest();
    request.open("GET","doc_center_action.php?func=" + 1 + "&patient_name=" + patient_name); //async
    request.send();
    request.onreadystatechange = function() {
        if(request.readyState === 4) {
            if(request.status === 200) {
                var jsonStr = request.response.replace(new RegExp('\\"',"gm"), '"' );
                var a = JSON.parse(jsonStr);
                var obj = getEle("search_patient_table_body");
                var table = '';

                for (var k in a) {
                    for (var j in a[k]) {
                        table += '' +
                            '                <tr>\n' +
                            '                    <td>' + a[k][j].name + '</td>\n' +
                            '                    <td>' + a[k][j].age + '</td>\n' +
                            '                    <td>' + a[k][j].email + '</td>\n' +
                            '                    <td>\n' +
                            '                        <div>\n' +
                            '                            <button type="button" class="btn btn-sm btn-secondary">Select</button>\n' +
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

var cou = 0;
function sort_patient() {
    var request = new XMLHttpRequest();
    ++cou;
    if (patient_name == '') {
        // not init
        request.open("GET","doc_center_action.php?func=" + 1 + "&patient_name=" + patient_name + "&mode=" + cou); //async
    } else {
        request.open("GET","doc_center_action.php?func=" + 1 + "&patient_name=" + patient_name + "&mode=" + cou); //async
    }
    request.send();
    request.onreadystatechange = function() {
        if(request.readyState === 4) {
            if(request.status === 200) {
                var jsonStr = request.response.replace(new RegExp('\\"',"gm"), '"' );
                var a = JSON.parse(jsonStr);
                var obj = getEle("search_patient_table_body");
                var table = '';

                for (var k in a) {
                    for (var j in a[k]) {
                        table += '' +
                            '                <tr>\n' +
                            '                    <td>' + a[k][j].name + '</td>\n' +
                            '                    <td>' + a[k][j].age + '</td>\n' +
                            '                    <td>' + a[k][j].email + '</td>\n' +
                            '                    <td>\n' +
                            '                        <div>\n' +
                            '                            <button type="button" class="btn btn-sm btn-secondary">Select</button>\n' +
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