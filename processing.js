//<!--manager processing request sending file-->
//<!--For sending processing page's request to its server-->
//<!--@author Lucas Qin, student ID is 103527269.-->
// @date 10/10/2022

var xHRObject = false;
//for compatible to different browser
if (window.XMLHttpRequest)
    xHRObject = new XMLHttpRequest();
else if (window.ActiveXObject)
    xHRObject = new ActiveXObject("Microsoft.XMLHTTP");
//sending request to processing.php
xHRObject.open("GET", "processing.php?id=" + Number(new Date), true);
xHRObject.onreadystatechange = function () {
    if (xHRObject.readyState == 4 && xHRObject.status == 200) {
        document.getElementById('showProcess').innerHTML = xHRObject.responseText;
    }
}
xHRObject.send(null);
//clearing the quantity sold for all those items with sold quantities,
//removing those items that have been completely sold, i.e., both quantity available and quantity on hold equal to 0.
function clickProcess() {
    xHRObject.open("GET", "processing.php?id=" + Number(new Date) + "&action=process", true);
    xHRObject.onreadystatechange = function () {
        if (xHRObject.readyState == 4 && xHRObject.status == 200) {
            document.getElementById('showProcess').innerHTML = xHRObject.responseText;
        }
    }
    xHRObject.send(null);
}