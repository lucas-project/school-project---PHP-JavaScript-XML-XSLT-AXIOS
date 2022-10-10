<?php session_start(); ?>
<?php

$folder = "./";
$pathToGood = "../../admin/goods.xml";
$pathToCart = "cart.xml";
$action = $_GET["action"];

if (array_key_exists("itemNumber", $_GET)) {
    $newItemNo = $_GET["itemNumber"];
} else {
    $newItemNo = "0";
}
if (array_key_exists("Cart", $_SESSION)) {
    $cart = $_SESSION["Cart"];
} else {
    $_SESSION["Cart"] = array();
    $cart = $_SESSION["Cart"];
}

$xmlDoc = new DomDocument("1.0");
$xmlDoc->formatOutput = true;
$xmlDoc->preserveWhiteSpace = false;
$xmlDoc->load($pathToGood);
$root = $xmlDoc->documentElement;
$arrGood = $root->getElementsByTagName('item');

$docForCart = new DomDocument("1.0");
$docForCart->formatOutput = true;
$docForCart->preserveWhiteSpace = false;

if (!file_exists($pathToCart)) {
    createXML($docForCart);
    $docForCart->load($pathToCart);
} else {
    $docForCart->load($pathToCart);
}


if ($action == "confirm") {
    performPurchase("confirm");
} else if ($action == "add") {
    echo "inside add";
    foreach ($arrGood as $good) {
        echo "<br>inside add for";
        $itemNoXml = $good->getElementsByTagName('id')->item(0)->nodeValue;
        $quantityXml = $good->getElementsByTagName('quantity')->item(0)->nodeValue;
        $onholdXml = $good->getElementsByTagName('onhold')->item(0)->nodeValue;
        echo "<br>inside add for before itemno";
        echo "<br>".$itemNoXml;
        echo "<br>".$newItemNo;
        if ($itemNoXml == $newItemNo) {// (1) if equals from select in form
            echo "<br>inside if";
            if ($quantityXml > 0) { // (2) if quan > 0
                //(1)--START: HANDING CART session
                if (count($cart) == 0) { // nothing in cart
                    $cart[$newItemNo] = 1;
                } else { // have exist
                    if ($cart[$newItemNo] > 0) { // exist key = newItemNo
                        $oldQuantity = $cart[$newItemNo];
                        $cart[$newItemNo] = $oldQuantity + 1;
                    } else {
                        $cart[$newItemNo] = 1;
                    }
                }
                $_SESSION["Cart"] = $cart; // (4)update cart
                //--END: HANDING CART session
                //(2)--START HANDING GOODS quantity, quantity hold
                $good->getElementsByTagName('quantity')->item(0)->nodeValue = $quantityXml - 1; // -1 quantity
                $good->getElementsByTagName('onhold')->item(0)->nodeValue = $onholdXml + 1; // +1 Hold
//                echo "<br>1";
                $xmlDoc->save($pathToGood);
//                echo "<br>2";
                //--END HANDING GOODS
                //(3)-- HANDING CART XML
                saveCart($cart, "add");
//                echo "<br>3";
                //--END
                //(4) display
//                echo "<br>brfore displayinh";
                transformXsl("buyingCart.xsl");
//                echo "<br>after displaying";
            } else {
                //TODO : when click add and decrease 0
                saveCart($cart, "add");
//            // display
                transformXsl("buyingCart.xsl");
            }
        }
    }
    echo "4";
} else if ($action == "remove") {
    // Remove in cart session
    global $cart;
    $oldQuantity = $cart[$newItemNo];
    $cart[$newItemNo] = $oldQuantity - 1;
    $_SESSION["Cart"] = $cart;
    //edit goods.xml +1 quantity -1 hold
    foreach ($arrGood as $good) {
        $itemNoXml = $good->getElementsByTagName('id')->item(0)->nodeValue;
        $quantityXml = $good->getElementsByTagName('quantity')->item(0)->nodeValue;
        $onholdXml = $good->getElementsByTagName('onhold')->item(0)->nodeValue;
        if ($itemNoXml == $newItemNo) {
            $good->getElementsByTagName('quantity')->item(0)->nodeValue = $quantityXml + 1; // -1 quantity
            $good->getElementsByTagName('onhold')->item(0)->nodeValue = $onholdXml - 1; // +1 Hold
            $xmlDoc->save($pathToGood);
        }
    }
    // edit cart.xml -1 quantity
    saveCart($cart, "remove");
    // display transform
    transformXsl("buyingCart.xsl");
} else if ($action == "cancel") {
    performPurchase("cancel");
} else if($action == "logout") {
    performPurchase("cancel");
    echo "Thanks for visiting out website. Your customer id is: ".$_SESSION["userid"];
} else if($action =="m_logout") {
    echo "Your email is: ".$_SESSION["email"];
}

