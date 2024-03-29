<?php
require('counter.php');
error_reporting(E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED & ~E_NOTICE);

require('dbconnect.php');
require('hour.php');
?>
<?php
$tag = '自己紹介';

$title = '自己紹介します。';

//aboutページのarticle_idは0

//コメントが入力されているかどうか
if (!empty($_POST)) {
    //エラー判定
    if ($_POST['name'] === '') {
        $errer['name'] = 'blank';
    }
    if ($_POST['comment'] === '') {
        $errer['comment'] = 'blank';
    }
}
//コメント
$comments = $db->prepare('SELECT * FROM comments WHERE article_id=0 ORDER BY created DESC');
//executeするとすべて取得
$comments->execute();

//カウンター画像に
//4けたに
$counter = str_pad($counter, 4, '0', STR_PAD_LEFT);
//1桁ずつに分割
$counter_array = str_split($counter);

$counterImg = '<img class="counter" src="images/7seg/' . $counter_array[0] . '.png" alt="' . $counter_array[0] . '"><img class="counter" src="images/7seg/' . $counter_array[1] . '.png" alt="' . $counter_array[1] . '"><img class="counter" src="images/7seg/' . $counter_array[2] . '.png" alt="' . $counter_array[2] . '"><img class="counter" src="images/7seg/' . $counter_array[3] . '.png" alt="' . $counter_array[3] . '">';


