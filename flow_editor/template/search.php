<ol class="breadcrumb">
	<li>
		<i class="fa fa-dashboard"></i> 搜索</a>
	</li>
	<li class="active">
		<i class="fa fa-bar-chart-o"></i> 
		<? if (isset($_POST["search_text"])) {?>
			字句: <?=$_POST["search_text"] ?>
		<?}else{?>
			選項: <?=$_POST["search_choice"] ?>
		<?}?>
	</li>
</ol>
<?php if(!empty($array)){?>
	<table class='table table-default'>
	<thead style='font-weight:bold'>
	<tr><td>FrameID</td><td>標題</td></tr>
	</thead>
	<tbody>
		<?php foreach($array as $v){ ?>
			<tr>
				<td><?=$v['id'];?></td><td><?=$v['title'];?></td><td><a href='editfile.php?worldid=<?=$worldid;?>&id=<?=$v['id'];?>'>Go</a></td>
			</tr>
		<?php } ?>
	</tbody>
	</table>
	最大只顯示50筆
<?php } ?>