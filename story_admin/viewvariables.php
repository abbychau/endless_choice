<?php 
	require_once('../include/sqldata.php'); 
	require_once('chksess.php');
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	$insertSQL = sprintf("INSERT INTO ec_variables (wid, varname) VALUES (%s, %s)",
					   $worldid,
					   trim(GetSQLValueString($_POST['title'], "text")));
	
	dbQuery($insertSQL);
	
}
	$varList = dbAr("SELECT * FROM ec_variables where wid = $worldid ORDER BY varname");

	$wrapin=basename($_SERVER["SCRIPT_FILENAME"], '.php');
	include_once("template/frame.php");
