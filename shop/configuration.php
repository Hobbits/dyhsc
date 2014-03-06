<?php
/* Iweb产品配置文件 */
if(!$IWEB_SHOP_IN) {
	die("Hacking attempt");
}

ini_set("date.timezone","UTC");

//站点配置
$webRoot = str_replace("\\","/",dirname(__FILE__))."/";
$adminEmail = 'admin@admin.com';
//缓存更新延时设置,单位为秒
$cache_update_delay_time="0";

//语言包参数，目前参数值zh,en
$langPackagePara = 'zh';
$langPackageBasePath = 'langpackage/'.$langPackagePara.'/';

//支持库配置
$baseLibsPath = 'iweb_mini_lib/';

//plugins位置文件
$pluginOpsition = array("index.html");

// session 前缀
global $session_prefix;
$session_prefix = 'iweb_';

// web访问根目录

$shopimg = "uploadfiles/shop/default/default.png";
$shopthumbimg = "uploadfiles/shop/default/thumbdefault.png";

$goodimg = "uploadfiles/goods/default/default.png";
$goodthumbimg = "uploadfiles/goods/default/thumbdefault.png";
// $baseUrl = 'http://yunku.4pu.com/shop/';
$baseUrl = 'http://yk.no-ip.biz/yunkuApp/shop/';
//$baseUrl = 'http://192.168.1.2/shop/';


// url_rewrite 是否开启
$url_rewrite = 2;

// IM 是否开启
$im_enable = false;
?>
