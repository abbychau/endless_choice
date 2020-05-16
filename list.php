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
<?php foreach($allStories as $v) { ?>
  <tr>
    <td><?php echo $v['id']; ?></td>
    <td>
    <a href="enter.php?worldid=<?php echo $v['id']; ?>" style="font-weight:bold;">
	<?php echo htmlspecialchars($v['name']); ?></a>
    </td>
    <td><?php echo htmlspecialchars($v['author']); ?></td>
    <td><?=timeago(strtotime($v['lastupdate'])) ?></td>
    <td>
	<?php $one = ($v['count']>=50000)?"color:#FF0000":"";	$two = ($v['count']>=10000)?"font-weight:bold":"";
	echo ("<span style='$two;$one'>".$v['count']."</span>") ?></td>
    
    
  </tr>
  <tr>
  <td colspan='5'>
  <?=$v['conclusion']?></td></tr>
<?php } ?>
</tbody>
</table>

<script>$("#top-nav li:nth-child(2)").addClass('active');</script>
<?php include("templateblock/footer.php");?>