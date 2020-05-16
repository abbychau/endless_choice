<?php 
	
	require_once('../include/sqldata.php'); 
	require_once('chksess.php');
	
	$editFormAction = $_SERVER['PHP_SELF'];
	if (isset($_SERVER['QUERY_STRING'])) {
		$editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
	}

	if (!isset($_GET['id'])) {
		screenMessage("Error","ID not specified.");
	}
	if ((isset($_GET["page"])) && is_numeric($_GET["page"]) && $_GET["delete"] == "1") {
		dbQuery("DELETE FROM ec_pages WHERE id = {$_GET['page']} AND wid = {$worldid}");
		header("Location: message.php?type=3");
		exit;
	}
	if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
		$chk = sprintf("SELECT count(1) FROM ec_pages WHERE id = %s AND wid = $worldid", GetSQLValueString($_POST['frameid'], "int"));
		$cnt = dbRs($chk);
		if($cnt > 1){
			die("Duplicated Frame ID ".$_POST['frameid']);
		}
		
	    $_POST['trail'] = isset($_POST['trail'])?1:0;
	    unset($_POST['MM_update']);
	    unset($_POST['color2']);
	    unset($_POST['Submit']);
// 		print_r(array_keys($_POST));
		//Array ( [0] => serial [1] => frameid [2] => title [3] => content [4] => js [5] => c1 [6] => c1to [7] => c2 [8] => c2to [9] => c3 [10] => c3to [11] => c4 [12] => c4to [13] => c5 [14] => c5to [15] => c6 [16] => c6to [17] => typing [18] => Submit [19] => trail )
		$count = dbRs("SELECT count(1) FROM ec_pages WHERE id = :frameid AND wid = :worldid AND serial != :serial",
		[
		    'frameid'=>$_POST['frameid'],'serial'=>$_POST['serial'],'worldid'=>$worldid
		]);
        if($count==1){
            screenMessage('Error','you are changing to an existing frame id');
        }
		dbQuery("UPDATE ec_pages SET id=:frameid, title=:title, content=:content, c1=:c1, c2=:c2, c3=:c3, c4=:c4, c5=:c5, c6=:c6, c1to=:c1to, c2to=:c2to, c3to=:c3to, c4to=:c4to, c5to=:c5to, c6to=:c6to, js=:js, typing=:typing, trail=:trail WHERE serial=:serial",
		    $_POST
		);
		dbQuery("UPDATE ec_system set lastupdate = '".gmdate("Y-m-d H:i:s", time()+28800)."' where id = $worldid");
		
		if(isset($_COOKIE["published"])){
			$expire=time()+60*60*12;
			setcookie("published", "true", $expire);
			if($fbme && false){
				$statusUpdate = $facebook->api('/me/feed', 'post', array('message'=> '我的Endless Choice 章節 - '.GetSQLValueString($_POST['title'], "text").'己更新!', 'link' => 'http://ec.abby.md/pages/enter.php?worldid='.$pWid));
			}
			addNews($gUsername,$_POST['title'],3,'http://ec.abby.md/pages/enter.php?worldid='.$pWid);
		}

				
		$updateGoTo = $editFormAction;
		if (isset($_SERVER['QUERY_STRING'])) {
			$updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
			$updateGoTo .= $_SERVER['QUERY_STRING'];
		}
		header("Location: "."message.php?type=2&worldid=$worldid&id={$_POST['frameid']}&title=".urlencode($_POST['title']));
	}
	
	$pageInfo = dbRow("SELECT * FROM ec_pages WHERE wid=:worldid AND round(id,3) = :page_id",
	['worldid'=>$worldid,'page_id'=>floatval($_GET['id'])]);
	$varList = dbAr("SELECT * FROM ec_variables where wid = $worldid ORDER BY varname");

	if(!$pageInfo){
		screenMessage("Error","This page has not been created yet.<br /><a style='padding:0.5em;background:#EEE;text-decoration:none;border:1px solid black;display:block' href='addpage.php?id={$_GET['id']}'>按我新建ID為{$_GET['id']}的頁面</a>");
	}
	$wrapin=basename($_SERVER["SCRIPT_FILENAME"], '.php');
	include_once("template/frame.php");
