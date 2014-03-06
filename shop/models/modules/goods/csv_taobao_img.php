<?php
if(!$IWEB_SHOP_IN) {
	trigger_error('Hacking attempt1');
}
//引入语言包
$m_langpackage=new moduleslp;
$i_langpackage=new indexlp;

set_session("goodsvercode",md5(rand(10000,999999)));

?>