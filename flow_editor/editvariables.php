<?php 
require_once('../include/sqldata.php');


$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL =sprintf("UPDATE `ec_variables` SET `varname` = %s WHERE `id` = %s", GetSQLValueString($_POST['varfield'], "text"), GetSQLValueString($_POST['vidfield'], "int"));

  dbQuery($updateSQL);

  $updateGoTo = "viewvariables.php?worldid=$worldid";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$row_varRecordset = dbRow("SELECT * FROM ec_variables WHERE id = ".intval($_GET['vid']));
	$wrapin=basename($_SERVER["SCRIPT_FILENAME"], '.php');
	include_once("template/frame.php");