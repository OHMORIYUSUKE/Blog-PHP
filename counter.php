<?php
session_start();

$counter_file = 'count.txt';
$counter_lenght = 8;
$fp = fopen($counter_file, 'r+');
    if ($fp) {
        if (flock($fp, LOCK_EX)) {
            $counter = fgets($fp, $counter_lenght);
            if(!isset($_SESSION['access'])){
                $_SESSION['access'] = 1;
                $counter++;
            }
            rewind($fp);
            if (fwrite($fp,  $counter) === FALSE) {
                echo ('<p>'.'ファイル書き込みに失敗しました'.'</p>');
            }
            flock ($fp, LOCK_UN);
        }
    }

fclose ($fp);
?>