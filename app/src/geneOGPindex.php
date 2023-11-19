<?php 
function OGPindex($counter,$cnt) {
	require('dbconnect.php');
	
	//idからタイトル取得
	$title = '記事:'.$cnt.'件 訪問者:'.$counter.'人';
	// 文字列を挿入する先の画像
	$file = "OGP.jpg";
	
	// 出力後のファイル名
	$newfile = 'OGPout/index.jpg';
	
	// コピー先画像作成
	$image = imagecreatefromjpeg($file);
	
	// 挿入する文字列
	$text = $title;

	//RSS_Feed配信を開始しました
	//このブログサイトについて
	//コメント機能を実装できませんでした。
	//レスポンシブにしました
	//今年の振り返りと来年への抱負-2020-

	//見た目の長さ 半角1全角2
	$textLength = mb_strwidth($text);

	$textWdth = $textLength*32;
	//中央に文字列が来るように調整

	$xp = 620 - ($textWdth / 2);

	// 挿入する文字列のフォント(今回はWindowsに入ってたメイリオを使う)
	$fontfile = "/var/www/html/07LogoTypeGothic7.ttf";
	//07LogoTypeGothic7.ttf
	//C:\Windows\Fonts\meiryo.ttc

	// 挿入する文字列の色(白)
	$color = imagecolorallocate($image, 0, 181, 253);//0, 181, 253
	
	// 挿入する文字列のサイズ(ピクセル)
	$size = 50;
	
	// 挿入する文字列の角度
	$angle = 0;
	
	// 挿入位置
	$x = $xp;         // 左からの座標(ピクセル)620が中央半角32px=64/2
	$y = 300 + $size; // 上からの座標(ピクセル)

	/*
	// 挿入位置
	$x = 380;         // 左からの座標(ピクセル)
	$y = 300 + $size; // 上からの座標(ピクセル)
	*/

	// 文字列挿入
	imagettftext(
		$image,     // 挿入先の画像
		$size,      // フォントサイズ
		$angle,     // 文字の角度
		$x,         // 挿入位置 x 座標
		$y,         // 挿入位置 y 座標
		$color,     // 文字の色
		$fontfile,  // フォントファイル
		$text
	);     // 挿入文字列
	
	// ファイル名を指定して画像出力
	imagejpeg($image, $newfile);

	return($newfile);
}
