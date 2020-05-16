<?
include 'include/sqldata.php';
if(!session_id()) {
    session_start();
}
$fb = new Facebook\Facebook($fbSettings);

$helper = $fb->getRedirectLoginHelper();

$permissions = ['email']; // Optional permissions
$loginUrl = $helper->getLoginUrl('https://ec.abby.md/fb_callback.php?next=index', $permissions);
header("location:".$loginUrl);
