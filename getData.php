<!--get data from xml function-->
<!--this file is for getting data from goods.xml-->
<!--@author Lucas Qin, student ID is 103527269.-->
<!--@date 10/10/2022-->
<?php
header('Content-Type: text/xml');

$xmlfile = './goods.xml';

if (!file_exists($xmlfile)){ // if the xml file not exist
    echo "The xml file does not exist.";
} else {
    $doc = new DomDocument();
    //$doc->preserveWhiteSpace = FALSE;
    $doc->load($xmlfile);

    echo ($doc->saveXML());
}
?>