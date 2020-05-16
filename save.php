<?php
	function asc_shift($str,$offset=0) {
		$new = '';
		for ($i = 0; $i < strlen($str); $i++)
        $new .= chr(ord($str[$i])+$offset);
		return $new;
	}
	if (isset($_POST['id'])) {
		$id = $_POST['id'];
	}
	if (isset($_POST['worldid'])) {
		$worldid = $_POST['worldid'];
	}
	if (isset($_POST['saveStr'])) {
		$nStr = $_POST['saveStr'];
	}
	
	$newPass = asc_shift(base64_encode($nStr), -1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>儲存信息</title>
		
	</head>
	
	<body>
		<fieldset>
			<legend>儲存信息</legend>
			Saved...<br />
			Password is: <br />
			<div style="border:#CCC 1px dashed; width:600px; word-wrap: break-word">
				<strong><?php echo $newPass; ?></strong>
			</div>
			<p>
				<label>
					<input type=button value="Back to Index" onclick="window.open('index.php', '_parent')" />
				</label>
				<label>
					<input type=button value="Back and Continue" onclick="history.go(-1)" />
				</label>
			</p>
		</fieldset>
		<p>
			<label></label>
		</p>
	</body>
</html>
