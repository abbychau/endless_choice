<?php 
	require_once('../include/sqldata.php'); 
	require_once('chksess.php');
	
	$editFormAction = $_SERVER['PHP_SELF'];
	
    function generateStoryCanStorage($string){
        $string = trim($string);
        $lines = explode(PHP_EOL, $string);
        $gather = [];
    
        $item = [];
        $context = [];
        foreach($lines as $v){
            $rl = trim($v);
            
            if(mb_substr($rl,0,1) == '#'){
                if($context){
                    $gather[$item['main_seq']][$item['sub_seq']] = $context;
                    $item = [];
                    $context = [];
                }
                
                
                
                $val = trim(mb_substr($rl, 1));
                if(mb_stristr($val,'.')){
                    $parts = explode(".",$val);
                    $item['main_seq'] = $parts[0];
                    $item['sub_seq'] = $parts[1];
                }else{
                    $item['main_seq'] = $val;
                    $item['sub_seq'] = '0';
                }
            }else{
                $context[] = $rl;
            }
		}
		$gather[$item['main_seq']][$item['sub_seq']] = $context;
		$item = [];
		$context = [];
        return json_encode($gather,JSON_FORCE_OBJECT);
    }

	$allCates = dbAr("SELECT * FROM ec_can WHERE world_id = :world_id", ["world_id"=>$worldid]);
	
	if (isset($_POST["action"])) {
	    
	    if($_POST["action"] == 'create'){
    		dbQuery("INSERT INTO `ec_can` (`world_id`, `can_cate`, `content`, `cache`) 
    		VALUES (:world_id, :cate_id, :content, :cache)",[
    		    'world_id'=>$worldid,
    		    'cate_id'=>$_POST['cate_id'],
    		    'content'=>$_POST['content'],
    		    'cache'=> generateStoryCanStorage($_POST['content'])
			]);
		}
		
	    if($_POST["action"] == 'update'){
	        
    		dbQuery("UPDATE `ec_can` SET `content` = :content , `can_cate` = :can_cate, `cache` = :cache
    		WHERE `world_id` = :world_id AND id = :id",
    		[
    		    'content'=>$_POST['content'],
    		    'can_cate'=>$_POST['cate_id'],
    		    'world_id'=>$worldid,
    		    'id'=>$_POST['id'],
    		    'cache'=> generateStoryCanStorage($_POST['content'])
			]);
			
	    }
	    if($_POST["action"] == 'delete'){
    		dbQuery("DELETE FROM `ec_can` WHERE `id` = :id AND `world_id` = :world_id",
    		[
    		    'world_id'=>$worldid,
    		    'id'=>$_POST['id']
		    ]);
	    }
	    
		header(sprintf("Location: %s", "cancatadmin.php"));
	}

	$suggestCateID = intval(dbRs("SELECT max(can_cate) FROM ec_can WHERE world_id = :world_id", ["world_id"=>$worldid])) + 1;

	
	$wrapin=basename($_SERVER["SCRIPT_FILENAME"], '.php');
	include_once("template/frame.php");