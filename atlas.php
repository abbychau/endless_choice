<?php 
require_once('include/sqldata.php'); 

$pages = dbAr("SELECT * FROM ec_pages WHERE wid = 121 ORDER BY id");
foreach($pages as $v){
	$tmptitle[intval($v['id'])] = $v['title'];
	
	
	preg_match_all("/ec_setChoiceTarget\(\d+,\d+\)/", $v['js'], $output_array);
	foreach($output_array[0] as $vv){
		$parts = explode(",",$vv);
		
		$arr2[] = ['from'=>intval($v['id']),'to'=>trim($parts[1],")")]; 
	}

	
}




foreach($pages as $page){ 

	for($i =1;$i<=6;$i++){
		if($page["c{$i}to"] != ""){
			$targetTitle = intval($page["c{$i}to"])?":".$tmptitle[$page["c{$i}to"]]:"";
			//echo intval($page['id']).":".$tmptitle[intval($page['id'])]."->".$page["c{$i}to"].$targetTitle."<br />"; 
			$arr2[] = ['from'=>intval($page['id']),'to'=>$page["c{$i}to"]]; 
		}

	}

}
//$arr2 = array_unique($arr2);
usort($arr2, function ($a,$b) {
    return $a['from'] == $b['from'] ? $a['to'] <=> $b['to'] : $a['from'] <=> $b['from'];
});
include("templateblock/header.php");?>

    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1.1", {packages:["wordtree"]});
      google.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable(
          [ ['Phrases'],
            ['cats are better than dogs'],
            ['cats eat kibble'],
            ['cats are better than hamsters'],
            ['cats are awesome'],
            ['cats are people too'],
            ['cats eat mice'],
            ['cats meowing'],
            ['cats in the cradle'],
            ['cats eat mice'],
            ['cats in the cradle lyrics'],
            ['cats eat kibble'],
            ['cats for adoption'],
            ['cats are family'],
            ['cats eat mice'],
            ['cats are better than kittens'],
            ['cats are evil'],
            ['cats are weird'],
            ['cats eat mice'],
          ]
        );

        var options = {
          wordtree: {
            format: 'implicit',
            word: 'cats'
          }
        };

        var chart = new google.visualization.WordTree(document.getElementById('wordtree_basic'));
        chart.draw(data, options);
      }
    </script>
	
	
	<div id="wordtree_basic" style="width: 900px; height: 500px;"></div>
	
	
	
<script src="/js/arbor/lib/arbor.js"></script>
<script src="/js/arbor/demos/atlas/atlas.js"></script>

<script src="/js/arbor/demos/_/jquery.address-1.4.min.js"></script>
<script src="/js/arbor/demos/_/graphics.js"></script>

<!-- the halfviz source, broken out one ‘class’ per file -->
<script src="/js/arbor/src/dashboard.js"></script>
<script src="/js/arbor/src/help.js"></script>
<script src="/js/arbor/src/io.js"></script>
<script src="/js/arbor/src/parseur.js"></script>
<script src="/js/arbor/src/renderer.js"></script>

<script src="/js/halfviz.jquery.js"></script>


<?php 
foreach($arr2 as $v){
	if(abs($v['from'] - $v['to'])>100){
		continue;
	}
	$tmp = $v['from']."-->".$v['to'];
	if($prev != $tmp){
		echo $tmp."<br />";
		$prev = $tmp;
	}
}
?><br />
<a href='http://ec.abby.md/js/arbor/demos/halfviz/#'>http://ec.abby.md/js/arbor/demos/halfviz/#</a>

<?php include("templateblock/footer.php");?>