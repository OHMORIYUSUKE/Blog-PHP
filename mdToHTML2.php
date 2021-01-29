<?php
//Parsedown.phpを使ってmd2HTML
require_once "Parsedown.php";
$md=file_get_contents("sample.md");
$html=md2html($md);
print $html;
function md2html($md){
  $Parsedown = new Parsedown();
  $html = $Parsedown->text($md);
  return $html;
}
?>