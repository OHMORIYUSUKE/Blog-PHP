<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>ブログ</title>
        <link rel="stylesheet" type="text/css" href="index.css" media="all">
        

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
$tag = 'プログラミング';
$tag = '#'.$tag; 

$title = 'C言語は難しい';

$time = '2021-01-18 14:07:33';

$text = '
# 目次
1. [C言語とは](#anchor1)
1. [C言語の特徴](#anchor2)
1. [サンプルコード](#anchor3)

<a id="anchor1"></a>

## 1. C言語とは
> C言語（シーげんご、英: C programming language）は、1972年にAT&Tベル研究所のデニス・リッチーが主体となって開発した汎用プログラミング言語である。英語圏では「C language」または単に「C」と呼ばれることが多い。日本でも文書や文脈によっては同様に「C」と呼ぶことがある。制御構文などに高水準言語の特徴を持ちながら、ハードウェア寄りの記述も可能な低水準言語の特徴も併せ持つ。基幹系システムや、動作環境の資源制約が厳しい、あるいは実行速度性能が要求されるソフトウェアの開発に用いられることが多い。後発のC++やJava、C#など、「C系」と呼ばれる派生言語の始祖でもある。ANSI、ISO、またJISにより言語仕様が標準規格化されている。

> <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/3/35/The_C_Programming_Language_logo.svg/800px-The_C_Programming_Language_logo.svg.png" width="50%"><img src="https://github-laboratory.github.io/imgs/langs/c.svg" width="50%"> 
<a id="anchor2"></a>

## 2. C言語の特徴
> C言語の特徴は、現在主流となっているオブジェクト指向（モノの振る舞いをひとまとめにしていくプログラミング）という概念が登場する前の言語であり、手続き型（一連の計算処理をひとまとめにしていくプログラミング）の言語ということが挙げられます。
また、非常に古い言語であるため、仕様は単純ながら難解です。そのため、コンピュータにとってわかりやすい低水準言語（機械語（コンピュータが直接理解できるレベルの言語）に近い形のプログラミング言語）と同様にプログラマが記述する範囲が多く、ハードウェアの制御知識が要求される部分もあることから、習得しにくいという側面があります。
一方、コンパイル型のため動作が高速で、ファイルサイズもコンパクトになりやすく、プログラミングに制限のあるハードウェア周辺でも活躍できるといったメリットがあります。また、汎用性が高く動作できるハードウェアが多いため、OS周りのシステムや組み込み・ハードウェア領域、IoT分野などで活用されています。

<a id="anchor3"></a>

## 3. サンプルコード

```C
#include <stdio.h>

int A[8]={5,4,3,8,6,7,2,1};

//値を交換する関数
void swap(int *a, int *b) {
	int temp = *a;
	*a = *b;
	*b = temp;
}

/*クイックソート*/
void QuickSort(int A[], int left, int right)
{
	// 変数定義
	int Left, Right;
	int pivot;

	// 初期値は引数から
	Left = left; 
	Right = right;

	// 基準は真ん中に設定
	pivot = A[(left + right) / 2];

	// ソーティング
	while (1) {

		// 基準より小さい値を左から見つけていく
		while (A[Left] < pivot) {
			Left++;
			}

		// 基準より大きい値を右から見つけていく
		while (pivot < A[Right]) {
			Right--;
			} 

		// 見つかった値の順序が逆になったら終了 
		if (Left >= Right) {
			break;
			}

		// 値を交換
		swap(&A[Left], &A[Right]);

	}

	//左のデータ群を対象としてクイックソートを再帰
	if (left < Left - 1) {
		QuickSort(A, left, Left - 1);
		}

	//右のデータ群を対象としてクイックソートを再帰
	if (Right + 1 < right) {
		QuickSort(A, Right + 1, right);
		}

}

void main(){
    printf("--Befor-QuickSort--\n");
    for(int i=0;i<8;i++){
        printf("%d ",A[i]);
    }
    printf("\n");

    QuickSort(A, 0, 7);
    printf("--After-QuickSort--\n");
    for(int i=0;i<8;i++){
        printf("%d ",A[i]);
    }
}
```
';
?>
<div>

<?php //タイトル.投稿時刻.タグ
//サニタイジング
$title = str_replace("<script>", "＜script＞", $title,$n);
$title = str_replace("</script>", "＜/script＞", $title,$n);
$tag = str_replace("<script>", "＜script＞", $tag,$n);
$tag = str_replace("</script>", "＜/script＞", $tag,$n);
?>
<p class="time"><?php print($time); ?></p>
<h1 class="title"><?php print($title); ?></h1>
<a href="#" class="tag"><?php print($tag); ?></a>

<?php //内容
//サニタイジング
$text = str_replace("<script>", "＜script＞", $text,$n);
$text = str_replace("</script>", "＜/script＞", $text,$n);

print($text); 
?>
</div>            
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
    <input type="text" size="16" placeholder="　キーワード検索"><input type="submit" value="&#xf002">
    </form>

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