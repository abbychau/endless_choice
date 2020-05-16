<?php 
require_once('../include/sqldata.php');

$vid = $_GET['vid'];
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

$SQL_query_variables = "SELECT * FROM ec_variables WHERE id = ".$vid;
$row_varRecordset = dbRow($SQL_query_variables);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
body { padding:5px;BACKGROUND-POSITION: right bottom;  BACKGROUND-IMAGE: url(../img/reversedflower.jpg);  BACKGROUND-REPEAT: no-repeat;}
a:link {
	color: #0066FF;
	text-decoration: none;
}
a:visited {
	text-decoration: none;
	color: #0066FF;
}
a:hover {
	text-decoration: underline;
	color: #0066FF;
}
a:active {
	text-decoration: none;
	color: #0066FF;
}
a{color:#0066FF; cursor:pointer}
input{border:#666666 1px solid}
textarea{border:#666666 1px solid}
fieldset{padding-left:10px; width:400px}
img{border:0}
</style>
</head>

<body>
<strong>Endless Choice World One</strong><br />
Edit Variables
<br />
<form action="<?php echo $editFormAction; ?>" id="form1" name="form1" method="POST">
  <input type="hidden" name="vidfield" id="vidfield" value="<?php echo $vid; ?>" />
  <fieldset>
  <legend>變數設定</legend>
  <table width="297">
    <tr>
      <td width="289">Variable Name</td>
    </tr>
    <tr align="right">
      <td><hr size="1" /></td>
    </tr>
    <tr>
      <td><input name="varfield" type="text" value="<?php echo $row_varRecordset['varname']; ?>" size="30" /></td>
    </tr>
  </table>
  </fieldset>
  <p>
    <label>
    <input type="submit" name="Submit" id="Submit" value="Submit" style="margin-left:10px" />
    </label>
  </p>
  <input type="hidden" name="MM_update" value="form1" />
</form>
</body>
</html>
