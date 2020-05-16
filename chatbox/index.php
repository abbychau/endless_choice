<?php
session_start();
//****************參數設置****************
//顯示在線用戶
$disonline = false;
//新登陸時顯示最近內容的條數(默認為30條)
$leastnum = 70;
//默認的房間名(默認是每天換一個文件)，如果去掉d，則是每月換一個文件
$room = "chattxt";//date("Y-m");
//房間保存路徑,必須以/結尾
$roomdir = "rooms/";
//編碼方式
$charset = "UTF-8";
//客戶端最大顯示內容條數(建議不要太大)
$maxdisplay = 300;


//語言
$lang = array(
//聊天室標題
"title"=>"歡迎進入迷你聊天系統",
//第一個到聊天室的歡迎
"firstone"=>"<span style='color:#16a5e9;'>系統廣播：</span>",
//當信息有禁止內容時顯示
"ban"=>"請使用文明用語！禁止發佈非法信息！",
//關鍵字
"keywords"=>"聊天室",
//發言提示
"hereyourwords" => "在這裡發言!"
);

header("content-type:text/html; charset=utf-8");

$get_past_sec = 3; //如果發現丟話，可以適當調大這個值
$touchs = 10; //檢查在線人數的時間間隔
$title = $lang["title"];
$earlier = 10;
$description = $lang["description"];
$origroom = $room;
$least = ($_GET["dis"])?intval($_GET["dis"]):$leastnum;
$touchme = $_POST['touchme'];
if (!is_dir($roomdir)) @mkdir($roomdir) or die("error when creating folder $roomdir");
$room = $_GET['room'];
if (!$room) $room = $_POST["room"];
$room = checkfilename($room);
if (!$room) $room = $origroom;
$filename = $roomdir.$room.".dat.php";
$datafile = $roomdir.$room.".php";
if (!file_exists($filename)) @file_put_contents($filename,'<?php die();?>'."\n".time()."|".$lang["firstone"]."\n");
if (!file_exists($datafile)) @file_put_contents($datafile,'<?php die();?>'."\n");
$action = $_POST["action"];

if (!function_exists("file_get_contents"))
{
function file_get_contents($path)
{
if (!file_exists($path)) return false;
$fp=@fopen($path,"r");
$all=fread($fp,filesize($path));
fclose($fp);
return $all;
}
}

if (!function_exists("file_put_contents"))
{
function file_put_contents($path,$val)
{
$fp=@fopen($path,"w");
fputs($fp,$val);
fclose($fp);
return true;
}
}

function checkfilename($file)
{
if (!$file) return "";
$file = trim($file);
$a = substr($file,-1);
$file = eregi_replace("^[.\\\/]*","",$file);
$file = eregi_replace("[.\\\/]*$","",$file);
$arr = array("../","./","/","\\","..\\",".\\");
$file = str_replace($arr,"",$file);
return $file;
}

function get_ip()
{
global $_SERVER;
if ($_SERVER)
{
if ( $_SERVER[HTTP_X_FORWARDED_FOR] )
$realip = $_SERVER["HTTP_X_FORWARDED_FOR"];
else if ( $_SERVER["HTTP_CLIENT_ip"] )
$realip = $_SERVER["HTTP_CLIENT_ip"];
else
$realip = $_SERVER["REMOTE_ADDR"];
}
else
{
if ( getenv( 'HTTP_X_FORWARDED_FOR' ) )
$realip = getenv( 'HTTP_X_FORWARDED_FOR' );
else if ( getenv( 'HTTP_CLIENT_ip' ) )
$realip = getenv( 'HTTP_CLIENT_ip' );
else
$realip = getenv( 'REMOTE_ADDR' );
}
return $realip;
}

