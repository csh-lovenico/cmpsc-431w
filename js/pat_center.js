function getEle(id) {
    return document.getElementById(id);
}

function load_all() {
    var all_his = getEle("all_his");
    var pid = getEle("pid").innerHTML;
    var request = new XMLHttpRequest();
    request.open("GET","pat_center_action.php?func=" + 1 + "&pid=" + pid); //async
    request.send();
    request.onreadystatechange = function() {
        if(request.readyState === 4) {
            if(request.status === 200) {
                var a = JSON.parse(request.response);
                var table = '';
                for (var k in a) {

                    table += '' +
                        '                <tr>\n' +
                        '                    <td>' + a[k].ahname + '</td>\n' +
                        '                    <td>' + a[k].ahdesc + '</td>\n' +
                        '                    <td id="ah_id" style="display: none">' + a[k].id + '</td>\n' +
                        '                    <td>' +
                        '                        <form action="pat_center_allergy_history_delete.php" method="post"><input class="btn btn-sm btn-danger" type="button" onclick=delete_allergy_his(this) value="Delete"><input type="hidden" name="allergy_history_id" value="' + a[k].id + '"></form>' +
                        '                    </td>' +
                        '                </tr>'
                }
            }
            all_his.innerHTML = table;
        }
    }
}

function load_med() {
    var med_his = getEle("med_his");
    var pid = getEle("pid").innerHTML;
    var request2 = new XMLHttpRequest();
    request2.open("GET","pat_center_action.php?func=" + 2 + "&pid=" + pid); //async
    request2.send();
    request2.onreadystatechange = function() {
        if(request2.readyState === 4) {
            if(request2.status === 200) {
                var a = JSON.parse(request2.response);
                var table2 = '';
                for (var k in a) {
                    table2 += '' +
                        '                <tr>\n' +
                        '                    <td>' + a[k].mhname + '</td>\n' +
                        '                    <td>' + a[k].mhdesc + '</td>\n' +
                        '                    <td id="ah_id" style="display: none">' + a[k].id + '</td>\n' +
                        '                    <td id="td">' +
                        '                        <form action="pat_center_allergy_history_delete.php" method="post"><input class="btn btn-sm btn-danger" type="button" onclick=delete_medical_his(this) value="Delete"><input type="hidden" name="allergy_history_id" value="' + a[k].id + '"></form>' +
                        '                    </td>' +
                        '                </tr>'
                }
            }
            med_his.innerHTML = table2;
        }
    }
}

function load_data() {
    load_all();
    load_med();
}

function delete_medical_his(__this) {
    var _this = __this.parentNode.parentNode.parentNode.cells[2].innerHTML;
    var request = new XMLHttpRequest();
    request.open("GET", "pat_center_action.php?idd=" + _this + "&func=" + 4); //async
    request.send();
    request.onreadystatechange = function () {
        if (request.readyState === 4) {
            if (request.status === 200) {
                load_med();
            } else {
                alert("error occured: " + request.status);
            }
        }
    }
}

function delete_allergy_his(__this) {
    var _this = __this.parentNode.parentNode.parentNode.cells[2].innerHTML;
    var request = new XMLHttpRequest();
    request.open("GET", "pat_center_action.php?idd=" + _this + "&func=" + 3); //async
    request.send();
    request.onreadystatechange = function () {
        if (request.readyState === 4) {
            if (request.status === 200) {
                load_all();
            } else {
                alert("error occured: " + request.status);
            }
        }
    }
}

function add_allergy_his() {
    var pid = getEle("pid").innerHTML;
    var desc = getEle("adescription").value;
    var aname = getEle("allergy_name").value;
    var request = new XMLHttpRequest();
    request.open("GET", "pat_center_action.php?func=" + 5 + "&pid=" + pid + "&adesc=" + desc + "&aname=" + aname); //async
    request.send();
    request.onreadystatechange = function () {
        if (request.readyState === 4) {
            if (request.status === 200) {
                load_all();
            } else {
                alert("error occured: " + request.status);
            }
        }
    }
}

function add_medical_his() {
    var pid = getEle("pid").innerHTML;
    var desc = getEle("description").value;
    var name = getEle("disease_name").value;
    var request = new XMLHttpRequest();
    request.open("GET", "pat_center_action.php?func=" + 6 + "&pid=" + pid + "&desc=" + desc + "&name=" + name); //async
    request.send();
    request.onreadystatechange = function () {
        if (request.readyState === 4) {
            if (request.status === 200) {
                load_med();
            } else {
                alert("error occured: " + request.status);
            }
        }
    }
}