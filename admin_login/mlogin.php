<?php
//start session to get login user's info
ob_start();
session_start();
?>

<HTML XMLns="http://www.w3.org/1999/xHTML">
<head>
    <title>Lucas Qin Lab 03 task C</title>
</head>
<body>
<H1>Input a name in below text box and click 'search' button to see the phone number.</H1>

<form>
    <br>
    <label>User Name: <input type="text" name="inputName"></label>
    <br>
    <br>
    <label>Password: <input type="text" name="password"></label>
    <br>
    <br>
    <input type="submit" value="Login" />
</form>
</body>

<?php
$file = "./manager.txt";
$err_msg = "";
if(!isset($_GET['inputName']))
{
    $err_msg.= "Please type in admin user name.";
}
if(!isset($_GET['password']))
{
    $err_msg.= "Please type in password.";
}
if ($err_msg != "") {
    echo $err_msg;
}
else {
    $name = $_GET['inputName'];
    $password = $_GET['password'];
    $bowlers = file($file);

    for ($i = 0; $i < count($bowlers); $i++) {
        $curBowler = explode(",", $bowlers[$i]);
        $temp = strval($curBowler[0]);

//        if ($temp == $name && $curBowler[1]==$password) {
//            header ("location: processing.php");
//            exit();
//        } elseif ($i == (count($bowlers) - 1)) {
//            echo "<p>Account not exit, register first.</p>";
//            echo "<button><a href='mregister.php'>register here</a></button>";
//        } elseif ($temp != $name && !$curBowler[1]==$password){
//            echo "<p>Username or password incorrect, please try again</p>";
//        }
        if ($temp == $name){
            if (strcmp(trim($curBowler[1]), trim($password)==0)){
                $_SESSION['username']=$name;
                header ("location: processing.php");

            }else {
//                echo $name." ".$curBowler[1];
//                echo $password."=".$curBowler[1];
//                $passwordType = gettype($password);
//                $curType = gettype($curBowler[1]);
//                echo $passwordType."+".$curType;
                echo "<p>Username or password incorrect, please try again</p>";
            }
        } elseif ($i==(count($bowlers)-1) && $temp != $name){
            echo "<p>Username not existed, please try again or <a href='mregister.php'>register here</a>.</p>";
        }
    }
}
?>

</HTML>