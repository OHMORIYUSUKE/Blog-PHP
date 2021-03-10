<?php
header("Access-Control-Allow-Origin: *"); //すべてのアクセスを許可
$homepage = file_get_contents('rss.xml');

$homepageAsXML = new SimpleXMLElement($homepage);
echo $homepageAsXML->asXML();

?>