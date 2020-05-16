<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">
			新增變數
		</h1>
		<ol class="breadcrumb">
			<li>
				<i class="fa fa-dashboard"></i>  <a href="index.php"><?=$worldInfo["name"];?></a>
			</li>
			<li class="active">
				<i class="fa fa-bar-chart-o"></i> 新增變數
			</li>
		</ol>
	</div>
</div>
<form action="<?php echo $editFormAction; ?>" id="form1" name="form1" method="POST">
    <label>變數名:<input name="title" type="text" id="title" /></label>
    <br />
    注意請勿在下列請況下設定變數:<br />
    1. 之前已設定有<strong>同名</strong>的變數<br />
    2. 變數內含<strong>空格</strong>或<strong>中文</strong><br />
    <br />
    <p><input type="submit" name="Submit" id="Submit" value="Submit" /></p>
    <input type="hidden" name="MM_insert" value="form1" />
</form>