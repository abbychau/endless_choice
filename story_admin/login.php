<?
	include("../include/sqldata.php");
	$leftInfo = dbAr("SELECT id,name,author FROM ec_system order by id");
	?>
<!DOCTYPE html>
<html lang="en">
	
	<head>
		
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<meta name="description" content="">
		<meta name="author" content="">
		
		<title>Endless Choice - Story Admin - <?=$worldInfo["name"];?></title>
		
		<link href="<?=$_COOKIE['asset_path'];?>css/bootstrap.min.css" rel="stylesheet">
		<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
		
		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
		<!-- jQuery -->
		<script src="<?=$_COOKIE['asset_path'];?>js/jquery.js"></script>
	</head>
	
	<body>
		<nav class="navbar navbar-inverse navbar-fixed-top">
			<div class="container">
				<div class="navbar-header">
					<a class="navbar-brand" href="/story_admin/"><i class="fa fa-dashboard"></i> Endless Choice Story Admin</a>
				</div>
			</div>
		</nav>
		<div class="container" style='margin-top:4em'>
			

	
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
			<br />
			<a href="http://ec.abby.md/createworld.php">申請新劇本</a>
			<a href="http://members.zkiz.com">註冊</a>
			
		</div> <!-- /container -->
		
		<script src="<?=$_COOKIE['asset_path'];?>js/bootstrap.min.js"></script>
		
	</body>
</html>
