<?php
header("content-type:text/html;charset=utf-8");
$IWEB_SHOP_IN = true;
require("../foundation/asession.php");
require("../configuration.php");
require("includes.php");
require_once($webRoot."langpackage/".$langPackagePara."/indexlp.php");
$i_langpackage=new indexlp;
$errstr=get_args("errstr");
$errorarray=explode("-",$errstr);
if(!$errorarray){
	$errorarray[0]=$i_langpackage->i_page_error;
}
if(!$errorarray[1]){
	$errorarray[1]=$baseUrl;
}

//echo "error.php";
//echo "<br>";
//echo $errorarray[0];
//echo "<br>";
//echo $errorarray[1];
echo "<br>行号";
echo get_args("errorline");
echo "<br>文件名";
echo get_args("errorfile");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta  http-equiv="Refresh" content="3;url=<?php echo $errorarray[1];?>" />
<title></title>
<link rel="stylesheet" type="text/css" href="skin/css/main.css">
<style>
body{
	font-size: 12px;
}
</style>
</head>

<body>
<div style="display:none"><?php echo $errorarray[0];?></div>
 <div class="warningInfo">
           <p>出现错误:<?php echo $errorarray[0]; ?></p>
           <?php echo $i_langpackage->i_href;?></br>
           <a title="<?php echo $i_langpackage->i_hand_index;?>" href="<?php echo $errorarray[1];?>">
           <?php echo $i_langpackage->i_hand_index;?>&gt;&gt;</a>
         </div>
</body>
</html>


