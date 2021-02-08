<?php
require('index.php');
$title = '自己紹介します。"\n"おおお';
$newfile = OGP($title);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
// $str="吾輩は猫である。名前はまだない。どこで生れたか頓と見当がつかぬ。";
// //正規表現でメモを分割する
// preg_match_all('/[一-龠]+|[ぁ-ん]+|[ァ-ヴー]+|[a-zA-Z0-9]+|[ａ-ｚＡ-Ｚ０-９]+/u', $str, $matches);
// $match_result = $matches[0];

// print_r($match_result); // マッチ結果が全出力

// print($match_result[0]);
?>

    <img src="<?php print($newfile); ?>" alt="">
</body>
</html>