<?php
	
	include("../include/sqldata.php");
	
	
	session_start();
	$fb = new Facebook\Facebook($fbSettings);

	try {
	  // Returns a `Facebook\FacebookResponse` object
	  $response = $fb->get('/me?fields=id,name,email', $_SESSION['fb_access_token']);
	  $user = $response->getGraphUser();
	} catch(Facebook\Exceptions\FacebookResponseException $e) {
	  $error = 1;
	} catch(Facebook\Exceptions\FacebookSDKException $e) {
	  $error = 1;
	}
	//print_r($user);
	//echo $pWid."X".$worldid;
	//exit;
	if($error == 1){
	

		$helper = $fb->getRedirectLoginHelper();

		$permissions = ['email']; // Optional permissions
		$loginUrl = $helper->getLoginUrl('https://ec.abby.md/fb_callback.php?next=linkup', $permissions);
		header("location:".$loginUrl);
	}else{
		dbQuery("update ec_system set author_fbid = '{$user['id']}',author_email = '{$user['email']}'  WHERE id = '{$pWid}'");
		
		screenMessage("成功連結","已成功連結。","/story_admin");
	}
	