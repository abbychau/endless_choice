<?php 
	
	require_once('../include/sqldata.php'); 
	if($pWid != $worldid){die($_COOKIE['EC_SESS']."|".$worldid);}	
	
	$editFormAction = $_SERVER['PHP_SELF'];
	if (isset($_SERVER['QUERY_STRING'])) {
		$editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
	}
	
	if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
		$chk = sprintf("SELECT id FROM ec_pages WHERE id = %s AND wid = $worldid", GetSQLValueString($_POST['frameid'], "int"));
		$cnt = mysql_query($chk);
		$num = mysql_num_rows($cnt);
		if($num > 1){
			mysql_free_result($cnt);
			die("Duplicated Frame ID ".$_POST['frameid']);
		}
		
		$updateSQL = sprintf("UPDATE ec_pages SET id=%s, title=%s, content=%s, c1=%s, c2=%s, c3=%s, c4=%s, c5=%s, c6=%s, c1to=%s, c2to=%s, c3to=%s, c4to=%s, c5to=%s, c6to=%s, js=%s, typing=%s WHERE serial=%s",
		GetSQLValueString($_POST['frameid'], "text"),
		GetSQLValueString($_POST['title'], "text"),
		GetSQLValueString($_POST['content'], "text"),
		GetSQLValueString($_POST['c1'], "text"),
		GetSQLValueString($_POST['c2'], "text"),
		GetSQLValueString($_POST['c3'], "text"),
		GetSQLValueString($_POST['c4'], "text"),
		GetSQLValueString($_POST['c5'], "text"),
		GetSQLValueString($_POST['c6'], "text"),
		GetSQLValueString($_POST['c1to'], "text"),
		GetSQLValueString($_POST['c2to'], "text"),
		GetSQLValueString($_POST['c3to'], "text"),
		GetSQLValueString($_POST['c4to'], "text"),
		GetSQLValueString($_POST['c5to'], "text"),
		GetSQLValueString($_POST['c6to'], "text"),
		GetSQLValueString($_POST['js'], "text"),
		GetSQLValueString($_POST['typing'], "int"),
		GetSQLValueString($_POST['serial'], "int"));
		
		$Result1 = dbQuery($updateSQL);
		
		dbQuery("UPDATE ec_system set lastupdate = '".gmdate("Y-m-d H:i:s", time()+28800)."' where id = $worldid");
		
		if($fbme && !isset($_COOKIE["published"])){
			$expire=time()+60*60*12;
			setcookie("published", "true", $expire);
			$statusUpdate = $facebook->api('/me/feed', 'post', array('message'=> '我的Endless Choice 章節 - '.GetSQLValueString($_POST['title'], "text").'己更新!', 'link' => 'http://ec.abby.md/pages/enter.php?worldid='.$pWid));	
			
		}
		
		$updateGoTo = $editFormAction;
		if (isset($_SERVER['QUERY_STRING'])) {
			$updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
			$updateGoTo .= $_SERVER['QUERY_STRING'];
		}
		header("Location: "."message.php?type=2&worldid=$worldid&id=".$_POST['frameid']);
	}
	
	$colname_EditHistory = "-1";
	if (isset($_GET['id'])) {
		$colname_EditHistory = $_GET['id'];
	}
	$query_EditHistory = sprintf("SELECT * FROM ec_pages WHERE wid=$worldid AND round(id,3) = %s", GetSQLValueString($colname_EditHistory, "double"));
	$EditHistory = mysql_query($query_EditHistory, $conn) or die(mysql_error());
	$row_EditHistory = mysql_fetch_assoc($EditHistory);
	$totalRows_EditHistory = mysql_num_rows($EditHistory);
	
	if($totalRows_EditHistory == 0){
		die("This page has not been created yet.");
	}
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Edit Page</title>
		<link rel="stylesheet" type="text/css" href="/editor/editor.css" />
		
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
		
		<script type="text/javascript" src="http://cdn.topost.me/autosize-1.11/jquery.autosize-min.js"></script>
		
	</head>
	
	<body>
		<form id="form2" name="form2" method="post" action="../pages/pages.php">
			<input type="hidden" name="id" id="id" value="<?php echo $id ?>" />
			<input type="hidden" name="worldid" id="worldid" value="<?php echo $worldid; ?>" />
			<script type="text/javascript">function save_page(page){document.form2.id.value=page;}</script>  
			<a onclick="save_page(<?php echo $row_EditHistory['id']; ?>);form2.submit()">[預覽]</a>
			<a onclick="clear_all();">[清空]</a>
		</form>
		
		
		<form action="<?php echo $editFormAction; ?>" id="form1" name="form1" method="POST" onsubmit="">
			<input name="serial" type="hidden" id="serial" value="<?php echo $row_EditHistory['serial']; ?>" />
			
			<fieldset>
				<legend>Frame ID: </legend>
				<input name="frameid" type="text" id="frameid" value="<?php echo floatval($row_EditHistory['id']); ?>" size="45" />
			</fieldset>
			<br />
			<fieldset>
				<legend>標題</legend>
				<input name="title" type="text" id="title" value="<?php echo $row_EditHistory['title']; ?>" size="80" />
			</fieldset>
			<br />
			<fieldset>
				<legend>內容</legend>
				
				<script type="text/javascript">
					var seltext = null;
					var sfoo = null;
					var sbar = null;
					
					function clear_all(){
						$("#frameid").val('');
						$("#title").val('');
						$("#content").html('');
						$("#c6").val('');
						$("#c6to").val('');
						$("#c5").val('');
						$("#c5to").val('');
						$("#c4").val('');
						$("#c4to").val('');
						$("#c3").val('');
						$("#c3to").val('');
						$("#c2").val('');
						$("#c2to").val('');
						$("#c1").val('');
						$("#c1to").val('');
						$("#typing").val('0');
					}
					
					function replaceit(arg){
						if (arg == 'b') {sfoo = "<b>"; sbar = "</b>";}
						if (arg == 'i') {sfoo = "<i>"; sbar = "</i>";}
						if (arg == 'u') {sfoo = "<u>"; sbar = "</u>";}
						if (arg == 'font') {sfoo = "<font size='20'>"; sbar = "</font>";}
						if (arg == 'img') {sfoo = "<img src='"; sbar = "' \/>";}
						if (arg == 'hilight') {sfoo = "<span style='background-color: " + document.form1.color2.value + "'>"; sbar = "</span>";}
						if (arg == 'color') {sfoo = "<font color=' " + document.form1.color2.value + "'>"; sbar = "</font>";}
						if (arg == 'span'){sfoo = "<span id='"; sbar="'></span>";}
						if (arg == 'samp'){sfoo = "<samp id='"; sbar="'></samp>";}
						if (arg == 'script') {sfoo = "<script>"; sbar = "<\/script>";}
						insert('content',sfoo,sbar);
						document.getElementById('content').focus();
					}
					
					function replaceit2(arg){
						if (arg == 'ec_toggle') {sfoo = "ec_toggle("; sbar = ");";}
						if (arg == 'ec_get') {sfoo = "ec_get('"; sbar = "');";}
						if (arg == 'ec_set') {sfoo = "ec_set("; sbar = ");";}
						if (arg == 'ec_push') {sfoo = "ec_push("; sbar = ");";}
						if (arg == 'ec_show') {sfoo = "ec_show("; sbar = ");";}
						if (arg == 'ec_hide') {sfoo = "ec_hide("; sbar = ");";}
						if (arg == 'dwrite') {sfoo = "dwrite('"; sbar = "');";}
						
						insert('jsf',sfoo,sbar);
						document.getElementById('jsf').focus();
					}      
					
					function insert(element, start, eind) {
						element = document.getElementById(element);
						if (document.selection) {
							element.focus();
							sel = document.selection.createRange();
							sel.text = start + sel.text + eind;
							} else if (element.selectionStart || element.selectionStart == '0') {
							element.focus();
							var startPos = element.selectionStart;
							var endPos = element.selectionEnd;
							element.value = element.value.substring(0, startPos) + start + element.value.substring(startPos, endPos) + eind + element.value.substring(endPos, element.value.length);
							} else {
							element.value += start + eind;
						}
					}
					jsfHeight = 150;
					ctHeight = 300;
					$(document).ready(function(){
						$('textarea').autosize();  
					});
				</script>
				<div style="padding:1px">
					<input type="button" name="b" value="粗體" onclick="replaceit('b');" />
					<input type="button" name="i" value="斜體" onclick="replaceit('i');" />
					<input type="button" name="u" value="底線" onclick="replaceit('u');" />
					<input type="button" name="font" value="２０號字體" onclick="replaceit('font');" />
					<input type="button" name="img" value="路徑轉換為圖片" onclick="replaceit('img');" />
					<input type="button" name="dwrite" value="+" onclick="ctHeight+=400; document.getElementById('content').style.height = ctHeight+'px';" />
					<input type="button" name="dwrite" value="-" onclick="ctHeight-=400; document.getElementById('content').style.height = ctHeight+'px';" />
				</div>
				<div style="padding:1px">
					<input type="button" name="img2" value="高亮文字" onclick="replaceit('hilight');" />
					<input type="button" name="wordcolor" value="文字顏色" onclick="replaceit('color')" />
					顏色:<input type="text" name="color2" size="20" id="pick2">
				</div>
				
				<div style="padding:1px">
					<textarea name="content" style="height:300px" cols="80" id="content" wrap="virtual"><?php echo htmlspecialchars($row_EditHistory['content']); ?></textarea>
				</div>
				<div style="padding:1px">
					<input type="button" name="script" value="script標記" onclick="replaceit('script');" />
					<input type="button" name="span" value="變數容器" onclick="replaceit('span');" />
					<input type="button" name="samp" value="隱藏容器" onclick="replaceit('samp');" />
					&nbsp;|&nbsp;
					<input type="button" name="setvar" value="代碼標記" onclick="replaceit('script');"/>
					<input type="button" name="upimg" value="上傳圖片" onclick="window.open('http://share.zkiz.com/rpgupload.php')" />
				</div>
			</fieldset>
			<br />
			<fieldset>
				<legend>EC 腳本 <a onclick="document.getElementById('js').style.display = (document.getElementById('js').style.display=='none'?'block':'none');">+</a></legend>
				<div id="js" <?php if($row_EditHistory['js']==""){?>style="display:none"<?php } ?>>
					<input type="button" name="ec_toggle" value="ec_toggle('目標框',FrameID)" onclick="replaceit2('ec_toggle');"/>
					<input type="button" name="ec_get" value="ec_get(調用變數)" onclick="replaceit2('ec_get');" />
					<input type="button" name="ec_set" value="ec_set('設定變數',數值)" onclick="replaceit2('ec_set');" />
					<input type="button" name="ec_push" value="ec_push('容器id', 變數)" onclick="replaceit2('ec_push');" />
					<input type="button" name="ec_show" value="ec_show('容器id')" onclick="replaceit2('ec_show');" />
					<input type="button" name="ec_hide" value="ec_hide('容器id')" onclick="replaceit2('ec_hide');" />
					<br />
					
					<textarea name="js" id="jsf" wrap="virtual" cols="80" style="height:150px" ><?php echo htmlspecialchars($row_EditHistory['js']); ?></textarea><br />
					<input type="button" name="dwrite" value="dwrite(印出文字)" onclick="replaceit2('dwrite');" />
					<input type="button" name="dwrite" value="+" onclick="jsfHeight+=40; document.getElementById('jsf').style.height = jsfHeight+'px';" />
					<input type="button" name="dwrite" value="-" onclick="jsfHeight-=40; document.getElementById('jsf').style.height = jsfHeight+'px';" />
					
				</div>
			</fieldset>  
			<br />  
			<fieldset>
				<legend>選項設定</legend>
				<table width="590">
					<tr>
						<td width="68" align="right">Choices</td>
						<td width="14">&nbsp;</td>
						<td width="310">Display Text</td>
						<td width="178">To Frame Number</td>
					</tr>
					<tr align="right">
						<td colspan="4"><hr size="1" /></td>
					</tr>
					<tr>
						<td align="right">1</td>
						<td>&nbsp;</td>
						<td><input name="c1" type="text" id="c1" value="<?php echo htmlspecialchars($row_EditHistory['c1']); ?>" size="40" /></td>
						<td><input name="c1to" type="text" id="c1to" value="<?php echo $row_EditHistory['c1to']; ?>" size="20" />
						<a href="editfile.php?worldid=<?php echo $worldid; ?>&amp;id=<?php echo $row_EditHistory['c1to']; ?>"><img src="../img/green-arrow-right.gif" /></a></td>
					</tr>
					<tr>
						<td align="right">2</td>
						<td>&nbsp;</td>
						<td><input name="c2" type="text" id="c2" value="<?php echo htmlspecialchars($row_EditHistory['c2']); ?>" size="40" /></td>
						<td><input name="c2to" type="text" id="c2to" value="<?php echo $row_EditHistory['c2to']; ?>" size="20" />
						<a href="editfile.php?worldid=<?php echo $worldid; ?>&amp;id=<?php echo $row_EditHistory['c2to']; ?>"><img src="../img/green-arrow-right.gif" /></a> </td>
					</tr>
					<tr>
						<td align="right">3</td>
						<td>&nbsp;</td>
						<td><input name="c3" type="text" id="c3" value="<?php echo htmlspecialchars($row_EditHistory['c3']); ?>" size="40" /></td>
						<td><input name="c3to" type="text" id="c3to" value="<?php echo $row_EditHistory['c3to']; ?>" size="20" />
						<a href="editfile.php?worldid=<?php echo $worldid; ?>&amp;id=<?php echo $row_EditHistory['c3to']; ?>"><img src="../img/green-arrow-right.gif" /></a> </td>
					</tr>
					<tr>
						<td align="right">4</td>
						<td>&nbsp;</td>
						<td><input name="c4" type="text" id="c4" value="<?php echo htmlspecialchars($row_EditHistory['c4']); ?>" size="40" /></td>
						<td><input name="c4to" type="text" id="c4to" value="<?php echo $row_EditHistory['c4to']; ?>" size="20" />
						<a href="editfile.php?worldid=<?php echo $worldid; ?>&amp;id=<?php echo $row_EditHistory['c4to']; ?>"><img src="../img/green-arrow-right.gif" /></a> </td>
					</tr>
					<tr>
						<td align="right">5</td>
						<td>&nbsp;</td>
						<td><input name="c5" type="text" id="c5" value="<?php echo htmlspecialchars($row_EditHistory['c5']); ?>" size="40" /></td>
						<td><input name="c5to" type="text" id="c5to" value="<?php echo $row_EditHistory['c5to']; ?>" size="20" />
						<a href="editfile.php?worldid=<?php echo $worldid; ?>&amp;id=<?php echo $row_EditHistory['c5to']; ?>"><img src="../img/green-arrow-right.gif" /></a> </td>
					</tr>
					<tr>
						<td align="right">6</td>
						<td>&nbsp;</td>
						<td><input name="c6" type="text" id="c6" value="<?php echo htmlspecialchars($row_EditHistory['c6']); ?>" size="40" /></td>
						<td><input name="c6to" type="text" id="c6to" value="<?php echo $row_EditHistory['c6to']; ?>" size="20" />
						<a href="editfile.php?worldid=<?php echo $worldid; ?>&amp;id=<?php echo $row_EditHistory['c6to']; ?>"><img src="../img/green-arrow-right.gif" /></a> </td>
					</tr>
				</table>
			</fieldset>
			<br />
			<fieldset>
				<legend>全頁特效</legend>
				*全頁打字機特效速度(0為關閉此特效):
				<input name="typing" type="text" id="typing" value="<?php echo $row_EditHistory['typing']; ?>" size="7" maxlength="4" />
				ms/w(愈小愈快, 建議50 - 150)
				<br />
				<br />
				*此特效不能和變數功能在同一頁共用
			</fieldset>
			<input type="submit" name="Submit" id="Submit" value="Submit" style="margin:10px;padding:5px;width:100px" />
			<input type="hidden" name="MM_update" value="form1" />
		</form>
	</body>
</html>
<?php
	mysql_free_result($EditHistory);
?>
