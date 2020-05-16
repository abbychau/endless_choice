<?php
	require_once('../include/sqldata.php'); 


	
	////////////////////
	$maxRows_WorldTimeLime = 50;
	
	$selected_pageno = isset($_COOKIE['admin_selected_page'])?intval($_COOKIE['admin_selected_page']):0;
	$startv = $selected_pageno * $maxRows_WorldTimeLime;
	$query_WorldTimeLime = "SELECT * FROM ec_pages WHERE wid = $worldId ORDER BY id ASC";
	$query_limit_WorldTimeLime = sprintf("%s LIMIT %d, %d", $query_WorldTimeLime, $startv, $maxRows_WorldTimeLime);
	$arrPages = dbAr($query_limit_WorldTimeLime);
	$totalRows_WorldTimeLime = dbRs("SELECT count(1) FROM ec_pages WHERE wid = $worldId");
	//print_r($query_limit_WorldTimeLime);exit;
	$totalPages_WorldTimeLime = ceil($totalRows_WorldTimeLime/$maxRows_WorldTimeLime)-1;
	//////////////////
	//////////////////
	$queryString = "";
	if (!empty($_SERVER['QUERY_STRING'])) {
		$params = explode("&", $_SERVER['QUERY_STRING']);
		$newParams = array();
		foreach ($params as $param) {
			if (stristr($param, "selected_pageno") == false && 
			stristr($param, "totalRows_WorldTimeLime") == false) {
				array_push($newParams, $param);
			}
		}
		if (count($newParams) != 0) {
			$queryString = "&" . htmlentities(implode("&", $newParams));
		}
	}
	$queryString = sprintf("&totalRows_WorldTimeLime=%d%s", $totalRows_WorldTimeLime, $queryString);
	$worldInfo = dbRow("SELECT * FROM ec_system WHERE id = $worldId");
	
	$wrapin = "template/index.php";
