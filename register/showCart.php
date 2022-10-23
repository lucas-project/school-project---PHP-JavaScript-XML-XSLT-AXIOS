<!--更新商店xml和购物车xml并保存-->
<!--displaying cart server side-->
<!--this file is for updating goods.xml and cart.xml, define the relationship of hold, sold and available quantity and store in relevant xml-->
<!--@author Lucas Qin, student ID is 103527269.-->
<!--@date 10/10/2022-->
<?php session_start(); ?>
<?php
//定义路径
$folder = "../admin";
$pathToGood = "../admin/goods.xml";
$pathToCart = "../admin/cart.xml";
$action = $_GET["action"];
//检查前端js是否传参数并获取参数
if (array_key_exists("itemNumber", $_GET)) {
    $addedItemId = $_GET["itemNumber"];
} else {
    $addedItemId = "0";
}

if (array_key_exists("storeQuan", $_GET)) {
    $addedItemId = $_GET["storeQuan"];
}

if (array_key_exists("cartQuan", $_GET)) {
    $addedItemId = $_GET["cartQuan"];
}
if (array_key_exists("Cart", $_SESSION)) {
    $cart = $_SESSION["Cart"];
} else {
    $_SESSION["Cart"] = array();
    $cart = $_SESSION["Cart"];
}

//创建购物车xml
$xmlDoc = new DomDocument("1.0");
$xmlDoc->formatOutput = true;
$xmlDoc->preserveWhiteSpace = false;
$xmlDoc->load($pathToGood);
$root = $xmlDoc->documentElement;
$arrGood = $root->getElementsByTagName('item');

$docForCart = new DomDocument("1.0");
$docForCart->formatOutput = true;
$docForCart->preserveWhiteSpace = false;
//echo "<br>before create";
$xmlfile='../admin/cart.xml';
//如果指定路径不存在就创建一个xml
if (!file_exists($xmlfile)) {
    createXML($docForCart);
    $docForCart->load($pathToCart);
//    echo "<br>after create";
} else {
//    echo "<br>create else";
    $docForCart->load($xmlfile);
}

//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx-根据前端传的action有不同的处理方法xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx

//aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa-前端执行confirm时-aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
if ($action == "confirm") {
    logoutCancelConfirmHandle("confirm");
    //前端执行add时
} else if ($action == "add") {
//    echo "<br>1";
    foreach ($arrGood as $good) {
//        echo "<br>2";
        //从goods.xml拿数据
        $xmlItemId = $good->getElementsByTagName('id')->item(0)->nodeValue;
        $xmlQuantity = $good->getElementsByTagName('quantity')->item(0)->nodeValue;
        $xmlOnhold = $good->getElementsByTagName('onhold')->item(0)->nodeValue;
//        echo "<br>3";

        //1. 如果前端传过来的id匹配上了
        if ($xmlItemId == $addedItemId) {
//            echo "<br>4";
            //2. 匹配上以后检查商店有没有该物品，大于0
            if ($xmlQuantity > 0) {
//                echo "<br>5";
                //如果商店里还有的卖，看购物车里是不是， 已存在
                if (isset($cart)&& count($cart) >= 0) {
                    //SESSION里该商品增加 1
                    $cart[$addedItemId] += 1;
//                    echo "<br>".$cart[$addedItemId];
                } else {
                        //如果不存在就将购物车数量设为 1
                        $cart[$addedItemId] = 1;
                }
                //更新SESSION里的购物车
                $_SESSION["Cart"] = $cart; // (4)update cart

//                echo "<br>10";
                //修改商店里的数量并保存
                $good->getElementsByTagName('quantity')->item(0)->nodeValue =$xmlQuantity-1; // -1 quantity
                $good->getElementsByTagName('onhold')->item(0)->nodeValue += 1; // +1 Hold
                $xmlDoc->save($pathToGood);

                //修改完商店的来修改购物车里的数量
//                echo "<br>11";
                saveCart($cart, "add");
                //展示更新后的数据
//                echo "<br>12";
                transformXsl("showCart.xsl");

            } else {
                echo "<br>sorry, this item sold out.";
                saveCart($cart, "add");
                //展示更新后的数据
//                echo "<br>15";
                transformXsl("showCart.xsl");
            }
        }
    }
    //bbbbbbbbbbbbbbbbbbbbbbbbbbbbbbb-前端执行remove时-bbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbb
} else if ($action == "remove") {
    // Remove in cart session
    global $cart;
    $cart[$addedItemId] -= 1;
    $_SESSION["Cart"] = $cart;
    //edit goods.xml +1 quantity -1 hold
    foreach ($arrGood as $good) {
        $xmlItemId = $good->getElementsByTagName('id')->item(0)->nodeValue;
        $xmlQuantity = $good->getElementsByTagName('quantity')->item(0)->nodeValue;
        $xmlOnhold = $good->getElementsByTagName('onhold')->item(0)->nodeValue;
        if ($xmlItemId == $addedItemId) {
            $good->getElementsByTagName('quantity')->item(0)->nodeValue = $xmlQuantity + 1; // -1 quantity
            $good->getElementsByTagName('onhold')->item(0)->nodeValue = $xmlOnhold - 1; // +1 Hold
            $xmlDoc->save($pathToGood);
        }
    }
    // edit cart.xml -1 quantity
    saveCart($cart, "remove");
    // display transform
    transformXsl("showCart.xsl");
    //cccccccccccccccccccccccccccccccc-前端执行cancel时-cccccccccccccccccccccccccccccccccccccccc
} else if ($action == "cancel") {
    logoutCancelConfirmHandle("cancel");
    //dddddddddddddddddddddddddddddddd-前端执行logout时-dddddddddddddddddddddddddddddddddddddddd
} else if($action == "logout") {
    logoutCancelConfirmHandle("cancel");
    echo "Thanks for visiting out website. Your customer id is: ".$_SESSION["userid"];
    //eeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee-前端执行管理员logout时-eeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee
} else if($action =="m_logout") {
    echo "Your email id is: ".$_SESSION["email"];
}
//处理cancel和logout
function logoutCancelConfirmHandle($action) {
    //从调用logoutCancelHandle()的地方引进变量
    global $cart, $arrGood, $docForCart, $xmlDoc, $addedItemId, $pathToGood;
    //获取商店里商品信息
    foreach ($arrGood as $good) {
        $xmlItemId = $good->getElementsByTagName('id')->item(0)->nodeValue;
        $xmlOnhold = $good->getElementsByTagName('onhold')->item(0)->nodeValue;
        $xmlSold = $good->getElementsByTagName('sold')->item(0)->nodeValue;
        $xmlQuantity = $good->getElementsByTagName('quantity')->item(0)->nodeValue;
//        $priceXml = $good->getElementsByTagName('price')->item(0)->nodeValue;

        //拆解购物车,key是商品id，cartQuantity是买了多少
        foreach ($cart as $key => $cartQuantity) {
//            echo "<br/>cancel ".$key;
//            echo "<br/>xmlOnhold ".$xmlOnhold;
            //把购物车里商品和商店的对比
            if ($key == $xmlItemId) {
//                echo "<br/>inside ".$key;
//                $xmlOnhold = $xmlOnhold - $cartQuantity;
                if ($action == "confirm") {
//                    $xmlSold = $xmlSold + $cartQuantity;
                    $good->getElementsByTagName('sold')->item(0)->nodeValue = $xmlSold + $cartQuantity;
                    $good->getElementsByTagName('onhold')->item(0)->nodeValue = $xmlOnhold - $cartQuantity;
                    $cartXml = $docForCart->getElementsByTagName('cart')->item(0);
                    $totalP = $cartXml->getElementsByTagName("total")->item(0)->nodeValue;
                    echo "<br/>Your purchase has been confirmed and total amount due to pay is $".$totalP;
                } else if ($action == "cancel") {
                    $good->getElementsByTagName('quantity')->item(0)->nodeValue = $xmlQuantity + $cartQuantity;
//                    echo "<br/>xmlQuantity ".$xmlQuantity;
                    $good->getElementsByTagName('onhold')->item(0)->nodeValue = $xmlOnhold - $cartQuantity;

                    echo "Your purchase request has been cancelled, welcome to shop next time";
//                    break;
//                    return;
                    //检查前端是否传了一个参数叫storeQuan，代表的是表格上读取的商店数量，有的话存进SESSION
//                    $storeQuan =0;
//                    if (array_key_exists("storequan", $_GET)) {
//                        $storeQuan = $_GET["storequan"];
//                    } else {
//                        $storeQuan = "0";
//                    }
//                    header('Content-Type: text/xml');
//                    $xmlfile = '../admin/cart.xml';

//                    if (!unlink($xmlfile)){ // if the xml file does not exist
//                        echo "Error in deleting $xmlfile.";
//                    } else {
//                        echo "Deleted $xmlfile";
//                    }
//                    $_SESSION["Cart"]=array();
//                    echo "<br>implode: ".implode(" ",$_SESSION["Cart"]);
//                        echo "<br>Your purchase request has been cancelled, welcome to shop next time";
//                        exit();
                    }

                }
        }

    }


    //不管是cancel还是logout， 清空购物车
    $cartXml = $docForCart->getElementsByTagName('cart')->item(0);
    while ($cartXml->hasChildNodes()) {
        $cartXml->removeChild($cartXml->firstChild);
    }
    //保存清空的状态
    $docForCart->save("../admin/cart.xml");
    $xmlDoc->save($pathToGood);
    transformXsl("showCart.xsl");
    //重置SEESION
    $cart = array();
    $_SESSION["Cart"] = $cart;
}


