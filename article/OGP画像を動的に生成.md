## OGP画像を動的に生成できるようにしました！！

↓こんな感じです。
<img src="https://github.com/OHMORIYUSUKE/Blog-PHP/blob/master/article/images/%E3%82%8F%E3%81%9F%E3%81%97%E3%81%AE%E5%A5%BD%E3%81%8D%E3%81%AA%E3%82%A2%E3%83%8B%E3%83%A1/SHIROBAKO.png?raw=true" width="100%">

画像に文字を書くには以下のコードで実装しました。  
引数で`$title`(記事のタイトル)を渡すと、生成した画像のファイルパスを返すようにしました。`return($newfile);`

```PHP
<?php 
function OGP($title) {
	$title = $title;
	// 文字列を挿入する先の画像
	$file = "OGP.jpg";
	
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

	//見た目の長さ 半角1全角2
	$textLength = mb_strwidth($text);

	$textWdth = $textLength*32;
	//中央に文字列が来るように調整

	$xp = 620 - ($textWdth / 2);

	// 挿入する文字列のフォント
	$fontfile = "arial.ttf";
	
	// 挿入する文字列の色(白)
	$color = imagecolorallocate($image, 0, 181, 253);//0, 181, 253
	
	// 挿入する文字列のサイズ(ピクセル)
	$size = 50;
	
	// 挿入する文字列の角度
	$angle = 0;
	
	// 挿入位置
	$x = $xp;         // 左からの座標(ピクセル)620が中央半角32px=64/2
	$y = 300 + $size; // 上からの座標(ピクセル)


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
```

この関数をview.phpで呼ぶことで、閲覧された時点で毎回画像を生成するようにしました。

```PHP
//OGPを生成
$newfile = OGP($post['title']);
```
↓生成された画像がレンタルサーバーに保存されています。  
文字化けしていますが。
<img src="https://github.com/OHMORIYUSUKE/Blog-PHP/blob/master/article/images/%E3%82%8F%E3%81%9F%E3%81%97%E3%81%AE%E5%A5%BD%E3%81%8D%E3%81%AA%E3%82%A2%E3%83%8B%E3%83%A1/SHIROBAKO.png?raw=true" width="100%">

無料レンタルサーバーの使える機能を最大限に使っていきたい。