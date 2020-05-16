<h2>系統提示</h2>
<?php if($_GET['type']==1){?>
<strong>｡:.ﾟヽ(*´∀`)ﾉﾟ.:｡　新的一章已經成功建立！ლ(╹◡╹ლ)</strong><br /><br />
ID: <?php echo $_GET['id'];?>
<p>請選擇:<br /><br />
    <a href="editfile.php?id=<?php echo $_GET['id'];?>&amp;worldid=<?php echo $worldid;?>" style='font-weight:bold'>按此進入編輯</a><br />
    <a href="addpage.php?worldid=<?php echo $worldid;?>">按此新增頁面</a>
</p>
<? } ?>



<?php if($_GET['type']==2){ ?>
<strong>｡:.ﾟヽ(*´∀`)ﾉﾟ.:｡　成功編輯好了！ლ(╹◡╹ლ)</strong><br /><br />
<p>
    請選擇:<br /><br />
    <a href="addpage.php?worldid=<?php echo $worldid;?>">按此新增頁面</a><br />
	<a href="editfile.php?worldid=<?=$worldid;?>&id=<?php echo $_GET['id']; ?>">返回繼續編輯</a>
    
	<form id="form2" name="form2" method="post" action="../pages/pages.php">
	<input type="hidden" name="id" id="id" value="<?php echo $_GET['id']; ?>" />
    <input type="hidden" name="worldid" id="worldid" value="<?php echo $worldid; ?>" />
    <a href="#" onclick="form2.submit()">[預覽]</a>
</form>
</p>
<? } ?>

<?php if($_GET['type']==3){ ?>
<strong>｡:.ﾟヽ(*´∀`)ﾉﾟ.:｡　成功刪除了！ლ(╹◡╹ლ)</strong><br />
<p>
    請選擇:<br />
    <a href="addpage.php?worldid=<?php echo $worldid;?>">按此新增頁面</a><br />
    
</p>
<? } ?>
