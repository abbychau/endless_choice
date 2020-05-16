<?php 
	require_once('../include/sqldata.php');
	
	
	$editFormAction = $_SERVER['PHP_SELF'];
	if (isset($_SERVER['QUERY_STRING'])) {
		$editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
	}
	if (isset($_POST["confirm"]) && !$_COOKIE['EC_READONLY']){
		
		$updateSQL = sprintf("UPDATE ec_system SET name=%s, conclusion=%s, entertext=%s, tid=%s WHERE id=%s", GetSQLValueString($_POST['name'], "text"),GetSQLValueString($_POST['conclusion'], "text"), GetSQLValueString($_POST['entertext'], "text"),GetSQLValueString($_POST['tid'], "int"),$worldid);
		
		dbQuery($updateSQL);
		
		header("location:announce.php?worldid=$worldid");
		exit;
	}
	
	$row_Recordset1 = dbRow("SELECT * FROM ec_system WHERE id = $worldid");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Announce</title>
		<link rel="stylesheet" type="text/css" href="/editor/editor.css" />
		<style>fieldset{width:auto}</style>
	</head>
	
	<body>
		<h3>設定劇本和作者資訊</h3>
		<form method="post" action="<?=$editFormAction; ?>">
			<fieldset style="padding-left:10px"><legend>修改Endless Choice 首頁簡介</legend>
				<textarea name="conclusion" cols="80" rows="12" id="conclusion"><?=$row_Recordset1['conclusion']; ?></textarea> 
			</fieldset>
			<fieldset style="padding-left:10px"><legend>修改進入頁面</legend>
				<textarea name="entertext" cols="80" rows="20" id="entertext"><?=$row_Recordset1['entertext']; ?></textarea>
			</fieldset>
			<fieldset style="padding-left:10px">
				<legend>修改</legend>
				作者名:<input name="author" type="text" id="author" value="<?=$row_Recordset1['author']; ?>" size="40" disabled="disabled" /><br />
				劇本名:<input name="name" type="text" id="name" value="<?=$row_Recordset1['name']; ?>" size="40" />
			</fieldset>
			<fieldset style="padding-left:10px">
				<legend>修改討論貼編號</legend>
				tid: <input name="tid" type="text" size="40" value="<?=$row_Recordset1['tid']; ?>" />
			</fieldset>
			<input type="hidden" name="confirm" value="true" />
			<?if(!$_COOKIE['EC_READONLY']){?>
			<input style="margin:5px;padding:5px;" type="submit" value="確認" />
			<?}?>
		</form>
		
		<h3>唯讀密碼</h3>
		輸入此密碼可以進入後台, 但無法修改變數、劇本設定、Frame 內容。<br />
		本劇本的唯讀密碼為: <?=substr(md5($row_Recordset1['password']),0,8);?>
	</body>
</html>