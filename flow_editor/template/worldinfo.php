<style>
	textarea{width:100%}
</style>
<div class="row">
	<div class="col-lg-12">
		<ol class="breadcrumb">
			<li class="active">
				<i class="fa fa-bar-chart-o"></i> 設定劇本和作者資訊
			</li>
		</ol>
	</div>
</div>



<div class="row">
	<div class="col-lg-4 col-md-4 col-sm-6">
		<div class="panel panel-red">
			<div class="panel-heading">
				<div class="row">
					<div class="col-xs-3">
						<i class="fa fa-fire fa-5x"></i>
					</div>
					<div class="col-xs-9 text-right">
						<div class="huge"><?=dbRs("select sum(count) from ec_pages where wid = $worldid");?></div>
						<div>人氣</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="col-lg-4 col-md-4 col-sm-6">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<div class="row">
					<div class="col-xs-3">
						<i class="fa fa-font fa-5x"></i>
					</div>
					<div class="col-xs-9 text-right">
						<div class="huge"><?=$wordCount;?></div>
						<div>總字數</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="col-lg-4 col-md-4 col-sm-6">
		<div class="panel panel-green">
			<div class="panel-heading">
				<div class="row">
					<div class="col-xs-3">
						<i class="fa fa-file fa-5x"></i>
					</div>
					<div class="col-xs-9 text-right">
						<div class="huge"><?=dbRs("select sum(1) from ec_pages where wid = $worldid");?></div>
						<div>總分頁</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>




<form method="post" action="<?=$editFormAction; ?>" id="disablable">
	
	<div class="input-group">
		<span class="input-group-addon">劇本名</span>
		<input type="text" name="name" class="form-control" value="<?=$world_info['name']; ?>" placeholder="劇本名">
	</div>
	
	<div class="panel panel-default">
		<div class="panel-heading">Endless Choice 首頁簡介</div>
		<div class="panel-body">
			<textarea name="conclusion" rows="10" id="conclusion"><?=$world_info['conclusion']; ?></textarea> 
		</div>
	</div>
	<div class="panel panel-default">
		<div class="panel-heading">進入頁面簡介</div>
		<div class="panel-body">
			<textarea name="entertext" rows="10" id="entertext"><?=$world_info['entertext']; ?></textarea>
		</div>
	</div>
	<div class="input-group">
		<span class="input-group-addon">RF 討論貼編號</span>
		<input type="text" name="tid" class="form-control" value="<?=$world_info['tid']; ?>" placeholder="RF 討論貼編號">
	</div>
	<div class="input-group">
		<span class="input-group-addon">Facebook 專頁名稱</span>
		<input type="text" name="facebook_page" class="form-control" value="<?=$world_info['facebook_page']; ?>" placeholder="輸入http://www.facebook.com/ 後面的名稱, 如:konran8raundo">
	</div>

	<div class="input-group">
		<span class="input-group-addon">最大體力值(0為不使用)</span>
		<input type="text" name="ap_max" class="form-control" value="<?=$world_info['ap_max']; ?>" placeholder="輸入整數(0為不使用)" />
	</div>
	<div class="input-group">
		<span class="input-group-addon">每小時回復體力值</span>
		<input type="text" name="ap_recovery_per_hour" class="form-control" value="<?=$world_info['ap_recovery_per_hour']; ?>" placeholder="輸入整數(0為不使用)" />
		(每分鐘結算,例如填入60即每分鐘回復1點)
	</div>
    <div class="input-group">
        <span class="input-group-addon">admob 廣告ID</span>
        <input type="text" name="admob_id" class="form-control" value="<?=$world_info['admob_id']; ?>" placeholder="admob_id(e.g.ca-app-pub-4549800596928715/3330071783)" />
    </div>

	<input type="hidden" name="confirm" value="true" />
	<input class="btn btn-primary" style="margin:1em 0" type="submit" value="確認" />
	<?if(!$_COOKIE['EC_READONLY']){?>
		
	<?}else{?>
	<script>
		$('#disablable input').attr('disabled',true);
		$('#disablable textarea').attr('disabled',true);
	</script>
	<?}?>
</form>

<h3>唯讀密碼</h3>
輸入此密碼可以進入後台, 但無法修改變數、劇本設定、Frame 內容。<br />
本劇本的唯讀密碼為: <?=substr(md5($world_info['password']),0,8);?>