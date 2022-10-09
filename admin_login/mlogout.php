<!--logout page-->
<!--For users to logout to their accounts-->
<!--@author Lucas Qin, student ID is 103527269.-->
<!--@date 10/09/2022-->
<?php
session_start();
unset($_SESSION["email"]);
unset($_SESSION["password"]);
header("Location:mlogin.php");
?>