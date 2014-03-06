<?php
function set_picdir($basedir,$filedir = '') {
		$dir = $basedir;
		!is_dir($dir) && @mkdir($dir,0777);
		if (!empty($filedir)) {
			$filedir = str_replace(array('{y}','{m}','{d}'),array(date('Y',time()),date('m',time()),date('d',time())),strtolower($filedir));
			$dirs = explode('/',$filedir);
			foreach ($dirs as $d) {
				!empty($d) && $dir .= $d.'/';
				!is_dir($dir) && @mkdir($dir,0777);
			}
		}
		return $dir;
	}

function get_rand($num){
	$chars = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','1','2','3','4','5','6','7','8','9','0');
	$charslen = count($chars)-1;
	shuffle($chars);
	$output ='';
	for($i = 0;$i < $num;$i++){
		$output .= $chars[rand(0, $charslen)];
	}
	return $output;
}

function time_long($time){//计算时长
  $min=floor(($time/60));
  if ($min < 1){
  	$str = '刚刚';
  }elseif ($min < 60){
  	$str = $min.'分钟前';
  }elseif($min > 60){
  	$hour =floor(($time/3600));
  	if ($hour<24){
  		$str = $hour.'小时前';
  	}else{
  		$day = floor(($time/86400));
  		$str = $day.'天前';
  	}
  }
  return $str;
}