var xhr = false;
if (window.XMLHttpRequest) {
    xhr = new XMLHttpRequest();
}
else if (window.ActiveXObject) {
    xhr = new ActiveXObject("Microsoft.XMLHTTP");
}

// access user inputs from customer page and pass them
// to custRegister.php
function testGet() {
    var email = document.getElementById('email').value;
    var password = document.getElementById('password').value;

    xhr.open("POST", "login.php?email=" + encodeURIComponent(email) + "&password=" +password + "&id=" + Number(new Date), true);

    xhr.onreadystatechange = testInput;
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
