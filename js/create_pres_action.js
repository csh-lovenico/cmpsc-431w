function getEle(id) {
    return document.getElementById(id);
}

function submit_comment() {
    var request = new XMLHttpRequest();
    var comment = getEle("comment").value;
    var pid = getEle("pid").innerHTML;

    request.open("GET","create_pres_action.php?pid=" + pid + "&comment=" + comment); //async
    request.send();
    request.onreadystatechange = function() {
        if(request.readyState === 4) {
            if(request.status === 200) {
                location.replace('edit_prescription.php?id=' + request.response);
            }
            else {
                alert("error occured: " + request.status);
            }
        }
    }
}