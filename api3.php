<?php
// PHP json https://qiita.com/fantm21/items/603cbabf2e78cb08133e
error_reporting(E_ALL & ~ E_DEPRECATED & ~ E_USER_DEPRECATED & ~ E_NOTICE);
//ini_set('mbstring.internal_encoding' , 'UTF-8');
//header("Content-Type: text/html;charset=UTF-8");

if(empty($_REQUEST['when'])){
  $year = "2021/1";
}else{
  $year = $_REQUEST['when'];
}

//2013/4~
$yearArray = array("2013","2014","2015","2016","2017","2018","2019","2020","2021");
$coolArry = array("1","2","3","4");
//$year = "2020/1";

// $url = "https://api.moemoe.tokyo/anime/v1/master/".$year;
// $json = file_get_contents($url);
// $json = mb_convert_encoding($json, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
// $arr = json_decode($json,true);


$url = "https://api.moemoe.tokyo/anime/v1/master/".$year;
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 60);
$json = curl_exec($ch);
curl_close($ch);
$arr = json_decode($json, true);


if ($arr === NULL) {
        return;
}else{
        $json_count = count($arr);

        $title_short2　= array();
        $twitter_account = array();
        $public_url = array();
        $title_short1 = array();
        $sex = array();
        $twitter_hash_tag = array();
        $id = array();
        $sequel = array();
        $created_at = array();
        $city_name = array();
        $cours_id = array();
        $title = array();
        $city_code = array();
        $title_short3 = array();
        $updated_at = array();
        
        for($i=$json_count-1;$i>=0;$i--){
            $title_short2[] = $arr[$i]["title_short2"];
            $twitter_account[] = $arr[$i]["twitter_account"];
            $public_url[] = $arr[$i]["public_url"];
            $title_short1[] = $arr[$i]["title_short1"];
            $sex[] = $arr[$i]["sex"];
            $twitter_hash_tag[] = $arr[$i]["twitter_hash_tag"];
            $id[] = $arr[$i]["id"];
            $sequel[] = $arr[$i]["sequel"];
            $created_at[] = $arr[$i]["created_at"];
            $city_name[] = $arr[$i]["city_name"];
            $cours_id[] = $arr[$i]["cours_id"];
            $title[] = $arr[$i]["title"];
            $city_code[] = $arr[$i]["city_code"];
            $title_short3[] = $arr[$i]["title_short3"];
            $updated_at[] = $arr[$i]["updated_at"];
        }
}

//表示
for($i=0;$i<=$json_count-1;$i++):
?>
<?php print($title[$i]); ?>
<br>
<?php endfor;?>