// $cartArr SESSION里的购物车(itemno-quantity) |
// $arrGood:商店里所有商品 (price)
function saveCart($cartArr, $action) {
    global $xmlDoc, $pathToCart, $docForCart, $addedItemId, $cart;
    //商品和购物车位置
    $root = $xmlDoc->documentElement;
    $arrGood = $root->getElementsByTagName('item');
    $cartXml = $docForCart->getElementsByTagName('cart')->item(0);
    //1. 在商店里根据物品id获取价格然后叠加
    $priceFrGood = 0;
    $total = 0;
    foreach ($cartArr as $itemNo => $quantity) {
        foreach ($arrGood as $element) {
            $itemNumberGood = $element->getElementsByTagName('id')->item(0)->nodeValue;
            if ($itemNo == $itemNumberGood) {
                $priceFrGood = $element->getElementsByTagName('price')->item(0)->nodeValue;
                $total += ($priceFrGood * $quantity);
            }
        }
    }

    //2. 算好钱就把商品存到购物车里
    $arrGoodInCart = $cartXml->getElementsByTagName('item');
    $flagEqual = false;

    //如果购物车之前已经有东西
    if ($arrGoodInCart->length > 0) {
        $quantityFoundInCart = 0;
        foreach ($arrGoodInCart as $good) {
            //找出之前的商品的id和数量
            $itemNumberFrCart = $good->getElementsByTagName('id')->item(0)->nodeValue;
            $quantityFrCart = $good->getElementsByTagName('quantity')->item(0)->nodeValue;

            //如果之前的商品和新加进来的是同款
            if ($itemNumberFrCart == $addedItemId) {
                //如果添加，直接给该商品数量+1
                if ($action == "add") {
                    $flagEqual = true;
                    $good->getElementsByTagName('quantity')->item(0)->nodeValue = $quantityFrCart + 1;
                    //如果不添加
                } else {
                    //原本只有一个在里面，减掉后直接删除
                    if ($quantityFrCart == 1) {
                        $cartXml->removeChild($good);
                    } else {
                    //如果原本有2个以上， 数量减一
                        $good->getElementsByTagName('quantity')->item(0)->nodeValue = $quantityFrCart - 1;
                    }
                }
                $flagEqual = true;
            }
        }
        //如果找不到同款商品，创建新的商品
        if ($flagEqual == false) {
            createGood($docForCart, $cartXml, $addedItemId, $priceFrGood, $cart[$addedItemId]);
            $flagEqual = false;
        }
        //如果是全新的购物车，创建新的商品
    } else {
        createGood($docForCart, $cartXml, $addedItemId, $priceFrGood, $cart[$addedItemId]);
        $flagEqual = false;
    }
    //至此购物车商品创建成功，接下来计算和写入总数
    if ($cartXml->getElementsByTagName("total")->length > 0) {
        $cartXml->getElementsByTagName("total")->item(0)->nodeValue = $total;
    } else {
        $totalXml = $cartXml->appendChild($docForCart->createElement('total'));
        $totalXml->appendChild($docForCart->createTextNode($total));
    }
    //存到购物车文件
    $docForCart->save("../admin/cart.xml");
}

//在购物车创建新的商品
function createGood($docForCart, $cart, $itemNumber, $priceFrGood, $quantity) {
    $goodXml = $cart->appendChild($docForCart->createElement('item'));

    $itemNumberXml = $goodXml->appendChild($docForCart->createElement('id'));
    $itemNumberXml->appendChild($docForCart->createTextNode($itemNumber));

    $priceXml = $goodXml->appendChild($docForCart->createElement('price'));
    $priceXml->appendChild($docForCart->createTextNode($priceFrGood));

    $xmlQuantity = $goodXml->appendChild($docForCart->createElement('quantity'));
    $xmlQuantity->appendChild($docForCart->createTextNode($quantity));
}
//转化xsl
function transformXsl($xsl) {
//    echo "<br>16";
    $xmlDoc = new DomDocument("1.0");
    $xmlDoc->formatOutput = true;
    $xmlDoc->preserveWhiteSpace = false;

    $xmlDoc->load("../admin/cart.xml");

    $xslDoc = new DomDocument("1.0");
    $xslDoc->load($xsl);

    $proc = new XSLTProcessor;
    $proc->importStyleSheet($xslDoc);
//    echo "<br>17";
    echo $proc->transformToXML($xmlDoc);
}
//创建xml
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