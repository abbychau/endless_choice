<?php
	setcookie("EC_WID","",time()-3600);
	setcookie("EC_USER","",time()-3600);
	setcookie("EC_READONLY","",time()-3600);
	
	header('Location: ../index.php');
?>