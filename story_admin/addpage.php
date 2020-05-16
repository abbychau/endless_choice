<?php 
	require_once('../include/sqldata.php'); 
	require_once('chksess.php');
	
	$editFormAction = $_SERVER['PHP_SELF'];
	
	if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
		if(!is_numeric($_POST['frameid'])){
			die("Incorrect Frame ID");
		}
		
		$chk = sprintf("SELECT count(1) FROM ec_pages WHERE id = %s AND wid= {$worldid}", GetSQLValueString($_POST['frameid'], "float"));
		
		if(dbRs($chk) > 0){
			mysql_free_result($cnt);
			die("Duplicated Frame ID ".$_POST['frameid']);
		}
		
		$insertSQL = sprintf("INSERT INTO ec_pages (wid, id, title, content, c1, c2, c3, c4, c5, c6, c1to, c2to, c3to, c4to, c5to, c6to, js, typing) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
		$worldid,
		GetSQLValueString($_POST['frameid'], "text"),
		GetSQLValueString($_POST['title'], "text"),
		GetSQLValueString($_POST['content'], "text"),
		"''",
		"''",
		"''",
		"''",
		"''",
		"''",
		"''",
		"''",
		"''",
		"''",
		"''",
		"''",
		"''",
		"0");
		
		$Result1 = dbQuery($insertSQL);
		
		$insertGoTo = "message.php?type=1&worldid=$worldid&id=".$_POST['frameid'];
		
		header(sprintf("Location: %s", $insertGoTo));
	}
	
	$row_Recordset1 = dbRow("SELECT name FROM ec_system WHERE id = {$worldid}");
	if(isset($_GET['id']) && intval($_GET['id']) > 0){
		$suggestFrameID =intval($_GET['id']);
	}else{	
		$suggestFrameID = intval(dbRs("SELECT max(id) FROM ec_pages WHERE wid = {$worldid}"))+1;
	}
	$wrapin=basename($_SERVER["SCRIPT_FILENAME"], '.php');
	include_once("template/frame.php");
