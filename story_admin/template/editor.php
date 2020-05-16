<?php
require_once('../include/sqldata.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>World Editor</title>
</head>

<frameset rows="*" cols="350,*" framespacing="1" frameborder="yes" border="1">
  <frame src="contentlist.php?worldid=<?=$pWid; ?>" name="leftFrame" scrolling="auto" id="leftFrame" title="leftFrame" />
  <frame src="announce.php?worldid=<?=$pWid ?>" name="mainFrame" id="mainFrame" title="mainFrame" />
</frameset>
<noframes><body>
</body>
</noframes></html>
