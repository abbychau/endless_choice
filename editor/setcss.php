<?php 
require_once('../include/sqldata.php');

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

$colname_Recordset1 = "-1";
if (isset($_GET['worldid'])) {
  $colname_Recordset1 = $_GET['worldid'];
}

$query_Recordset1 = sprintf("SELECT `css`, `bgmusic` FROM ec_system WHERE id = %s", GetSQLValueString($colname_Recordset1, "int"));
$row_Recordset1 = dbRow($query_Recordset1);

if ((isset($_POST["updateText"])) && ($_POST["updateText"] == "form4")) {
  $updateSQL = sprintf("UPDATE ec_system SET css=%s WHERE id=%s",
                       GetSQLValueString($_POST['entertext'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

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
                       GetSQLValueString($_POST['id'], "int"));

  dbQuery($updateSQL);

  $updateGoTo = "setcss.php?worldid=$worldid";
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
<title>Set CSS</title>
<link rel="stylesheet" type="text/css" href="/editor/editor.css" />
</head>

<body>
<p>歡迎在這編輯頁面模版!!</p>
<p>下面所輸入的是css header:</p>
<ul>
  <li>如不了解請不要更改</li>
  <li>這是css 的官方教學網站(英文): <a href="http://www.w3schools.com/css/" target="_blank">http://www.w3schools.com/css/</a></li>
</ul>
<fieldset style="padding-left:10px">
<legend>修改css header</legend>
<form id="form4" name="form4" method="post" action="">
  <label>

  <textarea name="entertext" cols="80" rows="20" id="entertext"><?php echo $row_Recordset1['css']; ?></textarea>
  </label>
  <br /><input name="updateText" type="hidden" id="updateText" value="form4" />
    <input type="hidden" name="id" value="<?php echo $colname_Recordset1; ?>" />
  <label>
  <input type="submit" name="button" id="button" value="Submit" />
  </label>

</form>
</fieldset>
<fieldset style="padding-left:10px">
<legend>修改背景音樂mp3 或youtube 路徑 </legend>
<form id="form1" name="form1" method="post" action="">
  <label>

  <input name="entertext" type="text" id="entertext" value="<?php echo $row_Recordset1['bgmusic']; ?>" size="80" />
  </label>
  <br />
  eg. http://www.youtube.com/v/eNdEu9s5qUU<br />
  eg. http://abby.zkiz.com/11.mp3
  <br />
  <input name="updateText" type="hidden" id="updateText" value="form1" />
    <input type="hidden" name="id" value="<?php echo $colname_Recordset1; ?>" />
  <label>
  <input type="submit" name="button" id="button" value="Submit" />
  </label>

</form>
</fieldset>
</body>
</html>