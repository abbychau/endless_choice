<?php 
	require_once('../include/sqldata.php');
	require_once('chksess.php');
	
	$editFormAction = $_SERVER['PHP_SELF'];
	if (isset($_SERVER['QUERY_STRING'])) {
		$editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
	}
		
	$query_Recordset1 = sprintf("SELECT `css`, `bgmusic` FROM ec_system WHERE id = %s", GetSQLValueString($worldId, "int"));
	$row_Recordset1 = dbRow($query_Recordset1);
	
	
	if ((isset($_POST["updateText"])) && ($_POST["updateText"] == "form4")) {
		$updateSQL = sprintf("UPDATE ec_system SET css=%s WHERE id=%s",
		GetSQLValueString($_POST['entertext'], "text"),
		GetSQLValueString($worldId, "int"));
		
		dbQuery($updateSQL);
		
		$updateGoTo = "setcss.php?worldid=$worldid";
		if (isset($_SERVER['QUERY_STRING'])) {
			$updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
			$updateGoTo .= $_SERVER['QUERY_STRING'];
		}
		header(sprintf("Location: %s", $updateGoTo));
	}
	if ((isset($_POST["updateText"])) && ($_POST["updateText"] == "form1")) {
		$updateSQL = sprintf("UPDATE ec_system SET bgmusic=%s WHERE id=%s",
		GetSQLValueString($_POST['entertext'], "text"),
		GetSQLValueString($worldId, "int"));
		
		dbQuery($updateSQL);
		
		$updateGoTo = "setcss.php?worldid=$worldid";
		if (isset($_SERVER['QUERY_STRING'])) {
			$updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
			$updateGoTo .= $_SERVER['QUERY_STRING'];
		}
		header(sprintf("Location: %s", $updateGoTo));
	}
	$wrapin=basename($_SERVER["SCRIPT_FILENAME"], '.php');
	include_once("template/frame.php");
	
