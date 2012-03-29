<?php


	function get_hour($l) {
		return trim($l[count($l)-2]);
	}

	function get_name($l) {
		return $l[count($l)-1];
	}

	function get_day($l) {
		return trim($l[0]);
	}

	function print_hours() {
		for ($h=0;$h<24;$h++) {
				$m="00";
				$hour=$h.":".$m.":00";
				$b = Array ($hour => $hour);
				print_block($b,0);
		} 
	}


	function print_block($b,$x) {
		# key(b) es la fecha 00:00:00
		# b(key(b))
		# positionX = x*WIDTH/1050
		# positionY = y*HEIGHT/1439 	
		$WIDTH = 1000;
		$HEIGHT = 600;
	
		foreach ($b as $c) {
			@list($h,$m,$s) = split(':',key($b));
			$positionY = (($h*60+$m)*$HEIGHT/1440)+50;
			$positionX = ($x*$WIDTH/1050)+30;
			if ( $c[0] ) { $color = dechex(ord($c[0])).dechex(ord($c[0])).dechex(ord($c[0])); } else { $color = "555"; }
			$w = $WIDTH/8;
			$h = $HEIGHT/24;
			print "<div style='font-size:10px;text-align:center;position:absolute;border:1px solid #000;top:".$positionY."px;left:".$positionX."px;width:".$w."px;height:".$h."px;background-color:#".$color.";'>".$c."</div>";
		}
	}

	function get_sizeX($d) {
		switch ($d) {
				case "Monday" : 
					$x = 150;
					break;
				case "Tuesday" :
					$x = 300;
					break;
				case "Wednesday":
					$x = 450;
					break;
				case "Thursday":
					$x = 600;
					break;
				case "Friday":
					$x = 750;
					break;
				case "Saturday":
					$x = 900;
					break;
				case "Sunday":
					$x = 1050;
					break;	
				default :
					$x = 0;
		}
		return $x;	
	}


	function print_sched() {
		#PARSE 
		$aras_path = "";
		$aras_sched = "aras.schedule";
		$f = fopen($aras_path.$aras_sched,"r");
	
		print_hours();
		while ( ($b = fgets($f,4096)) !== false) {
			$l = explode(" ",$b);
			if ($l[0] != "#" && count($l) > 1 ) {
				$sched = array ( get_day($l) => array ( get_hour($l) => get_name($l) ) );
				print_block($sched[get_day($l)],get_sizeX(get_day($l)));		
			}	
		} 
	}
		
?>

<html>
<head>
<title>ARAS Scheduler</title>
</head>
<body>
<div style="position:absolute;font-family:sans;left:50%;top:10px;z-index:2;font-size:30px;">ARAS SCHED <?php date_default_timezone_set("UTC"); date("H:m:s");?></div>
<?php print_sched(); ?>
</body>
</html>
