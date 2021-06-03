<?php

//	header("Content-type: text/xml");

	extract($_GET);
	if($time)
	{	
		//code for checking if text changed
		$last=$time;	
	}
	else
	{
		$last=null; 
	}
	
	$file=fopen("indigo.rss","r");
	//$file=fopen("jet_airways.rss","r");
	//$file=fopen("air_india.rss","r");
	while(true)
	{
		clearstatcache();
		$new=filemtime("indigo.rss");
		if($new>$last)
		{
			$ret=fread($file,filesize("indigo.rss"))."-----".$new;
			echo $ret;
			break;
			
		}
		else
		{
			sleep(5);
			continue;
		}
	}
?>