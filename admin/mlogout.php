<!--logout page-->
<!--For users to logout to their accounts-->
<!--@author Lucas Qin, student ID is 103527269.-->
<!--@date 10/09/2022-->
<?php
ob_start();
session_start();
echo "<br>Thanks for using our BuyOnline system,".$_SESSION["managerid"].".<br>";
unset($_SESSION["managerid"]);
//if (isset($_COOKIE['managerid'])) {
//    unset($_COOKIE['managerid']);
//    setcookie('managerid', null, -1, '/');
//    return true;
//} else {
//    return false;
//}
echo "<br><button><a href='mlogin.php'>login</a></button><br>";
echo "<br><button><a href='../buyonline.htm'>return to homepage</a></button><br>";
?>