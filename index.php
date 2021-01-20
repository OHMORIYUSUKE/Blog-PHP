<?php
error_reporting(E_ALL & ~ E_DEPRECATED & ~ E_USER_DEPRECATED & ~ E_NOTICE);
?>

<?php
require('dbconnect.php');
//データベースから取得
$posts = $db->prepare('SELECT * FROM article ORDER BY created DESC');
$posts->execute();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>ブログ</title>
<link rel="stylesheet" type="text/css" href="main.css" media="all">
<!--[if lt IE 9]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
</head>
<body>
<header>
        <h1>Blogs</h1>
        <p>うーたんの日記</p>
        </header>
<nav>
<h1>グローバルナビゲーション</h1>
<ul>
<li><a href="#">HOME</a></li>
<li><a href="#">MENU1</a></li>
<li><a href="#">MENU2</a></li>
<li><a href="#">MENU3</a></li>
<li><a href="#">SITE MAP</a></li>
<li><a href="#">ABOUT</a></li>
</ul>
</nav>
<article>
<?php foreach($posts as $post): ?>
    <section>
    <div class="inline-block_test">
        <a href="view.php?id=<?php print(htmlspecialchars($post['id'], ENT_QUOTES)); ?>" class="view_title"><h2><?php print(htmlspecialchars($post['title'], ENT_QUOTES)); ?></h2></a>
        <p class="time"><?php print(htmlspecialchars($post['created'], ENT_QUOTES)); ?></p>
    </div>
    <a href="#" class="tag"><?php print('#'.htmlspecialchars($post['tag'], ENT_QUOTES)); ?></a>
    </section>
<?php endforeach; ?>
<nav aria-label="Page navigation example">
  <ul class="pagination">
    <li class="page-item">
      <a class="page-link" href="#" aria-label="Previous">
        <span aria-hidden="true">&laquo; 前のページへ</span>
      </a>
    </li>
    <li class="page-item">
      <a class="page-link" href="#" aria-label="Next">
        <span aria-hidden="true">次のページへ &raquo;</span>
      </a>
    </li>
  </ul>
</nav>
</article>
<aside>
    <section>
    <h1>プロフィール</h1>
        <img  class="profile" src="images/profile.jpg" alt="画像">
        <a href="http://utan.php.xdomain.jp/profile.html">うーたん</a>
        <!-- <img src="images/external_link.png" alt="画像" width="14%"> -->
        <p class="sns_text">SNS</p>
        <a href="https://twitter.com/u____tan_"><img class="sns" src="images/twitter.png" alt="画像"></a>
        <a href="https://github.com/OHMORIYUSUKE"><img class="sns" src="images/github.png" alt="画像"></a>
        <a href="mailto:b2190350@photon.chitose.ac.jp"><img class="sns" src="images/gmail.png" alt="画像"></a>
    </section>

    <!-- 検索ボックス -->
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

    <form method="get" action="#" class="search_container">
    <input type="text" size="16" placeholder="　キーワード検索"><input type="submit" value="&#xf002">
    </form>
    <!-- 検索ボックスに入力された文字を取得 -->
    <?php $search = htmlspecialchars($_GET['search'],ENT_QUOTES,"UTF-8"); ?>
    <?php print($search); ?>

<section>
<h1>カテゴリー</h1>
<ul>
<li><a href="#">カテゴリー1</a></li>
<li><a href="#">カテゴリー2</a></li>
<li><a href="#">カテゴリー3</a></li>
<li><a href="#">カテゴリー4</a></li>
<li><a href="#">カテゴリー5</a></li>
</ul>
</section>
<section>
<h1>最新記事</h1>
<ul>
<li><a href="#">最新記事1</a></li>
<li><a href="#">最新記事2</a></li>
<li><a href="#">最新記事3</a></li>
<li><a href="#">最新記事4</a></li>
<li><a href="#">最新記事5</a></li>
</ul>
</section>
</aside>
<footer>
Copyright ©HTML5 【 レイアウト 】 All Rights Reserved.
</footer>
</body>
</html>