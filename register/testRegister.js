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

		xhr.open("GET", "testRegister.php?firstname=" + encodeURIComponent(firstname) + "&lastname=" + encodeURIComponent(lastname) + "&email=" + encodeURIComponent(email) + "&phone=" + encodeURIComponent(phone) + "&password=" +password + "&confirmpassword=" +confirmpassword + "&id=" + Number(new Date), true);

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
document.getElementById("firstname").value ="";
document.getElementById("lastname").value ="";
document.getElementById('email').value="";
document.getElementById('phone').value="";
document.getElementById('password').value="";
document.getElementById('confirmpassword').value="";
document.getElementById('msg').innerHTML ="";
}

setInterval(loadItems,5000);
function loadItems(){
	xhr.open('GET',"biddingload.php?id="+Number(new Date),true);
	xhr.onreadystatechange = function (){
		if(xhr.readyState == 4 && xhr.status == 200){
			var xmlDox = xhrt.responseXML;
			retrieveItemFromXMLDocument*=(xmlDoc);
		}
	}
	xhr.send(null);
}
