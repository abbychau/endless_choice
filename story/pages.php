<?php
	$ZG_DRY = 1;
	require_once('../include/sqldata.php');
	
	function AddValue($strIn){
		$strIn = trim($strIn);
		return is_numeric($strIn)?$strIn:("document.form1.".$strIn.".value");
	}
	
	dbQuery(sprintf("update ec_pages set count = count + 1 where id = %s AND wid = $worldid",GetSQLValueString($id, "double")));
	$query_ViewPage = sprintf("SELECT * FROM ec_pages WHERE round(id,3) = %s AND wid = $worldid", GetSQLValueString($id, "double"));
	$pageInfo = dbRow($query_ViewPage);
	
	
	$pageInfo['js'] = str_replace(["[[","]]"],array("ec_get('","')"),$pageInfo['js']); 
	$pageInfo['js'] = preg_replace( '/([^;\s]+)=>([^;\s]+)/s', "ec_set('$1',$2);" , $pageInfo['js']);
	
	$pageInfo['content'] = str_replace(["[[","]]","<<",">>"],["<v ","></v>","<span id='","'><span>"],$pageInfo['content']);
	$pageInfo['content'] = nl2br($pageInfo['content']);
	
	$arrVariables = dbAr("SELECT * FROM ec_variables WHERE wid= $worldid");
	
	foreach ($arrVariables as $row_varRecordset) {
		$varArr[$row_varRecordset['varname']] = $_POST[$row_varRecordset['varname']];
	}
	$varArr['EC_Path_Records'] = $_POST['EC_Path_Records'] . $_POST['buttonId'];
	
	$pass_padding = "|{$id}|";
	
	$varArr['ec_passed'] = str_replace($pass_padding,"",$_POST['ec_passed']);
	$varArr['ec_passed'] = "{$_POST['ec_passed']}{$pass_padding}";
	
	
	foreach($varArr as $k=>$v){
		$pwString .= "{$k}={$v}&";
	}
	$nStr=$pwString."id=".$id."&worldid=".$worldid;
	$newPass = asc_shift(base64_encode($nStr), -1);
?>


<script>
	var buttonId='<?=$_POST['buttonId']?$_POST['buttonId']:0;?>';
	var newPass= '<?=$newPass;?>';
	var id='<?=$id;?>';
	var worldId= <?=$worldid;?>;
	var typing_speed = <?=intval($pageInfo['typing']);?>;
	var autoPushVar = function (){
		<?php foreach($varArr as $i => $v) { ?>
			$("v[<?=$i;?>]").html($("#<?=$i;?>").val());
		<?php } ?>
	}
	var afterLoading = function(){
		<?=$pageInfo['js']; ?>
		
		autoPushVar();
		
		if(typing_speed >= 1){
			content=document.getElementById('story_content').innerHTML;
			type_write(content); 
			}else{
			showChoices();
		}
	};
	
</script>
<form action="/load.php" id='load_form' method="post"><input type='hidden' name='code' id='load_code' /></form>

<div class="content">
	<?php if(trim($pageInfo['title']) <> ""){ ?>
		<strong class="pagetitle"><?php echo $pageInfo['title']; ?></strong>
		( Views:<?php echo $pageInfo['count']; ?> )
		<hr width="100%" />
		
		
		<form name="form1" method="post" action="pages.php" class="pagecontent">
			<input type="hidden" name="buttonId" id="buttonId" value="0" />
			
			<div id="story_content"><?=$pageInfo['content']; ?></div>
			
			<div id="choices">
				
				<?php for($i = 1; $i <=6 ;$i++){?>
					<?php if(trim($pageInfo["c{$i}to"]) != ""){ ?>
						<a class="page_choices" id="choice<?=$i?>" href="javascript:save_page(<?=AddValue($pageInfo["c{$i}to"]); ?>,<?=$i;?>);" id="<?="c{$i}";?>"><?=$pageInfo["c{$i}"]; ?></a>	
					<?php } ?>
				<?php } ?>
				
			</div>
			
		</form>
	<?php }else{echo "<strong>作者未完成這一幕，請按下面的[儲存]以便下次繼續</strong>";} ?>	
</div>


