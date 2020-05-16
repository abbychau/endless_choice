<!DOCTYPE html>
<html>
	<head>
		<title>Endless Choice 無盡的選擇: Welcome</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="keywords" content="文字遊戲, 選擇遊戲, 遊戲, 可以自行創建劇本, endless choice, ec.abby.md, ec" />
		<meta name="description" content="無盡的選擇文字選擇遊戲, 可以自行創建劇本" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="data:image/x-icon;base64,AAABAAEAEBAQAAEABAAoAQAAFgAAACgAAAAQAAAAIAAAAAEABAAAAAAAgAAAAAAAAAAAAAAAEAAAAAAAAAAAAAAAWTswAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAQAAAAAAAAABERAAAAAAAAEREAAAAAAAAQAAAAAAAAABAAAAAAAAAAEAAAAAAAAAAQAAAAAAAAABAAAAAAAAAAEAAAAAAAAAAQAAAAAAAAAREAAAAAAAARERAAAAAAAREREQAAAAABERERAAAAAAARERAAAAAAAAERAAAAD+/wAA/h8AAP4fAAD+/wAA/v8AAP7/AAD+/wAA/v8AAP7/AAD+/wAA/H8AAPg/AADwHwAA8B8AAPg/AAD8fwAA" rel="icon" type="image/x-icon" />
		
		
		<script type="text/javascript" src="//code.jquery.com/jquery-1.9.1.js"></script>
		<script type="text/javascript" src="//code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
		<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
		
		<!-- Optional theme -->
		<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-theme.min.css">
		
		<!-- Latest compiled and minified JavaScript -->
		<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
		
		<style type="text/css">
			body {background-image:url(img/bg.jpg); background-position:center top;   padding-top: 70px;padding-bottom: 20px;}
			.left{float:left}
			.right{float:right}
			.hide{display:hidden}
			.clear{clear:both}
			
			@media (max-width: 920px) {
			.hidden-920 {
			display:none !important;
			}
			body{padding-top:50px;}
			}
		</style>
<?=gaScript();?>
	</head>
	<body>





		<div class="navbar navbar-default navbar-fixed-top">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="/">Endless Choice</a>
				</div>
				<div class="navbar-collapse collapse">
					<ul class="nav navbar-nav" id='top-nav'>
						<li><a href="/index.php">首頁</a></li>
						<li><a href="list.php">劇本總表</a></li>
						
						
						<li style='    background-image: linear-gradient(to bottom,#fff 0,hsla(105, 90%, 60%, 1) 100%);' ><a href="/createworld.php"><i class="fa fa-pencil" aria-hidden="true"></i> 申請劇本</a></li>
						<?if($pUser){?><li><a style=' ' href="/story_admin">故事編輯器</a></li><?}?>
						<?if($error==1){?><li><a href="/fb_login.php"><img width='16' src='/img/flogo-RGB-HEX-Blk-58.png' /> Facebook 登入</a></li><?}else{?>
						<li><a style=' ' href="/fb_logout.php">登出</a></li>
						<?}?>
					</ul>
					<form name="searchform" id="midBarForm" method="post" action="load.php" class="navbar-form navbar-right" style='padding-right:0;margin-right:-15px'>
						<div class="input-group" style="width:120px;">
							<input type="text" class="form-control" name="code" placeholder="輸入通關密碼" style='width:120px' />
                            <div class="input-group-btn">
                            <button onclick="chk();" class="btn btn-success">進入</button>
                            </div>
						</div>
					</form>
				</div><!--/.navbar-collapse -->
			</div>
		</div>
		<div class="container" style="background:white; margin: 0 auto; -webkit-box-shadow: white 0px 0px 1em;-moz-box-shadow: white 0px 0px 1em;">
		<a href="index.php"><img src="img/eclo.jpg" alt="banner" style="border:none;" width="100%" /></a>		