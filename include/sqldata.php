<?php
	error_reporting(E_ALL & ~E_NOTICE);
	require_once __DIR__ . '/credentials.php';
	require_once __DIR__ . '/../vendor/autoload.php';
	require_once __DIR__ . "/functions.php";

	$dbh = new PDO("mysql:dbname=ec;host=localhost", "ec", "aassddff");
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

	//dbConnect();
	
	$pWid		= decrypt($_COOKIE['EC_WID']);
	$pUser		= decrypt($_COOKIE['EC_USER']);
	
	$worldid	= $_REQUEST['worldid'] == ""?"0":$_REQUEST['worldid'];
	$worldid	= intval($worldid);
	
	$id 		= $_REQUEST['id'] == ""?1:$_REQUEST['id'];
	$id = floatval($id);
		
	if($_GET['app'] == "1" || $_COOKIE['is_app'] == "1"){
		setcookie("is_app", "1", time()+3600*24*365);
		$isApp = true;
	}else{
		$isApp = false;
	}
	
