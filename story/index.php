<?php
	require_once('../include/sqldata.php');
	$gWid = intval($_GET['wid']);
	dbQuery("UPDATE ec_system SET `count`=(SELECT sum(count) FROM ec_pages WHERE wid = $gWid) WHERE id=$gWid");
	
	$storyInfo = dbRow("SELECT * FROM ec_system WHERE id = $gWid");
	$arrVariables = dbAr("SELECT * FROM ec_variables WHERE wid= $gWid");
?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta http-equiv="x-ua-compatible" content="ie=8" />
		<meta name="keywords" content="文字遊戲, 選擇遊戲, 遊戲" />
		<meta name="description" content="無盡的選擇" />
		<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" type="text/javascript"></script>
		
		<title>Endless Choice - <?php echo $storyInfo['name']; ?>: <?php echo $pageInfo['title']; ?></title>
		<style type="text/css">
			#ec_template_choices a{display:block;cursor:pointer}
			<?=$isApp?"":$storyInfo['css'];?>
		</style>
		
		<script>
			var toast=function(msg){
				$("<div><h3>"+msg+"</h3></div>")
				.css({ display: "block", opacity: 0.90, position: "fixed",padding: "7px","text-align": "center",background: "yellow",	width: "270px",left: ($(window).width() - 284)/2,top: $(window).height()/2 })
				.appendTo( $('body') )
				.delay( 1500 )
				.fadeOut( 400, function(){$(this).remove();});
			}
			function getPassword(){
				alert("EC_PW:" + newPass);
			}
			function save1(){
				if(typeof newPass == 'undefined' || newPass==""){toast('這兒不能儲存');}
				else{window.localStorage['save'+worldId]=newPass;	toast('己儲存');	}
			}
			function load1(){
				if (localStorage.getItem('save'+worldId) === null) {toast('沒有存檔');return;}
				toast('載入中');
				$('#load_code').val(window.localStorage['save'+worldId]);
				$('#load_form').submit();
			}
			
			function ec_get(dom){
				if(document.getElementById(dom) == null){console.log("no dom:"+dom);}
				else{return document.getElementById(dom).value;}
			}
			function ec_set(dom,val){
				if(document.getElementById(dom) == null){console.log("no dom:"+dom);}
				else{document.getElementById(dom).value = val;}
			}
			function ec_add(strvar,amount){
				var prevVal = parseFloat(ec_get(strvar));
				if(isNaN(prevVal)){prevVal = 0;}
				ec_set(strvar,prevVal + amount);
			}
			function ec_toggle(target,a){$('#'+target).load('check.php?worldid='+worldId+'&id='+a,{},autoPushVar).toggle();}
            function ec_embed(target,a){$('#'+target).load('check.php?worldid='+worldId+'&id='+a,{},autoPushVar);}
			function ec_write(dom){document.write(document.getElementById(dom).value);}
			function dwrite(str){document.write(str);}
			function ec_push(dom_id,val){$('#'+dom_id).html(val);}
			function ec_show(dom){$('[id="'+dom+'"]').css('display','inline');}
			function ec_hide(dom){$('[id="'+dom+'"]').hide();}
			function ec_hideall(dom){$(dom).hide();}
			function ec_dice(num){ return Math.floor(Math.random()*num)+1; }
			function ec_hide_option(id){ $('#c'+id).hide(); }
			function ecPreviousButtonId(){return buttonId;}
			function ec_setTitle(str){$(".pagetitle").html(str);}
			function ec_hideOption(id){
                if(Array.isArray(id)){$.each(id, function( index, value ) {ec_hideOption(value);});
				}else{$("#choice"+id).hide();}
			}
            function ec_showOption(id){
                if(Array.isArray(id)){$.each(id, function( index, value ) {ec_showOption(value);});
				}else{$("#choice"+id).show();}
			}
			function ec_passed(id){
				return (ec_get("ec_passed").indexOf("|"+id+"|") >= 0);
			}
			function eliminateDuplicates(arr) {
				var i,len=arr.length,out=[],obj={};
				for (i=0;i<len;i++) {obj[arr[i]]=0;}
				for (i in obj) {out.push(i);}
				return out;
			}
			function showChoices(){
				$("#choices").show();
				$(".page_choices").each(
				function(){if(this.innerText==""){$(this).hide();}}
				);
			}
			function type_write(){
				if(count++ <= content.length){$('#story_content').html(content.substring(0,count)+"|");setTimeout("type_write()",typing_speed);
				}else{showChoices();}
			}
			function load1(){
				if (localStorage.getItem('save'+worldId) === null) {
					toast('沒有存檔');
					return;
				}
				toast('載入中');
				$('#load_code').val(window.localStorage['save'+worldId]);
				$('#load_form').submit();
			}
			function save_page(page,ec_input){
				try{loaded(page,ec_input);}catch(err){}
				document.form1.action="pages.php?id="+page+"&worldid="+worldId;
				$("#buttonId").val(ec_input);
				document.form1.submit();
			}
			
			if(typing_speed >= 1){
				var count=0;
				var content;
			}
			
		</script>
	</head>
	<body>
			<?php if($arrVariables){?>
				<?php foreach($arrVariables as $v) { ?>
					<input type="hidden" name="<?=$v;?>" value="" id="<?=$v;?>" />
				<?php } ?>
			<? } ?>
		<h1 id="ec_template_title"><?=$storyInfo["name"];?></h1>
		<div id="ec_template_content"><?=$storyInfo["entertext"];?><br />~<?=$storyInfo["author"];?></div>
		<div id="ec_template_choices"><a data-choice="1">開新遊戲</a><a data-choice="2">載入進度</a><a data-choice="3">離開</a><a data-choice="4"></a><a data-choice="5"></a><a data-choice="6"></a></div>
		<div id="ec_template_system_box">
			<?if(decrypt($_COOKIE['EC_WID'])==$worldid){?>
				
				<button onclick="save1()">快速儲存</button>
				<button onclick="load1()">快速讀取</button>
			<?}?>
			<?php if(!$isApp){?>
				<button onclick="$('#ec_record_field').toggle()">顯示選擇紀錄</button>
				<div id="ec_record_field"><?=$varArr['EC_Path_Records'];?></div>
				<button onclick="$('#password_field').toggle()">儲存(複製密碼)</button>
				<div id="password_field"><?=$newPass;?></div>
			<?}?>
			<?php if($storyInfo['tid'] == ""){ ?><button onclick="window.open('http://realforum.zkiz.com/thread.php?tid=<?php echo $storyInfo['tid']; ?>','_blank')" id="prevpage">按此討論此劇目</button><?php } ?>
		</div> 
	</body>
	<script type="text/javascript"> 
		var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
		document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
	</script> 
	<script type="text/javascript"> 
		try {
			var pageTracker = _gat._getTracker("UA-4293967-12");
			pageTracker._setDomainName(".zkiz.com");
			pageTracker._trackPageview();
		} catch(err) {}</script> 
</html>