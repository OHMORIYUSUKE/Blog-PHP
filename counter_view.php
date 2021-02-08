<?php
require('dbconnect.php');

//記事
$postss = $db->prepare('SELECT * FROM article WHERE id=?');
$postss->execute(array(
$_REQUEST['id']
));
$post = $postss->fetch();
$counter_view = $post['count_view'];

//10秒以放置してリロードすると1になる
//しばらくしてやってきたら$flagは1
//際リロードしたら$flagは0
if (isset($_COOKIE["visited"])){
    $flag = $_COOKIE["visited"];
    $flag = 0;
}else{
    $flag = 1;
}
//5分間は更新してもカウントしない
setcookie("visited", $flag, time() + 60 * 5);

//print($count);

if($flag == 1){
    $counter_view++;

    //閲覧数
    $posts = $db->prepare('UPDATE article SET count_view=? WHERE id=?');
    $posts->execute(array(
        $counter_view,
        $_REQUEST['id']
    ));
    $post = $posts->fetch();
}

?>