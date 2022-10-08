$url='./testData.xml';
$doc=new DomDocument();
$doc->load($url);
echo($doc->saveXML());