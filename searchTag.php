<?php
require('counter.php');
error_reporting(E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED & ~E_NOTICE);
if (empty($_REQUEST['searchTag']) || strpos($_REQUEST['searchTag'], ',') !== false) {
  header('Location: index.php');
  exit();
}
require('dbconnect.php');
require('hour.php');

//URLパラメータで渡ってきたpage
//$tagNameをHTMLにプリントしている
$tagName = $_REQUEST['searchTag'];

//$tagNameはHTMLにプリントするのに使っているため、代入しておく。
//$_REQUEST['searchTag']はSQLに入れるためエスケープしておく
$_REQUEST['searchTag'] = addcslashes($_REQUEST['searchTag'], '\_%');


$page = $_REQUEST['page'];
//URLパラメータで渡ってきたpageがnullだったら
if ($page == '') {
  $page = 1;
}
//$pageが1より小さかったら$page=1
$page = max($page, 1);

$searchTag = '%' . $_REQUEST['searchTag'] . '%';

$counts = $db->prepare('SELECT COUNT(*) AS cnt FROM article WHERE tag LIKE ?');
//$cnt = $counts->fetch();
$counts->execute(array(
  $searchTag,
));
$cnt = $counts->fetch();

$maxPage = ceil($cnt['cnt'] / 6); //切り上げ
$page = min($page, $maxPage); //$page>$maxPageだったら $page = $maxPage

//ページネーションの計算
$start = ($page - 1) * 6;
//データベースから取得
$searchTagArticles = $db->prepare('SELECT * FROM article WHERE tag LIKE ? ORDER BY created DESC LIMIT ?,6');
//LIKE ?に入るのはtagの名前である。
$searchTagArticles->bindParam(1, $searchTag, PDO::PARAM_STR, 12);
//LIMIT ?,5の?に入るのはint型ではないといけないので型指定できるbindParam(1, $start, PDO::PARAM_INT)を使う
$searchTagArticles->bindParam(2, $start, PDO::PARAM_INT);
$searchTagArticles->execute();

//createdを整形する
$date = date('Y/m/d', strtotime($post['created']));

//カウンター画像に
//4けたに
$counter = str_pad($counter, 4, '0', STR_PAD_LEFT);
//1桁ずつに分割
$counter_array = str_split($counter);

$counterImg = '<img class="counter" src="images/7seg/' . $counter_array[0] . '.png" alt="' . $counter_array[0] . '"><img class="counter" src="images/7seg/' . $counter_array[1] . '.png" alt="' . $counter_array[1] . '"><img class="counter" src="images/7seg/' . $counter_array[2] . '.png" alt="' . $counter_array[2] . '"><img class="counter" src="images/7seg/' . $counter_array[3] . '.png" alt="' . $counter_array[3] . '">';

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <title>ブログ</title>

  <link rel="icon" type="image/png" href="images/profile.jpg">

  <meta name="theme-color" content="#fff">

  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-4W0YW9MSGV"></script>
  <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
      dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', 'G-4W0YW9MSGV');
  </script>

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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>

  <!--レスポンシブ-->
  <meta name="viewport" content="width=device-width">

  <link rel="stylesheet" type="text/css" href="main.css" media="all">
  <!--[if lt IE 9]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
</head>

