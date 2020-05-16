<?php
	require_once('../include/sqldata.php');
	require_once('chksess.php');
	
	$editFormAction = $_SERVER['PHP_SELF'];
	if (isset($_SERVER['QUERY_STRING'])) {
		$editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
	}
	
	
	
	
	if (isset($_POST["confirm"]) && !$_COOKIE['EC_READONLY']){
		
		$updateSQL = sprintf("UPDATE ec_system SET name=%s, conclusion=%s, entertext=%s, tid=%s, facebook_page=%s, ap_max=%s, ap_recovery_per_hour=%s, admob_id=%s WHERE id=%s",
		GetSQLValueString($_POST['name'], "text"),
		GetSQLValueString($_POST['conclusion'], "text"),
		GetSQLValueString($_POST['entertext'], "text"),
		GetSQLValueString($_POST['tid'], "int"),
		GetSQLValueString($_POST['facebook_page'], "text"),
		GetSQLValueString($_POST['ap_max'], "int"),
		GetSQLValueString($_POST['ap_recovery_per_hour'], "int"),
		GetSQLValueString($_POST['admob_id'], "text"),
		$worldId);
		
		dbQuery($updateSQL);
		
		header("location:/story_admin/");
		exit;
	}
	
	$row_Recordset1 = dbRow("SELECT * FROM ec_system WHERE id = $worldId");
    $wordCount = dbRs("select sum(CHAR_LENGTH(content)+CHAR_LENGTH(title)+CHAR_LENGTH(c1)) from ec_pages where wid = $worldid");
    dbQuery("REPLACE INTO ec_stat VALUES($worldid,NOW(),$wordCount)");
	
	
	$arrPages = dbAr("SELECT * FROM ec_pages WHERE wid = $worldId ORDER BY id ASC");
	
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
		<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://cdn.rawgit.com/knsv/mermaid/7.0.0/dist/mermaid.css" />
		
		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
		<!-- jQuery -->
		<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/startbootstrap-sb-admin-2/3.3.7+1/js/sb-admin-2.min.js"></script>
		
		<script src='https://cdn.rawgit.com/knsv/mermaid/7.0.0/dist/mermaid.min.js'></script>
		<script src='https://cdn.rawgit.com/anvaka/panzoom/v2.5.0/dist/panzoom.min.js'></script>
		<script>
			function setCookie(cname, cvalue, exdays) {
				var d = new Date();
				d.setTime(d.getTime() + (exdays*24*60*60*1000));
				var expires = "expires="+d.toUTCString();
				document.cookie = cname + "=" + cvalue + "; " + expires;
			}
			function getCookie(cname) {
				var name = cname + "=";
				var decodedCookie = decodeURIComponent(document.cookie);
				var ca = decodedCookie.split(';');
				for(var i = 0; i <ca.length; i++) {
					var c = ca[i];
					while (c.charAt(0) == ' ') {
						c = c.substring(1);
					}
					if (c.indexOf(name) == 0) {
						return c.substring(name.length, c.length);
					}
				}
				return "";
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
		<script>
			var ori = '<?=$_GET['ori']==''?'LR':$_GET['ori'];?>';
			var tol = '<?=$_GET['tol']==''?'20':intval($_GET['tol']);?>';
			//getCookie('ori')==""?'TD':getCookie('ori');
			
			mermaid.initialize({
				startOnLoad:false,
				logLevel : 0
			});
			function toRightFrame(href){
				
				$("#right_iframe").attr('src',href);
			}
			function getGraph(ori_in){
				$.get("api.php?action=getGraphDefinition&ori="+ori_in+"&tol="+tol,function(graphDefinition){
					var domName = 'graphDiv'+Date.now();
					var graph = mermaidAPI.render(domName, graphDefinition, 
					
					function(svgCode, bindFunctions){
						
						$(".mermaid").html("");
						$(".mermaid").html(svgCode);
						
						$('#'+domName)
						.css('background-color','#eee')
						.css('outline','none')
						.css('width','100%')
						.css('max-width','none')
						
						$('[rx]').attr('rx',3);
						$('[ry]').attr('ry',3);
						var a = $('g.output');
						panzoom(a[0])
						//$("div#graphDiv").css("height",$("#page-wrapper").height());
						//$("svg#graphDiv").css("height",$("#page-wrapper").height());
						//var svg = document.querySelector('#graphDiv').outerHTML;
						
						//$("#dlbtn").attr('href','data:image/svg+xml;base64,' + utoa(svg));
					}
					
					);
					//$("#dgraphDiv").remove();
					$('.nodes').find('[id]').click(
					function(){
						
						$('.nodes').find('[id]').find('rect').removeClass('activeNode');
						$('.nodes').find('[id]').find('g').removeClass('activeNodeLabel');
						$(this).find('rect').addClass('activeNode');
						$(this).find('g').addClass('activeNodeLabel');
						
						toRightFrame('editfile.php?id='+$(this).attr('id'));
					}
					);
				});
			}
			
			$(function(){
				
				$('[data-href]').click(function(){
					toRightFrame($(this).attr('data-href'));
				});
				$('#editor_toggle').click(function(){
					$('#right_iframe').toggle();
					$(".editor_window").toggleClass('editor_window_on');
				});
				
				getGraph()
				
			});
			
		</script>
		<style>
			.node rect, .node circle, .node ellipse, .node polygon {
			fill: #f5f5f5;
			stroke: #999;
			}
			.activeNode{ fill: #444!important;
			stroke: #999!important;}
			.activeNodeLabel{
			
			color:#FDFDFD
			}
			body{background-color:white;overflow:hidden}
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
			.side-nav > li > ul > li > a {  padding: 2px 2px 2px 15px; font-size: 9pt;}
		</style>
		<style>.label{font-size:100%}
			a,.node{cursor:pointer}
		</style>
	</head>
	
	<body>
		
		<div id="wrapper">
			
			<nav class="navbar navbar-default navbar-top" role="navigation" style="margin-bottom: 0">
				
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="index.php"><i class="fa fa-dashboard"></i> 無盡的選擇 - <?=$worldInfo["name"];?></a>
				</div>
				
				<ul class="nav navbar-top-links navbar-right">
					<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-fw fa-wrench"></i> <b class="caret"></b></a>
						
						<ul class="dropdown-menu dropdown-messages">
							<?if($_COOKIE['EC_READONLY'] != 1){?>
								<li><a data-href="addpage.php"><i class="fa fa-fw fa-plus"></i> 加新篇章</a></li>
								<li class="divider"></li>
								<li><a data-href="viewvariables.php"><i class="fa fa-fw fa-code"></i> 檢視變數</a></li>
								<li><a data-href="setcss.php"><i class="fa fa-fw fa-paint-brush"></i> 設定主題和背景音樂</a></li>
								<li><a data-href="worldinfo.php"><i class="fa fa-fw fa-bar-chart-o"></i> 設定劇本和作者資訊</a></li>
								
							<?}?>
						</ul>
					</li>
					<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?=$worldInfo["author"];?> <b class="caret"></b></a>
						<ul class="dropdown-menu dropdown-messages">
							
							<li>
								<a data-href="export.php?type=tree"><i class="fa fa-caret-square-o-down"></i> 檢視選擇樹</a>
							</li>
							<li>
								<a data-href="export.php?type=text" target="_blank"><i class="fa fa-caret-square-o-down"></i> 匯出到文字檔</a>
							</li>
							<li>
								<a data-href="../enter.php?worldid=<?=$worldId; ?>"><i class="fa fa-fw fa-eye"></i> 預覽故事</a>
							</li>
							<li class="divider"></li>
							<li><a data-href="fb_linkup.php">連結此故事到我的Facebook 賬戶</a></li>
							<li>
								<a href="/"><i class="fa fa-fw fa-power-off"></i> 回到首頁</a>
							</li>
						</ul>
					</li>
				</ul>
				
				<div class="pull-right hidden-xs">
					<form class="navbar-form" role="search" action="search.php" method="post" target='right_iframe'>
						<div class="input-group ">
							<input type="text" class="form-control" value="<?=$_POST['search_text']; ?>" style="width:100px" placeholder="搜尋字句" name="search_text">
							<span class="input-group-btn">
								<button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
							</span>
						</div><!-- /input-group -->
					</form>
				</div>
				<div class="pull-right hidden-xs">
					<form class="navbar-form" role="search" action="search.php" method="post" target='right_iframe'>
						<div class="input-group ">
							<input name="search_choice" type="text" class="form-control" value="<?=$_POST['search_choice']; ?>" style="width:100px"  placeholder="搜尋選擇"/>
							<span class="input-group-btn">
								<button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
							</span>
						</div>
					</form>
					
				</div>
				
				
			</nav>
			<div class="mermaid" style='position: fixed;width:100%;border:0;height:calc(100vh - 52px)'></div>
			<style>
				.editor_window_on{height:calc(100vh - 90px);width:50%;}
				.editor_window_off{height:auto;width:auto;}
			</style>
			<script>
				
				
			</script>
			<div class="editor_window editor_window_on" style="position: fixed;right: 1em;top: 70px;">
				<a id='editor_toggle' class='btn btn-default btn-sm' style='display:block;float:right'>切換顯示編輯區</a>
				<iframe id='right_iframe' name='right_iframe' src='worldinfo.php' style='border-radius:3px;clear:both;width:100%;border:0;height:calc(100vh - 110px);background:white;opacity:0.95'></iframe>
			</div>		
			<div id="page-wrapper" style='margin:1em'>
				
				
			</div>
			<!-- /#page-wrapper -->
			
		</div>
		<!-- /#wrapper -->
		
		
		
		
		<!-- Button trigger modal -->
		<div style='position:fixed;left:1em;bottom:1em'>
			<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
				<i class="fa fa-wrench" aria-hidden="true"></i> 圖表選項
			</button>
			<button type="button" class="btn btn-primary" onclick='getGraph("TD")'>
				<i class="fa fa-hand-o-down" aria-hidden="true"></i> 
			</button>
			<button type="button" class="btn btn-primary" onclick='getGraph("LR")'>
				<i class="fa fa-hand-o-right" aria-hidden="true"></i> 
			</button>
		</div>
		<!-- Modal -->
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">圖表選項</h4>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label>Tolerance</label>
							<br />
							Fast-Forward: <input disabled class="form-control" name='tol_ff' type="number" min='1' max='10000' value='<?=intval($_COOKIE['tol_ff'])?intval($_COOKIE['tol_ff']):12?>' />
							Scrolling-Back: <input disabled class="form-control" name='tol_sb' type="number" min='1' max='10000' value='<?=intval($_COOKIE['tol_sb'])?intval($_COOKIE['tol_sb']):100?>' />
						</div>
						<!--
							<div class="form-group">
							<label>Orientation</label>
							<div class="radio">
							<label>
							<input type="radio" name="ori" id="ori1" value="TD" checked>Top-Down
							</label>
							</div>
							<div class="radio">
							<label>
							<input type="radio" name="ori" id="ori2" value="LR">Left-to-Right
							</label>
							</div>
							</div>
						-->
						<div class="form-group">
							<label><input name='show_choice_on_arrow' type="checkbox" <?=$_COOKIE['show_choice_on_arrow']=='1'?'checked':'';?> /> Show Choice Number on arrows</label>
						</div>
						
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal" onclick='resetChartOption()'>Close</button>
						<button type="button" class="btn btn-primary" data-dismiss="modal" onclick='saveChartOptions()'>Save changes</button>
					</div>
				</div>
			</div>
		</div>
		
		<script>
			function resetChartOption(){
				if(getCookie('show_choice_on_arrow') == 1){
					$('.myCheckbox').prop('checked', true);
					}else{
					$('.myCheckbox').prop('checked', false);
				}
				
			}
			function saveChartOptions(){
				//setCookie('ori', $('[name=ori]:checked').val());
				//setCookie('tol_ff', $('[name=tol_ff]').val());
				//setCookie('tol_sb', $('[name=tol_sb]').val());
				if($('[name=show_choice_on_arrow]').is(":checked")){
					setCookie('show_choice_on_arrow', 1);
					}else{
					setCookie('show_choice_on_arrow', 0);
				}
				getGraph()
			}
		</script>
		
		
		
		
		
		<?=gaScript();?>
	</body>
	
</html>
