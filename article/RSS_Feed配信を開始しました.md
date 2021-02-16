## feed43 を使って rss を配信を開始しました。

# [feed43](https://node2.feed43.com/)とは

rss 配信を行っていないサイトの更新状況を把握しやすくするために使われます。

# やったこと

rss 配信を行うためにすべての投稿内容を表示する[ページ](http://utan.php.xdomain.jp/blog/feed.php)を用意する必要がありました。  
その際に苦戦したことは、js では md から HTML に変換ができなかったことです。

js で md を HTML に変換していたコード。

```HTML
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
```

なので、PHP で変換することにしました。
[こちらを参考にしました](https://chaika.hatenablog.com/entry/2018/12/22/090000)

PHP で md を HTML に変換したコード

```PHP
<?php
require_once "Parsedown.php";
function md2html($md){
    $Parsedown = new Parsedown();
    $html = $Parsedown->text($md);
    return $html;
  }
?>
```

こんな感じで無事にすべての記事の内容を書きだすことに成功しました。[こちらのページ](http://utan.php.xdomain.jp/blog/feed.php)

これでは使えないので、[feed43](https://node2.feed43.com/)で rss 配信しました。

すると、こんな感じで外部のサイトで記事の内容を取得できるようになります。
<img src="https://github.com/OHMORIYUSUKE/Blog-PHP/blob/master/article/images/RSS_Feed%E9%85%8D%E4%BF%A1%E3%82%92%E9%96%8B%E5%A7%8B%E3%81%97%E3%81%BE%E3%81%97%E3%81%9F/1.png?raw=true" width="100%">
