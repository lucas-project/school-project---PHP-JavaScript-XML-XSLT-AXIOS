<!--logout page-->
<!--For users to logout to their accounts-->
<!--@author Lucas Qin, student ID is 103527269.-->
<!--@date 10/09/2022-->
<?php
ob_start();
session_start();
echo "<br>Thanks for using our BuyOnline system,".$_SESSION["username"].".<br>";
unset($_SESSION["username"]);
echo "<br><button><a href='mlogin.php'>login</a></button><br>";
echo "<br><button><a href='../buyonline.htm'>return to homepage</a></button><br>";
?>