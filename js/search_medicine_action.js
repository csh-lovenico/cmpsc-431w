function getEle(id) {
    return document.getElementById(id);
}

var pat_name = '';

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
                //alert(request.response)
                var obj = getEle("search_medicine_table_body");
                var table = '';

                for (var k in a) {
                    table += '' +
                        '                <tr >\n' +
                        '                    <td >' + a[k].name + '</td>\n' +
                        '                    <td >' + a[k].price + '</td>\n' +
                        '                    <td >' + a[k].stock + '</td>\n' +
                        '                    <input>' +
                        '                    <td  style="display:none">' + a[k].drug_id + '</td>\n' +
                        '                    <td >' + a[k].usage + '</td>\n' +
                        '                    <td >\n' +
                        '                        <div >\n' +
                        '                            <button type="button" class="btn btn-sm btn-secondary" onclick=select_patient(this)>Select</button>\n' +
                        '                        </div>\n' +
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
