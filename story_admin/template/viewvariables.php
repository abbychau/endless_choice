<ol class="breadcrumb">
	<li>
		<i class="fa fa-dashboard"></i>  <a href="index.php"><?=$worldInfo["name"];?></a>
	</li>
	<li class="active">
		<i class="fa fa-bar-chart-o"></i> 檢視或新增變數
	</li>
</ol>
<h2>變數列表</h2>
<ol>
<?php foreach($varList as $v) { ?>
<li>
	<a href="editvariables.php?vid=<?php echo $v['id']; ?>&amp;worldid=<?php echo $worldid; ?>" target="mainFrame"><?php echo $v['varname']; ?></a>
	(<?=$v['description'];?>)
<?php if($v['id'] <> ""){ ?>
	<a href="delvar.php?vid=<?php echo $v['id']; ?>&amp;worldid=<?php echo $worldid; ?>"><img src="../img/delete.gif" style="border:0px" /></a>
<?php } ?>
</li>
<?php } ?>
</ol>
<hr />
<h2>新增變數</h2>
<form action="<?php echo $editFormAction; ?>" id="form1" name="form1" method="POST">
	<div class='input-group'>
		<input class='form-control' onfocus="$('#warn_temp').show()" onblur="$('#warn_temp').hide()" name="title" type="text" id="title" placeholder="變數名" />
		<div class="input-group-btn">
		<input class='btn btn-primary' type="submit" name="Submit" id="Submit" value="新增" />
		</div>
	</div>
	<div class="alert alert-warning" role="alert" style="display:none" id="warn_temp">
		1. 請勿設定<strong>同名</strong>的變數<br />
		2. 請勿使用內含<strong>空格</strong>或<strong>中文</strong>的變數名
	</div>
    <input type="hidden" name="MM_insert" value="form1" />
</form>
<hr />