<?php 
	require_once('../include/sqldata.php'); 
	
	$storyInfo = dbRow("SELECT id, name, author, `count`, entertext, admob_id FROM ec_system WHERE id = $worldid");
	dbQuery("UPDATE ec_system SET `count`=(SELECT sum(count) FROM ec_pages WHERE wid = $worldid) WHERE id=$worldid");
	if(isset($_COOKIE['ec_theme'])){
		$ec_theme = intval($_COOKIE['ec_theme']);
		}else{
		$ec_theme = '1';
	}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" type="text/javascript"></script>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />
		<title>EC: Entering:<?php echo $storyInfo['name']; ?></title>
		<link rel="stylesheet" type="text/css" href="theme_css/<?=$ec_theme;?>.css" id='theme_css' />
		
		<style>
			input{padding:.5em}
			a{cursor:pointer}
		</style>
		<script type="text/javascript">
			var worldId= <?=$worldid;?>;
			var toast=function(msg){
				$("<div><h3>"+msg+"</h3></div>")
				.css({ display: "block", 
					opacity: 0.90, 
					position: "fixed",
					padding: "7px",
					"text-align": "center",
					background: "yellow",
					width: "270px",
					left: ($(window).width() - 284)/2,
				top: $(window).height()/2 })
				.appendTo( $('body') ).delay( 1500 )
				.fadeOut( 400, function(){
					$(this).remove();
				});
			}
			function setTheme(theme){
				setCookie("ec_theme",theme,9999);
				$("#theme_css").attr("href", "theme_css/" + theme + ".css");
			}
			function setCookie(name, value, days) {
				var expires;
				if (days) {
					var date = new Date();
					date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
					expires = "; expires=" + date.toGMTString();
				}
				else {
					expires = "";
				}
				document.cookie = name + "=" + value + expires + "; path=/";
			}
			function load1(){
				if (localStorage.getItem('save'+worldId) === null) {
					toast('沒有存檔');
					return;
				}
				toast('載入中');
				$('#load_code').val(window.localStorage['save'+worldId]);
				$('#load_form').submit();
			}
			function password1(){
				if(typeof newPass == 'undefined' || newPass==""){
					toast('這兒不能儲存，不能匯出密碼！');
					}else{
					alert("PW:" + newPass);
				}
			}
			function save1(){
				if(typeof newPass == 'undefined' || newPass==""){
					toast('這兒不能儲存');
					}else{
					window.localStorage['save'+worldId]=newPass;
					toast('己儲存');	
				}
			}
			function setTheme(theme){
				setCookie("ec_theme",theme,9999);
				$("#theme_css").attr("href", "theme_css/" + theme + ".css");
			}
		</script>
		
	</head>
	
	<body>
		
		<script>
			function getAdmobID(){
				return "<?=$storyInfo['admob_id'];?>";
			}
		</script>
		<form action="/load.php" id='load_form' method="post">
			<input type='hidden' name='code' id='load_code' />
		</form>
		
		
		<div id="wrapper">
			<div class="addround content">
				<p style="font-family: Georgia, 'Times New Roman', Times, serif; font-size: 2em; font-style: italic;"> <?php echo $storyInfo['name']; ?></p>
				
				<p class="font24"><?php echo nl2br($storyInfo['entertext']); ?></p>
				<p align="right">~<?php echo $storyInfo['author']; ?></p>
				
				<div id="menu">
					
					<div id="choices" style='display:block'>
						<a href='pages.php?id=1&worldid=<?=$storyInfo['id']; ?>'>開新遊戲</a>
						<a onclick="$('#form2div').toggle('slow');">載入進度</a>
						
						<div style="display:none" id="form2div">
							<form id="form2" name="form2" method="post" action="/load.php">
								
								
								<input name="code" type="text" id="code" style='width:150px' placeholder='輸入密碼' />
								<input type="submit" name="submit" value="進入" />
							</form>
						</div>
						<?php if(!$isApp){?>
						<a href="/" target="_parent">離開遊戲</a>
						<?}?>
						<a href='/pages/comment.php?wid=<?=$worldid;?>' target='_blank'>留言</a>
					</div>
				</div>
				<div id="pass" style="display:hidden"></div>
			</div>
		</div>
<?=gaScript();?>
	</body>
</html>
