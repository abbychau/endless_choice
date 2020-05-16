<?php
require_once('../include/sqldata.php');

$Extra = new ParsedownExtra();



if ($worldid=="pRandom"){
	screenMessage("Error","Wrong Story ID");
	exit;
}

$query_ViewPage = sprintf("SELECT * FROM ec_pages WHERE round(id,3) = %s AND wid = $worldid", GetSQLValueString($id, "double"));
$pageInfo = dbRow($query_ViewPage);

$worldid = intval($worldid);
$compareKey = $_REQUEST["ec_to{$id}key"];
if($id!=1 && !ec_validate_hash($compareKey, $worldid.trim($id))){
	


if($pageInfo){
	die("<pre>
好吧，我就直接說實話吧。
來到這個頁面有兩個可能性。
一是程序爆炸了，二是有人用了不正當的手段穿越頁面……
如果是程序爆炸的話，請看這邊（喂）
請容許作者和天上天下天地無雙的工程師在此給予玩家你的一個道歉，可以的話，請告訴我們你出現問題的頁面，如果是儲存後讀取的話，請盡可能回憶起出現問題的回合，我們會一個一個的測試看看問題在哪裡出現。
真的很對不起，<a href='https://www.facebook.com/konran8raundo/'>facebook專頁</a>或者電郵回報(zkizec (at) gmail.com)也可以。謝謝你。

如果是不正當的手段穿越頁面的話，請看這邊（喂）</span>

請自行回<a href='/'>主頁</a>進入遊戲。
</pre>");
}else{
	//screenMessage("未完成","作者未完成這一幕，請按下面的
}

}

dbQuery(sprintf("update ec_pages set count = count + 1 where id = %s AND wid = $worldid",GetSQLValueString($id, "double")));



$pageInfo['js'] = str_replace(["[[","]]"],array("ec_get('","')"),$pageInfo['js']);
$pageInfo['js'] = preg_replace( '/([^;\s]+)=>([^;\s]+)/s', "ec_set('$1',$2);" , $pageInfo['js']);

$pageInfo['content'] = str_replace(["[[","]]","<<",">>"],["<v ","></v>","<span id='","'><span>"],$pageInfo['content']);
$pageInfo['content'] = nl2br($pageInfo['content']);

$storyInfo = dbRow("SELECT name, css, tid, admob_id FROM ec_system WHERE id = $worldid");
$arrVariables = dbAr("SELECT * FROM ec_variables WHERE wid= $worldid");

foreach ($arrVariables as $row_varRecordset) {
	$varArr[$row_varRecordset['varname']] = $_POST[$row_varRecordset['varname']];
}

$varArr['EC_Path_Records'] = $_POST['EC_Path_Records'] . $_POST['buttonId'];

$pass_padding = "|{$id}";
$varArr['ec_passed'] = str_replace("||","|",$varArr['ec_passed']);
$varArr['ec_passed'] = str_replace($pass_padding,"",$_POST['ec_passed']);
$varArr['ec_passed'] = "{$_POST['ec_passed']}{$pass_padding}";

if($_POST["this_page_id"]){
	$varArr['ec_previous_page'] = $_POST['this_page_id'];
}
foreach($varArr as $k=>$v){
	$pwString .= "{$k}={$v}&";
}
$nStr=$pwString."id=".$id."&worldid=".$worldid."&prevbtnid=".$_POST['buttonId'];
$newPass = asc_shift(base64_encode($nStr), -1);

preg_match_all("/ec_setChoiceTarget\(\d+,\d+\)/", $pageInfo['js'], $output_array);
foreach($output_array[0] as $v){
	$parts = explode(",",$v);
	$keyStack[] = trim($parts[1],")");
}
preg_match_all("/ec_embed\(\d+,\d+\)/", $pageInfo['js'], $output_array);
foreach($output_array[0] as $v){
	$parts = explode(",",$v);
	$keyStack[] = str_replace('ec_embed(','',$parts[0]);
}
//print_r($output_array);

//$keyStack[] = 
if(isset($_COOKIE['ec_theme'])){
	$ec_theme = intval($_COOKIE['ec_theme']);
}else{
	$ec_theme = '1';
}
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
	
	<link rel="stylesheet" type="text/css" href="theme_css/<?=$ec_theme;?>.css" id='theme_css' />

	<title><?php echo $storyInfo['name']; ?>: <?php echo $pageInfo['title']; ?></title>
	<style type="text/css">

		<?php if(!$isApp){?>
		<?=$storyInfo['css']; ?>
		<?}?>
	</style>

	<script>
		var buttonId='<?=$_POST['buttonId']?$_POST['buttonId']:($_POST['prevbtnid']?$_POST['prevbtnid']:0);?>';
		var newPass= '<?=$newPass;?>';
		var id='<?=$id;?>';
		var worldId= <?=$worldid;?>;
		var typing_speed = <?=intval($pageInfo['typing']);?>;

		var toast=function(msg){
			$("<div><h3>"+msg+"</h3></div>")
				.css({ display: "block",
					opacity: 0.90,
					position: "fixed",
					padding: "7px",
					"text-align": "center",
					background: "yellow",
					width: "270px",
					left: ($(window).width() - 284)/2,
					top: $(window).height()/2 })
				.appendTo( $('body') ).delay( 1500 )
				.fadeOut( 400, function(){
					$(this).remove();
				});
		};
		function password1(){
			if(typeof newPass == 'undefined' || newPass==""){
				toast('這兒不能儲存，不能匯出密碼！');
			}else{
				alert("PW:" + newPass);
			}
		}
		function getPassword(){
			return newPass;
		}
		function save1(){
			if(typeof newPass == 'undefined' || newPass==""){
				toast('這兒不能儲存');
			}else{
				window.localStorage['save'+worldId]=newPass;
				toast('已儲存');
			}
		}

		function load1(){
			if (localStorage.getItem('save'+worldId) === null) {
				toast('沒有存檔');
				return;
			}
			toast('載入中');
			setTimeout(function(){
				$('#load_code').val(window.localStorage['save'+worldId]);
				$('#load_form').submit();
			}, 500);

		}
		function showPath(){

		}
		function ec_embed(target,a){
			$.get(
				'check.php?worldid='+worldId+'&id='+a,
				{key: ec_tokey[a]},
				function(rtn){
					autoPushVar();
					$('#'+target).html(rtn)
				}
			);
		}
		function ec_get(dom){
			if(document.getElementById(dom) == null){
				console.log("no dom:"+dom);
			}else{
				return document.getElementById(dom).value;
			}
		}
		function ec_set(dom,val){
			if(document.getElementById(dom) == null){
				console.log("no dom:"+dom);
			}else{
				document.getElementById(dom).value = val;
			}
		}
		function ec_add(strvar,amount){
			var prevVal = parseFloat(ec_get(strvar));
			if(isNaN(prevVal)){
				prevVal = 0;
			}
			ec_set(strvar,prevVal + amount);
		}
		function ec_setChoiceTarget(choice,val){
			$("#choice"+choice).attr("to",val)
		}
		var app_trophyID = "";
		function getTrophy(){return app_trophyID;}
		var app_willVibrate = "NO";
		function getVibration(){return app_willVibrate;}
		var app_hint = "";
		function getHint(){return app_hint;}
        var app_admob_id = "";
        function getAds(){return app_admob_id;}

		function ec_app(function_name,function_args){
			if(function_name == "vibrate"){app_willVibrate = "YES";}
            if(function_name == "ads_interstitial"){app_admob_id = "<?=$storyInfo['admob_id'];?>";}
			if(function_name == "trophy"){app_trophyID = app_trophyID + ',' + function_args;}
			if(function_name == "hint"){app_hint = function_args;}
		}
		function ec_write(dom){document.write(document.getElementById(dom).value);}
		function dwrite(str){document.write(str);}
		function ec_push(dom_id,val){$('[id='+dom_id+']').html(val);}
		function ec_show(dom){$('[id="'+dom+'"]').css('display','inline');}
		function ec_hide(dom){$('[id="'+dom+'"]').hide();}
		function ec_hideall(dom){$(dom).hide();}
		function ec_dice(num){ return Math.floor(Math.random()*num)+1; }
		function ec_hide_option(id){ $('#c'+id).hide(); }
		function ec_lazy_push(arr){
			for(var i=0; i<arguments.length; i++){
				ec_push(arguments[i],ec_get(arguments[i]));
			}
		}
		function ecPreviousPage(){
			return ec_get("ec_previous_page");
		}
		function ecThisPage(){
			return "<?=floatval($id);?>";
		}
		function eliminateDuplicates(arr) {

			var	len=arr.length;
			var	out=[];
			var	obj={};

			for (var i=0;i<len;i++) {
				obj[arr[i]]=0;
			}
			for (var ele in obj) {
				out.push(ele);
			}
			return out;
		}
		function showChoices(){
			$("#choices").show();
			$(".page_choices").each(
				function(){
					if(this.innerText==""){
						$(this).hide();
					}
				}
			);

            $("a[button_id]").on(
                "click",
                function(){
                    save_page($.isNumeric($(this).attr("to"))?$(this).attr("to"):ec_get($(this).attr("to")),$(this).attr("button_id"));
                }
            ).css("cursor","pointer");
		}
		function type_write(){
			if(count++ <= content.length){
				document.getElementById('story_content').innerHTML=content.substring(0,count)+"|";
				setTimeout("type_write()",typing_speed);
			}else{
				showChoices();
			}
		}
		
		
		
		
		function setTheme(theme){
			setCookie("ec_theme",theme,9999);
			$("#theme_css").attr("href", "theme_css/" + theme + ".css");
		}
		
		function save_page(page,ec_input){
			try{loaded(page,ec_input);}catch(err){}
			document.form1.action="pages_md.php?id="+page+"&worldid="+worldId;
			$("#buttonId").val(ec_input);
			document.form1.submit();
		}
		function ecPreviousButtonId(){
			return buttonId;
		}
		function ec_setTitle(str){
			$(".pagetitle").html(str);
		}
		function ec_hideOption(id){
			if(Array.isArray(id)){
				$.each(id, function( index, value ) {
					ec_hideOption(value);
				});
			}else{
				$("#choice"+id).hide();
			}
		}
		function ec_showOption(id){
			if(Array.isArray(id)){
				$.each(id, function( index, value ) {
					ec_showOption(value);
				});
			}else{
				$("#choice"+id).show();
			}
		}
		function ec_passed(id){
			return (ec_get("ec_passed").indexOf("|"+id+"|") >= 0);
		}
		if(typing_speed >= 1){
			var count=0;
			var content;
		}
function setCookie(name, value, days) {
    var expires;
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toGMTString();
    }
    else {
        expires = "";
    }
    document.cookie = name + "=" + value + expires + "; path=/";
}

