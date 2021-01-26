<?php
error_reporting(E_ALL & ~ E_DEPRECATED & ~ E_USER_DEPRECATED & ~ E_NOTICE);
?>

<?php
require('dbconnect.php');
require('hour.php');
//URLパラメータを指定せずにアクセスしようとした場合はheader('Location: index.php');
if(empty($_REQUEST['id'])){
  header('Location: index.php');
  exit();
}

$posts = $db->prepare('SELECT * FROM article WHERE id=?');
$posts->execute(array(
  $_REQUEST['id']
));
$post = $posts->fetch();

//createdを整形する
$date = date('Y/m/d', strtotime($post['created']));
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
        <meta property="og:description" content="😗< <?php print($post['title']); ?>">
        <meta property="og:url" content="http://utan.php.xdomain.jp/blog/view.php?id=<?php print($_REQUEST['id']); ?>">
        <meta property="og:image" content="https://github.com/OHMORIYUSUKE/mini_bbs/blob/master/member_picture/20210117010058YcFl9Nuw_400x400.jpg?raw=true">
        <!-- <meta property="og:site_name" content="ポートフォリオ"> -->

        <!--twitterの設定-->
        <meta name="twitter:card" content="summary">
        <meta name="twitter:site" content="http://utan.php.xdomain.jp/blog/view.php?id=<?php print($_REQUEST['id']); ?>">
        <meta name="twitter:image" content="https://github.com/OHMORIYUSUKE/mini_bbs/blob/master/member_picture/20210117010058YcFl9Nuw_400x400.jpg?raw=true" />
        <meta name="twitter:title" content="うーたんのブログ">
        <meta name="twitter:description" content="😗< <?php print('【#'.$post['tag'].'】'.$post['title']); ?>">

        <link rel="stylesheet" type="text/css" href="main.css" media="all">
        

        <script src="https://code.jquery.com/jquery-1.9.1.js"></script>

        <!-- ★マークダウン変換用 -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/marked/0.3.2/marked.min.js"></script>

        <!-- ◆シンタックスハイライト用 -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.9.0/highlight.min.js"></script>
        <!-- ◆VBをシンタックスハイライトする必要があるならこれ↓も入れる -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.9.0/languages/vbnet.min.js"></script>
        <!-- ◆シンタックスハイライト用 css （好きなテーマを選んで指定する） -->
        <!-- ◇https://highlightjs.org/static/demo/                          -->
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.9.0/styles/ir-black.min.css">
        
    </head>
    <body>
        <script>
            //マークダウンjs---------------------------------------------
            $(function() {

            // ★marked.js の設定
            marked.setOptions({
                breaks : true,

                // highlight.js でハイライトする
                highlight: function(code, lang) {
                    return hljs.highlightAuto(code, [lang]).value;
                }
            });

            // highlight.js の初期処理
            hljs.initHighlightingOnLoad(); 

            // ★マークダウンを HTML に変換して再セット
            var md = marked(getHtml("div"));
            $("div").html(md);

            });

            // 比較演算子が &lt; 等になるので置換
            function getHtml(selector) {
            var html = $(selector).html();
            html = html.replace(/&lt;/g, '<');
            html = html.replace(/&gt;/g, '>');
            html = html.replace(/&amp;/g, '&');

            return html;
            }
            //-------------------------------------------------------------
        </script>
        <header>
        <h1><a class="notext-decoration" href="index.php">Blog</a><img class="topGif" src="images/<?php print($imgTop); ?>" alt="画像"></h1>
        <p>うーたんのブログ</p>
        </header>
        <nav>
        <ul>
            <li><a class="navTop" href="index.php">🏡 HOME</a></li>
            <li><a class="navTop" href="about.php">🧑 ABOUT</a></li>
            <li><a class="navTop" href="http://utan.php.xdomain.jp/">📝 Portfolio <img class="externalLink" src="images/external_link.png" alt="画像"></a></li>
        </ul>
        </nav>
    <article>
        <section>

<div>
<!-- 指定されたURLパラメータが間違っていた場合(postはNULLである) -->
<?php if($post): ?>

<p class="time"><img class="timeImage" src="images/time.png" alt="画像"> <?php //print($created); 
print(htmlspecialchars($date, ENT_QUOTES)); 
?></p>
<h1 class="title"><?php //print($title); 
print(htmlspecialchars($post['title'], ENT_QUOTES)); 
?></h1>
<a href="searchTag.php?searchTag=<?php print($post['tag']);?>" class="tag"><?php //print($tag); 
print('#'.htmlspecialchars($post['tag'], ENT_QUOTES)); 
?></a>

<?php //内容
//print($text); 
print(htmlspecialchars($post['text'], ENT_QUOTES)); 
?>
<?php else: ?>
```C
<p>その投稿は削除されたか、URLが間違えています。</p>

 ∧＿∧
(´･ω･) みなさん、お茶が入りましたよ・・・。
( つ旦O
と＿)＿) 旦旦旦旦旦旦旦旦旦旦旦旦旦旦旦旦旦旦旦旦
```
<?php endif; ?>
</div>
<br>
<?php //SNS共有ボタン ?>
<ul class="shareSns">
    <li><a class="twitter" href="http://twitter.com/share?text=うーたんのブログ【<?php print($post['title']); ?>】&hashtags=ブログ,<?php print($post['tag']); ?>&url=http://utan.php.xdomain.jp/blog/view.php?id=<?php print($_REQUEST['id']); ?>" rel="nofollow">Tweet</a></li>
    <li><a class="facebook" href="http://www.facebook.com/share.php?u=http://utan.php.xdomain.jp/blog/view.php?id=<?php print($_REQUEST['id']); ?>" >Facebook</a></li>
    <li><a class="getpocket" href="http://getpocket.com/edit?url=http://utan.php.xdomain.jp/blog/view.php?id=<?php print($_REQUEST['id']); ?>" rel="nofollow">Pocket</a></li>
    <li><a class="line" href="https://social-plugins.line.me/lineit/share?url=http://utan.php.xdomain.jp/blog/view.php?id=<?php print($_REQUEST['id']); ?>">LINE</a></li>
</ul>
<br>
<p>&laquo; <a href="index.php">メインページへ</a></p>           
        </section>
            </article>
            <aside>
    <section>
    <h1>プロフィール</h1>
        <a href="about.php"><img  class="profile" src="images/profile.jpg" alt="画像"></a>
        <a href="about.php">うーたん</a>
        <!-- <img src="images/external_link.png" alt="画像" width="14%"> -->
        <p class="sns_text">SNS</p>
        <a href="https://twitter.com/u____tan_"><img class="sns" src="images/twitter.png" alt="画像"></a>
        <a href="https://github.com/OHMORIYUSUKE"><img class="sns" src="images/github.png" alt="画像"></a>
        <a href="mailto:b2190350@photon.chitose.ac.jp"><img class="sns" src="images/gmail.png" alt="画像"></a>
    </section>

    <!-- 検索ボックス -->
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

    <section>
    <h1>カテゴリー</h1>
    <?php
    $tags = $db->query('SELECT DISTINCT tag FROM article');
    $tags->execute();
    foreach($tags as $tag):
    ?>

    <a href="searchTag.php?searchTag=<?php print(htmlspecialchars($tag['tag'], ENT_QUOTES)); ?>" class="tag tagSide"><?php print('#'.htmlspecialchars($tag['tag'], ENT_QUOTES)); ?></a>

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
    Copyright © 2021 Ohmori Yusuke Blog All Rights Reserved.
    </footer>
    <script src="app.js"></script>
    </body>
</html>