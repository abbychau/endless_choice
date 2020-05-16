<?
	//DATABASE
	//error handler
	function dbErr($msg, $qry){
		$str.= "Error Catched!<br /><br />";
		$str.= "Message:<br />";
		$str.= "$msg<br /><br />";
		$str.= "Query:<br />";
		$str.= "$qry<br /><br />";
		file_put_contents("sql_err",$msg."\t".$qry,FILE_APPEND);
		return $str;
	}
	if(!function_exists("cacheValid")){
	    function cacheValid($x){
	        return false;
	    }
	}
	
    function dbAr($query,$param=[]){
        global $dbh;
        if($param!=[]){
            $stmt = $dbh->prepare($query);
            $stmt->execute($param);
        }else{
            $stmt = $dbh->query($query);
        }
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $x = [];
    
        foreach ($stmt as $v) {
            $x[] = $v; //clone
        }
        return $x;
    }
    function dbRow($query,$param=[]){
        $x = dbAr($query,$param);
        return isset($x[0])?$x[0]:[];
    }
    function dbRs($query,$param=[]){
        $x = dbRow($query,$param);
        return reset($x);
    }
    function dbQuery($query,$param=[]){
        global $dbh;
        if($param!=[]){
            $stmt = $dbh->prepare($query);
            $stmt->execute($param);
        }else{
            $dbh->query($query);
        }
    }
	function dbAffected(){
		global $conn;
		return mysqli_affected_rows($conn);
	}
	function dbUpdate($tableName,$pairs,$where){
		
	}
	
	
		function encrypt($string, $key = 'rf'){
		$result = '';
		for ($i = 0; $i < strlen($string); $i++) {
			$char = substr($string, $i, 1);
			$keychar = substr($key, ($i % strlen($key)) - 1, 1);
			$char = chr(ord($char) + ord($keychar));
			$result.= $char;
		}
		return base64_encode($result);
	}
	function decrypt($string, $key = 'rf'){
		$result = '';
		$string = base64_decode($string);
		for ($i = 0; $i < strlen($string); $i++) {
			$char = substr($string, $i, 1);
			$keychar = substr($key, ($i % strlen($key)) - 1, 1);
			$char = chr(ord($char) - ord($keychar));
			$result.= $char;
		}
		return $result;
	}
	
	
		//timer
	function logStartTime(){
		global $start;
		$time = explode(' ', microtime());
		$time = $time[1] + $time[0];
		$start = $time;
	}
	function logEndTime(){
		global $start;
		$time = explode(' ', microtime());
		$time = $time[1] + $time[0];
		return round(($time - $start), 4)*1000;
	}
	
	
	function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = ""){
		//global $conn;
		if (PHP_VERSION < 6) {
			$theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
		}
		//$theValue = mysqli_real_escape_string($conn,$theValue);
		switch ($theType) {
			case "long":
			case "int":
			case "integer":
			$theValue = ($theValue != "") ? intval($theValue) : "NULL";
			break;
			
			case "double":
			$theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
			break;
			
			case "text":
			case "date":
			$theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
			break;
			
			case "defined":
			$theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
			break;
		}
		return $theValue;
	}
	
	
	function screenMessage($title,$message,$url="",$errorCode=""){
		global $ttl,$msg,$defaulturl,$gId,$isLog;
		
		$ttl = $title;
		$msg = $message;
		$defaulturl = $url;
		if($errorCode!=""){
			if($errorCode==404){
				header('HTTP/1.1 404 Not Found', true, 404);
			}
		}
		echo "<h1>$title</h1><p>$message</p>";
		echo $url?"<a href='$url'>$url</a>":"";
		exit;
	}
	
	function timeago($referencedate=0, $timepointer='', $measureby=''){
		
		// Measureby can be: s, m, h, d, or y
		
		if($timepointer == '') $timepointer = time();
		$Raw = $timepointer-$referencedate;## Raw time difference
		$Clean = abs($Raw);
		
		if($Clean > 60*60*24*30){
			if(date("Y")==date("Y",$referencedate)){
				$strTime = date("n月j日",$referencedate);
				}else{
				$strTime = date("Y年n月j日",$referencedate);
			}
			return $strTime;
		}
		
		$calcNum = array(
		array('s', 60),
		array('m', 60*60),
		array('h', 60*60*60),
		array('d', 60*60*60*24),
		array('mo', 60*60*60*24*30)
		);
		## Used for calculating
		$calc = array(
		's' => array(1, '秒'), 
		'm' => array(60, '分鐘'), 
		'h' => array(60*60, '小時'), 
		'd' => array(60*60*24, '日'), 
		'mo' => array(60*60*24*30, '個月')
		);
		
		if($measureby == ''){
			$usemeasure = 's';## Default unit
			for($i=0; $i<count($calcNum); $i++){
				if($Clean <= $calcNum[$i][1]){
					$usemeasure = $calcNum[$i][0];
					$i = count($calcNum);
				}
			}
			}else{
			$usemeasure = $measureby;## Used if a unit is provided
		}
		
		$datedifference = floor($Clean/$calc[$usemeasure][0]);
		
		if($referencedate != 0){
			return $datedifference . '' . $calc[$usemeasure][1] . '前';
			}else{
			return 'No Time';
		}
	}
	
	function gaScript(){
		return "<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-80767368-1', 'auto');
  ga('send', 'pageview');

</script>";
	}
	
	function ec_hash($str){
		$salt = date("Y-m-d", strtotime('today'));
		return substr(md5($str.$salt),1,10);
	}
	function ec_validate_hash($input,$target){
		$salt  = date("Y-m-d", strtotime('today'));
		$salt2 = date("Y-m-d", strtotime('yesterday'));
		if($input == substr(md5($target.$salt),1,10) || $input == substr(md5($target.$salt2),1,10)){
			return true;
		}else{
			return false;
		}
	}
	
	function safe($str){
	    //global $conn;
		return addslashes($str);
	}
	
	
function get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
       $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}


	function asc_shift($str,$offset=0) {
		$new = '';
		for ($i = 0; $i < strlen($str); $i++)
        $new .= chr(ord($str[$i])+$offset);
		return $new;
	}
	
	function trimZeroDot($str){
		if(stristr($str,".")){
			$str = trim($str,"0");
			$str = trim($str,".");
		}
		return $str;
	}
