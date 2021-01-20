<?php
error_reporting(E_ALL & ~ E_DEPRECATED & ~ E_USER_DEPRECATED & ~ E_NOTICE);

require('dbconnect.php');
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
                <li><a href="index.php">HOME</a></li>
                <li><a href="#">     </a></li>
                <li><a href="#">     </a></li>
                <li><a href="#">     </a></li>
                <li><a href="#">     </a></li>
                <li><a href="about.php">ABOUT</a></li>
            </ul>
        </nav>
    <article>
        <section>
<?php 
$tag = '自己紹介';
$tag = '#'.$tag; 

$title = '自己紹介します。';

// $text = '
// # 目次
// 1. [C言語とは](#anchor1)
// 1. [C言語の特徴](#anchor2)
// 1. [サンプルコード](#anchor3)
// ';
?>
<div>

<?php //タイトル.投稿時刻.タグ
//サニタイジング
$title = str_replace("<script>", "＜script＞", $title,$n);
$title = str_replace("</script>", "＜/script＞", $title,$n);
$tag = str_replace("<script>", "＜script＞", $tag,$n);
$tag = str_replace("</script>", "＜/script＞", $tag,$n);

// ファイルを変数に格納
$filename = 'about.md';
// fopenでファイルを開く（'r'は読み込みモードで開く）
$fp = fopen($filename, 'r');
// fgetsでファイルを読み込み、変数に格納
$created = fgets($fp);
?>

<p class="time"><?php print($created); ?></p>
<h1 class="title"><?php print($title); ?></h1>
<a href="#" class="tag"><?php print($tag); ?></a>

<?php //内容
//print($text);

// ファイルを変数に格納
$filename = 'about.md';
 
// fopenでファイルを開く（'r'は読み込みモードで開く）
$fp = fopen($filename, 'r');
$i=0;
// whileで行末までループ処理
while (!feof($fp)) {
 
  // fgetsでファイルを読み込み、変数に格納
  $text = fgets($fp);
  if($i!==0){
    // ファイルを読み込んだ変数を出力
    print( $text);
  }
 $i+=1;
}
 
// fcloseでファイルを閉じる
fclose($fp);
?>

</div>
<br>
<p>&laquo; <a href="index.php">メインページへ</a></p>           
        </section>
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
    <footer>
    Copyright ©HTML5 【 レイアウト 】 All Rights Reserved.<br>
    <a href="https://programmercollege.jp/column/1635/">レイアウト</a>
    </footer>
    </body>
</html>