function array2json($arr)
{
$keys = array_keys($arr);
$isarr = true;
$json = "";
for($i=0;$i<count($keys);$i++)
{
if ($keys[$i] !== $i)
{
$isarr = false;
break;
}
}
$json = $space;
$json.= ($isarr)?"[":"{";
for($i=0;$i<count($keys);$i++)
{
if ($i!=0) $json.= ",";
$item = $arr[$keys[$i]];
$json.=($isarr)?"":$keys[$i].':';
if (is_array($item))
$json.=array2json($item);
else if (is_string($item))
$json.='"'.str_replace(array("\r","\n"),"",$item).'"';
else $json.=$item;
}
$json.= ($isarr)?"]":"}";
return $json;
}

function keeponline()
{
global $disonline,$datafile;
if (!$disonline) return;
$name = $_POST['name'];
$ip = get_ip();
$onlines = @file_get_contents($datafile);
$s1 = "|{$name}|{$ip}|";
if (strpos($onlines,$s1) === false)
{
if (strpos($onlines,"|".$name."|") === false)
{
$fp = @fopen($datafile,"a+");
if ($fp)
{
if (@flock($fp, LOCK_EX))
{
@fputs($fp,time()."|".time().$s1."\n");
@flock($fp, LOCK_UN);
}
@fclose($fp);
}
}
else
{
echo "NAME";
die();
}
}
}

