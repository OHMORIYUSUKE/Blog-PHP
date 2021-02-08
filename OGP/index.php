<?php 
function OGP($title) {
	$str=$title;
	//正規表現でメモを分割する
	preg_match_all('/[一-龠]+|[ぁ-ん]+|[ァ-ヴー]+|[a-zA-Z0-9]+|[ａ-ｚＡ-Ｚ０-９]+/u', $str, $matches);
	$match_result = $matches[0];

	print($match_result[0]);

	$title = $title;
	// 文字列を挿入する先の画像
	$file = "OGP2.jpg";
	
	// 出力後のファイル名
	$newfile = 'OGPout/'.$title.'OGP.jpg';
	
	// コピー先画像作成
	$image = imagecreatefromjpeg($file);
	
	// 挿入する文字列
	$text = $title;

	//RSS_Feed配信を開始しました
	//このブログサイトについて
	//コメント機能を実装できませんでした。
	//レスポンシブにしました
	//今年の振り返りと来年への抱負-2020-

	// //見た目の長さ 半角1全角2
	// $textLength = mb_strwidth($text);

	// $textWdth = $textLength*32;
	// //中央に文字列が来るように調整

	// $xp = 620 - ($textWdth / 2);

	// 挿入する文字列のフォント(今回はWindowsに入ってたメイリオを使う)
	$fontfile = "C:\Windows\Fonts\meiryo.ttc";
	//07LogoTypeGothic7.ttf
	//C:\Windows\Fonts\meiryo.ttc

	// 挿入する文字列の色(白)
	$color = imagecolorallocate($image, 255, 255, 255);//0, 181, 253
	
	// 挿入する文字列のサイズ(ピクセル)
	$size = 50;
	
	// 挿入する文字列の角度
	$angle = 0;
	
	// 挿入位置
	$x = 30;         // 左からの座標(ピクセル)620が中央半角32px=64/2
	$y = 60 + $size; // 上からの座標(ピクセル)

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
?>

