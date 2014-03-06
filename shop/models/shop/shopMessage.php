<?php
if(!$IWEB_SHOP_IN) {
	trigger_error('Hacking attempt');
}

//引入语言包
$m_langpackage=new moduleslp;
$i_langpackage=new indexlp;

$status=get_args('status');
?>