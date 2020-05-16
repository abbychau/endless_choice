<?php
	require_once('../include/sqldata.php'); 
	if($pWid == ""){die("Please login first. <br /><a href='/'>Endless Choice</a>");}	
	$worldid = $pWid;
	$currentPage = $_SERVER["PHP_SELF"];
	

	
	$maxRows_WorldTimeLime = 40;
	$pageNum_WorldTimeLime = 0;
	if (isset($_GET['pageNum_WorldTimeLime'])) {
		$pageNum_WorldTimeLime = $_GET['pageNum_WorldTimeLime'];
	}
	
	$startRow_WorldTimeLime = $pageNum_WorldTimeLime * $maxRows_WorldTimeLime;
	
	$query_WorldTimeLime = "SELECT * FROM ec_pages WHERE wid = $worldid ORDER BY id ASC";
	$query_limit_WorldTimeLime = sprintf("%s LIMIT %d, %d", $query_WorldTimeLime, $startRow_WorldTimeLime, $maxRows_WorldTimeLime);
	$WorldTimeLime = mysql_query($query_limit_WorldTimeLime, $conn) or die(mysql_error());
	$row_WorldTimeLime = mysql_fetch_assoc($WorldTimeLime);
	
	if (isset($_GET['totalRows_WorldTimeLime'])) {
		$totalRows_WorldTimeLime = $_GET['totalRows_WorldTimeLime'];
		} else {
		$all_WorldTimeLime = mysql_query($query_WorldTimeLime);
		$totalRows_WorldTimeLime = mysql_num_rows($all_WorldTimeLime);
	}
	$totalPages_WorldTimeLime = ceil($totalRows_WorldTimeLime/$maxRows_WorldTimeLime)-1;
	//////////////////
	$queryString_WorldTimeLime = "";
	if (!empty($_SERVER['QUERY_STRING'])) {
		$params = explode("&", $_SERVER['QUERY_STRING']);
		$newParams = array();
		foreach ($params as $param) {
			if (stristr($param, "pageNum_WorldTimeLime") == false && 
			stristr($param, "totalRows_WorldTimeLime") == false) {
				array_push($newParams, $param);
			}
		}
		if (count($newParams) != 0) {
			$queryString_WorldTimeLime = "&" . htmlentities(implode("&", $newParams));
		}
	}
	$queryString_WorldTimeLime = sprintf("&totalRows_WorldTimeLime=%d%s", $totalRows_WorldTimeLime, $queryString_WorldTimeLime);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Endless Choice Editor</title>
		
		<script src="http://code.jquery.com/jquery-1.8.0.min.js"></script>
		<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
		<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
		<script src="jquery-window-5.03/jquery.window.js"></script>
		<link rel="stylesheet" href="jquery-window-5.03/css/jquery.window.css" />
		<style type="text/css">
			a:link {
			color: #0000FF;
			text-decoration: none;
			}
			a:visited {
			text-decoration: none;
			color: #0000FF;
			}
			a:hover {
			text-decoration: underline;
			color: #0000FF;
			}
			a:active {
			text-decoration: none;
			color: #0000FF;
			}
			a{color: #0000FF; cursor:pointer; font-size:12px}
			hr{ margin:0px; color:#666666; height:0px }
			
			.rc{padding:4px;border:1px solid #999 ;border-top:0;}
			.left{float:left;}
			.clear{clear:both;}
			.edit_section{border-bottom:#AAA solid 1px;padding:2px;font-size:12px}
		</style>
		
		<script>
			function ec_get(){}
			$(document).ready(
			function(){
				
				refreshList("timeline.php?worldid=<?=$worldid;?>");
				$('#toolbox a').on('click',
				function(e){
					e.preventDefault();
					$('#bound').window({
						width: 650,
						height: 700,
						maxHeight: 850,
						maxWidth: 650,
						checkBoundary: true,
						bookmarkable: false,
						title: $(this).text(),
						url: $(this).attr('href')
					});
				}
				);
			}
			);
			$.window.prepare({
				dock: 'bottom',       // change the dock direction: 'left', 'right', 'top', 'bottom'
				animationSpeed: 200,  // set animation speed
				minWinLong: 180       // set minimized window long dimension width in pixel
			});
			function refreshList(url){
				$('#timeline').load(url,
				function(){
					$('.edit_section a').on('click',
					function(e){
						$('#bound').window({
							width: 650,
							height: 700,
							maxHeight: 850,
							maxWidth: 650,
							checkBoundary: true,
							bookmarkable: false,
							title: "Edit - "+ $(this).attr('pageid') + ":"+ $(this).text(),
							url: "editfile.php?worldid="+$(this).attr('worldid')+"&id="+$(this).attr('pageid')
						});
					}
					);
					$('.turnpage a').on('click',
					function(e){
						e.preventDefault();
						refreshList($(this).attr('href'));
					}
					);
				}
				
				);
				
			}
		</script>
	</head>
	
	<body>
		<table width="100%"><tr><td width="300">
			<div>
				<div class='ui-widget-header' style='padding:4px'><strong>Endless Choice</strong> - <em>Time Line</em></div>
				<div class='rc' id="timeline"></div>
				<div class='rc' id='toolbox'>
					<a href="../editor/addpage.php?worldid=<?php echo $worldid; ?>" target="mainFrame">按此加新篇章</a><br />
					<a onclick="refreshList();">按此重新整理列表</a><br />
					<br />
					<a href="../editor/announce.php?worldid=<?php echo $worldid; ?>" target="mainFrame">按此設定劇本和作者資訊</a><br />
					<a href="../editor/viewvariables.php?worldid=<?php echo $worldid; ?>" target="mainFrame">按此檢視變數</a><br />
					<a href="../editor/setcss.php?worldid=<?php echo $worldid; ?>" target="mainFrame">按此設定主題和背景音樂</a><br />
					<br />
					<a href="../editor/search.php?worldid=<?php echo $worldid; ?>" target="mainFrame">搜尋字句</a>
					<br />
					<a href="http://realforum.zkiz.com/viewforum.php?fid=129" target="mainFrame">到Real Forum 的吹水都輕鬆一下</a>
				</div>
				<div class='rc'>
					
					<a href="../enter.php?worldid=<?php echo $worldid; ?>" target="mainFrame">預覽世界</a><br />
				</div>
			</div>
			</td><td id="bound">
			
		</td></tr></table>
		<div style="position:fixed;bottom:5px;right:5px;padding:5px; color:#CCC; font-family:Arial;font-size:12px">ECA-Web 2013 | Best viewed @ 1920*1080</div>
	</body>
</html>
<?php
	mysql_free_result($WorldTimeLime);
?>
