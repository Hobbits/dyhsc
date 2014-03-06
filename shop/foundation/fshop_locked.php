<?php
/* 商铺信息处理 */
$user_id = get_sess_user_id();
$SHOP = get_shop_info($dbo,$t_shop_info,$shop_id);

if(!$SHOP) { trigger_error($s_langpackage->s_shop_error);}//没有此商铺
if($SHOP['lock_flg']) { trigger_error($s_langpackage->s_shop_locked);}//锁定
if($user_id!=$SHOP['user_id']){
	if($SHOP['open_flg']) {
		trigger_error($s_langpackage->s_shop_close);
	}//关闭
}
?>
