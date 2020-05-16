<?php
	require_once('../include/sqldata.php'); 
	require_once('chksess.php');
	
	$currentPage = $_SERVER["PHP_SELF"];
	
	function RemoveValue($strIn){
		$strIn = trim($strIn);
		$replaceArr = array("document.form1.", ".value");
		return str_replace($replaceArr, "",$strIn);
	}
	
	$maxRows_WorldTimeLime = 40;
	$pageNum_WorldTimeLime = 0;
	if (isset($_GET['pageNum_WorldTimeLime'])) {
		$pageNum_WorldTimeLime = $_GET['pageNum_WorldTimeLime'];
	}
	
	$startRow_WorldTimeLime = $pageNum_WorldTimeLime * $maxRows_WorldTimeLime;
	////////////////////
	$query_WorldTimeLime = "SELECT * FROM ec_pages WHERE wid = $worldid ORDER BY id ASC";
	$query_limit_WorldTimeLime = sprintf("%s LIMIT %d, %d", $query_WorldTimeLime, $startRow_WorldTimeLime, $maxRows_WorldTimeLime);
	$WorldTimeLime = dbAr($query_limit_WorldTimeLime);
	
	if (isset($_GET['totalRows_WorldTimeLime'])) {
		$totalRows_WorldTimeLime = $_GET['totalRows_WorldTimeLime'];
		} else {
		$totalRows_WorldTimeLime = dbRs("SELECT count(1) FROM ec_pages WHERE wid = $worldid ORDER BY id ASC");
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
		<title>The World Time Line</title>
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
			td{ border:1px solid #666666;
			-webkit-border-radius: 5px;
			-moz-border-radius: 5px;
			padding:4px 4px 4px 4px;
			background:#FFFFFF}
			.left{float:left;}
			.clear{clear:both;}
		</style>
		
	</head>
	
	<body>
		<div style='width:250px' class='left'>
		<table width="100%" align="center" id="timeline">
			<tr>
				<td valign="top"><strong>Endless Choice</strong> - <em>Time Line</em></td>
			</tr> 
			<?php if($totalPages_WorldTimeLime!=0){ ?>
			<tr>
				<td valign="top">
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
					<?php } // Show if not last page ?></td>
			</tr>
			<?}?>
			<tr>
				<td valign="top" style="padding-top:5px">
					
					<?php foreach($WorldTimeLime as row_WorldTimeLime) { ?>
						<span><a href="editfile.php?worldid=<?php echo $worldid; ?>&amp;id=<?php echo $row_WorldTimeLime['id']; ?>" target="mainFrame">
						<?php echo floatval($row_WorldTimeLime['id']); ?>　<strong><?php echo $row_WorldTimeLime['title']; ?></strong></a></span>
						<br />
						<div id="<?php echo $row_WorldTimeLime['id']; ?>" style="font-size:12px; display:block; padding-left:20px; border-bottom:1px solid #666">
							<?php if(isset($row_WorldTimeLime['c1'])){?>
								<a href = "editfile.php?worldid=<?php echo $worldid; ?>&amp;id=<?php echo $row_WorldTimeLime['c1to']; ?>" target="mainFrame">
								<?php echo $row_WorldTimeLime['c1']; ?>
								</a>
								<strong><?php echo RemoveValue($row_WorldTimeLime['c1to']); ?></strong> <br />
							<?php }?>
							
							<?php if(isset($row_WorldTimeLime['c2'])){?>
								<a href = "editfile.php?worldid=<?php echo $worldid; ?>&amp;id=<?php echo $row_WorldTimeLime['c2to']; ?>" target="mainFrame"> 
								<?php echo $row_WorldTimeLime['c2']; ?></a>
								<strong><?php echo RemoveValue($row_WorldTimeLime['c2to']); ?></strong> <br />
							<?php }?>
							
							<?php if(isset($row_WorldTimeLime['c3'])){?>
								<a href = "editfile.php?worldid=<?php echo $worldid; ?>&amp;id=<?php echo $row_WorldTimeLime['c3to']; ?>" target="mainFrame"> 
								<?php echo $row_WorldTimeLime['c3']; ?></a>
								<strong><?php echo RemoveValue($row_WorldTimeLime['c3to']); ?></strong> <br />
							<?php }?>
							
							<?php if(isset($row_WorldTimeLime['c4'])){?>
								<a href = "editfile.php?worldid=<?php echo $worldid; ?>&amp;id=<?php echo $row_WorldTimeLime['c4to']; ?>" target="mainFrame"> 
								<?php echo $row_WorldTimeLime['c4']; ?></a>
								<strong><?php echo RemoveValue($row_WorldTimeLime['c4to']); ?></strong> <br />
							<?php }?>
							
							<?php if(isset($row_WorldTimeLime['c5'])){?>
								<a href = "editfile.php?worldid=<?php echo $worldid; ?>&amp;id=<?php echo $row_WorldTimeLime['c5to']; ?>" target="mainFrame"> 
								<?php echo $row_WorldTimeLime['c5']; ?></a>
								<strong><?php echo RemoveValue($row_WorldTimeLime['c5to']); ?></strong> <br />
							<?php }?>
							
							<?php if(isset($row_WorldTimeLime['c6'])){?>
								<a href = "editfile.php?worldid=<?php echo $worldid; ?>&amp;id=<?php echo $row_WorldTimeLime['c6to']; ?>" target="mainFrame"> 
								<?php echo $row_WorldTimeLime['c6']; ?></a>
								<strong><?php echo RemoveValue($row_WorldTimeLime['c6to']); ?></strong>
							<?php }?>
							
						</div>
						
						
					<?php } ?> </td>
			</tr>
			<?php if($totalPages_WorldTimeLime!=0){ ?>
			<tr>
				<td valign="top">
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
					<?php } // Show if not last page ?></td>
			</tr>
			<?}?>
		</table>
		<table width="100%">
			<tr>
            <td>
				<a href="addpage.php?worldid=<?php echo $worldid; ?>" target="mainFrame">按此加新篇章</a><br />
				<a href="javascript:location.reload(true)" target="_self">按此重新整理列表</a><br />
				<br />
				<a href="announce.php?worldid=<?php echo $worldid; ?>" target="mainFrame">按此設定劇本和作者資訊</a><br />
				<a href="backup.php?worldid=<?php echo $worldid; ?>" target="mainFrame">按此備份或導入故事資料</a><br />
				<a href="viewvariables.php?worldid=<?php echo $worldid; ?>" target="mainFrame">按此檢視變數</a><br />
				<a href="setcss.php?worldid=<?php echo $worldid; ?>" target="mainFrame">按此設定主題和背景音樂</a><br />
				<br />
				<a href="search.php?worldid=<?php echo $worldid; ?>" target="mainFrame">搜尋字句</a>
				<br />
				<a href="../enter.php?worldid=<?php echo $worldid; ?>" target="mainFrame">預覽世界</a><br />
				<a href="/logout.php" target="_parent">登出並返回首頁</a><br />
				<br />
				<a href="http://realforum.zkiz.com/viewforum.php?fid=129" target="mainFrame">到Real Forum 的吹水都輕鬆一下</a>
			</td>
            </tr>
        </table>
		</div>
		<div style='width:250px' class='left'>
		</div>
		<div class='clear'></div>
	</body>
</html>
