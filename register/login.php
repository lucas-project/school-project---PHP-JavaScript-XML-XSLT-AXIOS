<?php
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
    $xmlDoc->load("register.xml");
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
                echo "successfully logined<br>";
                $idValue = $ids->item($i)->nodeValue;
                $_SESSION["userid"] = $idValue;
                $_SESSION["email"]=$emailValue;
                echo "Your email address is ".$_SESSION['email'].", and you customer id is ".$_SESSION['userid']."<br>";
                echo "<br><a href='./buying/buying.htm'>buuying page</a>";
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