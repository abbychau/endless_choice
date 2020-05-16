<?php 
	header("Content-type: application/xml");
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>
<rss version='2.0'>
  <channel>
    <title>無盡的選擇 - Endless Choice</title>
    <link>http://ec.abby.md</link>
    <description>Endless Choice 最新更新</description>
	<pubDate>".date("r")."</pubDate>
    <lastBuildDate>".date("r")."</lastBuildDate>";
	
		//START ITEMS
		require_once('include/sqldata.php');
		$query_Recordset3 = "SELECT name, lastupdate, id, author,conclusion FROM ec_system where `enable` > 0 ORDER BY lastupdate DESC limit 15";
		$Recordset3 = dbAr($query_Recordset3);
		
		foreach($Recordset3 as $row_Recordset3) {
		echo "<item>\n";
		echo "<title>".htmlspecialchars($row_Recordset3['name'])."</title>\n";
		echo "<link>http://ec.abby.md/enter.php?worldid=".$row_Recordset3['id']."</link>\n";
		echo "<description>
		<![CDATA[
		作者:".$row_Recordset3['author']."　最後更新:".$row_Recordset3['lastupdate']."<br />
		簡介:<br />".nl2br($row_Recordset3['conclusion'])."
		]]>
		</description>";
		echo "</item>\n";
		}
		
		//END ITEMS
	echo "\n</channel>\n</rss>";
