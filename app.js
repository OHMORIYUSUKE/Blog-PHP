//dom構築が終わる前にとりあえず実行して、ダークモード中は極力白画面を見せないようにする。---
var result = document.cookie.indexOf('dark');
if(result != -1){//ダークモードオン
  darkOn();
}
//---------------------------------------------------------------------------------------
//ローディング画面を出す------------------------------------------------------------------
var result = document.cookie.indexOf('dark');
if(result == -1){ //ダークモードオフ
  $(function(){
    $('img[src=""]').attr('src','images/loader_w.gif');
  });
  }else{ //ダークモードオン
    $('img[src=""]').attr('src','images/loader_b.gif');
  }
//読み込みが完了したら実行
$(window).on('load',function () {
  // ローディングが10秒以内で終わる場合、読み込み完了後ローディング非表示
  endLoading();
});

//10秒経過した段階で、上記の処理を上書き、強制終了
$(function(){
  setTimeout('endLoading()', 10000);
});

//ローディング非表示処理
function endLoading(){
  // 0.01秒かけてロゴを非表示にし、その後0.01秒かけて背景を非表示にする
  $('.js-loading img').fadeOut(1, function(){
    $('.js-loading').fadeOut(1);
  });
} 
//----------------------------------------------------------------------------------------
//dom構築が終わってから実行----------------------------------------------------------------
//dom構築が終わる前にjQueryを実行するとバグる
window.onload = function () {
  // ここに読み込み完了時に実行してほしい内容を書く。
  var result = document.cookie.indexOf('dark');
  if(result == -1){ //ダークモードオフ
    //window.alert("ダークモードoff");
    darkOff();
  }else{
    //window.alert("ダークモードon");
    darkOn();
  }
  };

//ダークモード
//onの時はクッキーあり(作る)
//offの時はクッキーなし(削除)
var i = 1;

var result = document.cookie.indexOf('dark');
if (result == -1) {
  i = 2;
}
//ボタンが押されるたびに実行される---------------------------------------------------------
function dark() {
 var flag = i%2;
 if(flag == 1){ //ダークモードオフ
  document.cookie = 'dark=on; max-age=0';
  //console.log(document.cookie);
  //window.alert("off");
  console.log("off");
  flag = 1;
 }else{ //ダークモードオン
  document.cookie = 'dark=on; max-age=3600'; //クッキーの保存時間(60分)
  //console.log(document.cookie);
  //window.alert("on");
  console.log("on");
  flag = 0;
 }
 //var result = document.cookie.indexOf('dark');
 //window.alert(result);//ダークモードoffの時に-1を返す
 if(flag == 1){ //ダークモードオフ
  //window.alert("off");
  darkOff();
 }else if(flag == 0){ //ダークモードオン
   //window.alert("on関数内");
   darkOn();
 }
 i+=1;
}
//---------------------------------------------------------------------------------------

function darkOn(){ //onの状態
  $("meta").css({
    content: "black",
  });
  $(".externalLink").css({
    filter: "invert(100%)",
  });
  $(".commentObject").css({
    backgroundColor: "#2E2E2E",
  });
   $(".commentTitleImage").css({
    filter: "invert(100%)",
  });
   $(".dark").css({
    backgroundColor: "#fff",
    opacity:"3",
  });
  $(".dark").text("🌞")
  $(".sns").css({
    filter: "invert(100%)",
  });
  $(".timeImage").css({
    filter: "invert(100%)",
  });
  $(".eye").css({
    filter: "invert(100%)",
  });
  $("td").css({
    color: "#fff",
  });
   $("p").css({
    color: "#fff",
  });
  $("h1").css({
    color: "#fff",
  });
  $("h2").css({
    color: "#fff",
  });
  $("h3").css({
    color: "#fff",
  });
  $("a").css({
    color: "#fff",
  });
  $("li").css({
    color: "#fff",
  });
  $("dt").css({
    color: "#fff",
  });
  $("footer").css({
    color: "#fff",
  });
  $("span").css({
    color: "#fff",
  });
  $("body").css({
    backgroundColor: "black",
  });
}

function darkOff(){ //offの状態
  $("meta").css({
    content: "",
  });
  $(".externalLink").css({
    filter: "invert(0%)",
  });
  $(".commentObject").css({
    backgroundColor: "",
  });
  $(".commentTitleImage").css({
    filter: "invert(0%)",
  });
  $(".dark").css({
    backgroundColor: "",
  });
  $(".dark").text("🌙")
  $(".sns").css({
    filter: "invert(0%)",
  });
  $(".timeImage").css({
    filter: "invert(0%)",
  });
  $(".eye").css({
    filter: "invert(0%)",
  });
  $("td").css({
    color: "",
  });
  $("p").css({
    color: "",
  });
  $("h1").css({
    color: "",
  });
  $("h2").css({
    color: "",
  });
  $("h3").css({
    color: "#fff",
  });
  $("a").css({
    color: "",
  });
  $("li").css({
    color: "",
  });
  $("dt").css({
    color: "",
  });
  $("span").css({
    color: "",
  });
  $("footer").css({
    color: "",
  });
  $("body").css({
    backgroundColor: "",
  });
}




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
//---------------------------------------------------------------