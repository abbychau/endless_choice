<?php
	require_once('../include/sqldata.php'); 
	if($pWid != $worldid){die($_COOKIE['EC_SESS']."|".$worldid);}	
	
	$currentPage = $_SERVER["PHP_SELF"];
	
	function RemoveValue($strIn){
		$strIn = trim($strIn);
		$replaceArr = array("document.form1.", ".value");
		return str_replace($replaceArr, "",$strIn);
	}
	
	
	
	
	////////////////////
	$maxRows_WorldTimeLime = 80;
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
<?php if($totalPages_WorldTimeLime!=0){ ?>
	<div class='turnpage'>
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
	</div>
<?}?>
<div valign="top" style="padding-top:5px; max-height:600px;overflow-y:scroll">
	
	<?php do { ?>
		<div class='edit_section'>
		<div>
		<?=floatval($row_WorldTimeLime['id']); ?>　
			<a worldid="<?=$worldid; ?>" pageid="<?=$row_WorldTimeLime['id']; ?>">
		<strong><?=$row_WorldTimeLime['title']; ?></strong></a>
		</div>
		
		<div>
			<?php for($i = 1; $i<=6;$i++){?>
			
			
			<?php if(isset($row_WorldTimeLime["c{$i}"])){?>
				<a worldid="<?=$worldid; ?>" pageid="<?=$row_WorldTimeLime["c{$i}to"]; ?>"><?=$row_WorldTimeLime["c{$i}"]; ?></a>
				<strong><?=RemoveValue($row_WorldTimeLime["c{$i}to"]); ?></strong> <br />
			<?php }?>
			
			<?}?>
		</div>
			
		</div>
		<?php } while ($row_WorldTimeLime = mysql_fetch_assoc($WorldTimeLime)); ?> 
	</div>
	<?php if($totalPages_WorldTimeLime!=0){ ?>
		<div class='turnpage'>
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
		</div>
	<?}?>	