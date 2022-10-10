<?php
header('Content-Type: text/xml');

    $err_msg = "";
    function sanitise_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    $name = sanitise_input($_GET["name"]);
    if ($name==""){
        $err_msg.="<p>Please fill in item's name.</p>";
    }
    $price = sanitise_input($_GET["price"]);
    if ($price==""){
        $err_msg.="<p>Please fill in item's price.</p>";
    }
    $quantity = sanitise_input($_GET["quantity"]);
    if ($quantity==""){
        $err_msg.="<p>Please fill in item's quantity.</p>";
    }
    $description = sanitise_input($_GET["description"]);
    if ($description==""){
        $err_msg.="<p>Please fill in item's description.</p>";
    }
    $id = $_GET["id"];
    $onhold = 0;
    $sold = 0;
    $total = 0;
    if ($err_msg != "") {
        echo $err_msg;
    }
    else {

        $xmlfile = './goods.xml';
        $doc = new DomDocument();

        if (!file_exists($xmlfile)){ // if the xml file does not exist, create a root node $items
            $items = $doc->createElement('items');
            $doc->appendChild($items);
            echo "items created";
        }
        else { // load the xml file
            $doc->preserveWhiteSpace = FALSE;
            $doc->load($xmlfile);
        }
        $items = $doc->getElementsByTagName("items");
        $add = "";

        echo "else";
        //create a item node under items node
        $items = $doc->getElementsByTagName('items')->item(0);
        $item = $doc->createElement('item');
        $items->appendChild($item);

        // create unique id using time stamp
        $ids = $doc->createElement('id');
        $item->appendChild($ids);
        $idValue = $doc->createTextNode($id);
        $ids->appendChild($idValue);

        // create first name node ....
        $Name = $doc->createElement('name');
        $item->appendChild($Name);
        $nameValue = $doc->createTextNode($name);
        $Name->appendChild($nameValue);

        // create last name node ....
        $Price = $doc->createElement('price');
        $item->appendChild($Price);
        $priceValue = $doc->createTextNode($price);
        $Price->appendChild($priceValue);

        //create a quantity node ....
        $Quantity = $doc->createElement('quantity');
        $item->appendChild($Quantity);
        $quantityValue = $doc->createTextNode($quantity);
        $Quantity->appendChild($quantityValue);

        //create a description node ....
        $Description = $doc->createElement('description');
        $item->appendChild($Description);
        $descriptionValue = $doc->createTextNode($description);
        $Description->appendChild($descriptionValue);

        //create a on hold item quantity
        $Onhold = $doc->createElement('onhold');
        $item->appendChild($Onhold);
        $onholdValue = $doc->createTextNode($onhold);
        $Onhold->appendChild($onholdValue);

        //create a sold item quantity
        $Sold = $doc->createElement('sold');
        $item->appendChild($Sold);
        $soldValue = $doc->createTextNode($sold);
        $Sold->appendChild($soldValue);

        //create an add button
        $Add = $doc->createElement('add');
        $item->appendChild($Add);
        $addValue = $doc->createTextNode($add);
        $Add->appendChild($addValue);

        //create an add button
        $Total = $doc->createElement('total');
        $item->appendChild($Total);
        $totalValue = $doc->createTextNode($total);
        $Total->appendChild($totalValue);

        //save the xml file
        $doc->formatOutput = true;
        $doc->save($xmlfile);



        echo "The item has been listed in the system, and the item number is: ".$id;

        echo "<a href=../buyonline.htm> <- Back</a>";


}
?>