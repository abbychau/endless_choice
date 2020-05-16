<?php

	setcookie("EC_WID","",time()-3600);
	setcookie("EC_USER","",time()-3600);
	setcookie("EC_READONLY","",time()-3600);
	setcookie("admin_selected_page",0,time()-3600);
	if(stristr($_SERVER['HTTP_REFERER'],"story_admin")){
		header("location:/story_admin/");
	}else{
		header("location:index.php");
	}