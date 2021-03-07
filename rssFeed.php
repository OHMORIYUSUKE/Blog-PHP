<?php
    //参考 https://syncer.jp/how-to-make-feed-by-php

    //header("Access-Control-Allow-Origin: *"); //すべてのアクセスを許可

    require('dbconnect.php');
    //データベースから取得
    $posts = $db->query('SELECT * FROM article ORDER BY created DESC');
    $posts->execute();

    //error_reporting(E_ALL & ~ E_DEPRECATED & ~ E_USER_DEPRECATED & ~ E_NOTICE);

    require_once "Parsedown.php";
    function md2html($md){
        $Parsedown = new Parsedown();
        $html = $Parsedown->text($md);
        return $html;
    }

	// ライブラリの読み込み
	require_once "./Feed/Item.php" ;
	require_once "./Feed/Feed.php" ;
	require_once "./Feed/RSS2.php" ;

	// デフォルトのタイムゾーンをセット
	date_default_timezone_set( "Asia/Tokyo" ) ;

	use \FeedWriter\RSS2 ;	// エイリアスの作成
	$feed = new RSS2 ;


    // チャンネル情報の登録
    $feed->setTitle( "うーたんのブログ" ) ;			// チャンネル名
    $feed->setLink( "http://utan.php.xdomain.jp/blog/" ) ;		// URLアドレス
    $feed->setDescription( "うーたんのブログ 時々更新" ) ;	// チャンネル紹介テキスト
    $feed->setImage( "うーたんのブログ" , "http://utan.php.xdomain.jp/blog/" , "https://github.com/OHMORIYUSUKE/Blog-PHP/blob/master/images/profile.jpg?raw=true" ) ;	// ロゴなどの画像
    $feed->setDate( date( DATE_RSS , time() ) ) ;	// フィードの更新時刻
    $feed->setChannelElement( "language" , "ja-JP" ) ;	// 言語
    $feed->setChannelElement( "pubDate" , date( \DATE_RSS , strtotime("2021-3-7 00:00") ) ) ;	// フィードの変更時刻
    $feed->setChannelElement( "category" , "Blog" ) ;	// カテゴリー

        foreach($posts as $post):
        // インスタンスの作成
        $item = $feed->createNewItem() ;

        // アイテムの情報
        $item->setTitle( $post['title'] ) ;	// タイトル
        $item->setLink( "http://utan.php.xdomain.jp/blog/view.php?id=".$post['id'] ) ;	// リンク
        
        $html=md2html($post['text']);
        $item->setDescription($html) ;	// 紹介テキスト
        $item->setDate( strtotime($post['created']) ) ;	// 更新日時

        // アイテムの追加
        $feed->addItem( $item ) ;
        
        endforeach;

    // コードの生成
    $xml = $feed->generateFeed() ;

    // ファイルの保存場所を設定
    $file = "rss.xml" ;

    // ファイルの保存を実行
    @file_put_contents( $file , $xml ) ;


    // header('Location: rss.xml');