function getCookie(c_name) {
    if (document.cookie.length > 0) {
        c_start = document.cookie.indexOf(c_name + "=");
        if (c_start != -1) {
            c_start = c_start + c_name.length + 1;
            c_end = document.cookie.indexOf(";", c_start);
            if (c_end == -1) {
                c_end = document.cookie.length;
            }
            return unescape(document.cookie.substring(c_start, c_end));
        }
    }
    return "";
}
		var autoPushVar = function (){
			<?php foreach($varArr as $i => $v) { ?>
			$("v[<?=$i;?>]").html($("#<?=$i;?>").val());
			<?php } ?>
		};

        $(document).ready(function(){
			<?=$pageInfo['js']; ?>

			autoPushVar();

			$("[ec_style='fade_size']").each(function( index ) {



				var from = parseFloat($(this).attr("from"));
				var to = parseFloat($(this).attr("to"));
				var intSpans = parseInt(Math.abs(from - to) * 10);
				var intCharPerSpan =  Math.round($( this ).text().length / intSpans);
				var regex = new RegExp(".{1,"+intCharPerSpan+"}", "g");
				var chunks = $(this).text().match(regex);
				//console.log(".{1,"+intCharPerSpan+"}");
				//console.log(chunks);
				var strHtml = "";
				for(var i = 0;i<=intSpans;i++) {
					strHtml = strHtml.concat("<span style='font-size:"+ parseFloat(from+i*0.1) + "em'>" + chunks[i] + "</span>");
				}
				strHtml = "<span style='line-height:"+to+"em'>" + strHtml + "</span>";
				$( this ).html(strHtml);
			});

			if(typing_speed >= 1){
				content=document.getElementById('story_content').innerHTML;
				type_write(content);
			}else{
				showChoices();
			}
		});

	</script>
