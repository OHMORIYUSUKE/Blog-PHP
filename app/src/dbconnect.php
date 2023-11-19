<?php
try{
    $db = new PDO('mysql:host=mysql;dbname=blog;charset=utf8mb4','test','test' );
}catch(PDOException $e){
    print('データベース接続エラー:'.$e->getMessage());
}
?>
