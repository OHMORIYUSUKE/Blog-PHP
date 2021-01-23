<?php
error_reporting(E_ALL & ~ E_DEPRECATED & ~ E_USER_DEPRECATED & ~ E_NOTICE);
?>

<?php
require('dbconnect.php');

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
<link rel="stylesheet" type="text/css" href="main.css" media="all">
<!--[if lt IE 9]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
</head>
<body>
<header>
        <h1><a class="notext-decoration" href="index.php">Blogs</a></h1>
        <p>うーたんの日記</p>
        </header>
<nav>
<h1>グローバルナビゲーション</h1>
<ul>
<li><a href="index.php">HOME</a></li>
<li><a href="about.php">ABOUT</a></li>
<li><a href="http://utan.php.xdomain.jp/">Portfolio</a></li>
</ul>
</nav>
<article>
  <p>記事の総数：<?php print($cnt['cnt']);?></p>
<?php foreach($posts as $post): ?>
    <section>
        <a href="view.php?id=<?php print(htmlspecialchars($post['id'], ENT_QUOTES)); ?>" class="view_title"><h2><?php print(htmlspecialchars($post['title'], ENT_QUOTES)); ?></h2></a>
      <div class="inline-block">
        <p class="time"><?php print(htmlspecialchars($post['created'], ENT_QUOTES)); ?></p>
      </div>
      <div class="inline-block">
        <a href="view.php?searchTag=<?php print($post['tag']);?>" class="tag"><?php print('#'.htmlspecialchars($post['tag'], ENT_QUOTES)); ?></a>
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
<aside>
    <section>
    <h1>プロフィール</h1>
        <img  class="profile" src="images/profile.jpg" alt="画像">
        <a href="about.php">うーたん</a>
        <!-- <img src="images/external_link.png" alt="画像" width="14%"> -->
        <p class="sns_text">SNS</p>
        <a href="https://twitter.com/u____tan_"><img class="sns" src="images/twitter.png" alt="画像"></a>
        <a href="https://github.com/OHMORIYUSUKE"><img class="sns" src="images/github.png" alt="画像"></a>
        <a href="mailto:b2190350@photon.chitose.ac.jp"><img class="sns" src="images/gmail.png" alt="画像"></a>
    </section>

    <!-- 検索ボックス -->
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

    <form method="get" class="search_container">
    <input type="text" name="search" size="16" placeholder="　キーワード検索"><input type="submit" value="&#xf002">
    </form>
    <!-- 検索ボックスに入力された文字を取得 -->
    <?php $search = htmlspecialchars($_POST['search'],ENT_QUOTES); ?>

<section>
<h1>カテゴリー</h1>
<?php
$tags = $db->query('SELECT DISTINCT tag FROM article');
$tags->execute();
foreach($tags as $tag):
?>

    <a href="view.php?searchTag=<?php print($tag['tag']); ?>" class="tag tagSide"><?php print('#'.$tag['tag']); ?></a>

<?php endforeach; ?>

</section>
<section>
<h1>最新記事</h1>
<hr>
<?php 
$posts_new = $db->prepare('SELECT * FROM article ORDER BY created DESC LIMIT 0,3');
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
    Copyright ©HTML5 【 レイアウト 】 All Rights Reserved.<br>
    <a href="https://programmercollege.jp/column/1635/">レイアウト</a>
    </footer>

    <script src="app.js"></script>
</body>
</html>