</head>
<body>
<form action="/load.php" id='load_form' method="post">
	<input type='hidden' name='code' id='load_code' />
</form>


<?php if(!$isApp){?>
	<div style="margin-bottom:20px" ><strong style="color:#FFF">Endless Choice - <?php echo $storyInfo['name']; ?></strong></div>
<?}?>
<div id="wrapper">
	<div class="addround">
		<div class="content">
			<?php if(trim($pageInfo['title']) <> ""){ ?>
				<strong class="pagetitle"><?php echo $pageInfo['title']; ?></strong>
				( Views:<?php echo $pageInfo['count']; ?> )
				<hr width="100%" />


				<form name="form1" method="post" action="pages_md.php" class="pagecontent">
					<input type="hidden" name="buttonId" id="buttonId" value="0" />
					<input type="hidden" name="this_page_id" id="this_page_id" value="<?=floatval($id);?>" />
					<?php if($varArr){?>
						<?php foreach($varArr as $i => $v) { ?>
							<input type="hidden" name="<?=$i;?>" value="<?=$v; ?>" id="<?=$i;?>" />
						<?php } ?>
					<? } ?>
					<?if(decrypt($_COOKIE['EC_WID'])==$worldid){?>
						<?php if($varArr){?>
						<table style='font-size:9px;line-height:1em;background:#333;color:#0F0;margin:.5em 0 1em 0;'>
							<?php foreach($varArr as $i => $v) { ?>
							<? if($v!=""){?>
								<tr><td><?=$i?></td><td> = <?=$v;?></td></tr>
							<?}?>
							<?php } ?>
						</table>
						<? } ?>					
					<?}?>
					
					<input type="hidden" name="ec_sys_current_view" value="<?php echo $pageInfo['count']; ?>" />

					<div id="story_content"><?=$Extra->text($pageInfo['content']); ?></div>

					<div style="clear:both"></div>


					<div id="choices">
						<? for($i = 1; $i <=6 ;$i++){?>
							<? if(trim($pageInfo["c{$i}"]) != ""){ ?>
								<a class="page_choices" id="choice<?=$i?>" id="c<?=$i;?>" button_id="<?=$i;?>" to="<?=trim($pageInfo["c{$i}to"]); ?>"><?=$pageInfo["c{$i}"]; ?></a>
								
								<? $keyStack[] = $pageInfo["c{$i}to"];?>
								
							<? } ?>
						<? } ?>
						<? 
							if(is_array($keyStack)){
								$keyStack = array_unique($keyStack); 
								foreach ($keyStack as $v){?>
									<input type="hidden" name="ec_to<?=$v;?>key" value="<?=ec_hash($worldid.trim($v)); ?>" />
								<?}?>
							<?}?>
						
					</div>

				</form>
				
				
						<? if(is_array($keyStack)){?>
							<script>
							var ec_tokey = {
							<?foreach ($keyStack as $v){?>
							<?=$v;?> : "<?=ec_hash($worldid.trim($v)); ?>",
							<?}?>
							};
							</script>
						<?}?>
				
			<?php }else{ ?>
			
				<strong>作者未完成這一幕，請按下面的[儲存]以便下次繼續</strong>
			
			<? } ?>



		</div>
	</div>
	<?php if(!$isApp){?>
		<div class='addround' style="padding:20px">
			<? if(false){?>
				<script type="text/javascript"><!--
					google_ad_client = "ca-pub-2146633441538112";
					/* 300x250, 已建立 2009/10/30 */
					google_ad_slot = "5462728465";
					google_ad_width = 300;
					google_ad_height = 250;
					//-->
				</script>
				<script type="text/javascript"
						src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
				</script>
				<br />
			<?}?>
			<?if(decrypt($_COOKIE['EC_WID'])==$worldid){?>

				<button onclick="save1()">快速儲存</button>
				<button onclick="load1()">快速讀取</button>
			<?}?>
			<button onclick="$('#ec_record_field').toggle()">顯示選擇紀錄</button>
			<div id="ec_record_field"><?=$varArr['EC_Path_Records'];?></div>
			<button onclick="$('#password_field').toggle()">儲存(複製密碼)</button>
			<div id="password_field"><?=$newPass;?></div>
			<button onclick="window.open('enter.php?worldid=<?=$worldid;?>','_parent')">回到遊戲主頁</button>
			<button onclick="history.go(-1)" id="prevpage">上一頁</button>
			
			<button onclick="window.open('https://ec.abby.md/pages/comment.php?wid=<?=$worldid; ?>','_blank')">留言給此故事</button>
			
		</div>
		<div style="height:20px"></div>

		<div class="footer">
			Powered by <a href='http://ec.abby.md' target="_blank"><strong>Endless Choice System</strong></a>
		</div>

	<? } ?>
</div>
<?=gaScript();?>

</body>
</html>