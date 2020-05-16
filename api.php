<?php
	require_once('include/sqldata.php'); 
	$q = dbAr("SELECT * FROM ec_pages WHERE wid = 1 ORDER BY id ASC");
	echo json_encode($q,JSON_UNESCAPED_UNICODE);