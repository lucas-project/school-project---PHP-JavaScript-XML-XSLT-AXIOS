<!--delete data from xml function-->
<!--this file is for deleting data from goods.xml-->
<!--@author Lucas Qin, student ID is 103527269.-->
<!--@date 10/10/2022-->
<?php

header('Content-Type: text/xml');

$xmlfile = './goods.xml';

if (!unlink($xmlfile)){ // if the xml file not exist
    echo "Error in deleting $xmlfile.";
} else {
    echo "Deleted $xmlfile";
}
?>