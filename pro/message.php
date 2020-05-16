<?php 
require_once('../include/sqldata.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>完成</title>
<style type="text/css">
a{padding-left:10px; color:#09F; text-decoration:none}
a:hover{text-decoration:underline}
h2{font-size:18px; border-bottom:1px dashed #333}
body{font-size:12px; margin:20px}
</style>
</head>

<body>
<h2>系統提示</h2>
<?php if($_GET['type']==1){?>
<strong>新的一章已經成功建立!</strong><br /><br />
ID: <?php echo $_GET['id'];?>
<p>請選擇:<br /><br />
    <a href="contentlist.php?worldid=<?php echo $worldid;?>" target="leftFrame">按此更新列表</a><br />
    <a href="editfile.php?id=<?php echo $_GET['id'];?>&amp;worldid=<?php echo $worldid;?>">按此進入編輯</a><br />
    <a href="addpage.php?worldid=<?php echo $worldid;?>">按此新增頁面</a>
</p>
<? } ?>



<?php if($_GET['type']==2){ ?>
<strong>成功編輯好了!</strong><br /><br />
<p>
    請選擇:<br /><br />
    <a href="contentlist.php?worldid=<?php echo $worldid;?>" target="leftFrame">按此更新列表</a><br />
    <a href="addpage.php?worldid=<?php echo $worldid;?>">按此新增頁面</a><br />
	<a href="editfile.php?worldid=<?=$worldid;?>&id=<?php echo $_GET['id']; ?>">返回繼續編輯</a>
    
	<form id="form2" name="form2" method="post" action="../pages/pages.php">
	<input type="hidden" name="id" id="id" value="<?php echo $_GET['id']; ?>" />
    <input type="hidden" name="worldid" id="worldid" value="<?php echo $worldid; ?>" />
    <a href="#" onclick="form2.submit()">[預覽]</a>
</form>
</p>
<? } ?>


</body>
</html>
