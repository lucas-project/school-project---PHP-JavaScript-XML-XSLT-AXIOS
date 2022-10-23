//<!--processing customer register request and send to its server-->
//<!--this file is for sending customer register request to server-->
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
// to custRegister.php
function testGet() {

		var firstname = document.getElementById('firstname').value;
		var lastname = document.getElementById('lastname').value;
		var email = document.getElementById('email').value;
		var phone = document.getElementById('phone').value;
		var password = document.getElementById('password').value;
		var confirmpassword = document.getElementById('confirmpassword').value;

		xhr.open("GET", "register.php?firstname=" + encodeURIComponent(firstname) + "&lastname=" + encodeURIComponent(lastname) + "&email=" + encodeURIComponent(email) + "&phone=" + encodeURIComponent(phone) + "&password=" +password + "&confirmpassword=" +confirmpassword + "&id=" + Number(new Date), true);

		xhr.onreadystatechange = testInput;
		xhr.send(null);
	
}

function testInput() {
	if ((xhr.readyState == 4) && (xhr.status == 200)) {
		document.getElementById('msg').innerHTML = xhr.responseText;
	}
	
}
//display xml that store customer register info
function getXML() {
xhr.open ("GET", "getData.php", true);
xhr.onreadystatechange = testXML;
xhr.send(null);
}

//display xml component for getXml()
function testXML() {
	if ((xhr.readyState == 4) && (xhr.status == 200)) {
		//var xmlDoc = xhr.responseXML;
		var xmlDoc = xhr.responseText;
		alert(xmlDoc);
	}
}
//delete xml that store all user's register info
function deleteXML() {
xhr.open ("GET", "deleteFile.php", true);
xhr.onreadystatechange = function () {
if ((xhr.readyState == 4) && (xhr.status == 200)) {
		document.getElementById('msg').innerHTML = xhr.responseText;
	}
}
xhr.send(null);
}
//reset inputs
function clearForm() {
document.getElementById("firstname").value ="";
document.getElementById("lastname").value ="";
document.getElementById('email').value="";
document.getElementById('phone').value="";
document.getElementById('password').value="";
document.getElementById('confirmpassword').value="";
document.getElementById('msg').innerHTML ="";
}

// setInterval(loadItems,5000);
// function loadItems(){
// 	xhr.open('GET',"biddingload.php?id="+Number(new Date),true);
// 	xhr.onreadystatechange = function (){
// 		if(xhr.readyState == 4 && xhr.status == 200){
// 			var xmlDox = xhrt.responseXML;
// 			retrieveItemFromXMLDocument*=(xmlDoc);
// 		}
// 	}
// 	xhr.send(null);
// }
