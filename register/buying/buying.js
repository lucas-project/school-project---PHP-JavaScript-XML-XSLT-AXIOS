let xHRObject = false;

if (window.ActiveXObject) {
    xHRObject = new ActiveXObject("Microsoft.XMLHTTP");
} else if (window.XMLHttpRequest) {
    xHRObject = new XMLHttpRequest();
}
//展示购物车
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
setInterval(getResults,2000);


//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
//添加商品到购物车
function addItemToCart(itemNo) {

    //获取空间
    document.getElementById('messageCatalog').className = "";
    document.getElementById("messageCatalog").innerHTML = "";
    let table = document.getElementById("tblCatalog");
    let rows = table.getElementsByTagName("tr");
    let row;
    console.log("1");

    //直接从后台返回的表格里拿id，用于发送请求
    for (let i = 0; i < rows.length; i++) {
        console.log("2");
        if (parseInt(rows[i].cells[0].innerHTML) == parseInt(itemNo)) {
            row = rows[i];
        }
    }
    console.log("3");
    //检查商店商品数量
    let oldQuantity = row.getElementsByTagName("td")[4].innerHTML;
    //如果商店还有存货
    if (oldQuantity > 0) {
        console.log("4");
        // row.getElementsByTagName("td")[4].innerHTML = oldQuantity - 1;
        xHRObject.open("GET", "showCart.php?id=" + Number(new Date) + "&itemNumber=" + itemNo + "&action=add", true);
        xHRObject.onreadystatechange = function () {
            if (xHRObject.readyState == 4 && xHRObject.status == 200) {
                let response = xHRObject.responseText;
                document.getElementById('cart').innerHTML = response;
            }
        }
        xHRObject.send(null);
    } else {
        document.getElementById("messageCatalog").innerHTML = "Sorry this item is not available for sale";
    }
    // end
}

//从购物车移除商品
function removeItemFromCart(itemNo) {
    // 从商店表格获取商品信息
    let table = document.getElementById("tblCatalog");
    let rows = table.getElementsByTagName("tr");
    let row;
    for (let i = 0; i < rows.length; i++) {
        if (parseInt(rows[i].cells[0].innerHTML) == parseInt(itemNo)) {
            row = rows[i];
        }
    }
    //每remove一次商店存货增加1，相当于直接修改html的显示了
    let oldQuantity = row.getElementsByTagName("td")[4].innerHTML;
    row.getElementsByTagName("td")[4].innerHTML = parseInt(oldQuantity) + 1;

    xHRObject.open("GET", "showCart.php?id=" + Number(new Date) + "&itemNumber=" + itemNo + "&action=remove", true);
    xHRObject.onreadystatechange = function () {
        if (xHRObject.readyState == 4 && xHRObject.status == 200) {
            let response = xHRObject.responseText;
            document.getElementById('cart').innerHTML = response;
        }
    }
    xHRObject.send(null);
}

//确认购买
function confirmPurchase() {
    xHRObject.open("GET", "showCart.php?id=" + Number(new Date) + "&action=confirm", true);
    xHRObject.onreadystatechange = function () {
        if (xHRObject.readyState == 4 && xHRObject.status == 200) {
            let response = xHRObject.responseText;
            document.getElementById('cart').innerHTML = response;
        }
    }
    xHRObject.send(null);
}

//取消购物车
function cancelPurchase() {
    // find how many item in cart based on tr quantity
    let tblCart = document.getElementById("tblCart");
    let cartLength = tblCart.getElementsByTagName("tr").length - 2;

    let tblCatalog = document.getElementById("tblCatalog");
    let rowsOfCatalog = tblCatalog.getElementsByTagName("tr");
    let catalogLength = tblCatalog.getElementsByTagName("tr").length;

    let storeQuan = 0;
    let cartQuan = 0;
    //扫描购物车获取商品种类和计算商店应该恢复的数量
    for (let i = 0; i < cartLength; i++) {
        let rowOfCart = tblCart.getElementsByTagName("tr")[i];
        //quantity of the item
        let quantityOfCart = rowOfCart.getElementsByTagName("td")[2].innerHTML;
        //id of the item
        let itemNoOfCart = rowOfCart.getElementsByTagName("td")[0].innerHTML;
        //add quantity in cart with quantity in store to get the total number
        for (let j = 0; j < catalogLength; j++) {
            if (rowsOfCatalog[j].getElementsByTagName("td")[0].innerHTML == itemNoOfCart) {
                storeQuan = parseInt(rowsOfCatalog[j].getElementsByTagName("td")[4].innerHTML);
                cartQuan = parseInt(quantityOfCart);
                storeQuan += cartQuan;
            }
        }
    }
    // 把算好的数量发给后台更新xml
    xHRObject.open("GET", "showCart.php?id=" + Number(new Date) +"&storeQuan="+storeQuan+"&cartQuan="+cartQuan+"&action=cancel", true);
    xHRObject.onreadystatechange = function () {
        if (xHRObject.readyState == 4 && xHRObject.status == 200) {
            let response = xHRObject.responseText;
            document.getElementById('cart').innerHTML = response;

        }
    }
    xHRObject.send(null);
}
