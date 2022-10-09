<?php
/*
	Author: Wei Lai
	Date: 9/10/2018
*/

header('Content-Type: text/xml');

$xmlfile = './goods.xml';

if (!file_exists($xmlfile)){ // if the xml file does not exist
    echo "The xml file does not exist.";
} else {
    $doc = new DomDocument();
    //$doc->preserveWhiteSpace = FALSE;
    $doc->load($xmlfile);

    echo ($doc->saveXML());
}
?>