<?php 
//OGPを簡単パースするOpenGraphを読み込み  
require_once('OpenGraph.php'); 

//URLを指定  
$graph = OpenGraph::fetch('http://cookpad.com/recipe/1606942');  
?>

<a href="<?php echo($graph->url);?>">
<p><?php echo($graph->title);?></p>  
<img src="<?php echo($graph->image);?>" />
</a>
  
<?php
//$graphの中身
/*
OpenGraph Object  
(  
    [_values:OpenGraph:private] => Array  
        (  
            [type] => cookpad:recipe  
            [title] => やわらか豚の角煮を簡単に by mi0921  
            [description] => 【話題入り・つくれぽ300件感謝です♡】圧力鍋無しでOK。とろとろ〜★もちろん箸で切れます！煮る時間は約２時間！  
            [image] => http://d3921.cpcdn.com/recipes/1606942/120x120c/8c530792c847977d1ecdf281ba5ec170.jpg?u=3586013&p=1322668071  
            [url] => http://cookpad.com/recipe/1606942  
        )  
  
    [_position:OpenGraph:private] => 0  
)  
*/
?>