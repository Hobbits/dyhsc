<?php
$goods = get_goods_info($dbo,$t_goods,'lock_flg',$goods_id);
if(!$goods) { trigger_error($s_langpackage->s_goods_error);}//没有此商品
if($goods['lock_flg']==1) { trigger_error($s_langpackage->s_goods_locked);}//锁定
?>