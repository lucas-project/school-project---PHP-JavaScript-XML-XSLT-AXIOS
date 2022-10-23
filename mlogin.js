//<!--processing manager login request and send to its server-->
//<!--this file is for sending manager login request to server-->
//<!--@author Lucas Qin, student ID is 103527269.-->
//<!--@date 10/10/2022-->
var xHRObject = false;
//for compatibility of different browsers
if (window.XMLHttpRequest)
    xHRObject = new XMLHttpRequest();
else if (window.ActiveXObject)
    //instanlise a new web request object
    xHRObject = new ActiveXObject("Microsoft.XMLHTTP");
xHRObject.open("GET", "processing.php?id=" + Number(new Date), true);
xHRObject.onreadystatechange = function () {
    if (xHRObject.readyState == 4 && xHRObject.status == 200) {
        document.getElementById('showProcess').innerHTML = xHRObject.responseText;
    }
}
xHRObject.send(null);
//clear all onhold and sold
//remove items with sold is 0
function clickProcess() {
    xHRObject.open("GET", "mlogin.php?id=" + Number(new Date) + "&action=process", true);
    xHRObject.onreadystatechange = function () {
        if (xHRObject.readyState == 4 && xHRObject.status == 200) {
            document.getElementById('showProcess').innerHTML = xHRObject.responseText;
        }
    }
    xHRObject.send(null);
}