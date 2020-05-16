<?php 
require_once('../include/sqldata.php');

$vid = $_GET['vid'];
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL =sprintf(
    "UPDATE `ec_variables` SET `varname` = %s, `description` = %s WHERE `id` = %s", 
    GetSQLValueString($_POST['varfield'], "text"),
    GetSQLValueString($_POST['varfield_description'], "text"),
    GetSQLValueString($_POST['vidfield'], "int")
  );

  dbQuery($updateSQL);

  $updateGoTo = "viewvariables.php?worldid=$worldid";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$SQL_query_variables = "SELECT * FROM ec_variables WHERE id = ".$vid;
$row_varRecordset = dbRow($SQL_query_variables);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>

</head>

<body>
<h1>變數設定 / Edit Variables</h1>
<form action="<?php echo $editFormAction; ?>" id="form1" name="form1" method="POST">
  <input type="hidden" name="vidfield" id="vidfield" value="<?php echo $vid; ?>" />
  Variable Name: <input name="varfield" type="text" value="<?php echo $row_varRecordset['varname']; ?>" size="30" /><br />
  Variable Description: <input name="varfield_description" type="text" value="<?php echo $row_varRecordset['description']; ?>" size="30" />
  <hr />
  <input type="submit" name="Submit" id="Submit" value="Submit" style="margin-left:10px" />

  <input type="hidden" name="MM_update" value="form1" />
</form>
</body>
</html>