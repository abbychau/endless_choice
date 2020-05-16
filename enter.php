<?php
$worldid = isset($_POST['worldid'])?$_POST['worldid']:(isset($_GET['worldid'])?$_GET['worldid']:"pRandom");
header("location:pages/enter.php?worldid=".$worldid);
?>