<body>
  <script>
    //白い画面を見せない
    var result = document.cookie.indexOf('dark');
    if (result != -1) {
      $("body").css({
        backgroundColor: "black",
      });
    }
  </script>
  <header>
    <h1><a class="notext-decoration headerTitle" href="index.php">Blog</a><img class="topGif" src="images/<?php print($imgTop); ?>" alt="画像"></h1>
    <p class="headerSubTitle">うーたんのブログ</p>
    <p>あなたは、<?php print($counterImg); ?>人目の訪問者です。</p>
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
    <p><span class="tag">#<?php print(htmlspecialchars($tagName, ENT_QUOTES)); ?></span><span class="counter"> の関連記事数：<?php print($cnt['cnt']); ?>件</span></p>
    <?php foreach ($searchTagArticles as $post) : ?>
      <section>
        <a href="view.php?id=<?php print(htmlspecialchars($post['id'], ENT_QUOTES)); ?>" class="view_title">
          <h2><?php print(htmlspecialchars($post['title'], ENT_QUOTES)); ?></h2>
        </a>
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
        <?php
        $tags = preg_split("/[\s,]+/", $post['tag']);
        //print_r($keywords);
        foreach ($tags as $tag) :
        ?>
          <div class="inline-block">
            <a href="searchTag.php?searchTag=<?php print($tag); ?>" class="tag"><?php print('#' . htmlspecialchars($tag, ENT_QUOTES)); ?></a>
          </div>
        <?php endforeach; ?>
      </section>
    <?php endforeach; ?>
    <nav aria-label="Page navigation example">
      <ul class="pagination">
        <?php if ($page > 1) : ?>
          <li class="page-item">
            &laquo;<a class="page-link" href="searchTag.php?searchTag=<?php print($tagName); ?>&page=<?php print($page - 1); ?>" aria-label="Previous">
              <span aria-hidden="true">前のページへ</span>
            </a>
          </li>
        <?php else : ?>
          <li class="page-item">
            <span aria-hidden="true">　　　　　　　</span>
          </li>
        <?php endif; ?>
        <li class="page-item">
          <?php print($page); ?>/<?php print($maxPage); ?>
        </li>
        <?php if ($page < $maxPage) : ?>
          <li class="page-item">
            <a class="page-link" href="searchTag.php?searchTag=<?php print($tagName); ?>&page=<?php print($page + 1); ?>" aria-label="Next">
              <span aria-hidden="true">次のページへ</span>
            </a>&raquo;
          </li>
        <?php else : ?>
          <li class="page-item">
            <span aria-hidden="true">　　　　　　　</span>
          </li>
        <?php endif; ?>
      </ul>
    </nav>
  </article>
  <aside class="aside">
    <section class="box">
      <div class="inline-block1">
        <h1 class="sideTitle prof">プロフィール</h1>
        <a href="about.php"><img class="profile" src="images/profile.jpg" alt="画像"></a>
        <p class="prof"><a href="about.php">うーたん</a></p>
      </div>
      <div class="inline-block1">
        <!-- <img src="images/external_link.png" alt="画像" width="14%"> -->
        <p class="sns_text"></p>
        <a href="https://twitter.com/uutan1108"><img class="sns" src="images/twitter.png" alt="画像"></a>
        <a href="https://github.com/OHMORIYUSUKE"><img class="sns" src="images/github.png" alt="画像"></a>
        <a href="mailto:b2190350@photon.chitose.ac.jp"><img class="sns" src="images/gmail.png" alt="画像"></a>
      </div>
    </section>

    <!-- 検索ボックス -->
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

    <section class="box2">
      <h1 class="sideTitle">カテゴリー</h1>
      <hr>
      <?php
      $tags = $db->query('SELECT DISTINCT tag FROM article');
      $tags->execute();
      $tagsArry = array(); //空の配列
      foreach ($tags as $tag) :
        // $tagSpritは配列
        $tagSprit = preg_split("/[\s,]+/", $tag['tag']); //データベースすべてのタグをスプリット
        foreach ($tagSprit as $item) :
          //スプリットしたタグを配列に入れていく
          array_push($tagsArry, $item);
        endforeach;
      endforeach;
      //タグが重複しているため削除
      $tagsArry = array_unique($tagsArry);
      //文字数順にソート
      array_multisort(array_map("strlen", $tagsArry), SORT_ASC, $tagsArry);
      foreach ($tagsArry as $tag) : ?>
        <a href="searchTag.php?searchTag=<?php print(htmlspecialchars($tag, ENT_QUOTES)); ?>" class="tag tagSide"><?php print('#' . htmlspecialchars($tag, ENT_QUOTES)); ?></a>
      <?php endforeach; ?>


    </section>
    <section class="box2">
      <h1 class="sideTitle">最新記事</h1>
      <hr>
      <?php
      $posts_new = $db->prepare('SELECT * FROM article ORDER BY created DESC LIMIT 0,3');
      $posts_new->execute();
      ?>
      <?php foreach ($posts_new as $post) : ?>
        <a href="view.php?id=<?php print(htmlspecialchars($post['id'], ENT_QUOTES)); ?>" class="view_title"><?php print(htmlspecialchars($post['title'], ENT_QUOTES)); ?></a>
        <br>
        <hr>
      <?php endforeach; ?>
    </section>
    <section class="box2">
      <h1 class="sideTitle">人気の記事</h1>
      <hr>
      <?php
      $posts_new = $db->prepare('SELECT * FROM article ORDER BY count_view DESC LIMIT 0,3');
      $posts_new->execute();
      ?>
      <?php foreach ($posts_new as $post) : ?>
        <a href="view.php?id=<?php print(htmlspecialchars($post['id'], ENT_QUOTES)); ?>" class="view_title"><?php print(htmlspecialchars($post['title'], ENT_QUOTES)); ?></a>
        <br>
        <hr>
      <?php endforeach; ?>
    </section>
    <section class="box2">
      <h1 class="sideTitle">アーカイブ</h1>
      <hr>
      <?php
      $posts_new = $db->prepare('SELECT * FROM article ORDER BY created');
      $posts_new->execute();

      $createds = array();
      ?>
      <?php foreach ($posts_new as $post) : ?>
        <?php
        $date = new DateTime($post['created']);
        $created = $date->format('Y-m'); // 2014-08-01 23:01:05 -> Y/m

        $createds[] = $created;
        ?>
      <?php endforeach; ?>
      <?php
      $createds = array_unique($createds);
      ?>

      <select class="pullarchive" name="select" onChange="location.href=value;">
        <option value="#">選択してください</option>
        <?php foreach ($createds as $value) : ?>
          <option value="searchArchive.php?searchArchive=<?php print($value); ?>"><?php print($value); ?></option>
        <?php endforeach; ?>
      </select>

    </section>
  </aside>
  <button class="dark" onclick="dark();">🌙</button>
  <button class="scroll-top" id="js-button"><i class="fa fa-chevron-up" aria-hidden="true"></i></button>
  <footer>
    Copyright © 2021 Ohmori Yusuke Blog All Rights Reserved.
    <br>
    当ブログでは、Googleアナリティクスを利用しています。
  </footer>

  <script src="app.js"></script>
</body>

</html>