<?php 
	
	require_once('../include/sqldata.php'); 
	require_once('chksess.php');
	
	$editFormAction = $_SERVER['PHP_SELF'];
	if (isset($_SERVER['QUERY_STRING'])) {
		$editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
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
		
		$updateSQL = sprintf("UPDATE ec_pages SET id=%s, title=%s, content=%s, c1=%s, c2=%s, c3=%s, c4=%s, c5=%s, c6=%s, c1to=%s, c2to=%s, c3to=%s, c4to=%s, c5to=%s, c6to=%s, js=%s, typing=%s, trail=%s WHERE serial=%s",
		GetSQLValueString($_POST['frameid'], "text"),
		GetSQLValueString($_POST['title'], "text"),
		GetSQLValueString($_POST['content'], "text"),
		GetSQLValueString($_POST['c1'], "text"),
		GetSQLValueString($_POST['c2'], "text"),
		GetSQLValueString($_POST['c3'], "text"),
		GetSQLValueString($_POST['c4'], "text"),
		GetSQLValueString($_POST['c5'], "text"),
		GetSQLValueString($_POST['c6'], "text"),
		GetSQLValueString($_POST['c1to'], "text"),
		GetSQLValueString($_POST['c2to'], "text"),
		GetSQLValueString($_POST['c3to'], "text"),
		GetSQLValueString($_POST['c4to'], "text"),
		GetSQLValueString($_POST['c5to'], "text"),
		GetSQLValueString($_POST['c6to'], "text"),
		GetSQLValueString($_POST['js'], "text"),
		GetSQLValueString($_POST['typing'], "int"),
		isset($_POST['trail'])?1:0,
		GetSQLValueString($_POST['serial'], "int")
		
		);
		
		dbQuery($updateSQL);
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
		header("Location: "."message.php?type=2&worldid=$worldid&id=".$_POST['frameid']);
	}
	
	$query_EditHistory = sprintf("SELECT * FROM ec_pages WHERE wid=$worldid AND round(id,3) = %s", floatval($_GET['id']));
	$pageInfo = dbRow($query_EditHistory);
	
	if(!$pageInfo){
		screenMessage("Error","This page has not been created yet.<br /><a style='padding:0.5em;background:#EEE;text-decoration:none;border:1px solid black;display:block' href='addpage.php?id={$_GET['id']}'>按我新建ID為{$_GET['id']}的頁面</a>");
	}
	$wrapin=basename($_SERVER["SCRIPT_FILENAME"], '.php');
	include_once("template/frame.php");
