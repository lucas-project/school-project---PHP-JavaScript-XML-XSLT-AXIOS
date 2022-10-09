<?php
//access user login status
session_start();
?>
<?php
//if user not login, redirect to login page
if(!isset($_SESSION["username"])) {
    header("Location:mlogin.php");
}else {
echo "hi,".$_SESSION['username'].", welcome to processing page";

}
