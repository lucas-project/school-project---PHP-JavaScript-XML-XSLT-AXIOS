<!--buying page server side-->
<!--this file return goods.xml defined by buying.xsl to client side-->
<!--@author Lucas Qin, student ID is 103527269.-->
<!--@date 10/10/2022-->
<?php
    $xmlDoc = new DomDocument;
    $xmlDoc->load("./goods.xml");
    $xslDoc = new DomDocument;
    $xslDoc->load("buying.xsl");

    $proc = new XSLTProcessor;
    $proc->importStyleSheet($xslDoc);
    echo $proc->transformToXML($xmlDoc);
?>