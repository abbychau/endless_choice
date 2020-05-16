<?php
	require_once('./include/sqldata.php');
	if (isset($_POST['code'])) {
		$password = $_POST['code'];
	}else{
		screenMessage("Error","No Password");
	}
	$decoded=base64_decode(asc_shift($password, 1));
	
	$varArr=explode("&",$decoded);


?><!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="initial-scale=1, maximum-scale=1" />
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" type="text/javascript"></script>
		<title>Loading</title>
	</head>
	<body>
		<form action="pages/pages.php" method="post" name="loadform" id="loadform">
			
			<?php foreach($varArr as $value){ ?>
				<?php $tmpArr = explode("=",$value);?>
				<? if($tmpArr['0'] == "worldid"){?>
					<? $worldid = $tmpArr['1'] ;?>
				<?}?>
			<?}?>
			<input name="debug_password" type="hidden" value="<?=$password?>" />
			<?php foreach($varArr as $value){ ?>
				<?php $tmpArr = explode("=",$value);?>
				<input name="<?php echo $tmpArr['0']; ?>" type="hidden" value="<?php echo $tmpArr['1']; ?>" />
				
				<? if($tmpArr['0'] == "id"){?>
					<input type="hidden" name="ec_to<?=trimZeroDot($tmpArr['1']);?>key" value="<?=ec_hash($worldid.trimZeroDot($tmpArr['1'])); ?>" />
				<? $compareKeyGenerated = true;?>
				<?}?>
			<?php } ?>
			
			
			<input type="submit" name="button" id="button" value="如沒有自動跳轉, 請按這裡" style='padding:.5em' />
		</form>
		<?php if(!$compareKeyGenerated){?>
			<?=$password;?>
		<?}?>
		<script language="javascript">
			<?php if(!$compareKeyGenerated){?>
				alert('你的密碼可能已經損壞!\n 不能載入正確進度！你可以複製後面的編碼回報問題。');
				
			<?}else{?>
			if(isNaN(document.loadform.worldid.value)){
				document.loadform.button.style.display = 'hidden';
				alert('你的密碼可能已經損壞!\n 可能不能載入正確進度!');
			}else{
				document.loadform.submit();
			}
			<?}?>
		</script>
	</body>
</html>

