<?php 
header("content-type:text/plain");
	include("../../lib/common_init.php");
	$worldid = $_GET['worldid'];
	
	$arr = dbAr("SELECT * FROM ec_pages WHERE wid=$worldid");
?>
<?php foreach($arr as $row_EditHistory){?>

 WorldID: <?=$worldid;?>
 Serial:  <?=$row_EditHistory['serial']; ?>
 FrameID: <?=floatval($row_EditHistory['id']); ?>
 Title:   <?=$row_EditHistory['title']; ?>

========= CONTENT ==========
<?=($row_EditHistory['content']); ?>

==========  J  S  ==========
<?=($row_EditHistory['js'])==""?"(EMPTY)":$row_EditHistory['js']; ?>

============================
C1: <?=htmlspecialchars($row_EditHistory['c1']); ?>
C1TO: <?=$row_EditHistory['c1to']; ?>
C2: <?=htmlspecialchars($row_EditHistory['c2']); ?>
C2TO: <?=$row_EditHistory['c2to']; ?>
C3: <?=htmlspecialchars($row_EditHistory['c3']); ?>
C3TO: <?=$row_EditHistory['c3to']; ?>
C4: <?=htmlspecialchars($row_EditHistory['c4']); ?>
C4TO: <?=$row_EditHistory['c4to']; ?>
C5: <?=htmlspecialchars($row_EditHistory['c5']); ?>
C5TO: <?=$row_EditHistory['c5to']; ?>
C6: <?=htmlspecialchars($row_EditHistory['c6']); ?>
C6TO: <?=$row_EditHistory['c6to']; ?>
============================
Typing: <?=$row_EditHistory['typing']; ?>

<?}?>