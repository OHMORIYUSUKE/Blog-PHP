<?php
try{
    $db = new PDO('mysql:dbname=blog;host=127.0.0.1;charset=utf8','root','' );
}catch(PDOException $e){
    print('データベース接続エラー:'.$e->getMessage());
}
