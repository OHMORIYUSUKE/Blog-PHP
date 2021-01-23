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

//ページトップjs-----------------------------------------------
scrollTop('js-button', 400);

function scrollTop(elem,duration) {
  let target = document.getElementById(elem);
  target.addEventListener('click', function() {
    let currentY = window.pageYOffset; 
    let step = duration/currentY > 1 ? 10 : 100;
    let timeStep = duration/currentY * step;
    let intervalID = setInterval(scrollUp, timeStep);

    function scrollUp(){
      currentY = window.pageYOffset;
      if(currentY === 0) {
          clearInterval(intervalID);
      } else {
          scrollBy( 0, -step );
      }
    }
  });
}
//-----------------------------------------------------------