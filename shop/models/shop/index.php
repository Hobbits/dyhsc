<?php
if(!$IWEB_SHOP_IN) {
	 trigger_error('Hacking attempt');
}
/* 公共信息处理 header, left, footer */
require("foundation/module_shop.php");
require("foundation/module_users.php");
require("foundation/asystem_info.php");
require("foundation/module_shop_category.php");

//引入语言包
$s_langpackage=new shoplp;
$i_langpackage=new indexlp;
$m_langpackage=new moduleslp;
/* 数据库操作 */
dbtarget('r',$dbServs);
$dbo=new dbex();

/* 定义文件表 */
$t_shop_info = $tablePreStr."shop_info";
$t_user_info = $tablePreStr."user_info";
$t_users = $tablePreStr."users";
$t_shop_category = $tablePreStr."shop_category";
$t_goods = $tablePreStr."goods";
$t_shop_guestbook = $tablePreStr."shop_guestbook";
$t_shop_categories = $tablePreStr."shop_categories";
$t_user_rank = $tablePreStr."user_rank";
$verifycode = unserialize($SYSINFO['verifycode']);

/* 商铺信息处理 */
include("foundation/fshop_locked.php");

//判断用户是否锁定，锁定则不许操作
$user_id = get_sess_user_id();
if($user_id > 0){
	$sql ="select locked from $t_users where user_id=$user_id";
	$row = $dbo->getRow($sql);
	if($row['locked']==1){
		session_destroy();
		trigger_error($m_langpackage->m_user_locked);//非法操作
	}
}

//商铺分类
$shop_rank = $SHOP['shop_categories'];
$shop_rank_arr = get_categories_rank($shop_rank,$dbo,$t_shop_categories);
if ($shop_rank_arr){
	$num = count($shop_rank_arr) - 1;
}

$sql = "select rank_id,user_name,last_login_time from $t_users where user_id='".$SHOP['user_id']."'";
$ranks = $dbo->getRow($sql);
$SHOP['rank_id'] = $ranks[0];

$sql = "select * from $t_user_rank where rank_id='".$ranks[0]."'";
$user_rank = $dbo->getRow($sql);

$best_num = 10;
$privilege = unserialize($user_rank[2]);
if($privilege){
	$best_num = $privilege[4];
}

/* 获取文章头部 */
$header = get_shop_header($s_langpackage->s_shop_index,$SHOP);
/* 本页面信息处理 */
$sql = "select goods_id,goods_name,goods_price,goods_thumb,is_set_image,transport_template_price from `$t_goods` where shop_id='$shop_id' and is_best=1 and is_on_sale=1 and lock_flg=0 order by sort_order asc,goods_id desc limit ".$best_num;
$best_goods = $dbo->getRs($sql);

$sql = "select goods_id,goods_name,goods_price,goods_thumb,is_set_image,transport_template_price from `$t_goods` where shop_id='$shop_id' and is_on_sale=1 and lock_flg=0 order by sort_order asc,goods_id desc limit 12";
$new_goods = $dbo->getRs($sql);


$sql = "SELECT * FROM $t_shop_guestbook WHERE shop_id='$shop_id' AND shop_del_status='1' order by add_time desc limit 10";
$guestbook_list = $dbo->getRs($sql);
$nav_selected="";

?>