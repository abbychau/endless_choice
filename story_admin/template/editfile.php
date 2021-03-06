<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.1.2/js/bootstrap-colorpicker.min.js"></script>
<script src="https://cdn.rawgit.com/google/code-prettify/master/loader/run_prettify.js"></script>
<script type="text/javascript">
	var var_list_hint=[];
	function ec_embed(target,a){}
	function ec_get(dom){var_list_hint.push(dom); return "";}
	function ec_set(dom,val){var_list_hint.push(dom);}
	function ec_add(strvar,amount){var_list_hint.push(strvar);}
	function ec_setChoiceTarget(choice,val){}
	function getTrophy(){return app_trophyID;}
	function getVibration(){return app_willVibrate;}
	function getHint(){return app_hint;}
	function getAds(){return app_admob_id;}
	function ec_app(function_name,function_args){}
	function ec_write(dom){}
	function dwrite(str){}
	function ec_push(dom_id,val){}
	function ec_show(dom){}
	function ec_hide(dom){}
	function ec_hideall(dom){}
	function ec_dice(num){ return Math.floor(Math.random()*num)+1; }
	function ec_hide_option(id){}
	function ec_lazy_push(arr){}
	function ecPreviousPage(){return 0;}
	function ecThisPage(){return "0";}


	//wait for document.ready to fire
	$(function () {
		
		//then load the JavaScript file
		$.getScript('js/autoresizer.js');
		var elements = $("#content").val().match(/\[\[.*?\]\]/g);
		elements = elements.map(function(match) { temp=match.slice(2, -2); var_list_hint.push(temp); return temp; })
		eval($("#jsf").val())
		$.each($("#desc_container span"),
			function(){
				if(elements.indexOf($(this).attr("data-name"))){
					//$(this).css("border","1px solid black")
				}else{
					$(this).hide()
				}
			}
		)
		console.log(var_list_hint)

	});
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
	function deletePage(){
		var txt;
		var r = confirm("你確定要刪除嗎? 不能反悔哦!");
		if (r == true) {
			window.location = "editfile.php?delete=1&page=<?=$_GET["id"];?>";
		}
	}
	
	function replaceit(arg){
		if (arg == 'b') {sfoo = "<b>"; sbar = "</b>";}
		if (arg == 'i') {sfoo = "<i>"; sbar = "</i>";}
		if (arg == 'u') {sfoo = "<u>"; sbar = "</u>";}
		if (arg == 'font') {sfoo = "<font size='7'>"; sbar = "</font>";}
		if (arg == 'img') {sfoo = "<img src='"; sbar = "' \/>";}
		if (arg == 'hilight') {sfoo = "<span style='background-color: " + document.form1.color2.value + "'>"; sbar = "</span>";}
		if (arg == 'color') {sfoo = "<font color='" + document.form1.color2.value + "'>"; sbar = "</font>";}
		if (arg == 'fade_size') {sfoo = "<span ec_style='fade_size' from='0.6' to='4.0'>"; sbar = "</span>";}
		if (arg == 'span'){sfoo = "<span id='"; sbar="'></span>";}
		if (arg == 'samp'){sfoo = "<samp id='"; sbar="'></samp>";}
		if (arg == 'script') {sfoo = "<script>"; sbar = "<\/script>";}
		if (arg == 'var') {sfoo = "[["; sbar = "]]";}
		insert('content',sfoo,sbar);
		document.getElementById('content').focus();
	}
	
	function replaceit2(arg){
		if (arg == 'ec_toggle') {sfoo = "ec_toggle("; sbar = ");";}
		if (arg == 'ec_get') {sfoo = "ec_get('"; sbar = "')";}
		if (arg == 'ec_set') {sfoo = "ec_set('"; sbar = "',);";}
		if (arg == 'ec_add') {sfoo = "ec_add('"; sbar = "',);";}
		if (arg == 'ec_push') {sfoo = "ec_push('"; sbar = "',);";}
		if (arg == 'ec_show') {sfoo = "ec_show('"; sbar = "');";}
		if (arg == 'ec_hide') {sfoo = "ec_hide('"; sbar = "');";}
		if (arg == 'ec_dice') {sfoo = "ec_dice("; sbar = ");";}
		if (arg == 'ec_app_vibrate') {sfoo = "ec_app('vibrate'"; sbar = ");";}
		if (arg == 'ec_app_trophy') {sfoo = "ec_app('trophy'"; sbar = ",'trophy_id_eg_101');";}
		if (arg == 'ec_app_hint') {sfoo = "ec_app('hint'"; sbar = ",'提示文字...');";}
		if (arg == 'dwrite') {sfoo = "dwrite('"; sbar = "');";}
		if (arg == 'ecPreviousButtonId') {sfoo = "ecPreviousButtonId("; sbar = ");";}
		if (arg == 'ecPreviousPage') {sfoo = "ecPreviousPage("; sbar = ");";}
		if (arg == 'ec_setTitle') {sfoo = "ec_setTitle("; sbar = ");";}
		if(arg == 'ec_hideOption'){sfoo = "ec_hideOption("; sbar = ");";}
		if(arg == 'ec_passed'){sfoo = "ec_passed("; sbar = ")";}
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
	
	function setTitle(str){
		$(".pagetitle").html(str);
	}
	
	jsfHeight = 150;
	ctHeight = 300;
	<?if($_COOKIE['EC_READONLY']){?>
		
		$("input").prop("disabled", true);
		$('textarea').attr('readonly','readonly');
	<?}?>
	
	function save_page(page){document.form2.id.value=page;}
</script>

<style>
	textarea {
	/* Try and go 100% while supporting padding and borders. */
	-webkit-box-sizing: border-box;
	-moz-box-sizing: border-box;
	-ms-box-sizing: border-box;
	box-sizing: border-box;
	
	/* Best to set all three of these or something will be 'inherit' and cause problems. */    
	font-size: 16px;
	line-height: 20px;
	
	/* The reason for using border-box. */
	width: 100%;
	
	}
	a{cursor:pointer}
	.input-xs {
    height: 22px;
    padding: 2px 5px;
    font-size: 12px;
    line-height: 1.5;
    border-radius: 3px;
    }
</style>


<form id="form2" name="form2" method="post" action="../pages/pages.php" target="_blank">
	<div class="row">
		<div class="col-lg-12">
			<ol class="breadcrumb">
				<li>
					<i class="fa fa-dashboard"></i>  <a href="index.php"><?=$worldInfo["name"];?></a>
				</li>
				<li class="active">
					<i class="fa fa-bar-chart-o"></i> 編輯 Frame: <?=floatval($id) ?>
					
					<a class='btn btn-xs btn-default' onclick="save_page(<?=$pageInfo['id']; ?>);form2.submit()">預覽</a>
					<a class='btn btn-xs btn-default' onclick="clear_all();return false;">清空</a>
					<a class='btn btn-xs btn-default' onclick="deletePage();return false;">刪除</a>
				</li>
			</ol>
		</div>
	</div>
	<input type="hidden" name="ec_to<?=trimZeroDot($id) ?>key" value="<?=ec_hash($worldid.trimZeroDot($id)); ?>" />
	<input type="hidden" name="id" id="id" value="<?=$id ?>" />
	<input type="hidden" name="worldid" id="worldid" value="<?=$worldid; ?>" />
</form>

<form action="<?=$editFormAction; ?>" id="form1" name="form1" method="POST" onsubmit="formSubmitting=true;">
	<input name="serial" type="hidden" id="serial" value="<?=$pageInfo['serial']; ?>" />
	<div class="input-group">
		<span class="input-group-addon">Frame ID</span>
		<input class="form-control" name="frameid" type="text" id="frameid" value="<?=floatval($pageInfo['id']); ?>"  />
	</div>
	<div class="input-group">
		<span class="input-group-addon">標題</span>
		<input class="form-control" name="title" type="text" id="title" value="<?=$pageInfo['title']; ?>"  />
	</div>
	
	
	
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">內容</h3>
		</div>
		<div class="panel-body">
			
			<div style="padding:1px">
				<div class="btn-group">
					<input type="button" class="btn btn-default btn-xs" name="b" value="粗體" onclick="replaceit('b');" />
					<input type="button" class="btn btn-default btn-xs" name="i" value="斜體" onclick="replaceit('i');" />
					<input type="button" class="btn btn-default btn-xs" name="u" value="底線" onclick="replaceit('u');" />
				</div>
				
				<input type="button" class="btn btn-default btn-xs" name="font" value="7號字體" onclick="replaceit('font');" />
				<input type="button" class="btn btn-default btn-xs" name="img" value="路徑轉換為圖片" onclick="replaceit('img');" />
				<div class="btn-group">
					<input type="button" class="btn btn-default btn-xs" name="dwrite" value="+" onclick="ctHeight+=400; document.getElementById('content').style.height = ctHeight+'px';" />
					<input type="button" class="btn btn-default btn-xs" name="dwrite" value="-" onclick="ctHeight-=400; document.getElementById('content').style.height = ctHeight+'px';" />
				</div>
			</div>
			<div style="padding:1px">
				<div class="input-group">
					<span class="input-group-btn">
						<input class="btn btn-default btn-xs" type="button" name="img2" value="高亮文字" onclick="replaceit('hilight');" />
						<input class="btn btn-default btn-xs" type="button" name="wordcolor" value="文字顏色" onclick="replaceit('color')" />
					</span>
					
					<input type="text" name="color2" class="form-control input-xs" size="20" id="pick2" placeholder="顏色" style="width:100px">
					<input type="button" class="btn btn-default btn-xs" name="fade_size" value="字型大小漸變" onclick="replaceit('fade_size');" />
				</div><!-- /input-group -->


			</div>
			<script>
			var assignedUnload = false;
			var formSubmitting = false;
			function noteSave(){
				formSubmitting = false;
				if(assignedUnload == false){
					window.addEventListener("beforeunload", function (e) {
						if (formSubmitting) {
							return undefined;
						}
						
						var confirmationMessage = 'It looks like you have been editing the story. '
												+ 'If you leave before saving, your changes will be lost.';

						(e || window.event).returnValue = confirmationMessage; //Gecko + IE
						return confirmationMessage; //Gecko + Webkit, Safari, Chrome etc.
					});
					assignedUnload = true;
				}
			}
			</script>
			<div style="padding:1px">
				<textarea onkeyup="noteSave()" name="content" style="height:300px;" id="content" wrap="virtual"><?=htmlspecialchars($pageInfo['content']); ?></textarea>
			</div>
			<div style="padding:1px">
				<div class="btn-group">
					<input class="btn btn-default btn-xs" type="button" name="script" value="script標記" onclick="replaceit('script');" />
					<input class="btn btn-default btn-xs" type="button" name="span" value="SPAN" onclick="replaceit('span');" />
					<input class="btn btn-default btn-xs" type="button" name="span" value="變數容器" onclick="replaceit('var');" />
					<input class="btn btn-default btn-xs" type="button" name="samp" value="隱藏容器" onclick="replaceit('samp');" />
				</div>
				<div class="btn-group">
					<input class="btn btn-default btn-xs" type="button" name="setvar" value="代碼標記" onclick="replaceit('script');"/>
					<input class="btn btn-default btn-xs" type="button" name="upimg" value="上傳圖片" onclick="window.open('http://share.zkiz.com/rpgupload.php')" />
				</div>
			</div>
			
			
		</div>
	</div>
	
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">EC 腳本 <a onclick="document.getElementById('js').style.display = (document.getElementById('js').style.display=='none'?'block':'none');">+</a></h3>
		</div>
		<div class="panel-body" id="js" <? if($pageInfo['js']==""){?>style="display:none"<? } ?>>
			

			<div class="btn-group">
				<input class="btn btn-default btn-xs" type="button" value="ec_get(調用變數)" onclick="replaceit2('ec_get');" />
				<input class="btn btn-default btn-xs" type="button" value="ec_set('設定變數',數值)" onclick="replaceit2('ec_set');" />
				<input class="btn btn-default btn-xs" type="button" value="ec_add('設定變數',數值)" onclick="replaceit2('ec_add');" />
			</div>
			
			<div class="btn-group">
				
				<input class="btn btn-default btn-xs" type="button" value="ec_show('容器id')" onclick="replaceit2('ec_show');" />
				<input class="btn btn-default btn-xs" type="button" value="ec_hide('容器id')" onclick="replaceit2('ec_hide');" />
				<input class="btn btn-default btn-xs" type='button' value="ec_hideOption(隱藏選項)" onclick="replaceit2('ec_hideOption');" />
			</div>
			<div class="btn-group">
			<input class="btn btn-default btn-xs" type="button" value="ec_push('容器id', 變數)" onclick="replaceit2('ec_push');" />
			<input class="btn btn-default btn-xs" type="button" value="ec_setTitle('頁面標題')" onclick="replaceit2('ec_setTitle');" />
			</div>
			<div class="btn-group">
			<input class="btn btn-default btn-xs" type="button" value="ec_dice(最大數)" onclick="replaceit2('ec_dice');" />
			<input class="btn btn-default btn-xs" type="button" value="上一頁選擇" onclick="replaceit2('ecPreviousButtonId');" />
			<input class="btn btn-default btn-xs" type="button" value="上一頁ID" onclick="replaceit2('ecPreviousPage');" />
			<input class="btn btn-default btn-xs" type="button" value="是否已經過(FrameID)" onclick="replaceit2('ec_passed');" />
			
			</div>
			<div class="btn-group">
				<input class="btn btn-default btn-xs" type="button" value="APP震動" onclick="replaceit2('ec_app_vibrate');" />
				<input class="btn btn-default btn-xs" type="button" value="APP成就解鎖(id)" onclick="replaceit2('ec_app_trophy');" />
				<input class="btn btn-default btn-xs" type="button" value="APP提示(文字)" onclick="replaceit2('ec_app_hint');" />
			</div>

			<br />
			<textarea name="js" id="jsf" wrap="virtual" style="height:150px" ><?=htmlspecialchars($pageInfo['js']); ?></textarea><br />
			<input class="btn btn-default btn-xs" type="button" value="dwrite(印出文字)" onclick="replaceit2('dwrite');" />
			<input class="btn btn-default btn-xs" type="button" value="ec_toggle('目標框',FrameID)" onclick="replaceit2('ec_toggle');"/>
			
			<div class="btn-group">
			<input class="btn btn-default btn-xs" type="button" value="+" onclick="jsfHeight+=40; document.getElementById('jsf').style.height = jsfHeight+'px';" />
			<input class="btn btn-default btn-xs" type="button" value="-" onclick="jsfHeight-=40; document.getElementById('jsf').style.height = jsfHeight+'px';" />
			</div>
			<div id='desc_container'>
			<? foreach($varList as $v){ ?>
				<span data-varname="<?=$v['varname'];?>"><?=$v['varname'];?> (<?=$v['description'];?>)</span>
			<?}?>
			</div>
		</div>


	
	</div>
	
	
	
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">頁面選擇</h3>
		</div>
		<table class="table table-condensed">
			<thead>
				<th >選擇</th>
				<th >顯示文字</th>
				<th >目標 Frame</th>
			</thead>
			<? for($i = 1; $i<=6; $i++){ ?>
				<tr>
					<td width="40"><?=$i;?></td>
					<td><input name="c<?=$i;?>" type="text" id="c<?=$i;?>" value="<?=htmlspecialchars($pageInfo["c{$i}"]); ?>" style="width:100%" /></td>
					<td><input name="c<?=$i;?>to" type="text" id="c<?=$i;?>to" value="<?=$pageInfo["c{$i}to"]; ?>" size="5" />
					<a href="editfile.php?worldid=<?=$worldid; ?>&amp;id=<?=$pageInfo["c{$i}to"]; ?>"><img src="../img/green-arrow-right.gif" /></a></td>
				</tr>
			<?}?>
		</table>
	</div>
	
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">其他</h3>
		</div>
		<div class="panel-body">
			*全頁打字機特效速度(0為關閉此特效):
			<input name="typing" type="text" id="typing" value="<?=$pageInfo['typing']; ?>" size="7" maxlength="4" />
			ms/w(愈小愈快, 建議50 - 150)
			<br />
			Trailing: <input type="checkbox" name="trail" <?=$pageInfo["trail"]?"checked":"";?> /> (打開後可以使用ec_passed(frame_id) 來得知玩家是否經過此頁)
		</div>
	</div>
	
	<?if(!$_COOKIE['EC_READONLY']){?><input class="btn btn-primary" type="submit" name="Submit" id="Submit" value="送出" /><?}?>
	<input type="hidden" name="MM_update" value="form1" />
</form>
