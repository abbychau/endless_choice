<?php
	require_once('include/sqldata.php'); 
	header("content-type:text/plain");
	
	$arr = dbAr("SELECT * FROM  `ec_pages` where wid = 121 order by id");
	
	foreach($arr as $v){
		echo "Serial: ". $v['serial']."\n";
		echo "FrameID: ". $v['id']."\n";
		echo "Title: ". $v['title']."\n\n";
		echo "Content: \n=======\n". $v['content']."\n";
		echo "\n\nJS: \n=======\n". $v['js']."\n";
		echo "\n***************\n";
		for($i = 1; $i <= 6; $i++){
			if($v['c'.$i]){
				echo "C$i: ". $v['c'.$i]."\n";
			}
			if($v['c'.$i."to"]){
				echo "C{$i}TO: ". $v["c{$i}to"]."\n";
			}
		}
		
		echo "\n=====================================\n\n\n";
	}