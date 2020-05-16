<?php
	if(isset($_GET["from_app"])){
		setcookie("asset_path","file:///android_asset/",time()+1000000);
	}
	if(!isset($_COOKIE["EC_WID"])){
		header("location:login.php");
	}
	$worldId 	= $pWid?intval($pWid):die("PLX LOGIN");
	$worldid = $worldId;
	
	