?>
<!DOCTYPE html>
<html lang="en">
	
	<head>
		
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<meta name="description" content="">
		<meta name="author" content="">
		
		<title><?=$worldInfo["name"];?> - EC Editor</title>
		
		
		<link href="<?=$_COOKIE['asset_path'];?>css/bootstrap.min.css" rel="stylesheet">
		<link href="<?=$_COOKIE['asset_path'];?>css/sb-admin.css" rel="stylesheet">
		<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
		
		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
		<!-- jQuery -->
		<script src="<?=$_COOKIE['asset_path'];?>js/jquery.js"></script>
		<script>
			function setCookie(cname, cvalue, exdays) {
				var d = new Date();
				d.setTime(d.getTime() + (exdays*24*60*60*1000));
				var expires = "expires="+d.toUTCString();
				document.cookie = cname + "=" + cvalue + "; " + expires;
			} 
			//$('#story_pages').scrollTop($('#ida<?=str_replace(".","_",$_GET["id"]);?>').focus());
			$(document).ready(function(){
				//TO-DO
				//$("#sidebar").scrollTop($("#ida<?=str_replace(".","_",$_GET["id"]);?>").position().top - 60);
				
				$("a[data-change-page]").click(function(){
					setCookie("admin_selected_page",$(this).attr("data-change-page"),300);
					location.reload(); 
				});
						
				
			});
		</script>
		
			<style>
			<? if($isMobile){?>
				body{    -webkit-touch-callout: none;
				-webkit-user-select: none;
				-khtml-user-select: none;
				-moz-user-select: none;
				-ms-user-select: none;
				user-select: none;}
				<?}?>
				.side-nav > li > ul > li > a {  padding: 2px 2px 2px 15px; font-size: 9pt;}
			</style>
		
	</head>
	
	<body>
		
		<div id="wrapper">
			
			<!-- Navigation -->
			<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="index.php"><i class="fa fa-dashboard"></i> ECE - <?=$worldInfo["name"];?></a>
				</div>
				<!-- Top Menu Items -->
				
				<ul class="nav navbar-right top-nav">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-fw fa-wrench"></i> <b class="caret"></b></a>
						
						
						
						<ul class="dropdown-menu alert-dropdown">
							<li><a href="search.php"><i class="fa fa-fw fa-search"></i> �j�M�r�y�ο��</a></li>
							<?if($_COOKIE['EC_READONLY'] != 1){?>
								<li><a href="addpage.php"><i class="fa fa-fw fa-plus"></i> �[�s�g��</a></li>
								<li><a href="javascript:location.reload(true)"><i class="fa fa-fw fa-refresh"></i> ���s��z�C��</a></li>
								<li class="divider"></li>
								<li><a href="viewvariables.php"><i class="fa fa-fw fa-code"></i> �˵��ܼ�</a></li>
								<li><a href="setcss.php"><i class="fa fa-fw fa-paint-brush"></i> �]�w�D�D�M�I������</a></li>
								<li><a href="setcss.php"><i class="fa fa-fw fa-bar-chart-o"></i> �]�w�@���M�@�̸�T</a></li>

							<?}?>
						</ul>
					</li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?=$worldInfo["author"];?> <b class="caret"></b></a>
						<ul class="dropdown-menu">
							
							<li>
								<a href="export.php?type=tree"><i class="fa fa-caret-square-o-down"></i> �˵���ܾ�</a>
							</li>
							<li>
								<a href="export.php?type=text" target="_blank"><i class="fa fa-caret-square-o-down"></i> �ץX���r��</a>
							</li>
							<li>
								<a href="../enter.php?worldid=<?=$worldId; ?>"><i class="fa fa-fw fa-eye"></i> �w���G��</a>
							</li>
							<li class="divider"></li>
							<li><a data-change-page="0">yoyo</a></li>
							<li>
								<a href="/logout.php"><i class="fa fa-fw fa-power-off"></i> �n�X</a>
							</li>
						</ul>
					</li>
				</ul>
				
				<div class="pull-right hidden-xs">
					<form class="navbar-form" role="search" action="search.php" method="post">
						<div class="input-group ">
							<input type="text" class="form-control" style="width:100px" placeholder="�j�M�r�y" name="search_text">
							<span class="input-group-btn">
								<button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
							</span>
						</div><!-- /input-group -->
					</form>
				</div>
				
				<!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
				<div class="collapse navbar-collapse navbar-ex1-collapse">
					<ul class="nav navbar-nav side-nav" id="sidebar">
						<? if($totalPages_WorldTimeLime>0){?>
							<li>
								<a href="javascript:;" data-toggle="collapse" data-target="#pages"><i class="fa fa-fw fa-arrows-v"></i> ���� <i class="fa fa-fw fa-caret-down"></i></a>
								<ul id="pages" class="collapse">
									<?php 
										for($i=0;$i <= $totalPages_WorldTimeLime; $i++){
											echo "<li><a ".($i==$selected_pageno?"style='background:#080808;color:white'":"") ." data-change-page='{$i}'>".($i+1)."</a></li>";
										}
									?>
								</ul>
							</li>
						<?}?>
						<li>
							<a href="javascript:;" data-toggle="collapse" data-target="#story_pages"><i class="fa fa-fw fa-arrows-v"></i> �g�� <i class="fa fa-fw fa-caret-down"></i></a>
							<ul id="story_pages" class="collapse in">
								<?php foreach($arrPages as $v) { ?>
									<li>
										<a id="ida<?=str_replace(".","_",$v["id"]);?>" <? if($_GET["id"]==$v["id"]){?>style="background:#000000;color:#FFF"<?}?> href="editfile.php?id=<?=$v['id']; ?>">
										<?=floatval($v['id']); ?>. <?=$v['title']; ?></a>
									</li>
								<?php } ?>
							</ul>
						</li>
						<li>
							<a href="addpage.php"><i class="fa fa-fw fa-plus"></i> �[�s�g��</a>
						</li>
					</ul>
				</div>
				<!-- /.navbar-collapse -->
			</nav>
			
			<div id="page-wrapper">
				<div class="container-fluid">
					<? include(dirname(__FILE__)."/".$wrapin . ".php");?>
				</div>
			</div>
			<!-- /#page-wrapper -->
			
		</div>
		<!-- /#wrapper -->
		
		
		
		<!-- Bootstrap Core JavaScript -->
		<script src="<?=$_COOKIE['asset_path'];?>js/bootstrap.min.js"></script>
		<script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		  ga('create', 'UA-4293967-12', 'auto');
		  ga('send', 'pageview');

		</script>
	</body>
	
</html>
