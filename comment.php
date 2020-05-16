<?php
require_once('include/sqldata.php');


$storyInfo = dbRow("SELECT name, css, tid, admob_id FROM ec_system WHERE id = ".intval($_GET['wid']));
$ec_theme = isset($_COOKIE['ec_theme'])?intval($_COOKIE['ec_theme']):'1';
?>
<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="x-ua-compatible" content="ie=8" />
	<meta name="keywords" content="文字遊戲, 選擇遊戲, 遊戲" />
	<meta name="description" content="無盡的選擇 - <?=$storyInfo['name'];?> - 留言" />
	<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" type="text/javascript"></script>
	
	<link rel="stylesheet" type="text/css" href="/pages/theme_css/<?=$ec_theme;?>.css" id='theme_css' />

	<title>無盡的選擇 - <?=$storyInfo['name'];?> - 留言</title>
	<style type="text/css">
<?=$storyInfo['css']; ?>
	</style>

</head>
<body>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/zh_HK/sdk.js#xfbml=1&version=v2.8&appId=1304366376315801";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<?php if(!$isApp){?>
	<div style="margin-bottom:20px" ><strong style="color:#FFF">Endless Choice - <?=$storyInfo['name']; ?></strong></div>
<?}?>
<div id="wrapper">
	<div class="addround">
		<div class="content">

			<div class="fb-comments" data-href="http://ec.abby.md/pages/enter.php?worldid=<?=intval($_GET['wid']);?>" data-width="100%" data-numposts="5"></div>
		
		<div style="height:20px"></div>

		<div class="footer">
			Powered by <a href='http://ec.abby.md' target="_blank"><strong>Endless Choice System</strong></a>
		</div>

		</div>
	</div>
</div>
<?=gaScript();?>

</body>
</html>