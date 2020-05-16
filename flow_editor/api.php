<?php
	header('Access-Control-Allow-Origin: *');
	
	
	require_once('../include/sqldata.php'); 
	require_once('chksess.php');
	//////////////////////GRAPH
	
	
	function removeInvalidChar($str,$replacement=''){
		$str = trim(str_replace(["『","』","，","。","…","．","「","」","（","）","！","？","－","：","　"," ","、","／"],$replacement,$str));
		$str = strip_tags($str);
		return $str==''?'empty':$str;
	}
	

	$pages = dbAr("SELECT * FROM ec_pages WHERE wid = $worldid ORDER BY id");
	$arr2 = [];
	foreach($pages as $v){
		
		$v['title'] = removeInvalidChar($v['title'],'.');
		$title['x'.floatval($v['id'])] = floatval($v['id']).":".$v['title'];
		
		preg_match_all("/ec_setChoiceTarget\(\d+,\d+\)/", $v['js'], $output_array);
		foreach($output_array[0] as $vv){
			$parts = explode(",",$vv);
			$choice = str_replace("ec_setChoiceTarget(",'',$parts[0]);
			$arr2[] = ['from'=>floatval($v['id']),'to'=>trim($parts[1],")"),'text'=>$choice]; 
		}

		for($i =1;$i<=6;$i++){
			if($v["c{$i}to"] != ""){ 
				$arr2[] = ['from'=>floatval($v['id']),'to'=>$v["c{$i}to"],'text'=>$i];
			}

		}
	}

	//$arr2 = array_unique($arr2);
	usort($arr2, function ($a,$b) {
		return $a['from'] == $b['from'] ? $a['to'] <=> $b['to'] : $a['from'] <=> $b['from'];
	});

	if(!in_array($_GET['ori'],['TD','TB','BT','RL','LR'])){
		$_GET['ori'] = 'LR';
	}
		
	$tolerance = intval($_GET['tolerance'])>0?intval($_GET['tolerance']):10;
	
	$graphDef = "graph {$_GET['ori']}\n";
	foreach($arr2 as $v){
		if($v['from']>$v['to'] && abs($v['from'] - $v['to'])>12){
			continue;
		}
		if($v['to']>$v['from'] && abs($v['from'] - $v['to'])>100){
			continue;
		}
		
		if($title['x'.$v['to']] == ""){
			$title['x'.$v['to']] = "empty";
		}
		if($_COOKIE['show_choice_on_arrow']=='1'){
			$_text="|{$v['text']}|";
		}
		$tmp = "{$v['from']}[\"{$title['x'.$v['from']]}\"]-->{$_text}{$v['to']}[\"{$title['x'.$v['to']]}\"]";
		if($prev != $tmp){
			$graphDef .= "\t".$tmp."\n";
			$prev = $tmp;
		}
	}
	
	
	echo $graphDef;
	
	/////////// GRAPH