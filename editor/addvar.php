<?php 
require_once('../include/sqldata.php'); 
require_once('chksess.php');

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	$insertSQL = sprintf("INSERT INTO ec_variables (wid, varname) VALUES (%s, %s)",
					   $worldid,
					   trim(GetSQLValueString($_POST['title'], "text")));
	
	dbQuery($insertSQL);
	
	$insertGoTo = "viewvariables.php";
	if (isset($_SERVER['QUERY_STRING'])) {
		$insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
		$insertGoTo .= $_SERVER['QUERY_STRING'];
	}
	header(sprintf("Location: %s", $insertGoTo));
}

$story_name = dbRs("SELECT name FROM ec_system WHERE id = ?",[$_GET['worldid']]);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<p><strong>Endless Choice <?=$story_name; ?></strong><br />
Add a Variable</p>
<form action="<?php echo $editFormAction; ?>" id="form1" name="form1" method="POST">
    <label>變數名:<input name="title" type="text" id="title" /></label>
    <br />
    注意請勿在下列請況下設定變數:<br />
    1. 之前已設定有<strong>同名</strong>的變數<br />
    2. 變數內含<strong>空格</strong>或<strong>中文</strong><br />
    <br />
    <p><input type="submit" name="Submit" id="Submit" value="Submit" /></p>
    <input type="hidden" name="MM_insert" value="form1" />
</form>
</body>
</html>