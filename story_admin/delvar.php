<?php 
require_once('../include/sqldata.php'); 
require_once('chksess.php');

$vid = $_POST['vid'] <> ""?$_POST['vid']:($_GET['vid'] <> ""?$_GET['vid']:die('Wrong parameter!'));

$query_varList = "SELECT * FROM ec_variables where (wid = $worldid) AND (id = $vid)";
$row_varList = dbRow($query_varList);


if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {

	  $updateSQL ="delete FROM `ec_variables` where id = $vid";
	
	  dbQuery($updateSQL);
	
	  $updateGoTo = "viewvariables.php?worldid=$worldid";
	  if (isset($_SERVER['QUERY_STRING'])) {
		$updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
		$updateGoTo .= $_SERVER['QUERY_STRING'];
	  }
	  header(sprintf("Location: %s", $updateGoTo));
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>delvar</title>
</head>

<body>
<label></label>
<form id="form1" name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
  你決定要刪除'<?php echo $row_varList['varname']; ?>'嗎?<br />
  <br />
<label>
<input type="submit" name="button" id="button" value="確認" />
</label>
<input type="hidden" name="MM_update" value="form1" />
<input type="hidden" name="worldid" value="<?php echo $worldid; ?>" />
<input type="hidden" name="vid" value="<?php echo $vid; ?>" />
<label>
<input type="button" onclick="history.go(-1)" value="返回" />
</label>
</form>
</body>
</html>