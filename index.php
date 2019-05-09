<?php
require_once('Classes/Crawler.php');



$form = include('forms/Basic_Crawl_Interface');

if($_REQUEST){
    $name = $_REQUEST['urlName'];
    $depth = $_REQUEST['crawlDepth'];

    $crawl =[
        'URL' => $name,
        'TAG' => ['TAG' => 'a']
    ];

    $crawlPage = new Crawler($crawl);
    
    echo $form;
    echo '<pre>';
    print_r($crawlPage->results());
    echo '</pre>';
}else{
    echo $form;
}