function performPurchase($action) {
    global $cart, $arrGood, $docForCart, $xmlDoc, $pathToCart, $pathToGood;
    // UPDATE goods.xml
    foreach ($arrGood as $good) {
        $itemNoXml = $good->getElementsByTagName('id')->item(0)->nodeValue;
        $onholdXml = $good->getElementsByTagName('onhold')->item(0)->nodeValue;
        $soldXml = $good->getElementsByTagName('sold')->item(0)->nodeValue;
        $quantityXml = $good->getElementsByTagName('quantity')->item(0)->nodeValue;

        foreach ($cart as $key => $value) {
            if ($key == $itemNoXml) {
                $good->getElementsByTagName('onhold')->item(0)->nodeValue = $onholdXml - $value;
                if ($action == "confirm") {
                    $good->getElementsByTagName('sold')->item(0)->nodeValue = $soldXml + $value;
                }
                if ($action == "cancel") {

                    $good->getElementsByTagName('quantity')->item(0)->nodeValue = $quantityXml + $value;
                }
            }
        }
    }

    $cartXml = $docForCart->getElementsByTagName('cart')->item(0);
    while ($cartXml->hasChildNodes()) {
        $cartXml->removeChild($cartXml->firstChild);
    }
    //update xml files
    $docForCart->save($pathToCart);
    $xmlDoc->save($pathToGood);
    transformXsl("buyingCart.xsl");
    // UPDATE CART
    $cart = array();
    $_SESSION["Cart"] = $cart;
}

function saveCart($cartArr, $action) {
    global $xmlDoc, $pathToCart, $docForCart, $newItemNo, $cart;
    $root = $xmlDoc->documentElement;
    $arrGood = $root->getElementsByTagName('item');
    $cartXml = $docForCart->getElementsByTagName('cart')->item(0);

    $priceFrGood = 0;
    $total = 0;
    foreach ($cartArr as $itemNo => $quantity) {
        foreach ($arrGood as $element) {
            $idGood = $element->getElementsByTagName('id')->item(0)->nodeValue;
            if ($itemNo == $idGood) {
                $priceFrGood = $element->getElementsByTagName('price')->item(0)->nodeValue;
                $total += ($priceFrGood * $quantity);
            }
        }
    }
    //--END GET PRICE
    //(2)--START WRITE GOOD IN cart.xml
    $arrGoodInCart = $cartXml->getElementsByTagName('item');
    $flagEqual = false;
    if ($arrGoodInCart->length > 0) { // if exist good
        $quantityFoundInCart = 0;
        foreach ($arrGoodInCart as $good) {
            $idFrCart = $good->getElementsByTagName('id')->item(0)->nodeValue;
            $quantityFrCart = $good->getElementsByTagName('quantity')->item(0)->nodeValue;

            if ($idFrCart == $newItemNo) { // check equal to newItemNo if !equal -> create new good else increase
                if ($action == "add") {
                    $flagEqual = true;
                    $good->getElementsByTagName('quantity')->item(0)->nodeValue = $quantityFrCart + 1;
                } else {
                    if ($quantityFrCart == 1) {
//                        echo "1";
                        $cartXml->removeChild($good);
                    } else {
//                        echo "2";
                        $good->getElementsByTagName('quantity')->item(0)->nodeValue = $quantityFrCart - 1;
                    }
                }
                $flagEqual = true;
            }
        }
        if ($flagEqual == FALSE) { // them cai moi ngoai item trong cart
//            echo "3";
            createGood($docForCart, $cartXml, $newItemNo, $priceFrGood, $cart[$newItemNo]);
            $flagEqual = false;
        }
    } else { // not exist any good
//        echo "4";
        createGood($docForCart, $cartXml, $newItemNo, $priceFrGood, $cart[$newItemNo]);
        $flagEqual = false;
    }
    //--END WRITE GOOD
    //(3)--START WRITE TOTAL
    if ($cartXml->getElementsByTagName("total")->length > 0) {
        $cartXml->getElementsByTagName("total")->item(0)->nodeValue = $total;
    } else {
        $totalXml = $cartXml->appendChild($docForCart->createElement('total'));
        $totalXml->appendChild($docForCart->createTextNode($total));
    }
    $docForCart->save($pathToCart);
    //--END
}

function createGood($docForCart, $cart, $id, $priceFrGood, $quantity) {
    $goodXml = $cart->appendChild($docForCart->createElement('good'));

    $idXml = $goodXml->appendChild($docForCart->createElement('id'));
    $idXml->appendChild($docForCart->createTextNode($id));

    $priceXml = $goodXml->appendChild($docForCart->createElement('price'));
    $priceXml->appendChild($docForCart->createTextNode($priceFrGood));

    $quantityXml = $goodXml->appendChild($docForCart->createElement('quantity'));
    $quantityXml->appendChild($docForCart->createTextNode($quantity));
}

function transformXsl($name) {
    global $pathToCart;
    $xmlDoc = new DomDocument("1.0");
    $xmlDoc->formatOutput = true;
    $xmlDoc->preserveWhiteSpace = false;
    $xmlDoc->load($pathToCart);

    $xslDoc = new DomDocument("1.0");
    $xslDoc->load($name);

    $proc = new XSLTProcessor;
    $proc->importStyleSheet($xslDoc);
    echo $proc->transformToXML($xmlDoc);
}

function displayDump($arr) {
    echo "<pre>";
    print_r($arr);
    echo "</pre>";
}

function createXML($docForCart) {
    global $folder, $pathToCart;
    $cart = $docForCart->createElement('cart');
    $docForCart->appendChild($cart);

    if (!is_dir($folder)) {
        mkdir($folder, 0777, true);
    }
    $docForCart->save($pathToCart);
}

?>