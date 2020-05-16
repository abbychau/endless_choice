<?php
	
	$arrPages = dbAr("SELECT * FROM ec_pages WHERE wid = $worldId ORDER BY id ASC");

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
		
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
		
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/startbootstrap-sb-admin-2/3.3.7+1/css/sb-admin-2.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/metisMenu/2.7.0/metisMenu.css" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
		
		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
		<!-- jQuery -->
		<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/metisMenu/2.7.0/metisMenu.js"></script>
				<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/startbootstrap-sb-admin-2/3.3.7+1/js/sb-admin-2.min.js"></script>
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
				<?}else{?>
				
				<?}?>
				
				@media screen and (min-width: 768px) {
					.sidebar{
						height: calc(100vh - 52px);overflow-y:scroll
					}
					.container-fluid{padding-top:70px;background:white}
				}
				@media screen and (max-width: 768px) {
					.container-fluid{padding-top:120px;background:white}
				}
            .sidebar-nav .nav>li>a{padding:0.1em}
			</style>
		
	</head>
	
	<body>
		
		<div id="wrapper">
			
			<nav class="navbar navbar-default navbar-fixed-top" role="navigation" style="margin-bottom: 0">
				
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="index.php"><i class="fa fa-dashboard"></i> ECE - <?=$worldInfo["name"];?></a>
				</div>
				
				<ul class="nav navbar-top-links navbar-right">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-fw fa-wrench"></i> <b class="caret"></b></a>
						
						<ul class="dropdown-menu dropdown-messages">
							<li><a href="search.php"><i class="fa fa-fw fa-search"></i> 搜尋字句或選擇</a></li>
							<?if($_COOKIE['EC_READONLY'] != 1){?>
							    <li><a href="cancatadmin.php"><i class="fa fa-fw fa-code"></i> 罐頭管理</a></li>
								<li><a href="addpage.php"><i class="fa fa-fw fa-plus"></i> 加新篇章</a></li>
								<li><a href="javascript:location.reload(true)"><i class="fa fa-fw fa-refresh"></i> 重新整理列表</a></li>
								<li class="divider"></li>
<script>
function pg(pgv){$.get('setcookie.php',{k:"page_chunk",v:pgv},function(){location.reload();});}
</script>

								<li><a href="javascript:pg(15)"><i class="fa fa-fw fa-refresh"></i> Set page chunk to 15</a></li>
                                <li><a href="javascript:pg(45)"><i class="fa fa-fw fa-refresh"></i> Set page chunk to 45</a></li>

                                <li><a href="javascript:pg(99999)"><i class="fa fa-fw fa-refresh"></i> Set page chunk to 99999</a></li>
								<li class="divider"></li>
								<li><a href="viewvariables.php"><i class="fa fa-fw fa-code"></i> 檢視變數</a></li>
								<li><a href="setcss.php"><i class="fa fa-fw fa-paint-brush"></i> 設定主題和背景音樂</a></li>
								<li><a href="setcss.php"><i class="fa fa-fw fa-bar-chart-o"></i> 設定劇本和作者資訊</a></li>

							<?}?>
						</ul>
					</li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?=$worldInfo["author"];?> <b class="caret"></b></a>
						<ul class="dropdown-menu dropdown-messages">
							
							<li>
								<a href="export.php?type=tree"><i class="fa fa-caret-square-o-down"></i> 檢視選擇樹</a>
							</li>
							<li>
								<a href="export.php?type=text" target="_blank"><i class="fa fa-caret-square-o-down"></i> 匯出到文字檔</a>
							</li>
							<li>
								<a href="../enter.php?worldid=<?=$worldId; ?>"><i class="fa fa-fw fa-eye"></i> 預覽故事</a>
							</li>
							<li class="divider"></li>
							<li><a href="fb_linkup.php">連結此故事到我的Facebook 賬戶</a></li>
							<li>
								<a href="/logout.php"><i class="fa fa-fw fa-power-off"></i> 登出</a>
							</li>
						</ul>
					</li>
				</ul>
				
				<div class="pull-right hidden-xs">
					<form class="navbar-form" role="search" action="search.php" method="post">
						<div class="input-group ">
							<input type="text" class="form-control" style="width:120px" placeholder="搜尋字句" name="search_text">
							<span class="input-group-btn">
								<button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
							</span>
						</div><!-- /input-group -->
					</form>
				</div>
				

            <div class="navbar-default sidebar" role="navigation" style=''>
                <div class="sidebar-nav navbar-collapse">
					<ul class="nav in" id="side-menu">
						<li <? if($l1++ == 0){?>class='active'<?}?>>
							<a><i class="fa fa-fw fa-book"></i> 篇章 <span class="fa arrow"></span></a>
							<?$l2active = 0;?>
							<ul id="story_pages" class="nav nav-second-level collapse in">
<?
$cpg = $_COOKIE['page_chunk'];
//echo "SELECT `value` FROM ec_editor_settings WHERE world_id = $worldId AND setting_key = 'page_chunk'";
//var_dump($cpg);
$arrPagesPieces = array_chunk($arrPages, $cpg>0?$cpg:30);
?>
<? foreach($arrPagesPieces as $tempArrPages){?>
								<li <? if(!isset($_GET["id"]) && $l2++ == 0){?>class='active'<?}?>>
								<? 
									$end = end($tempArrPages);
									$from = trimZeroDot($tempArrPages[0]['id']);
									$to   = trimZeroDot($end['id']);
									
								?>
								<a href="#"><?=$from;?> ~ <?=$to;?> <span class="fa arrow"></span></a>
									<ul class="nav nav-third-level collapse">
									<? foreach($tempArrPages as $v){?>
										<li><a id="ida<?=str_replace(".","_",$v["id"]);?>" <? if($_GET["id"]==$v["id"]){?>class="active"<?}?> href="editfile.php?id=<?=$v['id']; ?>">
										<?=trimZeroDot($v['id']); ?>. <?=$v['title']; ?></a></li>
									<?}?>
									</ul>
								</li>
<?}?>
							</ul>
						</li>
						<li>
							<a href="addpage.php"><i class="fa fa-plus"></i> 加新篇章</a>
						</li>
					</ul>
				</div>
			</div>
			</nav>
			
			<div id="page-wrapper" style=''>
				<div class="container-fluid" style="">
					<? include(dirname(__FILE__)."/".$wrapin . ".php");?>
				</div>
			</div>
			<!-- /#page-wrapper -->
			
		</div>
		<!-- /#wrapper -->
		
<?=gaScript();?>
	</body>
	
</html>
