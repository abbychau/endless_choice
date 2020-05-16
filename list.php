<?php 
require_once('include/sqldata.php'); 

$allStories = dbAr("SELECT id, name, tid, author, count, conclusion, lastupdate FROM ec_system WHERE enable > 0 ORDER BY count DESC");
include("templateblock/header.php");?>


<script type="text/javascript"><!--
google_ad_client = "pub-2146633441538112";
/* 728x90, 已建立 2009/8/14 */
google_ad_slot = "9239766567";
google_ad_width = 728;
google_ad_height = 90;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script><br />

<table class="table">
	<thead>
  <tr>
    <td><strong>編號</strong></td>
    <td><strong>劇本名</strong></td>
    <td><strong>作者</strong></td>
    <td><strong>最後更新日期</strong></td>
    <td><strong>人氣</strong></td>
  </tr>
  </thead>
  <tbody>
<?php foreach($allStories as $row_Recordset1) { ?>
  <tr>
    <td><?php echo $row_Recordset1['id']; ?></td>
    <td>
    <a href="enter.php?worldid=<?php echo $row_Recordset1['id']; ?>" style="font-weight:bold;">
	<?php echo htmlspecialchars($row_Recordset1['name']); ?></a>
    </td>
    <td><?php echo htmlspecialchars($row_Recordset1['author']); ?></td>
    <td><?=timeago(strtotime($row_Recordset1['lastupdate'])) ?></td>
    <td>
	<?php $one = ($row_Recordset1['count']>=50000)?"color:#FF0000":"";	$two = ($row_Recordset1['count']>=10000)?"font-weight:bold":"";
	echo ("<span style='$two;$one'>".$row_Recordset1['count']."</span>") ?></td>
    
    
  </tr>
  <tr>
  <td colspan='5'>
  <?=$row_Recordset1['conclusion']?></td></tr>
<?php } ?>
</tbody>
</table>

<script>$("#top-nav li:nth-child(2)").addClass('active');</script>
<?php include("templateblock/footer.php");?>