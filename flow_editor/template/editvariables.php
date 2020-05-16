<div class='well'>
<form action="<?php echo $editFormAction; ?>" id="form1" name="form1" method="POST">
  <input type="hidden" name="vidfield" id="vidfield" value="<?=intval($_GET['vid']); ?>" />
  變數名稱: <input name="varfield" type="text" value="<?php echo $row_varRecordset['varname']; ?>" size="30" />
    <input type="submit" name="Submit"  id="Submit" value="Submit" style="margin-left:.5em" />
  <input type="hidden" name="MM_update" value="form1" />
</form>

<a href='viewvariables.php'>取消</a>
</div>