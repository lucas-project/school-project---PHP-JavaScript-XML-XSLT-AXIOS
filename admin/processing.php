<!--manager logout page-->
<!--this is the server side of processing page, it perform following functions:-->
<!--1. clear all sold items-->
<!--2. remove items with available quantity 0-->
<!--3. quantity onhold set to 0-->
<!--@author Lucas Qin, student ID is 103527269.-->
<!--@date 10/10/2022-->
<?php

$pathToFile = "./goods.xml";
$xmlDoc = new DomDocument("1.0");
$xmlDoc->formatOutput = true;
$xmlDoc->preserveWhiteSpace = false;
$xmlDoc->load($pathToFile);

$xslDoc = new DomDocument("1.0");
$xslDoc->load("processing.xsl");

$proc = new XSLTProcessor;
$proc->importStyleSheet($xslDoc);
echo $proc->transformToXML($xmlDoc);
if (array_key_exists("action", $_GET) && $_GET["action"] == "process") {
    $root = $xmlDoc->documentElement;
    $arrGood = $root->getElementsByTagName('item');
    foreach ($arrGood as $good) {
        $quantitySoldXml = $good->getElementsByTagName('sold')->item(0)->nodeValue;
        $quantityXml = $good->getElementsByTagName('quantity')->item(0)->nodeValue;
        $quantityHoldXml = $good->getElementsByTagName('onhold')->item(0)->nodeValue;
        if($quantitySoldXml > 0) {
            $good->getElementsByTagName('sold')->item(0)->nodeValue = 0;
        }
        if($quantityXml == 0 && $quantityHoldXml == 0) {
            $good->parentNode->removeChild($good);
        }
    }
    $xmlDoc->save($pathToFile);
    echo "success";
}
?>