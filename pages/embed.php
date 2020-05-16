<?php 
	require_once('../include/sqldata.php');
	
	
	$query_ViewPage = sprintf("SELECT * FROM ec_pages WHERE id = %s AND wid = $worldid", GetSQLValueString($id, "double"));
	$pageInfo = dbRow($query_ViewPage);
	
	$pageInfo['content'] = str_replace(["[[","]]","<<",">>"],["<v ","></v>","<span id='","'><span>"],$pageInfo['content']);
	$pageInfo['content'] = nl2br($pageInfo['content']);

?>

<?php if(trim($pageInfo['content']) <> ""){ ?>

	<?=($pageInfo['content']); ?>
	<script type="text/javascript">
		<?=$pageInfo['js']; ?>
	</script>
<?php } else {?>
	<strong>作者未完成這一幕，請按下面的save 以便下次繼續</strong>
<? } ?>