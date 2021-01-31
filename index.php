<?php
error_reporting(E_ALL & ~ E_DEPRECATED & ~ E_USER_DEPRECATED & ~ E_NOTICE);
?>

<?php
require('dbconnect.php');
require('hour.php');
//URLパラメータで渡ってきたpage
$page = $_REQUEST['page'];
//URLパラメータで渡ってきたpageがnullだったら
if($page == ''){
  $page = 1;
}
//$pageが1より小さかったら$page=1
$page = max($page,1);

//dbからコメントの総数を取る
$counts = $db->query('SELECT COUNT(*) AS cnt FROM article');
$cnt = $counts->fetch(); //SQLたたいたらfetch()する
$maxPage = ceil($cnt['cnt'] / 6); //切り上げ
$page = min($page,$maxPage); //$page>$maxPageだったら $page = $maxPage

//ページネーションの計算
$start = ($page - 1)*6;
//データベースから取得
$posts = $db->prepare('SELECT * FROM article ORDER BY created DESC LIMIT ?,6');
//LIMIT ?,5の?に入るのはint型ではないといけないので型指定できるbindParam(1, $start, PDO::PARAM_INT)を使う
$posts->bindParam(1, $start, PDO::PARAM_INT);
$posts->execute();

?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>ブログ</title>

<link rel="icon" type="image/png" href="images/profile.jpg">

<!--facebook & その他SNSの設定-->
<meta property="og:title" content="うーたんのブログ">
<meta property="og:type" content="article">
<meta property="og:description" content="😗< <?php print('見てね！'); ?>">
<meta property="og:url" content="http://utan.php.xdomain.jp/blog/searchTag.php">
<meta property="og:image" content="https://github.com/OHMORIYUSUKE/mini_bbs/blob/master/member_picture/20210117010058YcFl9Nuw_400x400.jpg?raw=true">
<!-- <meta property="og:site_name" content="ポートフォリオ"> -->

<!--twitterの設定-->
<meta name="twitter:card" content="summary">
<meta name="twitter:site" content="http://utan.php.xdomain.jp/blog/searchTag.php">
<meta name="twitter:image" content="https://github.com/OHMORIYUSUKE/mini_bbs/blob/master/member_picture/20210117010058YcFl9Nuw_400x400.jpg?raw=true" />
<meta name="twitter:title" content="うーたんのブログ">
<meta name="twitter:description" content="😗< <?php print('見てね！'); ?>">

<!-- jQuery-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>

<!--レスポンシブ-->
<meta name="viewport" content="width=device-width">

<link rel="stylesheet" type="text/css" href="main.css" media="all">
<!--[if lt IE 9]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
</head>
<body>
<header>
        <h1><a class="notext-decoration headerTitle" href="index.php">Blog</a><img class="topGif" src="images/<?php print($imgTop); ?>" alt="画像"></h1>
        <p class="headerSubTitle">うーたんのブログ</p>
        </header>
<nav>
<h1>グローバルナビゲーション</h1>
<ul>
<li><a class="navTop" href="index.php">🏡 HOME</a></li>
<li><a class="navTop" href="searchWord.php">🔍 Search</a></li>
<li><a class="navTop" href="about.php">🧑 ABOUT</a></li>
<li><a class="navTop" href="feed.php">📰 Feed</a></li>
<li><a class="navTop" href="http://utan.php.xdomain.jp/">📝 Portfolio <img class="externalLink" src="images/external_link.png" alt="画像"></a></li>
</ul>
</nav>
<article class="article">
  <p class="counter">記事の総数：<?php print($cnt['cnt']);?>件</p>
<?php foreach($posts as $post): ?>
    <section>
        <a href="view.php?id=<?php print(htmlspecialchars($post['id'], ENT_QUOTES)); ?>" class="view_title"><h2><?php print(htmlspecialchars($post['title'], ENT_QUOTES)); ?></h2></a>
        <div class="inline-block">
          <img class="timeImage" src="images/time.png" alt="画像">
        </div>
        <?php 
          //createdを整形する
          $date = date('Y/m/d', strtotime($post['created']));
        ?>
        <div class="inline-block">
        <p class="time"><?php print(htmlspecialchars($date, ENT_QUOTES)); ?></p>
      </div>
      <div class="inline-block">
        <a href="searchTag.php?searchTag=<?php print($post['tag']);?>" class="tag"><?php print('#'.htmlspecialchars($post['tag'], ENT_QUOTES)); ?></a>
      </div>
    </section>
<?php endforeach; ?>
<nav aria-label="Page navigation example">
  <ul class="pagination">
  <?php if($page > 1): ?>
    <li class="page-item">
    &laquo;<a class="page-link" href="index.php?page=<?php print($page - 1); ?>" aria-label="Previous">
        <span aria-hidden="true">前のページへ</span>
      </a>
    </li>
    <?php else: ?>
      <span aria-hidden="true">　　　　　　　</span>
    <?php endif; ?>
    <?php if($page < $maxPage): ?>
    <li class="page-item">
      <a class="page-link" href="index.php?page=<?php print($page + 1); ?>" aria-label="Next">
        <span aria-hidden="true">次のページへ</span>
      </a>&raquo;
    </li>
    <?php else: ?>
      <span aria-hidden="true">　　　　　　　</span>
    <?php endif; ?>
  </ul>
</nav>
</article>
<aside class="aside">
    <section class="box">
      <div class="inline-block1">
      <h1 class="sideTitle prof">プロフィール</h1>
        <a href="about.php"><img  class="profile" src="images/profile.jpg" alt="画像"></a>
        <p class="prof"><a href="about.php">うーたん</a></p>
      </div>
      <div class="inline-block1">
        <!-- <img src="images/external_link.png" alt="画像" width="14%"> -->
        <p class="sns_text">SNS</p>
        <a href="https://twitter.com/uutan1108"><img class="sns" src="images/twitter.png" alt="画像"></a>
        <a href="https://github.com/OHMORIYUSUKE"><img class="sns" src="images/github.png" alt="画像"></a>
        <a href="mailto:b2190350@photon.chitose.ac.jp"><img class="sns" src="images/gmail.png" alt="画像"></a>
      </div>
    </section>

    <!-- 検索ボックス -->
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

<section class="box2">
<h1 class="sideTitle">カテゴリー</h1>
<?php
$tags = $db->query('SELECT DISTINCT tag FROM article');
$tags->execute();
foreach($tags as $tag):
?>

<a href="searchTag.php?searchTag=<?php print(htmlspecialchars($tag['tag'], ENT_QUOTES)); ?>" class="tag tagSide"><?php print('#'.htmlspecialchars($tag['tag'], ENT_QUOTES)); ?></a>

<?php endforeach; ?>

</section>
<section class="box2">
<h1 class="sideTitle">最新記事</h1>
<hr>
<?php 
$posts_new = $db->prepare('SELECT * FROM article ORDER BY created DESC LIMIT 0,4');
$posts_new->execute();
?>
<?php foreach($posts_new as $post): ?>
<a href="view.php?id=<?php print(htmlspecialchars($post['id'], ENT_QUOTES)); ?>" class="view_title"><?php print(htmlspecialchars($post['title'], ENT_QUOTES)); ?></a>
<br>
<hr>
<?php endforeach; ?>
</section>
</aside>
<button class="scroll-top" id="js-button"><i class="fa fa-chevron-up" aria-hidden="true"></i></button>
<footer>
    Copyright © 2021 Ohmori Yusuke Blog All Rights Reserved.
    </footer>

    <script src="app.js"></script>
</body>
</html>