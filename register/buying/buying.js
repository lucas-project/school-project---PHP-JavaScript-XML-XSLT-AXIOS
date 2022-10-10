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

//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
function addItemToCart(itemNo) {
    // alert("here");
    document.getElementById('messageCatalog').className = "";
    document.getElementById("messageCatalog").innerHTML = "";
    // decrease quantity 1
    var table = document.getElementById("tblCatalog");
    var rows = table.getElementsByTagName("tr");
    var row;
    console.log("1");
    for (var i = 0; i < rows.length; i++) {
        console.log("2");
        if (parseInt(rows[i].cells[0].innerHTML) == parseInt(itemNo)) {
            row = rows[i];
        }
    }
//                var row = table.getElementsByTagName("tr")[itemNo];
    console.log("3");
    var oldQuantity = row.getElementsByTagName("td")[4].innerHTML;
    if (oldQuantity > 0) {
        console.log("4");
        row.getElementsByTagName("td")[4].innerHTML = oldQuantity - 1;
        xHRObject.open("GET", "showCart.php?id=" + Number(new Date) + "&itemNumber=" + itemNo + "&action=add", true);
        xHRObject.onreadystatechange = function () {
            if (xHRObject.readyState == 4 && xHRObject.status == 200) {
                var response = xHRObject.responseText;
                document.getElementById('cart').innerHTML = response;
            }
        }
        xHRObject.send(null);
    } else {
        document.getElementById('messageCatalog').className = "alert alert-danger";
        document.getElementById("messageCatalog").innerHTML = "Sorry this item is not available for sale";
    }
    // end
}

function removeItemFromCart(itemNo) {
    // increase quantity 1
    var table = document.getElementById("tblCatalog");
//                var row = table.getElementsByTagName("tr")[itemNo];
    var rows = table.getElementsByTagName("tr");
    var row;
    for (var i = 0; i < rows.length; i++) {
        if (parseInt(rows[i].cells[0].innerHTML) == parseInt(itemNo)) {
            row = rows[i];
        }
    }
    var oldQuantity = row.getElementsByTagName("td")[4].innerHTML;
    row.getElementsByTagName("td")[4].innerHTML = parseInt(oldQuantity) + 1;
    // end

    xHRObject.open("GET", "showCart.php?id=" + Number(new Date) + "&itemNumber=" + itemNo + "&action=remove", true);
    xHRObject.onreadystatechange = function () {
        if (xHRObject.readyState == 4 && xHRObject.status == 200) {
            var response = xHRObject.responseText;
            document.getElementById('cart').innerHTML = response;
        }
    }
    xHRObject.send(null);
}

function confirmPurchase() {
    //delete session
    // goods.xml- quanHold | + quan sold in cart session
    // -> amount to pay
    // clear shopping
    xHRObject.open("GET", "showCart.php?id=" + Number(new Date) + "&action=confirm", true);
    xHRObject.onreadystatechange = function () {
        if (xHRObject.readyState == 4 && xHRObject.status == 200) {
            var response = xHRObject.responseText;
            document.getElementById('cart').innerHTML = response;
        }
    }
    xHRObject.send(null);
}

function cancelPurchase() {
    // change catalog: increase quantity in the catalog
    var tblCart = document.getElementById("tblCart");
    var cartLength = tblCart.getElementsByTagName("tr").length - 2;

    var tblCatalog = document.getElementById("tblCatalog");
    var catalogLength = tblCatalog.getElementsByTagName("tr").length;
    var rowsOfCatalog = tblCatalog.getElementsByTagName("tr");
    for (var i = 0; i < cartLength; i++) {
        var rowOfCart = tblCart.getElementsByTagName("tr")[i];
        var quantityOfCart = rowOfCart.getElementsByTagName("td")[2].innerHTML;
        var itemNoOfCart = rowOfCart.getElementsByTagName("td")[0].innerHTML;
        // find row with itemNo in catalog
        for (var j = 0; j < catalogLength; j++) {
            if (rowsOfCatalog[j].getElementsByTagName("td")[0].innerHTML == itemNoOfCart) {
                rowsOfCatalog[j].getElementsByTagName("td")[4].innerHTML = parseInt(rowsOfCatalog[j].getElementsByTagName("td")[4].innerHTML) + parseInt(quantityOfCart);
            }
        }
    }

    // ajax for update card by xml
    xHRObject.open("GET", "showCart.php?id=" + Number(new Date) + "&action=cancel", true);
    xHRObject.onreadystatechange = function () {
        if (xHRObject.readyState == 4 && xHRObject.status == 200) {
            var response = xHRObject.responseText;
            document.getElementById('cart').innerHTML = response;
        }
    }
    xHRObject.send(null);
}
