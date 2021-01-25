<?php
//現在時刻によってヘッダーの画像を変える
//現在時刻取得
$hour = date("H");
//$hour = 22;
//21時から4時までは月
if($hour<=4 && $hour>=0){
  $imgTop = "tuki.png";
}else if($hour>=21 && $hour<=24){
  $imgTop = "tuki.png";
//5時から12時までは太陽
}else if($hour>=5 && $hour<=12){
  $imgTop = "taiyou.png";
}else{
//12時から20時まではペンギン
  $imgTop = "pengin.gif";
}
?>