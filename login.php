<!--customer login server-->
<!--this file is for handling server side of customer login, it compare customer's input against customer.xml-->
<!--@author Lucas Qin, student ID is 103527269.-->
<!--@date 10/09/2022-->
<?php
ob_start();
session_start();
if(isset($_GET["email"]) && isset($_GET["password"])) {
    $err_msg = "";
    function sanitise_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $email = sanitise_input($_GET["email"]);
    $password = sanitise_input($_GET["password"]);

    if (empty($email)) {
        $err_msg .= "You must enter an email id. <br />";
    }

    if (empty($password)) {
        $err_msg .= "You must enter a password. <br />";
    }
    $xmlDoc = new DomDocument;
    $xmlDoc->load("customer.xml");
    //$xslDoc = new DomDocument;
    //$xslDoc->load("books3.xsl");
    if ($err_msg != "") {
        echo $err_msg;
    } else {
//        $proc = new XSLTProcessor;
        //$proc->importStyleSheet($xslDoc);
        $emails = $xmlDoc->getElementsByTagName('email');
        $passwords = $xmlDoc->getElementsByTagName('password');
        $ids = $xmlDoc->getElementsByTagName('id');
        $length = $emails->length;
        $errormsg = array();
        $correctmsg = array();
        for ($i = 0; $i < $length; $i++) {
            $emailValue = $emails->item($i)->nodeValue;
            $passValue = $passwords->item($i)->nodeValue;
            if (trim($emailValue) == trim($email) && trim($passValue) == trim($password)) {
                echo "Successfully logined<br>";
                $idValue = $ids->item($i)->nodeValue;
                $_SESSION["userid"] = $idValue;
                $_SESSION["email"]=$emailValue;
                setcookie("userid",$idValue);
                setcookie("emial",$emailValue);
                echo "Your email address is ".$_SESSION['email'].", and you customer id is ".$_SESSION['userid']."<br>";
//                if (isset($_COOKIE["userid"])){
//                    echo "Cookie is".$_COOKIE["userid"];
//                }

                echo "<br><h2><a href='buying.htm'><strong>Buying page<strong</a></h2>";
                array_push($correctmsg,"successfully");
                break;
            } else {
                array_push($errormsg, "Email or password is incorrect, please try again");
            }


//        echo $proc->transformToXML($xmlDoc);
        }
        if (count($correctmsg)==0){
            echo $errormsg[0];
        }
    }
}
?>