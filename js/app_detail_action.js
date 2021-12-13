function getEle(id) {
    return document.getElementById(id);
}

var cou = 0;
function get_app_record() {
    var request = new XMLHttpRequest();
    ++cou;
    var appid = getEle("appid").innerHTML;
    request.open("GET", "app_detail_action.php?appid=" + appid + "&cou=" + cou); //async
    request.send();
    request.onreadystatechange = function () {
        if (request.readyState === 4) {
            if (request.status === 200) {
                var jsonStr = request.response.replace(new RegExp('\\"', "gm"), '"');
                var a = JSON.parse(jsonStr);
                var obj = getEle("app_detail_pres_body");
                var table = '';
                for (var k in a) {
                    table += '' +
                        '                <tr>\n' +
                        '                    <td>' + a[k].dname + '</td>\n' +
                        '                    <td>' + a[k].dnum + '</td>\n' +
                        '                    <td>' + a[k].dprice + '</td>\n' +
                        '                    <td>' + a[k].dusage + '</td>\n' +
                        '                </tr>'
                }
                obj.innerHTML = table;
            } else {
                alert("error occured: " + request.status);
            }
        }
    }
}