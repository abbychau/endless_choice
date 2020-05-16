<?php 
	require_once('../include/sqldata.php'); 
	require_once('chksess.php');
	
	$editFormAction = $_SERVER['PHP_SELF'];
	
	if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
		if(!is_numeric($_POST['frameid'])){
			die("Incorrect Frame ID");
		}
		
		$num = dbRs("SELECT count(1) FROM ec_pages WHERE id = ? AND wid= ?", [$_POST['frameid'],$worldid]);
		
		if($num > 0){
			die("Duplicated Frame ID ".$_POST['frameid']);
		}
		
		dbQuery("INSERT INTO ec_pages (wid, id, title, content, c1, c2, c3, c4, c5, c6, c1to, c2to, c3to, c4to, c5to, c6to, js, typing) 
		VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
		[$worldid,
		GetSQLValueString($_POST['frameid'], "text"),
		GetSQLValueString($_POST['title'], "text"),
		GetSQLValueString($_POST['content'], "text"),
		"''",
		"''",
		"''",
		"''",
		"''",
		"''",
		"''",
		"''",
		"''",
		"''",
		"''",
		"''",
		"''",
		"''"]);
		
		$Result1 = ($insertSQL);
		
		$insertGoTo = "message.php?type=1&worldid=$worldid&id=".$_POST['frameid'];
		
		header("Location: $insertGoTo");
	}
	
	
	
	$sysName = dbRs("SELECT name FROM ec_system WHERE id = ?",[$worldid]);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>New Page</title>

		<style type="text/css">
			body{margin:1em}
			body *{font-size:12pt;display:block;width:100%;margin:1px;padding:1px}
			input{border:1px solid #CCC; border-radius:2px}
		</style>
	</head>
	
	<body>
		<strong>NEW page to <?=$sysName; ?></strong>
		
		
		<form action="<?php echo $editFormAction; ?>" id="form1" name="form1" method="POST" onsubmit="">
			
			<input name="worldid" type="hidden" value="<?php echo $worldid; ?>" />
			
			<input placeholder="Frame ID (最大6位, 如:填入23)" name="frameid" type="text" id="frameid" size="45" />
			<input placeholder='標題' name="title" type="text" id="title" size="80" />
			
			<textarea placeholder='內容' name="content" rows="5" id="content" wrap="virtual"></textarea>
			
			<input type="submit" name="Submit" id="Submit" value="建立" />
			<input type="hidden" name="MM_insert" value="form1" />
		</form>
	</body>
</html>