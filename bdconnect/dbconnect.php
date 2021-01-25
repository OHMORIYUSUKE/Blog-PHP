<?php
try{
    $db = new PDO('mysql:host=mysql1.php.xdomain.ne.jp;dbname=utan_blog','utan_bloguser','bloguserpass' );
}catch(PDOException $e){
    print('データベース接続エラー:'.$e->getMessage());
}
?>