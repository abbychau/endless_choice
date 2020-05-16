<?php
	require_once('../include/sqldata.php'); 
	require_once('chksess.php');
	
	$editFormAction = $_SERVER['PHP_SELF'];
	if (isset($_SERVER['QUERY_STRING'])) {
		$editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
	}
	

	
	
	if (isset($_POST["confirm"]) && !$_COOKIE['EC_READONLY']){
		
		$updateSQL = sprintf("UPDATE ec_system SET name=%s, conclusion=%s, entertext=%s, tid=%s, facebook_page=%s, ap_max=%s, ap_recovery_per_hour=%s, admob_id=%s WHERE id=%s",
			GetSQLValueString($_POST['name'], "text"),
			GetSQLValueString($_POST['conclusion'], "text"),
			GetSQLValueString($_POST['entertext'], "text"),
			GetSQLValueString($_POST['tid'], "int"),
			GetSQLValueString($_POST['facebook_page'], "text"),
			GetSQLValueString($_POST['ap_max'], "int"),
			GetSQLValueString($_POST['ap_recovery_per_hour'], "int"),
            GetSQLValueString($_POST['admob_id'], "text"),
			$worldId);
		
		dbQuery($updateSQL);
		
		header("location:/story_admin/");
		exit;
	}
	
	$world_info = dbRow("SELECT * FROM ec_system WHERE id = $worldId");
    $wordCount = dbRs("select sum(CHAR_LENGTH(content)+CHAR_LENGTH(title)+CHAR_LENGTH(c1)) from ec_pages where wid = $worldid");
    dbQuery("REPLACE INTO ec_stat VALUES($worldid,NOW(),$wordCount)");

	
	
	
	$wrapin=basename($_SERVER["SCRIPT_FILENAME"], '.php');
	include_once("template/frame.php");
