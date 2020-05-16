<h1>搜索 <small>搜尋字句和選擇</small></h1>
<form action="<?php echo $editFormAction; ?>" method="post">
	搜尋字句: <input name="search_text" type="text" value="<?=$_POST['search_text']; ?>" size="30" placeholder="搜尋字句"/>
	<input name="world_id" type="hidden" value="<?php echo $worldid; ?>" />
	<input type="submit" name="Submit" id="Submit" value="Submit" />
</form>
<form action="<?php echo $editFormAction; ?>" method="post">
	搜尋選擇: <input name="search_choice" type="text" value="<?=$_POST['search_choice']; ?>" size="30" placeholder="搜尋選擇"/>
	<input name="world_id" type="hidden" value="<?php echo $worldid; ?>" />
	<input type="submit" name="Submit" id="Submit" value="Submit" />
</form>
<?php if(!empty($array)){?>
	<table class='table table-default'>
		<?php foreach($array as $v){ ?>
			<tr>
				<td><?=$v['id'];?></td><td><?=$v['title'];?></td><td><a href='editfile.php?worldid=<?=$worldid;?>&id=<?=$v['id'];?>'>Go</a></td>
			</tr>
		<?php } ?>
	</table>
	最大只顯示50筆
<?php } ?>