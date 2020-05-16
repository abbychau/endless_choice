<?php
	require_once('../include/sqldata.php'); 
	require_once('chksess.php');
	
	header('Content-type:application/force-download');
	header("content-type:text/plain;charset=utf8");
	if($_GET["type"]=="text"){
		header("Content-Disposition:attachment;filename=exportWorld{$worldId}.txt"); //檔名
		
		$arr = dbAr("SELECT * FROM  `ec_pages` where wid = {$worldId} order by id");
		
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
	}
	if($_GET["type"]=="tree"){
		header("Content-Disposition:attachment;filename=exportTree_World{$worldId}.txt"); //檔名
		$pages = dbAr("SELECT * FROM ec_pages WHERE wid = 121 ORDER BY id");
		foreach($pages as $v){
			$tmptitle[intval($v['id'])] = $v['title'];
		}
		foreach($pages as $page){ 
			
			for($i =1;$i<=6;$i++){
				if($page["c{$i}to"] != ""){
					$targetTitle = intval($page["c{$i}to"])?":".$tmptitle[$page["c{$i}to"]]:"";
					//echo intval($page['id']).":".$tmptitle[intval($page['id'])]."->".$page["c{$i}to"].$targetTitle."<br />"; 
					$arr2[] = intval($page['id'])."->".$page["c{$i}to"]; 
				}
				
			}
			
		}
		$arr2 = array_unique($arr2);

		echo implode("\r\n",$arr2);
	}	