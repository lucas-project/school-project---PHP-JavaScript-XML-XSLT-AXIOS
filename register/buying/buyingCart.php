<?php
$pathToFile = "./goods.xml";
$xmlDoc = new DomDocument("1.0");
$xslDoc = new DomDocument("1.0");
$xslDoc->load("buyingCart.xsl");

$xmlDoc->formatOutput = true;
$xmlDoc->preserveWhiteSpace = false;
$xmlDoc->load($pathToFile);

$proc = new XSLTProcessor;
$proc->importStyleSheet($xslDoc);
echo $proc->transformToXML($xmlDoc);
?>