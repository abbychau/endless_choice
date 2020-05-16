<style>
	.scopecan input,.scopecan textarea{width:100%; margin:0 0 3px 0;padding:3px}
</style>	
<div class="row">
	<div class="col-lg-12">
		<ol class="breadcrumb">
			<li>
				<i class="fa fa-dashboard"></i>  <a href="index.php"><?=$worldInfo["name"];?></a>
			</li>
			<li class="active">
				<i class="fa fa-bar-chart-o"></i> 罐頭管理
			</li>
		</ol>
	</div>
</div>
<script>
	$(function () {
		$.getScript('js/autoresizer.js');
	});
</script>
<div class='scopecan'>
<h1>現存</h1>
<? foreach($allCates as $v){?>
<form action="<?php echo $editFormAction; ?>" method="POST">

	<input name="id" type="hidden" value="<?=$v['id']; ?>" />
	
	<input placeholder="Cate ID (number)" name="cate_id" type="number" step="any" value="<?=$v['can_cate'];?>" required="required" />
	<br />
	<textarea placeholder='內容' name="content" rows="5" required="required" wrap="virtual"><?=$v['content'];?></textarea>
	<br />
	<input type="submit" name="Submit" class='btn btn-primary' value="更新" />
	<input type="hidden" name="action" value="update" />
</form>
<form action="<?php echo $editFormAction; ?>" method="POST">
    <input type="hidden" name="action" value="delete" />
    <input name="id" type="hidden" value="<?=$v['id']; ?>" />
    <input type="submit" name="Submit" class='btn btn-danger' value="刪除" />
</form>
<?}?>

<h1>新建</h1>
<form action="<?php echo $editFormAction; ?>" method="POST">

	<input name="id" type="hidden" value="<?=$v['id']; ?>" />
	<br />
	<input placeholder="Cate ID (number)" name="cate_id" type="number" step="any" value="<?=$suggestCateID ;?>" required="required" />
	<br />
	<textarea placeholder='內容' name="content" rows="5" required="required" wrap="virtual"></textarea>
	<br />
	<input type="submit" name="Submit" class='btn btn-primary' value="建立" />
	<input type="hidden" name="action" value="create" />
</form>
</div>