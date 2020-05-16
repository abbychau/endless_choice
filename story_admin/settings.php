<?php 
require_once('../include/sqldata.php');
require_once('chksess.php');

$vid = $_GET['vid'];
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL =sprintf("INSERT INTO `ec_editor_settings` SET `setting_key` = 'page_chunk', `value` = %s , `world_id` = %s ON DUPLICATE KEY UPDATE `value`=%s;", 
  GetSQLValueString($_POST['page_chunk'], "text"), 
  GetSQLValueString($worldid, "int"),
  GetSQLValueString($_POST['page_chunk'], "text")
);

  dbQuery($updateSQL);

  $updateGoTo = "viewvariables.php?worldid=$worldid";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$settings = dbAr("SELECT * FROM ec_editor_settings WHERE world_id = $worldid");
foreach($settings as $v){
  $local_setting[$v['setting_key']] = $v['value'];
}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Editor Settings</title>
<style type="text/css">
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
<form action="<?php echo $editFormAction; ?>" id="form1" name="form1" method="POST">
  <input type="hidden" name="vidfield" id="vidfield" value="<?php echo $vid; ?>" />
  <fieldset>
  <legend>編輯器設定</legend>
  <table width="297">
    <tr>
      <td width="289">Page chunk</td>
    </tr>
    <tr align="right">
      <td><hr size="1" /></td>
    </tr>
    <tr>
      <td><input name="page_chunk" type="text" value="<?php echo $local_setting['page_chunk']; ?>" size="30" /></td>
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