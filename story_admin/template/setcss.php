<ol class="breadcrumb">
  <li>
    <i class="fa fa-dashboard"></i>  <a href="index.php"><?=$worldInfo["name"];?></a>
  </li>
  <li class="active">
    <i class="fa fa-bar-chart-o"></i> 編輯頁面模版
  </li>
</ol>
<style>
	textarea{width:100%}
	input[type="text"]{width:100%}
</style>
<p>歡迎在這編輯頁面模版!!</p>
<p>下面所輸入的是css header:</p>
<ul>
  <li>如不了解請不要更改</li>
  <li>這是css 的官方教學網站(英文): <a href="http://www.w3schools.com/css/" target="_blank">http://www.w3schools.com/css/</a></li>
</ul>
<h3>修改css header</h3>
<form id="form4" name="form4" method="post">
  <textarea name="entertext" rows="10" id="entertext"><?php echo $row_Recordset1['css']; ?></textarea>
  <br /><input name="updateText" type="hidden" id="updateText" value="form4" />
    <input type="hidden" name="id" value="<?php echo $colname_Recordset1; ?>" />
  <input type="submit" name="button" id="button" class='btn btn-primary' value="送出" />

</form>
<h3>修改背景音樂mp3 或youtube 路徑 </h3>
<form id="form1" name="form1" method="post">

  <input name="entertext" type="text" id="entertext" value="<?php echo $row_Recordset1['bgmusic']; ?>" />
  <br />
  eg. http://www.youtube.com/v/eNdEu9s5qUU<br />
  eg. http://abby.zkiz.com/11.mp3
  <br />
  <input name="updateText" type="hidden" id="updateText" value="form1" />
    <input type="hidden" name="id" value="<?php echo $colname_Recordset1; ?>" />
  <input type="submit" name="button" id="button" class='btn btn-primary' value="送出" />

</form>