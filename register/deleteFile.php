<?php
/*
	Author: Wei Lai
	Date: 9/10/2018
*/

header('Content-Type: text/xml');

$xmlfile = './testData.xml';

if (!unlink($xmlfile)){ // if the xml file does not exist
	echo "Error in deleting $xmlfile.";
} else {
	echo "Deleted $xmlfile";
}
?>