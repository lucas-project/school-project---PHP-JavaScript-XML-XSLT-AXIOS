//<!--processing customer login request and send to its server-->
//<!--this file is for sending customer login request to server-->
//<!--@author Lucas Qin, student ID is 103527269.-->
//<!--@date 10/10/2022-->
var xhr = false;
if (window.XMLHttpRequest) {
    xhr = new XMLHttpRequest();
}
else if (window.ActiveXObject) {
    xhr = new ActiveXObject("Microsoft.XMLHTTP");
}

// access user inputs from customer page and pass them
// to login.php
function testGet() {
    var email = document.getElementById('email').value;
    var password = document.getElementById('password').value;

    xhr.open("POST", "login.php?email=" + encodeURIComponent(email) + "&password=" +password + "&id=" + Number(new Date), true);

    xhr.onreadystatechange = testInput;
    function getCookie(cookieName) {
        let name = cookieName + "=";
        let decodedCookie = decodeURIComponent(document.cookie);
        let ca = decodedCookie.split(';');
        for(let i = 0; i <ca.length; i++) {
            let c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    }
    function checkCookie() {
        if(getCookie("userid")!==null){
            window.location = "buying.htm"
        }
    }
    setInterval(checkCookie,2000)

    xhr.send(null);

}

function testInput() {
    if ((xhr.readyState == 4) && (xhr.status == 200)) {
        document.getElementById('msg').innerHTML = xhr.responseText;
    }

}

function getXML() {
    xhr.open ("GET", "getData.php", true);
    xhr.onreadystatechange = testXML;
    xhr.send(null);
}

function testXML() {
    if ((xhr.readyState == 4) && (xhr.status == 200)) {
        //var xmlDoc = xhr.responseXML;
        var xmlDoc = xhr.responseText;
        alert(xmlDoc);
    }
}


function clearForm() {
    document.getElementById('email').value="";
    document.getElementById('password').value="";
    document.getElementById('msg').innerHTML ="";
}
