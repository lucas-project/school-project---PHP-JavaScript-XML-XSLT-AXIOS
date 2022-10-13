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

    var name = document.getElementById('name').value;
    var price = document.getElementById('price').value;
    var quantity = document.getElementById('quantity').value;
    var description = document.getElementById('description').value;

    xhr.open("GET", "processListing.php?name=" + name + "&price=" + encodeURIComponent(price) + "&quantity=" + encodeURIComponent(quantity) + "&description=" +description + "&id=" + Number(new Date), true);
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
       // alert(xmlDoc);
    }
}

function deleteXML() {

    xhr.open ("GET", "deleteFile.php", true);

    xhr.onreadystatechange = function () {
        if ((xhr.readyState == 4) && (xhr.status == 200)) {
            document.getElementById('msg').innerHTML = xhr.responseText;
        }
    }
    xhr.send(null);
}
function clearForm() {
    document.getElementById("name").value ="";
    document.getElementById('price').value="";
    document.getElementById('quantity').value="";
    document.getElementById('description').value="";
    document.getElementById('msg').innerHTML ="";
}
