<?php
    $xmlDoc = new DomDocument;

    $xmlDoc->load("../../admin/goods.xml");
    $xslDoc = new DomDocument;
    $xslDoc->load("buying.xsl");

    $proc = new XSLTProcessor;
    $proc->importStyleSheet($xslDoc);
    echo $proc->transformToXML($xmlDoc);
?>