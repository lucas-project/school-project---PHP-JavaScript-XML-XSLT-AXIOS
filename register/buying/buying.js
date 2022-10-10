var xHRObject = false;

if (window.ActiveXObject) {
    xHRObject = new ActiveXObject("Microsoft.XMLHTTP");
} else if (window.XMLHttpRequest) {
    xHRObject = new XMLHttpRequest();
}

function getResults(){
    xHRObject.open("POST", "buying.php?id=" + Number(new Date), true);
    xHRObject.onreadystatechange = getData;
    xHRObject.send(null);
}

function getData()
{
    if ((xHRObject.readyState == 4) &&(xHRObject.status == 200))
    {
        document.getElementById('welcome').innerHTML = sessionStorage.getItem("userid");
        document.getElementById('results').innerHTML = xHRObject.responseText;
    }
}

setInterval(getResults,5000);
