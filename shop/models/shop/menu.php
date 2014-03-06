<?php
if(!$IWEB_SHOP_IN) {
	trigger_error('Hacking attempt');
}
$app = short_check(get_args('app'));
?>