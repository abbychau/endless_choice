<?php 
	require_once('include/sqldata.php'); 
	
	$currentPage = $_SERVER["PHP_SELF"];
	$maxRows_Recordset1 = 6;
	$page = 0;
	if (isset($_GET['page'])) {
		$page = $_GET['page'];
	}
	$startRow_Recordset1 = $page * $maxRows_Recordset1;
	
	$query_Recordset1 = "SELECT * FROM ec_system WHERE  `enable` > 0 ORDER BY count DESC";
	$query_limit_Recordset1 = sprintf("%s LIMIT %d, %d", $query_Recordset1, $startRow_Recordset1, $maxRows_Recordset1);
	$arrSystem = dbAr($query_limit_Recordset1);
	
	////get total rows
	$totalRows_Recordset1 = dbRs("SELECT count(*) as ce FROM ec_system WHERE `enable` > 0");
	$totalPages_Recordset1 = ceil($totalRows_Recordset1/$maxRows_Recordset1)-1; 
	///end get total rows
	
	session_start();
	$fb = new Facebook\Facebook($fbSettings);
	
	try {
		// Returns a `Facebook\FacebookResponse` object
		$response = $fb->get('/me?fields=id,name', $_SESSION['fb_access_token']);
		$user = $response->getGraphUser();
		} catch(Facebook\Exceptions\FacebookResponseException $e) {
		$error = 1;
		} catch(Facebook\Exceptions\FacebookSDKException $e) {
		$error = 1;
	}


	$allInfo = dbAr("SELECT id,name,author FROM ec_system order by id");
	if($error == 1){
		$leftInfo = $allInfo;
	}else{
		$leftInfo = dbAr("SELECT id,name,author FROM ec_system WHERE author_fbid = '{$user['id']}' order by id");
		//echo "SELECT id,name,author FROM ec_system WHERE author_fbid = '{$user['id']}' order by id";
	}
	$queryString_Recordset1 = "";
	if (!empty($_SERVER['QUERY_STRING'])) {
		$params = explode("&", $_SERVER['QUERY_STRING']);
		$newParams = array();
		foreach ($params as $param) {
			if (stristr($param, "page") == false && stristr($param, "totalRows_Recordset1") == false) {
				array_push($newParams, $param);
			}
		}
		if (count($newParams) != 0) {
			$queryString_Recordset1 = "&" . htmlentities(implode("&", $newParams));
		}
	}
	$last_updates = dbAr("SELECT name, lastupdate, id, author, enable, count FROM ec_system where `enable` > 0 ORDER BY lastupdate DESC limit 4");
	
	//FINISHED
	$finished = dbAr("SELECT name, author, id FROM ec_system where `enable` = 2 ORDER BY lastupdate DESC limit 10");
	
	$nosidebar = true;
	
