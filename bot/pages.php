<?php
	
	require_once('../include/sqldata.php');
	
	function AddValue($strIn){
		$strIn = trim($strIn);
		return is_numeric($strIn)?$strIn:("document.form1.".$strIn.".value");
	}
	
	
	$query_ViewPage = sprintf("SELECT * FROM ec_pages WHERE round(id,3) = %s AND wid = $worldid", GetSQLValueString($id, "double"));
	$row_ViewPage = dbRow($query_ViewPage);
	
	
	$SQL_query_ec_variables = "SELECT * FROM ec_variables WHERE wid=".$worldid;
	$varRecordset = dbAr($SQL_query_ec_variables);
	
	
	foreach ($varRecordset as $row_varRecordset) {
		$varArr[$row_varRecordset['varname']] = $_POST[$row_varRecordset['varname']];
	}
	
	unset($id);
	$prevID = parse_url($_SERVER['HTTP_REFERER'],PHP_URL_QUERY);
	parse_str($prevID);
	if($id && $_GET["id"]!=1){
		$varArr['EC_Path_Records'] = $_POST['EC_Path_Records'] .">{$id}";
	}
	$lastten = substr($varArr['EC_Path_Records'],-10);
	if(
		strlen($lastten)>=10&&
		str_replace(
			$varArr['EC_Path_Records'],
			$lastten		
		)!=$varArr['EC_Path_Records']
	){
		file_put_contents("records.txt",$varArr['EC_Path_Records']."\n", FILE_APPEND);
		header("location:http://ec.abby.md/bot/pages.php?id=1&worldid=121");
	}
	$record = file_get_contents("records.txt");
	foreach($varArr as $k=>$v){
		$pwString .= "{$k}={$v}&";
	}
?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta http-equiv="x-ua-compatible" content="ie=8" />
		<meta name="keywords" content="文字遊戲, 選擇遊戲, 遊戲" />
		<meta name="description" content="無盡的選擇" />
		<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" type="text/javascript"></script>
		
		<title>EC_BOT <?=$_GET['id'];?>@WORLD<?=$_GET["worldid"];?></title>
		
		<script>
			var buttonId='<?=$_POST['buttonId']?$_POST['buttonId']:0;?>';
			var worldId= <?=$worldid;?>;
			function showPath(){
				
			}
			function ec_toggle(target,a){
				$('#'+target).load('check.php?worldid=<?=$worldid; ?>&id='+a);
			}
			function ec_get(dom){
				if(document.getElementById(dom) == null){
					console.log("no dom:"+dom);
					}else{
					return document.getElementById(dom).value;
				}
			}
			function ec_set(dom,val){
				if(document.getElementById(dom) == null){
					console.log("no dom:"+dom);
					}else{
					document.getElementById(dom).value = val;
				}
			}
			function ec_add(strvar,amount){
				var prevVal = parseFloat(ec_get(strvar));
				if(isNaN(prevVal)){
					prevVal = 0;
				}
				ec_set(strvar,prevVal + amount);
			}
			function ec_write(dom){document.write(document.getElementById(dom).value);}
			function dwrite(str){document.write(str);}
			function ec_push(dom,val){$('[id="'+dom+'"]').html(val);}
			function ec_show(dom){$('[id="'+dom+'"]').css('display','inline');}
			function ec_hide(dom){$('[id="'+dom+'"]').hide();}
			function ec_hideall(dom){$(dom).hide();}
			function ec_dice(num){ return Math.floor(Math.random()*num)+1; }
			function ec_hide_option(id){ $('#c'+id).hide(); }
			function ec_lazy_push(arr){
			    for(var i=0; i<arguments.length; i++){
					ec_push(arguments[i],ec_get(arguments[i]));
				}
			}
			function showChoices(){
				$("#choices").show();
				$(".page_choices").each(
				function(){
					if(this.innerText==""){
						$(this).hide();
					}
				}
				);
			}
			function save_page(page,ec_input){
				try{loaded(page,ec_input);}catch(err){}
				document.form1.action="pages.php?id="+page+"&worldid=<?php echo $worldid; ?>";
				$("#buttonId").val(ec_input);
				document.form1.submit();
			}
			function c_page(page,ec_input){
				document.form1.action="pages.php?id="+page+"&worldid=<?php echo $worldid; ?>";
				$("#buttonId").val(ec_input);
				document.form1.submit();
			}
			function ecPreviousButtonId(){
				return buttonId;
			}
			function ec_setTitle(str){
				$(".pagetitle").html(str);
			}
			function ec_hideOption(id){
				$("#choice"+id).hide();
				
			}

			$(document).ready(function(){
				<?=str_replace(array("[[","]]"),array("ec_get('","')"),$row_ViewPage['js']); ?>
				
				<?php foreach($varArr as $i => $v) { ?>
					$("v[<?=$i;?>]").html("<?=htmlentities($v,ENT_QUOTES); ?>");
				<?php } ?>
				

					showChoices();
				
			});
			
		</script>
	</head>
	<body>
		<form action="/load.php" id='load_form' method="post">
			<input type='hidden' name='code' id='load_code' />
		</form>
		<? echo $varArr['EC_Path_Records'];?>
			<div class="content">
				<?php if(trim($row_ViewPage['title']) <> ""){ ?>
					<strong class="pagetitle"><?php echo $row_ViewPage['title']; ?></strong>
					( Views:<?php echo $row_ViewPage['count']; ?> )
					<hr width="100%" />
					
					
					<form name="form1" method="post" action="pages.php" class="pagecontent">
						<input type="hidden" name="buttonId" id="buttonId" value="0" />
						<?php if($varArr){?>
							<?php foreach($varArr as $i => $v) { ?>
								<input type="hidden" name="<?=$i;?>" value="<?=$v; ?>" id="<?=$i;?>" />
								<?if(decrypt($_COOKIE['EC_WID'])==$worldid){?>
									<?=($v!="")?"$i = $v <br/>":"";?>
								<?}?>
							<?php } ?>
						<? } ?>
						
						<input type="hidden" name="ec_sys_current_view" value="<?php echo $row_ViewPage['count']; ?>" />
						
						<div id="reply_comment"><?php echo nl2br($row_ViewPage['content']); ?></div>
						
						<div style="clear:both"></div>
						
						
						<div id="choices">
							
							<?php for($i = 1; $i <=6 ;$i++){?>
								<?php if(trim($row_ViewPage["c{$i}to"]) != ""){ ?>
									<a class="page_choices" id="choice<?=$i?>" href="javascript:save_page(<?=AddValue($row_ViewPage["c{$i}to"]); ?>);" id="<?="c{$i}";?>"><?=$row_ViewPage["c{$i}"]; ?></a>
								<? if(!strstr($record,$varArr['EC_Path_Records'].">".$row_ViewPage["c{$i}to"])){?>
										<script>save_page(<?=AddValue($row_ViewPage["c{$i}to"]); ?>);</script>
									<?}?>
								<?php } ?>
							<?php } ?>
							
							
						</div>
					</form>
				<?php }else{echo "<strong>作者未完成這一幕，請按下面的[儲存]以便下次繼續</strong>";} ?>
				
	</div>
	
</body>
</html>