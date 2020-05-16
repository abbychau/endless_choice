<?php 
require_once('../include/sqldata.php'); 

$query_varList = "SELECT * FROM ec_variables where wid = $worldid ORDER BY varname";
$varList = dbAr($query_varList);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>The World Time Line</title>
<link rel="stylesheet" type="text/css" href="/editor/editor.css" />

</head>

<body>
<h3>Endless Choice</h3>
Variable List

<table width="100%" align="center">
<?php foreach($varList as $row_varList) { ?>
	<tr>
		<td valign="top" style="padding-top:5px">
		<a href="editvariables.php?vid=<?php echo $row_varList['id']; ?>&amp;worldid=<?php echo $worldid; ?>" target="mainFrame"><?php echo $row_varList['varname']; ?></a>
<?php if($row_varList['id'] <> ""){ ?>
		<a href="delvar.php?vid=<?php echo $row_varList['id']; ?>&amp;worldid=<?php echo $worldid; ?>"><img src="../img/delete.gif" style="border:0px" /></a>
<?php } ?>
		</td>
	</tr>
<?php } ?>
</table>

<p><a href="addvar.php?worldid=<?php echo $worldid;?>" target="_self">按此新增一個變數</a></p>
</body>
</html>