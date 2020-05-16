<?php
	require_once('../include/sqldata.php'); 
	require_once('chksess.php');
	
	if(get_client_ip() != "1.64.4.119"){die('oh u read my facebook');}	
	//$worldid=154;
$pages = dbAr("SELECT * FROM ec_pages WHERE wid = $worldid ORDER BY id");
foreach($pages as $v){
	
	$v['title'] = trim(str_replace(["，","。","…","．","「","」","（","）","！","？","－","：","　"," ","、","／"],'.',$v['title']));
	$title[floatval($v['id'])] = floatval($v['id']).":".$v['title'];
	
	preg_match_all("/ec_setChoiceTarget\(\d+,\d+\)/", $v['js'], $output_array);
	foreach($output_array[0] as $vv){
		$parts = explode(",",$vv);
		
		$arr2[] = ['from'=>floatval($v['id']),'to'=>trim($parts[1],")")]; 
	}

	
}

foreach($pages as $page){ 

	for($i =1;$i<=6;$i++){
		if($page["c{$i}to"] != ""){ 
			$arr2[] = ['from'=>floatval($page['id']),'to'=>$page["c{$i}to"]]; 
		}

	}

}
//$arr2 = array_unique($arr2);
usort($arr2, function ($a,$b) {
    return $a['from'] == $b['from'] ? $a['to'] <=> $b['to'] : $a['from'] <=> $b['from'];
});


	$wrapin=basename($_SERVER["SCRIPT_FILENAME"], '.php');
	include_once("template/frame.php");
