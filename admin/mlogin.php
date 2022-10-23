<!--manager login server-->
<!--this file is for handling server side of manager login, it compare manager's input against manager.txt-->
<!--@author Lucas Qin, student ID is 103527269.-->
<!--@date 10/09/2022-->
<?php
//start session to get login user's info
ob_start();
session_start();
?>
<style>
    <?php include '../styles.css'; ?>
</style>

<?php
//define file locaiton
$file = "./manager.txt";
$err_msg = "";
//check all inputs provided
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
    //get inputs from pathname params
    $name = $_GET['inputName'];
    $password = $_GET['password'];
    $bowlers = file($file);

    //check against manager.txt
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
        //find names
        if ($temp == $name){
            //check password
            if (strcmp(trim($curBowler[1]), trim($password)==0)){
                //store managerid using session and cookie, cookie works for client side here
                $_SESSION['managerid']=$name;
                setcookie("managerid",$name);
                //if successfully match, display below info
                echo "<div id='titles'><h4>You are successfully logined in, your manager id is ".$name."</h4></div>";
                echo "<h3>Choose an operation below:</h3><br>";
                echo "<div id='buttons'><div id='inButtons'> <br><br><button><a href='processing.htm'>processing page</a></button><br>";
                echo "<br><button><a href='listing.htm'>listing page</a></button>";
                echo "<br><br><button><a href='mlogout.php'>logout</a></button></div></div>";
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