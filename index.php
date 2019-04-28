<?php
require_once('Classes/Crawler.php');


$form ='
    <form method="POST">
        <input type="text" id="urlName" name="urlName" placeholder="What URL to Crawl Today?">
        <input type="number" id="crawlDepth">
        <button type="Submit">Init Crawl</button>
    </form>';

if($_REQUEST){
    $name = $_REQUEST['urlName'];
    $depth = $_REQUEST['crawlDepth'];

    $crawl =[
        'URL' => $name,
        'TAG' => ['TAG' => 'img']
    ];

    $crawlPage = new Crawler($crawl);
    
    echo $form;
    echo '<pre>';
    print_r($crawlPage->results());
    echo '</pre>';
}else{
    echo $form;
}