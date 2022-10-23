<!--manager logout page-->
<!--For users to logout to their accounts-->
<!--@author Lucas Qin, student ID is 103527269.-->
<!--@date 10/10/2022-->
<style>
    <?php include '../styles.css'; ?>
</style>
<?php
ob_start();
session_start();

if (isset($_SESSION["managerid"])){
    echo "<br><div id='titles'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<h3>Thanks for using our BuyOnline system,your manager id is ".$_SESSION["managerid"].".</h3></div><br>";
    unset($_SESSION["managerid"]);
} else {
    echo "<div id='titleSS'> You have logged out and refreshed the page, select below operation to proceed.</div><br><br>";
}

//if (isset($_COOKIE['managerid'])) {
//    unset($_COOKIE['managerid']);
//    setcookie('managerid', null, -1, '/');
//    return true;
//} else {
//    return false;
//}
echo "<br><div id='buttons'> <div id='inButtons'></div> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button><a href='mlogin.htm'>Manager login</a></button><br>";
echo "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button><a href='buyonline.htm'>return to homepage</a></button></div></div><br>";
?>