<?php
require('index.php');
$title = '自己紹介します。';
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

    <img src="<?php print($newfile); ?>" alt="">
</body>
</html>