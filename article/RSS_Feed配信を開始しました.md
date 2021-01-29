## feed43を使ってrssを配信を開始しました。
# [feed43](https://node2.feed43.com/)とは
rss配信を行っていないサイトの更新状況を把握しやすくするために使われます。  
# やったこと
rss配信を行うためにすべての投稿内容を表示する[ページ](http://utan.php.xdomain.jp/blog/feed.php)を用意する必要がありました。  
その際に苦戦したことは、jsではmdからHTMLに変換ができなかったことです。  

jsでmdをHTMLに変換していたコード。
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
なので、PHPで変換することにしました。
[こちらを参考にしました](https://chaika.hatenablog.com/entry/2018/12/22/090000)

PHPでmdをHTMLに変換したコード
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

これでは使えないので、[feed43](https://node2.feed43.com/)でrss配信しました。  

すると、こんな感じで外部のサイトで記事の内容を取得できるようになります。
<img src="https://github.com/OHMORIYUSUKE/Blog-PHP/blob/master/article/images/%E3%82%8F%E3%81%9F%E3%81%97%E3%81%AE%E5%A5%BD%E3%81%8D%E3%81%AA%E3%82%A2%E3%83%8B%E3%83%A1/SHIROBAKO.png?raw=true" width="100%">