include("templateblock/header.php");?>
<div class="col-xs-12 col-sm-4">
	<div class='well' style='margin-top:1em'>
		<h4>最後更新劇本 <a href="rss.php"><img style="border:0px" src="https://realforum.zkiz.com/images/rss.png" alt="subs rss" /></a></h4>
		<ul>
			<?php foreach($last_updates as $row_Recordset3) { ?>
				<li>
					
					<a href="/pages/enter.php?worldid=<?php echo $row_Recordset3['id']; ?>">
					<?php echo htmlspecialchars($row_Recordset3['name']); ?></a>
					<br />
					<span class="smallfont">
						作者: <?php echo htmlspecialchars($row_Recordset3['author']); ?>
						人氣: <strong><?php echo htmlspecialchars($row_Recordset3['count']); ?></strong>
						
						<?php echo $row_Recordset3['lastupdate']; ?>
					</span>
				</li>
			<?php } ?>
		</ul>
	</div>
	<div class='well'>
		
		<h4>快捷選擇劇本</h4>
		<div class="input-group">
			<select name="goto" class='form-control input-sm' id="goto" style="width:100%">
				<?php foreach($allInfo as $v) { ?>
					<option value="<?=$v["id"]; ?>"><?=$v["id"]; ?>.<?=$v["name"]; ?></option>
				<?php } ?>
			</select>
			<span class="input-group-btn">
				
				<input onclick="location.href='/pages/enter.php?worldid='+document.getElementById('goto').value;" class="btn btn-primary btn-sm" type="button" value="進入" />
			</span>
		</div><!-- /input-group -->
	</div>
	
	
	<div class='well'>
		
		<h4>登入/編輯</h4>
		

		<?php if($pUser!=""){ ?>
			
			<?php foreach($leftInfo as $v) { 
				if($pWid==$v['id']){$storyName = $v['name'];}
			} ?>
			
			你已經登入無盡的選擇故事管理模式。<br />
			用戶名: <strong><?=$pUser; ?></strong> 故事: <strong><?=$storyName;?></strong>
			<br />
			<button class="btn btn-success btn-sm" onClick="location.href='/story_admin'"><i class="fa fa-pencil" aria-hidden="true"></i> 編輯故事</button>
			<a class='btn btn-default btn-sm' href='/logout.php'>登出</a>
			
			<br />
			
			<a href='editor/editor.php'>舊編輯工具</a> 
			
			<hr style="border-top:1px solid #888"/>
		<?php } ?>
		

		
		<form action='/login.php?login=true' method='post'>
			
			<div class="input-group">
				<span class="input-group-addon"><i class="fa fa-book"></i></span>
				<select class="selectpicker form-control" name="idnum" id="idnum" style="width:100%">
					<?php foreach($leftInfo as $v) { ?>
						<option value="<?=$v["id"]; ?>" <?if($v['author']==$gUsername){?>selected<?}?>><?=$v["id"]; ?>.<?=$v["name"]; ?></option>
					<?php } ?>
				</select> 
				
			</div>
			<div class="input-group" style='margin-top:0.5em'>
				<span class="input-group-addon"><i class="fa fa-lock"></i></span>
				<input type="password" name="ec_passwd" class="form-control" placeholder="Password" required>
			</div>		
			
			<div class="checkbox">
				<label>
					<input type="checkbox" name='remember' value="remember-me"> 記住我
				</label>
			</div>
			<button class="btn btn-lg btn-primary btn-block" type="submit">登入</button>
		</form>
		
	</div>
	
	<div class='well'>
		
		<h4>接關</h4>
		
		<form id="form2" name="form2" method="post" action="load.php">
			<div class="input-group">
				<input type="text" name="code" id="code" placeholder='輸入接關密碼' class='form-control input-sm' />
				<span class="input-group-btn">
					<input type="submit" name="submit" value="進入" class="btn btn-primary btn-sm" />
				</span>
			</div>
		</form>
	</div>
	
	<div class='well'>
		<h4>已完成劇本</h4>
		<ul>
			<?php foreach($finished as $row_Recordset4) { ?>
				<li><a href="/pages/enter.php?worldid=<?php echo $row_Recordset4['id']; ?>">
				<span class="name"><?php echo $row_Recordset4['id']; ?>. <?php echo htmlspecialchars($row_Recordset4['name']); ?></span></a></li>
			<?php } ?>
		</ul>
	</div>
	<div class='well'>
	<a class='btn btn-primary' href='/list.php'><i class="fa fa-list" aria-hidden="true"></i> 劇本總表</a>
	
	</div>
	
</div>
<div class="col-xs-12 col-sm-8" style='margin-top:1em'>
	
	
	<?php foreach($arrSystem as $row_Recordset1){ ?>
		<div class="well">
			<h2><a href="/pages/enter.php?worldid=<?php echo $row_Recordset1['id']; ?>" class="entertext"><?=htmlspecialchars($row_Recordset1['name']); ?></a></h2>
			<?php if($row_Recordset1['facebook_page'] <> ""){ ?>
				<span class='label label-primary'><a style='color:white' href="http://www.facebook.com/<?=$row_Recordset1['facebook_page']; ?>"><i class="fa fa-facebook" aria-hidden="true"></i> FB專頁</a></span>
			<?php } ?>
			<?php if ($row_Recordset1['enable']=='2'){?>			
				<span class='label label-warning'><i class="fa fa-check-square-o" aria-hidden="true"></i>
				已完成</span>
			<?}?>
			
			<span class='label label-default'>作者: <?php echo htmlspecialchars($row_Recordset1['author']); ?></span>
			
			<span class='label <?=$row_Recordset1['count']>=50000?'label-danger':'label-default';?>'>人氣: <?=$row_Recordset1['count'];?></span>
			<?php if ($row_Recordset1['lastupdate']<>""){ ?>
				<span class='label label-success'>最後更新: <?=timeago(strtotime($row_Recordset1['lastupdate']));?></span>
			<?php } ?>
			<hr size="1" />
			<?php echo nl2br(htmlspecialchars($row_Recordset1['conclusion'])); ?>
			
		</div>
	<?php } ?>
	
	
	
	<ul class="pagination pagination-sm">
		
		<li <? if ($page == 0) { ?>class="disabled"<?}?>><a href="<?="$currentPage?page=0"?>">&laquo;</a></li>
		<?php 
			if($totalPages_Recordset1!=0){
				for($i=0;$i <= $totalPages_Recordset1; $i++){
					if($i==$page){
						
					?>
					<li class="active"><a href="#"><?=($i+1);?><span class="sr-only">(current)</span></a></li>
					<?
						}else{
					?>
					<li><a href="<?="$currentPage?page=$i$queryString_Recordset1";?>"><?=($i+1);?></a></li>
					<?
					}
				}
			}
		?>
		<li <?php if ($page == $totalPages_Recordset1) { ?>class="disabled"<?}?>>
			<a href="<?=printf("%s?page=%d%s", $currentPage, $totalPages_Recordset1, $queryString_Recordset1); ?>">&raquo;</a>
		</li>
		
	</ul>
	
</div>






<script>$("#top-nav li:nth-child(1)").addClass('active');</script>


<?php include("templateblock/footer.php");?>