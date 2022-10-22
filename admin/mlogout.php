<!--logout page-->
<!--For users to logout to their accounts-->
<!--@author Lucas Qin, student ID is 103527269.-->
<!--@date 10/09/2022-->
<?php
ob_start();
session_start();
if (isset($_SESSION["managerid"])){
    echo "<br>Thanks for using our BuyOnline system,your manager id is ".$_SESSION["managerid"].".<br>";
    unset($_SESSION["managerid"]);
} else {
    echo "You have logged out and refreshed the page, select below operation to proceed.<br><br>";
}

//if (isset($_COOKIE['managerid'])) {
//    unset($_COOKIE['managerid']);
//    setcookie('managerid', null, -1, '/');
//    return true;
//} else {
//    return false;
//}
echo "<br><button><a href='mlogin.htm'>Manager login</a></button><br>";
echo "<br><button><a href='../buyonline.htm'>return to homepage</a></button><br>";
?>