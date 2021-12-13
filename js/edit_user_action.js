function getEle(id) {
    return document.getElementById(id);
}

function update() {

    var id = getEle("pid").innerHTML;
    var fname = getEle("fname").value;
    var mname = getEle("mname").value;
    var lname = getEle("lname").value;
    var email = getEle("email").value;
    var password = getEle("password").value;
    var birthday = getEle("birthday").value;
    var gender = getEle("gender").value;

    var request = new XMLHttpRequest();
    request.open("GET","edit_user_action.php?id=" + id + "&fname=" + fname + "&mname=" + mname + "&lname=" + lname + "&email=" + email + "&password=" + password + "&birthday=" + birthday + "&gender=" + gender); //async
    request.send();
    request.onreadystatechange = function() {
        if(request.readyState === 4) {
            if(request.status === 200) {
                location.href = "pat_center.php";
            }
        }
    }
}