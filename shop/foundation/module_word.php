<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

function get_word_list(&$dbo,$table) {
	$sql="select * from $table";
	return $dbo->getRow($sql);
}
?>