//コメント投稿
//if 投稿するボタンが押されたとき
if (!empty($_POST)) {
    //下のテキストエリアがname="message"のため($_POST['message']である
    if ($_POST['comment'] !== '' && $_POST['name'] !== '') {
        $message = $db->prepare('INSERT INTO comments SET name=?, comment=?, article_id=0, created=NOW()');
        $message->execute(array(
            $_POST['name'],
            $_POST['comment']
        ));
        $URL = 'about.php';
        //messageをdbに保存したら再読み込みして$_POST['message']を削除する
        //リロードされて同じメッセージが誤送信されることを防ぐ
        header('Location:' . $URL);
        exit();
    }
}
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
    <meta property="og:description" content="😗< <?php print($title); ?>">
    <meta property="og:url" content="http://utan.php.xdomain.jp/blog/about.php">
    <meta property="og:image" content="http://utan.php.xdomain.jp/blog/OGPout/about.jpg">
    <!-- <meta property="og:site_name" content="ポートフォリオ"> -->

    <!--twitterの設定-->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="http://utan.php.xdomain.jp/blog/about.php">
    <meta name="twitter:image" content="http://utan.php.xdomain.jp/blog/OGPout/about.jpg" />
    <meta name="twitter:title" content="うーたんのブログ">
    <meta name="twitter:description" content="😗< <?php print('自己紹介します。'); ?>">

    <link rel="stylesheet" type="text/css" href="main.css" media="all">

    <!-- jQuery-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>

    <!--レスポンシブ-->
    <meta name="viewport" content="width=device-width">

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
        //白い画面を見せない
        var result = document.cookie.indexOf('dark');
        if (result != -1) {
            $("body").css({
                backgroundColor: "black",
            });
        }
    </script>
    <script>
        //マークダウンjs---------------------------------------------
        $(function() {

            // ★marked.js の設定
            marked.setOptions({
                breaks: true,

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
        <h1><a class="notext-decoration headerTitle" href="index.php">Blog</a><img class="topGif" src="images/<?php print($imgTop); ?>" alt="画像"></h1>
        <p class="headerSubTitle">うーたんのブログ</p>
        <p>あなたは、<?php print($counterImg); ?>人目の訪問者です。</p>
    </header>
    <nav>
        <ul>
            <li><a class="navTop" href="index.php">🏡 HOME</a></li>
            <li><a class="navTop" href="searchWord.php">🔍 Search</a></li>
            <li><a class="navTop" href="about.php">🧑 ABOUT</a></li>
            <li><a class="navTop" href="feed.php">📰 Feed</a></li>
            <li><a class="navTop" href="http://utan.php.xdomain.jp/">📝 Portfolio <img class="externalLink" src="images/external_link.png" alt="画像"></a></li>
        </ul>
    </nav>
    <article class="article">
        <section>

            <div>
                <div class="loading js-loading">
                    <img src="" alt="">
                </div>

                <?php //タイトル.投稿時刻.タグ
                //サニタイジング
                $title = str_replace("<script>", "＜script＞", $title, $n);
                $title = str_replace("</script>", "＜/script＞", $title, $n);
                $tag = str_replace("<script>", "＜script＞", $tag, $n);
                $tag = str_replace("</script>", "＜/script＞", $tag, $n);

                // ファイルを変数に格納
                $filename = 'about.md';
                // fopenでファイルを開く（'r'は読み込みモードで開く）
                $fp = fopen($filename, 'r');
                // fgetsでファイルを読み込み、変数に格納
                $created = fgets($fp);
                ?>

                <p class="time"><img class="timeImage" src="images/time.png" alt="画像"> <?php print($created); ?></p>
                <h1 class="title"><?php print($title); ?></h1>
                <a href="about.php?searchTag=<?php print("自己紹介"); ?>" class="tag"><?php print('#' . $tag); ?></a>

                <?php //内容
                //print($text);

                // ファイルを変数に格納
                $filename = 'about.md';

                // fopenでファイルを開く（'r'は読み込みモードで開く）
                $fp = fopen($filename, 'r');
                $i = 0;
                // whileで行末までループ処理
                while (!feof($fp)) {

                    // fgetsでファイルを読み込み、変数に格納
                    $text = fgets($fp);
                    if ($i !== 0) {
                        // ファイルを読み込んだ変数を出力
                        print($text);
                    }
                    $i += 1;
                }

                // fcloseでファイルを閉じる
                fclose($fp);
                ?>

            </div>
            <br>
            <?php //SNS共有ボタン 
            ?>
            <ul class="shareSns">
                <li><a class="twitter" href="http://twitter.com/share?text=うーたんのブログ【<?php print($title); ?>】&hashtags=ブログ,<?php print($tag); ?>&url=http://utan.php.xdomain.jp/blog/about.php" rel="nofollow">Tweet</a></li>
                <li><a class="facebook" href="http://www.facebook.com/share.php?u=http://utan.php.xdomain.jp/blog/about.php">Facebook</a></li>
                <li><a class="getpocket" href="http://getpocket.com/edit?url=http://utan.php.xdomain.jp/blog/about.php" rel="nofollow">Pocket</a></li>
                <li><a class="line" href="https://social-plugins.line.me/lineit/share?url=http://utan.php.xdomain.jp/blog/about.php">LINE</a></li>
            </ul>

            <p class="toTop">&laquo; <a href="index.php">メインページへ</a></p>




            <?php //コメント表示 
            ?>
            <?php foreach ($comments as $comment) : ?>
                <?php
                $commentCreated = date('Y年m月d日 H:i',  strtotime($comment['created']));
                ?>
                <section class="commentObject">
                    <p>
                        <img class="commentImage" src="images/commenter.png" alt="画像">
                        <span class="commentName"><?php print(htmlspecialchars($comment['name'], ENT_QUOTES)); ?> より　</span>
                        <span class="commentCreated"><?php print(htmlspecialchars($commentCreated, ENT_QUOTES)); ?></span>
                    </p>
                    <p class="comment"><?php print(htmlspecialchars($comment['comment'], ENT_QUOTES)); ?></p>
                </section>
            <?php endforeach; ?>

        </section>
    </article>
    <aside class="aside">
        <section class="box">
            <die class="inline-block1">
                <h1 class="sideTitle prof">プロフィール</h1>
                <a href="about.php"><img class="profile" src="images/profile.jpg" alt="画像"></a>
                <p class="prof"><a href="about.php">うーたん</a></p>
            </die>
            <die class="inline-block1">
                <!-- <img src="images/external_link.png" alt="画像" width="14%"> -->
                <p class="sns_text"></p>
                <a href="https://twitter.com/uutan1108"><img class="sns" src="images/twitter.png" alt="画像"></a>
                <a href="https://github.com/OHMORIYUSUKE"><img class="sns" src="images/github.png" alt="画像"></a>
                <a href="mailto:b2190350@photon.chitose.ac.jp"><img class="sns" src="images/gmail.png" alt="画像"></a>
            </die>
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