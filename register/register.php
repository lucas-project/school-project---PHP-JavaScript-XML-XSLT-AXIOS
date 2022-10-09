<?php

header('Content-Type: text/xml');

if(isset($_GET["firstname"]) && isset($_GET["email"]) && isset($_GET["password"]) && isset($_GET["lastname"]) ){
    $err_msg = "";
    function sanitise_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
	$firstName = sanitise_input($_GET["firstname"]);
	$lastName = sanitise_input($_GET["lastname"]);
	$email = sanitise_input($_GET["email"]);
    $id = $_GET["id"];
    if (isset($_GET["phone"])){
        $phone = sanitise_input($_GET["phone"]);
        if (!preg_match("/^[0][0-9][\s][0-9]{8}$/",$phone) && !preg_match("/^[(][0]\d[)]\d{8}$/",$phone)){
            $err_msg.= "Phone number must be either like (0d)dddddddd or 0d dddddddd, d is any number from 1 to 9";
        }
    }

	$password = sanitise_input($_GET["password"]);

	if (empty($firstName)) {
			$err_msg .= "You must enter first name. <br />";
	}

	if (empty($lastName)) {
			$err_msg .= "You must enter last name. <br />";
	}
	
	if (empty($email)) {
			$err_msg .= "You must enter an email id. <br />";
	}


	if (empty($password)) {
			$err_msg .= "You must enter a password. <br />";
	}

    //check if password is same as first-time input
    $confirm_password = sanitise_input($_GET["confirmpassword"]);
    if ($confirm_password == "") {
        $err_msg .= "<p>Please confirm your password.</p>";
    } elseif (!preg_match("/^[a-zA-Z0-9]{2,20}$/", $confirm_password)) {
        $err_msg .= "<p>Password must contain letters or number between 2 to 20.</p>";
    } elseif (strcmp($password, $confirm_password)) {
        $err_msg .= "<p>Password not match, confirm your password again.</p>";
    }
	
	if ($err_msg != "") {
			echo $err_msg;
	}
	else {

	$xmlfile = './register.xml';
	$doc = new DomDocument();

	if (!file_exists($xmlfile)){ // if the xml file does not exist, create a root node $customers
		$customers = $doc->createElement('customers');
		$doc->appendChild($customers);
        echo "<br>create elements";
        //create a customer node under customers node
        $customers = $doc->getElementsByTagName('customers')->item(0);
        $customer = $doc->createElement('customer');
        $customers->appendChild($customer);

        // create unique id using time stamp
        $ids = $doc->createElement('id');
        $customer->appendChild($ids);
        $idValue = $doc->createTextNode($id);
        $ids->appendChild($idValue);

        // create first name node ....
        $firstname = $doc->createElement('firstname');
        $customer->appendChild($firstname);
        $firstNameValue = $doc->createTextNode($firstName);
        $firstname->appendChild($firstNameValue);

        // create last name node ....
        $lastname = $doc->createElement('lastname');
        $customer->appendChild($lastname);
        $lastNameValue = $doc->createTextNode($lastName);
        $lastname->appendChild($lastNameValue);

        //create a Email node ....
        $Email = $doc->createElement('email');
        $customer->appendChild($Email);
        $emailValue = $doc->createTextNode($email);
        $Email->appendChild($emailValue);

        //create a Phone node ....
        $Phone = $doc->createElement('phone');
        $customer->appendChild($Phone);
        $phoneValue = $doc->createTextNode($phone);
        $Phone->appendChild($phoneValue);

        //create a pwd node ....
        $pwd = $doc->createElement('password');
        $customer->appendChild($pwd);
        $pwdValue = $doc->createTextNode($password);
        $pwd->appendChild($pwdValue);
        echo "<br>customers created";
	}
	else { // load the xml file
		$doc->preserveWhiteSpace = FALSE; 
		$doc->load($xmlfile);
        $errMsg = "";
        $customers = $doc->getElementsByTagName("customers");
        $customer = $doc->getElementsByTagName("customer");

        echo "<br>before childNodes";
        $emails = $doc->getElementsByTagName('email');
        $length = $emails->length;
        echo "<br>before for";
        for ($i=0;$i<$length;$i++){
            echo "<br>emails length is:".$length."<br>";


            $emailValue = $emails->item($i)->nodeValue;
//            echo "<br>".$email."=".$emailValue;
            if(trim($emailValue)==trim($email)){
                echo "<br>Email existed, please try another one or <a href='login.htm'>login</a>";
                break;
                exit;
            }else{
                echo "<br>create elements";
                //create a customer node under customers node
                $customers = $doc->getElementsByTagName('customers')->item(0);
                $customer = $doc->createElement('customer');
                $customers->appendChild($customer);

                // create unique id using time stamp
                $ids = $doc->createElement('id');
                $customer->appendChild($ids);
                $idValue = $doc->createTextNode($id);
                $ids->appendChild($idValue);

                // create first name node ....
                $firstname = $doc->createElement('firstname');
                $customer->appendChild($firstname);
                $firstNameValue = $doc->createTextNode($firstName);
                $firstname->appendChild($firstNameValue);

                // create last name node ....
                $lastname = $doc->createElement('lastname');
                $customer->appendChild($lastname);
                $lastNameValue = $doc->createTextNode($lastName);
                $lastname->appendChild($lastNameValue);

                //create a Email node ....
                $Email = $doc->createElement('email');
                $customer->appendChild($Email);
                $emailValue = $doc->createTextNode($email);
                $Email->appendChild($emailValue);

                //create a Phone node ....
                $Phone = $doc->createElement('phone');
                $customer->appendChild($Phone);
                $phoneValue = $doc->createTextNode($phone);
                $Phone->appendChild($phoneValue);

                //create a pwd node ....
                $pwd = $doc->createElement('password');
                $customer->appendChild($pwd);
                $pwdValue = $doc->createTextNode($password);
                $pwd->appendChild($pwdValue);
            }
        }

//        if (isset($customers->customer)){
//            echo "before foreach";
//            foreach($customers as $node)
//            {
//                echo "inside foreach";
////                $emails = $node->getElementsByTagName("email");
//
//                if (trim($emails)==trim($email)){
//                    echo "email same";
//                }
//            }
//        }else {

        }

//	}
        //save the xml file
        $doc->formatOutput = true;
        $doc->save($xmlfile);

        echo "<br><a href=../buyonline.htm> <- Back</a>";
	} 
}
?>