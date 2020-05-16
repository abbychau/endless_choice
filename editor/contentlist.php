<?php
	require_once('../include/sqldata.php'); 
	require_once('chksess.php');
	
	$currentPage = $_SERVER["PHP_SELF"];
	
	function RemoveValue($strIn){
		$strIn = trim($strIn);
		$replaceArr = array("document.form1.", ".value");
		return str_replace($replaceArr, "",$strIn);
	}
	$maxRows_WorldTimeLime = 50;
	$pageNum_WorldTimeLime = 0;
	if (isset($_GET['pageNum_WorldTimeLime'])) {
		$pageNum_WorldTimeLime = $_GET['pageNum_WorldTimeLime'];
	}
	
	$startRow_WorldTimeLime = $pageNum_WorldTimeLime * $maxRows_WorldTimeLime;
	$query_WorldTimeLime = "SELECT * FROM ec_pages WHERE wid = $worldid ORDER BY id ASC";
	$query_limit_WorldTimeLime = sprintf("%s LIMIT %d, %d", $query_WorldTimeLime, $startRow_WorldTimeLime, $maxRows_WorldTimeLime);
	$WorldTimeLime = dbAr($query_limit_WorldTimeLime);
	
	if (isset($_GET['totalRows_WorldTimeLime'])) {
		$totalRows_WorldTimeLime = $_GET['totalRows_WorldTimeLime'];
		} else {
		$totalRows_WorldTimeLime = dbRs("SELECT count(*) FROM ec_pages WHERE wid = $worldid ORDER BY id ASC");
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
	
	$WorldInfo = dbRow("SELECT * FROM ec_system WHERE id = $worldid");
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>The World Time Line</title>
		<script src="../js/curvycorners.js" language="javascript"></script>
		<style type="text/css">
			body{padding:0;margin:0;font-family:monospace}
			
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
			.section{padding:0.2em 0.1em; margin:0.3em 0.2em;border-top:1px solid #CCC}
		</style>
		
	</head>
	
	<body>
		<div class='section'>
		<strong style='font-size:1.3em'><?=$WorldInfo['name'];?></strong>
		- Endless Choice
		</div>
		<div class='section'>
			<?php if($totalPages_WorldTimeLime!=0){ ?>
				<?php if ($pageNum_WorldTimeLime > 0) { // Show if not first page ?>
					<a href="<?php printf("%s?pageNum_WorldTimeLime=%d%s", $currentPage, max(0, $pageNum_WorldTimeLime - 1), $queryString_WorldTimeLime); ?>">上一頁</a>
				<?php } ?>
				&nbsp;
				<?php 
					for($i=0;$i <= $totalPages_WorldTimeLime; $i++){
						if($i==$pageNum_WorldTimeLime){echo ($i+1)." ";
						}else{echo "<a href='$currentPage?pageNum_WorldTimeLime=$i$queryString_WorldTimeLime'>".($i+1)."</a> ";}
					}
				?>
				&nbsp;
				<?php if ($pageNum_WorldTimeLime < $totalPages_WorldTimeLime) { // Show if not last page ?>
					<a href="<?php printf("%s?pageNum_WorldTimeLime=%d%s", $currentPage, min($totalPages_WorldTimeLime, $pageNum_WorldTimeLime + 1), $queryString_WorldTimeLime); ?>">下一頁</a>
				<?php } // Show if not last page ?>
				
			<?}?>
			
			
			<?php foreach($WorldTimeLime as $row_WorldTimeLime) { ?>
				<span><a href="editfile.php?worldid=<?php echo $worldid; ?>&amp;id=<?php echo $row_WorldTimeLime['id']; ?>" target="mainFrame">
				<?=floatval($row_WorldTimeLime['id']); ?>. <strong><?php echo $row_WorldTimeLime['title']; ?></strong></a></span>
				<br />
				<div id="<?php echo $row_WorldTimeLime['id']; ?>" style='font-size:10pt'>
					
					<? for($i = 1; $i <= 6; $i++){?>
						<?php if(isset($row_WorldTimeLime["c{$i}"]) && $row_WorldTimeLime["c{$i}"]!=""){?>　<a href = "editfile.php?worldid=<?=$worldid; ?>&amp;id=<?=$row_WorldTimeLime["c{$i}to"]; ?>" target="mainFrame"><?=$row_WorldTimeLime["c{$i}"]; ?></a>-&gt;<strong><?=RemoveValue($row_WorldTimeLime["c{$i}to"]); ?></strong><?php }?>
					<?}?>
					
				</div>
				<div style='margin:0.1em 0;border-top:0.1em solid #CCC '></div>						
				
			<?php } ?>
			
			
			<?php if($totalPages_WorldTimeLime!=0){ ?>
				
				<?php if ($pageNum_WorldTimeLime > 0) { // Show if not first page ?>
					<a href="<?php printf("%s?pageNum_WorldTimeLime=%d%s", $currentPage, max(0, $pageNum_WorldTimeLime - 1), $queryString_WorldTimeLime); ?>">上一頁</a>
				<?php } ?>
				&nbsp;
				<?php 
					for($i=0;$i <= $totalPages_WorldTimeLime; $i++){
						if($i==$pageNum_WorldTimeLime){echo ($i+1)." ";
						}else{echo "<a href='$currentPage?pageNum_WorldTimeLime=$i$queryString_WorldTimeLime'>".($i+1)."</a> ";}
					}
				?>
				&nbsp;
				<?php if ($pageNum_WorldTimeLime < $totalPages_WorldTimeLime) { // Show if not last page ?>
					<a href="<?php printf("%s?pageNum_WorldTimeLime=%d%s", $currentPage, min($totalPages_WorldTimeLime, $pageNum_WorldTimeLime + 1), $queryString_WorldTimeLime); ?>">下一頁</a>
				<?php } // Show if not last page ?>
			<?}?>
		</div>
		<div class='section'>
			<?if($_COOKIE['EC_READONLY'] != 1){?>
				<a href="addpage.php?worldid=<?php echo $worldid; ?>" target="mainFrame">按此加新篇章</a><br />
				<a href="javascript:location.reload(true)" target="_self">按此重新整理列表</a><br />
				<br />
				<a href="announce.php?worldid=<?php echo $worldid; ?>" target="mainFrame">按此設定劇本和作者資訊</a><br />
				
				<a href="viewvariables.php?worldid=<?php echo $worldid; ?>" target="mainFrame">按此檢視變數</a><br />
				<a href="setcss.php?worldid=<?php echo $worldid; ?>" target="mainFrame">按此設定主題和背景音樂</a><br />
				<br />
			<?}?>
			<a href="search.php?worldid=<?php echo $worldid; ?>" target="mainFrame">搜尋字句</a>
			<a href="search_choice.php?worldid=<?php echo $worldid; ?>" target="mainFrame">搜尋選項</a>
			<br />
			<a href="../enter.php?worldid=<?php echo $worldid; ?>" target="mainFrame">預覽世界</a><br />
			<a href="/logout.php" target="_parent">登出並返回首頁</a><br />
			<br />
			<a href="http://realforum.zkiz.com/viewforum.php?fid=129" target="mainFrame">到Real Forum 的吹水都輕鬆一下</a>
		</div>
	</body>
</html>