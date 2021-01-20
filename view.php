<?php
error_reporting(E_ALL & ~ E_DEPRECATED & ~ E_USER_DEPRECATED & ~ E_NOTICE);
?>

<?php
require('dbconenect.php');
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
?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>ブログ</title>
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
    <!-- ---------------------------------mdをHTMLに変換---------------------------------- -->
    <script>
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

    </script>
    <!-- ------------------------------------------------------------------------- -->

        <header>
        <h1>Blogs</h1>
        <p>うーたんの日記</p>
        </header>
        <nav>
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
        <section>
<?php 
// $tag = 'プログラミング';
// $tag = '#'.$tag; 

// $title = 'C言語は難しい';

// $created = '2021-01-18 14:07:33';

// $text = '
// # 目次
// 1. [C言語とは](#anchor1)
// 1. [C言語の特徴](#anchor2)
// 1. [サンプルコード](#anchor3)
// ';
?>
<div>
<!-- 指定されたURLパラメータが間違っていた場合(postはNULLである) -->
<?php if($post): ?>
<?php //タイトル.投稿時刻.タグ
//サニタイジング
$title = str_replace("<script>", "＜script＞", $title,$n);
$title = str_replace("</script>", "＜/script＞", $title,$n);
$tag = str_replace("<script>", "＜script＞", $tag,$n);
$tag = str_replace("</script>", "＜/script＞", $tag,$n);
?>

<p class="time"><?php //print($created); 
print(htmlspecialchars($post['created'], ENT_QUOTES)); 
?></p>
<h1 class="title"><?php //print($title); 
print(htmlspecialchars($post['title'], ENT_QUOTES)); 
?></h1>
<a href="#" class="tag"><?php //print($tag); 
print(htmlspecialchars($post['tag'], ENT_QUOTES)); 
?></a>

<?php //内容
//サニタイジング
$text = str_replace("<script>", "＜script＞", $text,$n);
$text = str_replace("</script>", "＜/script＞", $text,$n);

//print($text); 
print(htmlspecialchars($post['text'], ENT_QUOTES)); 
?>
<?php else: ?>
```C
<p>その投稿は削除されたか、URLが間違えています。</p>

∧＿∧
( ´･ω･) みなさん、お茶が入りましたよ・・・。
( つ旦O
と＿)＿) 旦旦旦旦旦旦旦旦旦旦旦旦旦旦旦旦旦旦旦旦
```
<?php endif; ?>
</div>
<p>&laquo; <a href="index.php">メインページへ</a></p>           
        </section>
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
    <input type="text" name="search" value="<?php print(htmlspecialchars($_GET['osiname'],ENT_QUOTES)); ?>" size="16" placeholder="　キーワード検索"><input type="submit" value="&#xf002">
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
    Copyright ©HTML5 【 レイアウト 】 All Rights Reserved.<br>
    <a href="https://programmercollege.jp/column/1635/">レイアウト</a>
    </footer>
    </body>
</html>