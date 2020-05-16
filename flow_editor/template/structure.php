<?php 
	if(in_array($_GET['ori'],['TD','TB','BT','RL','LR'])){
		if(in_array($_GET['ori'],['TD','TB','BT'])){
			$jsFix = "$('#graphDiv').css('height','auto');";
		}else{
			$jsFix = "$('#graphDiv').css('width','auto');";
		}
	}else{
		screenMessage("ERROR","Wrong Param");
	}
	
	$tolerance = intval($_GET['tolerance'])?intval($_GET['tolerance']):1000;
	
	$graphDef = "graph {$_GET['ori']}\\n";
	foreach($arr2 as $v){
		if(abs($v['from'] - $v['to'])>$tolerance){
			continue;
		}
		if($title[$v['to']] == ""){
			$title[$v['to']] = "empty";
		}
		$tmp = "{$v['from']}[\"{$title[$v['from']]}\"]-->{$v['to']}[\"{$title[$v['to']]}\"]";
		if($prev != $tmp){
			$graphDef .= "\\t".$tmp."\\n";
			$prev = $tmp;
		}
	}
?>
<script>
	var linkElement = document.createElement("link");
	linkElement.rel = "stylesheet";
	linkElement.href = "https://cdn.rawgit.com/knsv/mermaid/6.0.0/dist/mermaid.css"; //Replace here

	document.head.appendChild(linkElement);
</script>
<script src='https://cdn.rawgit.com/knsv/mermaid/6.0.0/dist/mermaid.min.js'></script>
<script src='https://cdn.rawgit.com/anvaka/panzoom/v2.5.0/dist/panzoom.min.js'></script>
<style>.label{font-size:100%}
.node{cursor:pointer}	
#graphDiv{outline:none!important}
</style>
<script>mermaid.initialize({startOnLoad:false});
	
    $(function(){
        var insertSvg = function(svgCode, bindFunctions){
            $(".mermaid").html(svgCode);
			<?=$jsFix;?>
			$('#graphDiv').css('background-color','white');
			var a = $('g.output');
			panzoom(a[0])
			//$("div#graphDiv").css("height",$("#page-wrapper").height());
			//$("svg#graphDiv").css("height",$("#page-wrapper").height());
			var svg = document.querySelector('#graphDiv').outerHTML;
			$("#dlbtn").attr('href','data:image/svg+xml;base64,' + utoa(svg));
        };

        var graphDefinition = '<?=$graphDef;?>';
        var graph = mermaidAPI.render('graphDiv', graphDefinition, insertSvg);
		
		$('.nodes').find( '[id]' ).click(
			function(){
				window.open('editfile.php?id='+$(this).attr('id'));
			}
		);
		
		
    });	
	
</script>

<div class="mermaid"></div>
<a class='btn btn-default' href='structure.php?ori=TD'>由上向下</a>
<a class='btn btn-default' href='structure.php?ori=LR'>由左向右</a>
<a class='btn btn-primary' download='diagram.svg' id='dlbtn'>下載本圖</a>
<script>
	
	function utoa(str) {
    return window.btoa(unescape(encodeURIComponent(str)));
}
</script>