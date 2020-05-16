<?php 
	require_once('../include/sqldata.php');
	require_once('chksess.php');
	
	$editFormAction = $_SERVER['PHP_SELF'];
	if (isset($_SERVER['QUERY_STRING'])) {
		$editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
	}
	
	if (isset($_POST["search_text"])) {
		$text = safe($_POST['search_text']);
		$array = dbAr("SELECT * FROM ec_pages WHERE (
		`title` LIKE '%{$text}%' OR 
		`content` LIKE '%{$text}%' OR 
		`js` LIKE '%{$text}%' OR
		`c1` LIKE '%{$text}%' OR
		`c2` LIKE '%{$text}%' OR
		`c3` LIKE '%{$text}%' OR
		`c4` LIKE '%{$text}%' OR
		`c5` LIKE '%{$text}%' OR
		`c6` LIKE '%{$text}%'
		) AND wid = {$worldid} LIMIT 50");
	}
	if (isset($_POST["search_choice"])) {
		$text = safe($_POST['search_var']);
		$array = dbAr("SELECT * FROM ec_pages WHERE 
		(
		`c1to` = '{$text}' OR
		`c2to` = '{$text}' OR
		`c3to` = '{$text}' OR
		`c4to` = '{$text}' OR
		`c5to` = '{$text}' OR
		`c6to` = '{$text}' )
		AND wid = {$worldid} 
		ORDER BY id LIMIT 50");
		
	}
	$wrapin=basename($_SERVER["SCRIPT_FILENAME"], '.php');
include_once("template/frame.php");