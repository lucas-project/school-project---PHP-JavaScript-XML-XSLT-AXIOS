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
        $length = $emails->length;
        for ($i = 0; $i < $length; $i++) {
            $emailValue = $emails->item($i)->nodeValue;
            $passValue = $passwords->item($i)->nodeValue;
            if (trim($emailValue) == trim($email) && trim($passValue) == trim($password)) {
                echo "successfully logined";
                $_SESSION["useremail"] = $email;
                break;
            } else {
                echo "Email or password incorrect, please try again";
            }
//        echo $proc->transformToXML($xmlDoc);
        }
    }
}
?>