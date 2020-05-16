<style>
	.addpage input,.addpage textarea{width:100%; margin:0 0 3px 0;padding:3px}
	
</style>	
<div class="row">
	<div class="col-lg-12">
		<ol class="breadcrumb">
			<li class="active">
				<i class="fa fa-bar-chart-o"></i> 新增篇章
			</li>
		</ol>
	</div>
</div>


	<form action="<?php echo $editFormAction; ?>" id="form1" name="form1" method="POST" onsubmit="">
		<div class='addpage'>
			<input name="worldid" type="hidden" value="<?=$worldid; ?>" />
			<br />
			<input placeholder="Frame ID (最大6位, 如:填入23)" name="frameid" type="number" step="any" id="frameid" value="<?=$suggestFrameID ;?>" required="required" />
			<br />
			<input placeholder='標題' name="title" type="text" size="80" required="required" />
			<br />
			<textarea placeholder='內容' name="content" rows="5" id="content" required="required" wrap="virtual"></textarea>
			<br />
			<input type="submit" name="Submit" id="Submit" class='btn btn-primary' value="建立" />
			<input type="hidden" name="MM_insert" value="form1" />
		</div>
	</form>