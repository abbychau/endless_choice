<?php 
require_once('../include/sqldata.php');

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if (isset($_POST["search_var"])) {
	$text = safe($_POST['search_var']);
	$array = dbAr("SELECT * FROM ec_pages WHERE (`content` LIKE '%{$text}%' OR `js` LIKE '%{$text}%') AND wid = '{$worldid} LIMIT 50'");
}


?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Search</title>
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

<form action="<?php echo $editFormAction; ?>" method="post">
	<fieldset>
	<legend>搜尋字句</legend>
	<table width="297">

	<tr>
		<td>
			<input name="search_var" type="text" value="<?php echo $row_varRecordset['varname']; ?>" size="30" />
			<input name="world_id" type="hidden" value="<?php echo $worldid; ?>" />
			<input type="submit" name="Submit" id="Submit" value="Submit" style="margin-left:10px" />
		</td>
	</tr>
	</table>
	</fieldset>
</form>
<div style='clear:both'></div>
<?php if(!empty($array)){?>
<table>
<?php foreach($array as $v){ ?>
<tr>
<td><?=$v['id'];?></td><td><?=$v['title'];?></td><td><a href='editfile.php?worldid=<?=$worldid;?>&id=<?=$v['id'];?>'>Go</a></td>
</tr>
<?php } ?>
</table>
最大只顯示50筆
<?php } ?>
</body>
</html>