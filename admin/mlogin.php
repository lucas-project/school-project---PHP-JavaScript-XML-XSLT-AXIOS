<?php
//start session to get login user's info
ob_start();
session_start();
?>


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
//            header ("location: processing.htm");
//            exit();
//        } elseif ($i == (count($bowlers) - 1)) {
//            echo "<p>Account not exit, register first.</p>";
//            echo "<button><a href='mregister.php'>register here</a></button>";
//        } elseif ($temp != $name && !$curBowler[1]==$password){
//            echo "<p>Username or password incorrect, please try again</p>";
//        }
        if ($temp == $name){
            if (strcmp(trim($curBowler[1]), trim($password)==0)){
                $_SESSION['managerid']=$name;
                setcookie("managerid",$name);
                echo "You are successfully logined in, your manager id is ".$name;
                echo "<h4>Choose an operation below:</h4><br>";
                echo "<br><br><button><a href='processing.htm'>processing page</a></button><br>";
                echo "<br><button><a href='listing.htm'>listing page</a></button>";
                echo "<br><br><button><a href='mlogout.php'>logout</a></button>";
                break;
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