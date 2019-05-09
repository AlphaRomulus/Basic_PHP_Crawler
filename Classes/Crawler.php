<?php

class Crawler{
	private $_url;
	private $_results;
	private $_dom;
	private $_tag;
	private $_crawlTag;
	private $_className;
	private $_format;
	
	function __construct($crawl){
		if(!is_array($crawl)){
			error('Not enough Parameters; expecting array');
		}else{
		    if(!$crawl['URL']){
		        $this->_url = 'No URL Selected';
		    }else{
    		    $this->_url = $crawl['URL'];
		    }
		    
    		$this->_crawlTag = $crawl['TAG']['TAG'];
    		$this->_className = $crawl['TAG']['CLASS'];
    		if(isset($crawl['FORMAT'])){
    		    $this->_format = $crawl['FORMAT'];
    		}else{
    		    $this->_format = '';
    		}
    		
    		$this->_dom = new DOMDocument;
    		$this->error($this->_url);
		}
	}
	
	function initCrawl(){
		
		//Check For 404 If it Fails Set error to string
		if (!$html = @file_get_contents($this->_url)) {
			$this->error('Error 404, Please input a valid '. $this->_url);
		} else {
			$this->checkElementByTagName($html);
		}
	}
	
	function checkElementByTagName($html){
		(!$cat) ? (!dog ) ? cat:dog :cat
	    //I get HTML DATA
        $dom =  $this->_dom;
        $crawlResults = array();
       	@$dom->loadHTML( $html );
       	
		//Determins How to Process DATA
       	if(isset($this->_className)){
       		$finder = new DomXPath($dom);
       		$classname= $this->_className;
       		$results = $finder->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' $classname ')]");
       	}else{
       	
       		$results = $dom->getElementsByTagName($this->_crawlTag);
       	}
       	
       	foreach($results as $result){
    		$crawlResults[] = trim($result->nodeValue);
    	}
    	
    	if(isset($this->_format) && $this->_format !== '' ){
    	    $format = $this->_format;
    	    $this->$format($dom);
    	}else{
        	if(count($crawlResults) > 0){
        		$this->_results = $crawlResults;
        	}else{
        		$this->error('No Tags Found');
        	}
    	}
	}
	
	function table($dom){
	    foreach( $dom->getElementsByTagName( 'tr' ) as $tr ) {
            $cells = array();
        	foreach( $tr->getElementsByTagName( 'th' ) as $td ) {
        		$cells[] = $td->nodeValue;
                $tableHead[] = $td->nodeValue;
            }
            foreach( $tr->getElementsByTagName( 'td' ) as $td ) {
                $cells[] = $td->nodeValue;
            }
            $crawlResults[] = $cells;
        }
        
        $this->_results = $crawlResults;
    }
	

	function error($url){			
		//validate url 
		if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$url)) {
			$this->_results = 'An Error Occured: '.$url; 
		}else{
			$this->initCrawl();
		}
	}
	
	function results(){
			return $this->_results;
	}
}