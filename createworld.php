<?php
	require_once('include/sqldata.php');
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

if($error == 1){
$fb = new Facebook\Facebook($fbSettings);

$helper = $fb->getRedirectLoginHelper();

$permissions = ['email']; // Optional permissions
 $loginUrl= $helper->getLoginUrl('https://ec.abby.md/fb_callback.php?next=create', $permissions);

	header("location:$loginUrl");
	exit;
}

$htmltitle="申請Endless Choice 新劇本";


$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {


	$insertSQL = sprintf("INSERT INTO ec_system (name, author,author_fbid,author_email, password, conclusion) VALUES (%s, %s, %s, %s, %s, %s)",
						 GetSQLValueString($_POST['name'], "text"),
						 GetSQLValueString($_POST['username'], "text"),
						 GetSQLValueString($user['id'], "text"),
						 GetSQLValueString($user['email'], "text"),
						 GetSQLValueString($_POST['password'], "text"),
						 GetSQLValueString($_POST['conclusion'], "text"));

	$newId = dbQuery($insertSQL);
	dbQuery("INSERT INTO ec_pages (`wid`, `id` , `title` , `content` , `count` , `c1` , `c2` , `c3` , `c4` , `c5` , `c6` , `c1to` , `c2to` , `c3to` , `c4to` , `c5to` , `c6to` ) VALUES ($newId, 1, '測試頁', '測試頁', '1', '測試頁', NULL , NULL , NULL , NULL , NULL , '1', NULL , NULL , NULL , NULL , NULL );");

	screenMessage("完成", "已成功申請Endless Choice 新劇本, 你的劇本編號為 $newId 。<br />你可以到Story Admin 編輯器開始編輯了。<br />先在下面登入吧！", "//ec.abby.md/");

}

?>
<?php include("templateblock/header.php");?>
<h1>申請Endless Choice 新劇本</h1>
<div class="well">
  <form action="<?php echo $editFormAction; ?>" id="form1" name="form1" method="POST">

     <label>劇本名: <input required type="text" name="name" id="name" class='form-control' size="50"  /></label>

  <br />


  <label>劇本介紹(可選): <br />
  <textarea name="conclusion" cols="50" rows="10"  class='form-control'></textarea>
  </label>
  <br />
  <label>作者名 :
<input type="text" name="username" class='form-control' required />

 </label>
  <label>密碼 :
    <input type="password" name="password" class='form-control' required />
  </label>
  <br />
  注意：<br />
<ul>
<li>EC 登入使用Facebook 認證</li>
<li>每個劇本都要用密碼二次認證</li>
<li>劇本在申請後三個月仍在試用階段(頁面不足10, 字數不足1000) 將可能被移除</li>
<li>申請後會自動跳到Endless Choice 的首頁，請嘗試登入。</li>
</ul>
  <label>
    <input type="submit" name="submit" id="submit" value="提交" class="btn btn-primary" />
  </label>
  <input type="hidden" name="MM_insert" value="form1" />
</form>

</div>

<?php include("templateblock/footer.php");?>


