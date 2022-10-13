<?php
header('Content-Type: text/xml');

$xmlfile = './register.xml';

if (!unlink($xmlfile)){ // if the xml file does not exist
	echo "Error in deleting $xmlfile.";
} else {
	echo "Deleted $xmlfile";
}
?>