if ($action == "write")
{
$color = $_POST["color"];
if (!eregi("[0-9a-fA-F]{6}",$color) || $color == "#000000") $color = "";
$color = "#".$color;
$size = intval($_POST["size"]);
$name = str_replace(array("\n","\r"),"",$_POST['name']);
if (!$name) die("No Name!!");
$ip = get_ip();
keeponline();

$s = "";
$style = "";
$font = $_POST["font"];
if ($font == "heiti") $font = "新細明體";
else $font = "";
$style .= (!$font)?"":"font-family:".$font.";";
$style .= (!$_POST["bold"])?"":"font-weight:bold;";
$style .= (!$color || $color == "#")?"":"color:{$color};";
$style .= (!$size || $size == "16")?"":"font-size:{$size}px;";
$t = time();
$arr = explode("\n",$_POST['content']);
for($i = 0;$i<count($arr);$i++)
{
$content = $arr[$i];
$content = trim($content);
$content = str_replace(array("\n","\r"),"",$content);
if (!$content) continue;
$content = htmlspecialchars($content);
$content = preg_replace("~\[img\](http:\/\/[a-zA-Z0-9\.-_\+%\?]*)\[\/img\]~i", "<img src='$1' />", $content);
$content = ($style)?"<span style='{$style}'>{$content}</span>":$content;
$s.= $t."|".$name.":".$content."\n";
}

if (!$s) die("No Content!!");
$fp = @fopen($filename,"a+");
if (!$fp) die("repeat");
$re_time = 0;
while(!@flock($fp, LOCK_EX))
{
sleep(1);
$re_time++;
if ($re_time >=4) break;
}
if ($re_time <4)
{
@fputs($fp,$s);
@flock($fp, LOCK_UN);
}
else die("repeat");
@fclose($fp);
echo "OK";
}
else if ($action == "read")
{
$first = $_POST["first"];
$lastmod = intval($_POST["lastmod"]) - $get_past_sec; //得到兩秒以內的所有發言，
$alastmod = @filemtime($filename);
$name = $_POST['name'];
$name = str_replace("\n","",$name);
$ip = get_ip();
$json = array();
$json["lastmod"] = time();
$item = array();
$newonline = array();
$offline = array();

$fp = @fopen($filename,'r');
flock($fp,LOCK_EX);
$s = fread($fp,filesize($filename));
flock($fp,LOCK_UN);
fclose($fp);
$lines = explode("\n",$s);

if ($alastmod >= $lastmod && !$first)
{
foreach($lines as $l)
{
$item2 = array();
$l = str_replace(array("\n","\r"),"",$l);
if (strpos($l,"|") === false) continue;
$arr = explode("|",$l);
$t = intval($arr[0]);
if ($t >= $lastmod)
{
$item2["time"] = date("H:i:s",$t);
$item2["word"] = addslashes($arr[1]);
$item[] = $item2;
}
}
}
else if ($first)
{
$item = array();
$total = count($lines);
for($i=$total-1;$i>=$total-$least;$i--)
{
if ($i<=0) break;
$item2 = array();
$l = str_replace(array("\n","\r"),"",$lines[$i]);
if (strpos($l,"|") === false) continue;
$arr = explode("|",$l);
$t = intval($arr[0]);
$item2["time"] = (date("m-d",time()) == date("m-d",$t))?date("H:i:s",$t):date("m-d H:i",$t);
$item2["word"] = addslashes($arr[1]);
$item[] = $item2;
}
$item = array_reverse($item);
}

$s = "";
$nt = time();
$onlines = array();
if($disonline && $touchme)
{
$users = @file($datafile);
foreach($users as $l)
{
$l = str_replace(array("\r","\n"),"",$l);
if (strpos($l,"|") === false)
{
$s.=$l."\n";
continue;
}
$arr = explode("|",$l);
if ($nt - intval($arr[1]) < $touchs*3)
{
if (trim($name) == trim($arr[2]))
{
$s.= $arr[0]."|".time()."|".$name."|".get_ip()."|\n";
}
else $s.=$l."\n";
$onlines [] = $arr[2];
}
}
@file_put_contents($datafile,$s);
$json["onlines"] = $onlines;
}
$json["lines"] = $item;
echo array2json($json);
}
else if ($action == "keep" )
{
keeponline();
echo "keep ok";
}
else if ($action == "quit")
{
$name = $_POST['name'];
if($disonline)
{
$users = @file($datafile);
foreach($users as $l)
{
$l = str_replace(array("\r","\n"),"",$l);
if (strpos($l,"|") === false)
{
$s.=$l."\n";
continue;
}
$arr = explode("|",$l);
if (trim($name) == trim($arr[2])) continue;
else $s.=$l."\n";
}
@file_put_contents($datafile,$s);
echo "OK";
}
die();
}
else
{
?>

<html>
<head>
<title>迷你聊天 | <?php echo $title;?></title>
<meta http-equiv='Pragma' content='no-cache' />
<meta http-equiv=Content-Type content="text/html; charset=<?php echo $charset;?>" />
<meta name="keywords" content="<?php echo $lang["keywords"];?>">
<meta name="description" content="Mini AJAX Chatroom By Longbill. <?php echo $description;?>">

<style type='text/css'>
body { text-align:center; color:#333333; font-size:12px; margin:0px}
a { text-decoration:none; color:#a2b700; }
.mydiv { text-align:left; margin:5px; padding:5px; border:1px solid #999; width:520px; }
.inputtext { border:0px; border-bottom:1px solid #333333; background-color:transparent;}
.submit { border:1px solid #999; background-color:transparent; }
.contents { border:1px solid #999; margin:5px; margin-top:10px;background-color:#ffffff; overflow:auto;word-break:break-all;word-wrap :break-word;}
.bg { background-color:#ffffff; }
.content { border:0px;background-color:transparent;width:auto; font-size:16px; font-family:Fixedsys; margin:2px; padding:1px; }
.time { color:#aaaaaa; font-size:10px; font-family:Arial;}
.online { margin:5px; padding:0px; display:inline; }
.mybut { width:20px; height:20px; background-color:#999; text-align:center; font-size:18px; color: #333333;}
</style>

<script>
function $(obj)
{
return document.getElementById(obj);
}

function setCookie(name,value,t)
{
var cookieexp = 5*30*24*60*60*1000; //5 months
var cookiestr=name+"="+escape(value)+";";
var expires = "";
var d = new Date();
var t2=(!t)?cookieexp:t*60*1000;
d.setTime( d.getTime() + cookieexp);
expires = "expires=" + d.toGMTString()+";";
document.cookie = cookiestr+ expires;
}

function getCookie(name)
{
var start = document.cookie.indexOf( name + "=" );
var len = start + name.length + 1;
if ( ( !start ) && ( name != document.cookie.substring( 0, name.length ) ) ) return "";
if ( start == -1 ) return "";
var end = document.cookie.indexOf( ";", len );
if ( end == -1 ) end = document.cookie.length;
return unescape( document.cookie.substring( len, end ) );
}

function createAJAX()
{
if (window.XMLHttpRequest)
{
var oHttp = new XMLHttpRequest();
return oHttp;
}
else if (window.ActiveXObject)
{
var versions = [
"MSXML2.XmlHttp.6.0",
"MSXML2.XmlHttp.3.0"
];

for (var i = 0; i < versions.length; i++)
{
try {
var oHttp = new ActiveXObject(versions[i]);
return oHttp;
} catch (error) {}
}
}
throw new Error("Your browser doesn't support XMLHttpRequest");
}

function pickColor()
{
if (!window.isIE) return;
var sColor = $('dlgHelper').ChooseColorDlg();
var color = sColor.toString(16);
while (color.length<6) color="0"+color;
window.color = color;
color = "#"+color;
$('div_color').style.backgroundColor = color;
$('div_color').value = color;
}

var isIE = (document.all && window.ActiveXObject) ? true : false;
</script>
</head>
<body >
<center>

<div class='contents mydiv rooms' style='height:230px;' id='div_contents'>Loading...</div>

<div class="mydiv login" id='div_name' style='display:block;'>
暱稱:<input type=text class="inputtext bg" size="12" id='chat_user' value='<?php echo $_SESSION['ec_user']==""?"未登入":$_SESSION['ec_user']; ?>' readonly />
<OBJECT id=dlgHelper CLASSID="clsid:3050f819-98b5-11cf-bb82-00aa00bdce0b" WIDTH="0px" HEIGHT="0px"></OBJECT>
<input class="inputtext" style='width:55px;cursor:hand;10px;background-color:#000000;color:#ffffff;' id='div_color' onClick="pickColor()" value="#000000" onBlur="this.style.backgroundColor=this.value;window.color=this.value.replace('#','');" />
字體:
<select id='input_font' class='inputtext bg' style='width:100px;'>
<option value='heiti' selected>新細明體</option>
<option value='Fixedsys'>Fixedsys</option>
</select>
加粗:<input type=checkbox id='input_bold' class='inputtext' style='border-bottom:0px;' />
<a href='#' onclick='clearAll()'>清屏</a>
<input type="text" class="inputtext bg" id="chat_word" style="height:20px;overflow:hidden;width:420px;" onFocus="if (this.value == '<?php echo $lang["hereyourwords"];?>') this.value='';" onKeyDown="return check_send(event);" value="<?php echo $lang["hereyourwords"];?>" scrolling="no">
<input type=button class=submit value='發 表' onClick="chat_send();$('chat_word').style.height=20;" onFocus="this.blur();"/>
</div>

<script>
var debug = 0;
var lastmod = <?php echo time()-$earlier*60;?>;
var login = 1;
var loading = false;
var room = "<?php echo $room;?>";
var first = 1;
var dis = "<?php echo $least;?>";
var lastword;
var color='';
var touchs = <?php echo $touchs;?>;
var dotouch = true;
var maxdisplay = <?php echo $maxdisplay;?>;
var nowdisplay = 1;
var sending = 0;
var loaded_lines = [];
function encode(s)
{
return (encodeURIComponent)? encodeURIComponent(s):s;
}

var keep_ajax;
function keeponline()
{
var name = $('chat_user').value;
if (!name) return;
keep_ajax = createAJAX();
keep_ajax.open('POST','<?php echo basename(__FILE__);?>',1);
keep_ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

keep_ajax.onreadystatechange = function ()
{
if (keep_ajax.readyState == 4 && keep_ajax.status == 200)
{
//alert(keep_ajax.responseText);
}
}
keep_ajax.send("action=keep&name="+encode(name));
}
setInterval("keeponline()",touchs*1000);

function quitroom()
{

var ajax = createAJAX();
ajax.open('POST','<?php echo basename(__FILE__);?>',0);
ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
ajax.send("action=quit&name="+encode($('chat_user').value));
//alert("sending close action=quit&name="+encode($('chat_user').value));
//alert("response:"+ajax.responseText);

}
document.body.onbeforeunload = quitroom;

setInterval(" load_word()",(debug)?6000:1000);

var load_word_ajax;

//下載完成後的處理函數
function load_word_change()
{
if (load_word_ajax.readyState == 4)
{
if (load_word_ajax.status != 200)
{
load_word_error();
return;
}
window.loading = false;
var body = $('div_contents');

try {
if (debug) alert(load_word_ajax.responseText);
eval("var arr = "+load_word_ajax.responseText);
} catch(e)
{
alert('Error 101\nJSON syntax error!\n\n'+load_word_ajax.responseText);
return;
}
if (!arr || !arr.lastmod || typeof(arr.lastmod) == "undefined" )
{
return;
}

var html = "";
var line = arr.lines;
var i = 0;
var v1 = 0;
var div_online = $('div_online');
if (window.first)
{
body.innerHTML = "";
window.first = false;
}

if (arr.onlines)
{
$('div_online').innerHTML = "";
for(var i=0;i<arr.onlines.length;i++) addonline(arr.onlines[i]);
}
for(var i=0;i<line.length;i++)
{
var linekey = line[i].word.substring(line[i].word.length-20,line[i].word.length)+line[i].time;
if (window.loaded_lines[linekey] === true)
{
if (debug) alert("jump:"+linekey);
continue;
}
var div1 = document.createElement("div");
window.nowdisplay ++;
if (window.nowdisplay > window.maxdisplay) window.nowdisplay = 1;
if ($("contentitem"+window.nowdisplay)) body.removeChild($("contentitem"+window.nowdisplay));
div1.className = "content";
div1.id = "contentitem"+window.nowdisplay;
div1.innerHTML = line[i].word+" <span class='time'>("+line[i].time+")</span>";
body.appendChild(div1);

window.loaded_lines[linekey] = true;
body.scrollTop = 655350;
v1 = 1;
}

if (v1)
{
window.focus();
document.body.focus();
window.lastmod = arr.lastmod;
if(debug) alert("lastmod = "+arr.lastmod + " \nwindow.lastmod="+window.lastmod);
if ($('chat_word').disabled == false) $('chat_word').focus();
}
}
}

function load_word_error()
{
window.loading = false;
window.status = 'Error 102:while loading words';
setTimeout("window.status = '';",5000);
}

function load_word()
{
load_word_ajax = createAJAX();
if (window.loading)
{
try
{
load_word_ajax.abort();
window.loading = false;
}catch(e) {}
}
if (!window.lastmod)
{
alert("window.lastmod="+window.lastmod);
return;
}

load_word_ajax.open('POST','<?php echo basename(__FILE__);?>',true);
load_word_ajax.onreadystatechange = load_word_change;

var urlstring = '';
urlstring += "lastmod="+window.lastmod;
urlstring+= "&room="+room;
urlstring+= "&action=read";
urlstring+= "&name="+encode($('chat_user').value);

if (window.first)
{
urlstring+= "&first=true";
urlstring += "&dis="+dis;
}
//如果到了取得在線用戶的時間
if (window.dotouch)
{
urlstring+= "&touchme=true";
window.dotouch = false;
//垃圾內存回收
try { CollectGarbage(); } catch(e) {}
}

window.loading = true;
if (debug) alert("sending:"+urlstring);
load_word_ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

load_word_ajax.send(urlstring);
}

function touchme()
{
window.dotouch = true;
setTimeout("touchme()",window.touchs*1000);
}

function showalert(a,n)
{
if (!n) n=0;
if (n>3) return;
if (!a)
{
a = 0;
b = 1;
}
else
{
a = 1;
b = 0;
}
document.title = mytitle[a];
setTimeout("showalert("+b+","+(n+1)+");",500);
}

function addonline(name)
{
if ($(name)) return;
var d1 = document.createElement("div");
d1.id = name;
d1.innerHTML = name;
d1.className = "online";
$('div_online').appendChild(d1);
}

touchme();

function check_send(e)
{
if (!e) e = window.event;
var obj = $('chat_word');
if (isIE) obj.style.height = obj.scrollHeight+3;
if (e.keyCode == 13)
{
if ((!e.shiftKey && !e.altKey && !e.ctrlKey) || !isIE)
{
chat_send();
obj.style.height = 20;
return false;
}
else if (isIE) obj.style.height = obj.scrollHeight+18;
}
return true;
}

var send_ajax;
send_ajax_change = function()
{
if (send_ajax.readyState == 4)
{
if (send_ajax.status != 200)
{
send_ajax_error();
return;
}
if (debug) alert("send_ajax response:"+send_ajax.responseText);
if (send_ajax.responseText.indexOf("NAME")!=-1)
{
alert('該暱稱已被人佔用了！');
$('chat_user').value = "";
$('chat_user').focus();
}
else if (send_ajax.responseText.indexOf("repeat")!=-1)
{
$('chat_word').value = window.lastcontent;
}

on_send_ok();

if (!window.loading)
{
window.dotouch = true;
load_word();
}
}
}

function on_send_begin()
{
with($('chat_word'))
{
disabled = true;
style.backgroundColor = "#eeeeee";
}
window.sending = 1;
}

function on_send_ok()
{
window.sending = 0;
with($('chat_word'))
{
value = '';
disabled = false;
focus();
style.backgroundColor = "#ffffff";
}
}

function on_send_error()
{
window.sending = 0;
with($('chat_word'))
{
disabled = false;
focus();
style.backgroundColor = "#ffffff";
}
}

function send_ajax_error()
{
alert('Error 103\nwhen send words\n\nYou can send them again!');
$('chat_word').value = window.lastcontent;
window.sending = 0;
on_send_error();
}

function chat_send()
{
send_ajax = createAJAX();
send_ajax.open('POST','<?php echo basename(__FILE__);?>',true);
send_ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
send_ajax.onreadystatechange = send_ajax_change;
var urlstring = '';
var name = $('chat_user').value.replace("\n","");
var content = $('chat_word').value;
var bold = ($('input_bold').checked)?"bold":"";
var size = 12;
var font = $('input_font').value;

if (name == "")
{
alert('Please enter your nick name first!!');
$('chat_user').focus();
return;
}

if (content == "" || content == "\n" || content == "\n\n" || content == "\n\n\n")
{
alert('Please enter your words!');
$('chat_word').focus();
$('chat_word').value = "";
return;
}
if (size>100) size = 100;
else if (size<0) size = 1;

urlstring+= "action=write";
urlstring+= "&name="+encode(name);
urlstring+= "&content="+encode(content);
urlstring+= "&bold="+bold;
urlstring+= "&color="+window.color;
urlstring+= "&size="+size;
urlstring+= "&font="+font;
urlstring+= "&room="+room;

window.sending = 1;
window.lastcontent = content;
on_send_begin();
if (debug) alert("sending:"+urlstring);

send_ajax.send(urlstring);
setTimeout("if (window.sending) send_ajax.abort(); on_send_error();",5000);
}

function clearAll()
{
$('div_contents').innerHTML = "";
}
</script>
</center>
</body>
</html>
<?php
}
?>