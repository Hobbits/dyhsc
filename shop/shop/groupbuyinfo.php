<?php
/*
 * 注意：此文件由itpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/shop/groupbuyinfo.html
 * 如果您的模型要进行修改，请修改 models/shop/groupbuyinfo.php
 *
 * 修改完成之后需要您进入后台重新编译，才会重新生成。
 * 如果您开启了debug模式运行，那么您可以省去上面这一步，但是debug模式每次都会判断程序是否更新，debug模式只适合开发调试。
 * 如果您正式运行此程序时，请切换到service模式运行！
 *
 * 如您有问题请到官方论坛（http://tech.jooyea.com/bbs/）提问，谢谢您的支持。
 */
?><?php
/*
 * 此段代码由debug模式下生成运行，请勿改动！
 * 如果debug模式下出错不能再次自动编译时，请进入后台手动编译！
 */
/* debug模式运行生成代码 开始 */
if(!function_exists("tpl_engine")) {
	require("foundation/ftpl_compile.php");
}
if(filemtime("templates/default/shop/groupbuyinfo.html") > filemtime(__file__) || (file_exists("models/shop/groupbuyinfo.php") && filemtime("models/shop/groupbuyinfo.php") > filemtime(__file__)) ) {
	tpl_engine("default","shop/groupbuyinfo.html",1);
	include(__file__);
} else {
/* debug模式运行生成代码 结束 */
?><?php
if(!$IWEB_SHOP_IN) {
	trigger_error('Hacking attempt');
}
/* 公共信息处理 header, left, footer */
require("foundation/module_shop.php");
require("foundation/module_goods.php");
require("foundation/module_users.php");
require("foundation/module_areas.php");
require("foundation/module_credit.php");
require("foundation/flefttime.php");
require("foundation/asystem_info.php");
//引入语言包
$s_langpackage=new shoplp;
$i_langpackage=new indexlp;
$m_langpackage=new moduleslp;
/* 定义文件表 */
$t_shop_info = $tablePreStr."shop_info";
$t_user_info = $tablePreStr."user_info";
$t_users = $tablePreStr."users";
$t_shop_category = $tablePreStr."shop_category";
$t_goods = $tablePreStr."goods";
$t_goods_gallery = $tablePreStr."goods_gallery";
$t_areas = $tablePreStr."areas";
$t_goods_attr = $tablePreStr."goods_attr";
$t_credit = $tablePreStr."credit";
$t_integral = $tablePreStr."integral";
$t_attribute = $tablePreStr."attribute";
$t_shop_payment = $tablePreStr."shop_payment";
$t_payment = $tablePreStr."payment";
$t_shop_groupbuy = $tablePreStr."groupbuy";
$t_shop_groupbuy_log = $tablePreStr."groupbuy_log";
$t_shop_guestbook = $tablePreStr."shop_guestbook";
$t_user_rank = $tablePreStr."user_rank";
$verifycode = unserialize($SYSINFO['verifycode']);
$group_id = intval($_GET['id']);
/* 数据库操作 */
dbtarget('r',$dbServs);
$dbo=new dbex();
$sql = "select goods_id,examine from `$t_shop_groupbuy` where group_id = $group_id";
$groupbuyinfo = $dbo->getRow($sql);
if($groupbuyinfo['examine']==0){
	throw_succes('0',$s_langpackage->s_groupbuy_lock_error,'0');
}
if ($groupbuyinfo){
	$goods_id = $groupbuyinfo['goods_id'];
}else {
	throw_succes('0',$s_langpackage->s_no_group,'0');
}
//判断用户是否锁定，锁定则不许操作
$user_id = get_sess_user_id();
if($user_id){
	$sql ="select locked from $t_users where user_id=$user_id";
	$row = $dbo->getRow($sql);
	if($row['locked']==1){
		session_destroy();
		throw_succes('0',$m_langpackage->m_user_locked,'0');
	}
}else{
	throw_succes('0',$m_langpackage->m_user_denglu,'0');
}

/* 数据库操作 */
dbtarget('w',$dbServs);
$dbo=new dbex();
$sql = "update $t_goods set pv=pv+1 where goods_id='$goods_id'";
$dbo->exeUpdate($sql);

/* 数据库操作 */
dbtarget('r',$dbServs);
$dbo=new dbex();

/* 产品信息获取 */
$sql = "select * from `$t_goods` where goods_id=$goods_id and is_on_sale=1";
$goodsinfo = $dbo->getRow($sql);
if($goodsinfo['lock_flg']) { throw_succes('0',$s_langpackage->s_goods_locked,'0'); }
if(!$goodsinfo) { throw_succes('0',$s_langpackage->s_goods_error,'0'); }

//获取商家信用值
$shop_id = $goodsinfo['shop_id'];
$credit=get_credit($dbo,$t_credit,$shop_id);
$credit['SUM(seller_credit)'] = intval($credit['SUM(seller_credit)']);
$integral=get_integral($dbo,$t_integral,$credit['SUM(seller_credit)']);

$sql = "SELECT * FROM $t_goods_gallery WHERE goods_id='$goods_id' order by is_set desc";
$gallery = $dbo->getRs($sql);

$sql = "SELECT * FROM $t_goods_attr WHERE goods_id='$goods_id'";
$goods_attr = $dbo->getRs($sql);
$attr = array();
$attr_ids = array();
$attr_status = false;
if($goods_attr) {
	foreach($goods_attr as $key=>$value) {
		$attr[$value['attr_id']] = $value['attr_values'];
		$attr_ids[] = $value['attr_id'];
	}
	$sql = "SELECT attr_id,attr_name FROM $t_attribute WHERE attr_id IN (".implode(',',$attr_ids).")";
	$attribute_result = $dbo->getRs($sql);
	$attribute = array();
	foreach($attribute_result as $value) {
		$attribute[$value['attr_id']] = $value['attr_name'];
	}
	$attr_status = true;
}

$areainfo = get_areas_kv($dbo,$t_areas);

/* 显示支付方式 */
$sql = "SELECT b.pay_id,b.pay_code FROM $t_shop_payment AS a, $t_payment AS b WHERE a.pay_id=b.pay_id AND a.shop_id=$shop_id AND a.enabled=1";
$result = $dbo->getRs($sql);
$payment_info = array();
if($result) {
	foreach($result as $value) {
		$temp = trim($value['pay_code'],' 0123456789');
		$payment_info[$temp] = $temp;
	}
}

/* 商铺信息处理 */
$shop_id = $goodsinfo['shop_id'];
$SHOP = get_shop_info($dbo,$t_shop_info,$shop_id);
if(!$SHOP) { throw_succes('0',$s_langpackage->s_no_this_goods,'0');}

$sql = "select rank_id,user_name,last_login_time from $t_users where user_id='".$SHOP['user_id']."'";
$ranks = $dbo->getRow($sql);
$SHOP['rank_id'] = $ranks[0];

$sql = "select goods_id,goods_name,goods_price,goods_thumb,is_set_image from `$t_goods` where shop_id=$shop_id and is_on_sale=1 order by is_best desc,is_hot desc,is_promote desc,is_new desc,goods_id desc limit 7";
$best_goods = $dbo->getRs($sql);

set_hisgoods_cookie($goodsinfo['goods_id']);

$header['keywords'] = $goodsinfo['goods_name'].','.$goodsinfo['keyword'];
$header['description'] = sub_str(strip_tags($goodsinfo['goods_intro']),100);

$user_id = get_sess_user_id();
/* 团购信息处理 */
if ($user_id){
	$isset_logo = false;
	if ($user_id == $shop_id){
		$sql = "select g.*,t.* from $t_shop_groupbuy g left join $t_goods t on g.goods_id = t.goods_id where g.shop_id = $user_id and g.group_id = $group_id";
	}else {
		$sql = "select * from $t_shop_groupbuy_log where group_id = $group_id and user_id = $user_id";
		$groupbuy_oneinfo = $dbo->getRs($sql);
		if ($groupbuy_oneinfo){
			$isset_groupbuy = true;
			$sql = "select * from $t_shop_groupbuy as g, $t_shop_groupbuy_log as l , $t_goods as t where g.group_id = l.group_id and l.group_id = $group_id and l.user_id = $user_id and g.goods_id=t.goods_id";

		}else {
			$isset_groupbuy = false;
			$sql = "select * from $t_shop_groupbuy g left join $t_goods t on g.goods_id = t.goods_id where g.group_id = $group_id";
		}
	}
}else {
	$isset_logo = true;
	$sql = "select * from $t_shop_groupbuy g left join $t_goods t on g.goods_id = t.goods_id where g.group_id = $group_id";
}
$groupbuyinfo = $dbo->getRow($sql);

$goods_p_id = $groupbuyinfo['goods_id'];
if ($groupbuyinfo['goods_id']){
	$goods_price = "select goods_price from `$t_goods` where goods_id ='$goods_p_id'";
	$goods_price = $dbo->getRow($goods_price);
	$groupbuyinfo['goods_price'] =$goods_price['goods_price'];
}
$header['title'] = $groupbuyinfo['group_name']." - ".$SHOP['shop_name'];
/* 时间处理 */
$now_time = new time_class();
$start_time = strtotime($groupbuyinfo['start_time']);
$now_time = $now_time -> time_stamp();
$end_time = strtotime($groupbuyinfo['end_time']);
if ($user_id){
	$sql = "select user_id,quantity,linkman,tel FROM `$t_shop_groupbuy_log` where user_id = $user_id";
	$isset_add_groupbuy = $dbo->getRow($sql);
}

/* 认证信息 */
$sql="select b.rank_name from $t_users as a,$t_user_rank as b where a.user_id=$shop_id and a.rank_id=b.rank_id";
$rank_name=$dbo->getRow($sql);

/* 留言管理 */
$sql = "SELECT * FROM $t_shop_guestbook WHERE shop_id='$shop_id' and group_id='$group_id' order by add_time desc limit 10";

$guestbook_list = $dbo->getRs($sql);
/* 本页面信息处理 */
//$sql = "select goods_id,goods_name,goods_price,goods_thumb,is_set_image,transport_template_price from `$t_goods` where shop_id='$shop_id' and is_best=1 and is_on_sale=1 and lock_flg=0 order by sort_order asc,goods_id desc limit 12";
//$best_goods = $dbo->getRs($sql);

$nav_selected=6;
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo  $header['title'];?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<meta name="keywords" content="<?php echo  $header['keywords'];?>" />
<meta name="description" content="<?php echo  $header['description'];?>" />
<base href="<?php echo  $baseUrl;?>" />
<link href="skin/<?php echo  $SYSINFO['templates'];?>/css/import.css" type="text/css" rel="stylesheet" />
<link href="skin/<?php echo  $SYSINFO['templates'];?>/css/shop.css" rel="stylesheet" type="text/css" />
<link href="skin/<?php echo  $SYSINFO['templates'];?>/css/shop_<?php echo  $SHOP['shop_template'];?>.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="skin/<?php echo  $SYSINFO['templates'];?>/js/changeStyle.js"></script>
<script type="text/javascript" src="skin/<?php echo  $SYSINFO['templates'];?>/js/magnifier.js"></script>
<script type="text/javascript" src="skin/<?php echo  $SYSINFO['templates'];?>/js/izoom.js"></script>
<style>
.detail .pro_detail .pro_text ul li.operate a.inquiry { width:89px; background:url(skin/<?php echo $SYSINFO['templates'];?>/images/inquiry.gif) 0 0 no-repeat;margin-left:10px; }
dl.guboo { text-align:left; padding:10px; border-bottom:1px solid #eeeeee; }
.ftcolor { color:#E78210; }
dt span { color:#CECFCE; }
.messagebox { text-align:left; padding:10px; }
</style>
<script type="text/javascript">
window.onload=function() { 
	new imageZoom("img1",{
	    bigImg:"<?php echo  isset($gallery[0]['img_original']) ? $gallery[0]['img_original'] : 'skin/default/images/nopic_big.gif';?>"
	}); 
	gettransport_price(0,'<?php echo $s_langpackage->s_country;?>');
}
function changeImage(obj){
	var ia=obj.parentNode;
	var rev=ia.rev;//中图
	var ref=ia.rel;//大图
	document.getElementById("img1").src=rev;
	new imageZoom("img1",{ 
	    bigImg:ref
	}); 
}
</script>
</head>
<body>
<div id="wrapper"> <?php  require("shop/index_header.php");?>
  <div id="contents" class="clearfix">
  <div id="pkz">

    	<?php echo $i_langpackage->i_location;?>：<a href="index.php"><?php echo $i_langpackage->i_index;?></a> &gt; <a href="<?php echo  shop_url($shop_id,'index');?>"><?php echo  $SHOP['shop_name'];?></a> &gt; <?php echo  $groupbuyinfo['group_name'];?>

    </div>


    <div id="itemContents" class="clearfix">
      <div id="intro" >
        <h3><?php echo  $groupbuyinfo['group_name'];?> (<?php echo $s_langpackage->s_groupbuy;?>)</h3>
        <div class="box">
           	<div class="pro_pic" align="center">
             <img id="img1" alt="" src="<?php echo  isset($gallery[0]['img_url']) ? $gallery[0]['img_url'] : "skin/default/images/nopic_big.gif";?>" onerror="this.src='skin/default/images/nopic.gif'">
            </div>
            
            
            <div class="pic_box clear">
                <a class="left_button" href="javascript:void(0);" onclick="img_pre('list1_1');"></a>
                    <div id="thumbbox">
                        <div class="long_box" id="list1_1">
                        <?php foreach($gallery as $val){?>
							<a href="javascript:;" rev="<?php echo $val['img_url'];?>" rel="<?php echo $val['img_original'];?>" onclick="javascript:return false;">
							<img src="<?php echo $val['thumb_url'];?>" onclick="changeImage(this)" onerror="this.src='skin/default/images/nopic.gif'"></a>
                		<?php }?>
                        </div>
                    </div>
                <a class="right_button" href="javascript:void(0);" onclick="img_next('list1_1');"></a>
            </div>
        </div>
        <div class="itemProperty">
          <ul>
            <?php  if($isset_logo){?><!-- 未登录 -->
            <?php  if($groupbuyinfo['recommended']){?>
		            <li><span><?php echo $s_langpackage->s_groupbuy_time;?>:</span>
		              <label><?php echo  time_left(strtotime($groupbuyinfo['end_time']));?></label>
		            </li>
		            <li><span><?php echo $s_langpackage->s_groupbuy_regiment_number;?>:</span>
		              <em><?php echo  $groupbuyinfo['min_quantity'];?></em>
		            </li>
		            <li><span><?php echo $s_langpackage->s_groupbuy_restult_num;?>:</span>
		              <label id='purchase'><?php echo  $groupbuyinfo['purchase_num'];?></label>
		            </li>
		            
		                <?php echo  $s_langpackage->s_yuan;?></li>
		            <li><span><?php echo  $i_langpackage->i_one_num;?>:</span>
		              <label id="one_num"><?php echo  $groupbuyinfo['one_num'];?></label></li>
		             <li><span><?php echo $i_langpackage->i_all_num;?>:</span><label id="all_num"><?php echo  $groupbuyinfo['all_num'];?></label></li>  
		             
		            <li><span><?php echo $s_langpackage->s_groupbuy_old_price;?>:</span><?php echo $s_langpackage->s_money_sign;?>
		              <label><?php echo  $groupbuyinfo['goods_price'];?></label>
		              <?php echo  $s_langpackage->s_yuan;?></li>
		            <li><span><?php echo $s_langpackage->s_groupbuy_price;?>:</span><?php echo $s_langpackage->s_money_sign;?>
		               <em class="price"><?php echo  $groupbuyinfo['spec_price'];?></em>
		          
		              
		              
		            <li><span><?php echo $s_langpackage->s_group_buy_state;?>:</span>
		              <label><?php echo $s_langpackage->s_completed;?></label>
		            </li>
		            <li><span><a href="login.php" style=" color:#F00"><?php echo $s_langpackage->s_isset_login;?></a>
		              </label>
		            </li>
            <?php  } else{?>
		            <li><span><?php echo $s_langpackage->s_groupbuy_time;?>:</span>
		              <label><?php echo  time_left(strtotime($groupbuyinfo['end_time']));?></label>
		            </li>
		            <li><span><?php echo $s_langpackage->s_groupbuy_regiment_number;?>:</span>
		              <label><?php echo  $groupbuyinfo['min_quantity'];?></label>
		            </li>
		            <li><span><?php echo $s_langpackage->s_groupbuy_restult_num;?>:</span>
		              <label  id='purchase'><?php echo  $groupbuyinfo['purchase_num'];?></label>
		            </li>
		          <li><span><?php echo  $i_langpackage->i_one_num;?>:</span>
		              <label id="one_num"><?php echo  $groupbuyinfo['one_num'];?></label></li>
		             <li><span><?php echo  $i_langpackage->i_all_num;?>:</span><label id="all_num"><?php echo  $groupbuyinfo['all_num'];?></label></li>  
		            <li><span><?php echo $s_langpackage->s_groupbuy_old_price;?>:</span><?php echo $s_langpackage->s_money_sign;?>
		              <em><?php echo  $groupbuyinfo['goods_price'];?></em>
		              <?php echo  $s_langpackage->s_yuan;?></li>
		            <li><span><?php echo $s_langpackage->s_groupbuy_price;?>:</span><?php echo $s_langpackage->s_money_sign;?>
		               <em class="price"><?php echo  $groupbuyinfo['spec_price'];?></em>
		              <?php echo  $s_langpackage->s_yuan;?></li>
	
		             
		            <?php  if($start_time < $now_time and $now_time < $end_time){?>
		            <li><span><?php echo $s_langpackage->s_group_buy_state;?>:</span>
		              <label><?php echo $s_langpackage->s_ongoing;?></label>
		            </li>
		            <?php  } else if($start_time > $now_time){?>
		            <li><span><?php echo $s_langpackage->s_group_buy_state;?>:</span>
		              <label><?php echo $s_langpackage->s_not_published;?></label>
		            </li>
		            <?php  } else if($end_time > $now_time){?>
		            <li><span><?php echo $s_langpackage->s_group_buy_state;?>:</span>
		              <label><?php echo $s_langpackage->s_completed;?></label>
		            </li>
		            <?php }?>
		            <li><span><a href="login.php" style=" color:#F00"><?php echo $s_langpackage->s_isset_login;?></a>
		              </label>
		            </li>
		            <?php }?>
            <?php  } else{?><!-- 已登录 -->
            <?php  if($user_id != $shop_id){?>
            <?php  if($groupbuyinfo['recommended']){?>
		            <li><span><?php echo $s_langpackage->s_groupbuy_time;?>:</span>
		              <label><?php echo  time_left(strtotime($groupbuyinfo['end_time']));?></label>
		            </li>
		            <li><span><?php echo $s_langpackage->s_groupbuy_regiment_number;?>:</span>
		              <em><?php echo  $groupbuyinfo['min_quantity'];?></em>
		            </li>
		            <li><span><?php echo $s_langpackage->s_groupbuy_restult_num;?>:</span>
		              <label  id='purchase'><?php echo  $groupbuyinfo['purchase_num'];?></label>
		            </li>
		            <li><span><?php echo  $i_langpackage->i_one_num;?>:</span>
		              <label id="one_num"><?php echo  $groupbuyinfo['one_num'];?></label></li>
		             <li><span><?php echo  $i_langpackage->i_all_num;?>:</span><label id="all_num"><?php echo  $groupbuyinfo['all_num'];?></label></li>  
		            <li><span><?php echo $s_langpackage->s_groupbuy_old_price;?>:</span><?php echo $s_langpackage->s_money_sign;?>
		              <em><?php echo  $groupbuyinfo['goods_price'];?></em>
		              <?php echo  $s_langpackage->s_yuan;?></li>
		            <li><span><?php echo $s_langpackage->s_groupbuy_price;?>:</span><?php echo $s_langpackage->s_money_sign;?>
		              <em class="price"><?php echo  $groupbuyinfo['spec_price'];?></em>
		              <?php echo  $s_langpackage->s_yuan;?></li>
		             
		             
		            <li><span><?php echo $s_langpackage->s_group_buy_state;?>:</span>
		              <label><?php echo $s_langpackage->s_completed;?></label>
		            </li>
		            <?php  if($isset_groupbuy){?>
		            <li><a href="javascript:gotoOrder(<?php echo  $groupbuyinfo['group_id'];?>);"
											title="<?php echo $s_langpackage->s_detriment;?>"><?php echo $s_langpackage->s_detriment;?></a> </li>
		            <?php }?>
            <?php  } else{?>
		            <li><span><?php echo $s_langpackage->s_groupbuy_time;?>:</span>
		              <label><?php echo  time_left(strtotime($groupbuyinfo['end_time']));?></label>
		            </li>
		            <li><span><?php echo $s_langpackage->s_groupbuy_regiment_number;?>:</span>
		              <em><?php echo  $groupbuyinfo['min_quantity'];?></em>
		            </li>
		            <li><span><?php echo $s_langpackage->s_groupbuy_restult_num;?>:</span>
		              <em  id='purchase'><?php echo  $groupbuyinfo['purchase_num'];?></em>
		            </li>
		             <li><span><?php echo  $i_langpackage->i_one_num;?>:</span>
		              <label id="one_num"><?php echo  $groupbuyinfo['one_num'];?></label></li>
		             <li><span><?php echo  $i_langpackage->i_all_num;?>:</span><label id="all_num"><?php echo  $groupbuyinfo['all_num'];?></label></li>  
		             
		            <li><span><?php echo $s_langpackage->s_groupbuy_old_price;?>:</span><?php echo $s_langpackage->s_money_sign;?>
		              <em><?php echo  $groupbuyinfo['goods_price'];?></em>
		              <?php echo  $s_langpackage->s_yuan;?></li>
		            
		             
		            <li><span><?php echo $s_langpackage->s_groupbuy_price;?>:</span><?php echo $s_langpackage->s_money_sign;?>
		               <em class="price"><?php echo  $groupbuyinfo['spec_price'];?></em>
		              <?php echo  $s_langpackage->s_yuan;?></li>
		            <?php  if($start_time < $now_time and $now_time < $end_time){?>
		            <li><span><?php echo $s_langpackage->s_group_buy_state;?>:</span>
		              <label><?php echo $s_langpackage->s_ongoing;?></label>
		            </li>
		            <?php  if($isset_groupbuy){?>
		            <li><span><?php echo $s_langpackage->s_groupbuy_buy_num;?>:</span>
		              <label><?php echo  $groupbuyinfo['quantity'];?></label>
		            </li>
		            <li><span><?php echo $s_langpackage->s_groupbuy_real_name;?>:</span>
		              <label><?php echo  $groupbuyinfo['linkman'];?></label>
		            </li>
		            <li><span><?php echo $s_langpackage->s_groupbuy_tel;?>:</span>
		              <label><?php echo  $groupbuyinfo['tel'];?></label>
		            </li>
		            <?php  if($groupbuyinfo['recommended']){?>
		            <li><a href="javascript:gotoOrder(<?php echo  $groupbuyinfo['group_id'];?>);"
												style=" background: url(skin/default/images/pj_bg.gif); width=180px; height=133px;"><?php echo  $s_langpackage->s_detriment;?></a> </li>
		            <?php  } else{?>
		            <li><a href="javascript:exitGroupbuy(<?php echo  $groupbuyinfo['group_id'];?>);"
												title="<?php echo $s_langpackage->s_groupbuy_del;?>" style=" background: url(skin/default/images/shop/btn_groundbuy.gif);display:block; width:80px; height:18px;text-align:center;padding-top:5px;"><?php echo $s_langpackage->s_groupbuy_del;?></a> </li>
		            <?php }?>
		            <?php  } else{?>
		            <li><span><?php echo $s_langpackage->s_groupbuy_buy_num;?>:</span>
		              <input size="8" value="1" id='num' />
		              (<?php echo $s_langpackage->s_required;?>)</li>
		            <li><span><?php echo $s_langpackage->s_groupbuy_real_name;?>:</span>
		              <input size="8" value="" id='groupbuyname' />
		              (<?php echo $s_langpackage->s_required;?>)</li>
		            <li><span><?php echo $s_langpackage->s_groupbuy_tel;?>:</span>
		              <input size="8" value="" id='groupbuytel' />
		              (<?php echo $s_langpackage->s_required;?>)</li>
		            <li><a href="javascript:gotoGroupbuy(<?php echo  $groupbuyinfo['group_id'];?>);"
												title="<?php echo $s_langpackage->s_groupbuy_add;?>" style=" background: url(skin/default/images/shop/btn_groundbuy.gif);display:block; width:80px; height:18px;text-align:center;padding-top:5px;"><?php echo $s_langpackage->s_groupbuy_add;?></a> </li>
		            <?php }?>
		            <?php  } else if($start_time > $now_time){?>
		            <li><span><?php echo $s_langpackage->s_group_buy_state;?>:</span>
		              <label><?php echo $s_langpackage->s_not_published;?></label>
		            </li>
		            <?php  } else if($end_time > $now_time){?>
		            <li><span><?php echo $s_langpackage->s_group_buy_state;?>:</span>
		              <label><?php echo $s_langpackage->s_completed;?></label>
		            </li>
		            <?php  if($isset_groupbuy){?>
		            <li><a href="javascript:gotoOrder(<?php echo  $groupbuyinfo['group_id'];?>);"
													 style=" background: url(skin/default/images/pj_bg.gif); width=180px; height=133px;"><?php echo  $s_langpackage->s_detriment;?></a> </li>
		            <?php }?>
		            <?php  } else if($end_time < $now_time){?>
		            <li><span><?php echo $s_langpackage->s_group_buy_state;?>:</span>
		              <label><?php echo $s_langpackage->s_completed;?></label>
		            </li>
		            <?php }?>
		            <?php }?>
            <?php  } else{?>
		            <?php  if($groupbuyinfo['recommended']){?>
		            <li><span><?php echo $s_langpackage->s_groupbuy_time;?>:</span>
		              <label><?php echo  time_left(strtotime($groupbuyinfo['end_time']));?></label>
		            </li>
		            <li><span><?php echo $s_langpackage->s_groupbuy_regiment_number;?>:</span>
		              <label><?php echo  $groupbuyinfo['min_quantity'];?></label>
		            </li>
		            <li><span><?php echo $s_langpackage->s_groupbuy_restult_num;?>:</span>
		              <label  id='purchase'><?php echo  $groupbuyinfo['purchase_num'];?></label>
		            </li>
		           <li><span><?php echo  $i_langpackage->i_one_num;?>:</span>
		              <label id="one_num"><?php echo  $groupbuyinfo['one_num'];?></label></li>
		             <li><span><?php echo  $i_langpackage->i_all_num;?>:</span><label id="all_num"><?php echo  $groupbuyinfo['all_num'];?></label></li>  
		            <li><span><?php echo $s_langpackage->s_groupbuy_old_price;?>:</span><?php echo $s_langpackage->s_money_sign;?>
		              <em><?php echo  $groupbuyinfo['goods_price'];?></em>
		              <?php echo  $s_langpackage->s_yuan;?></li>
		            <li><span><?php echo $s_langpackage->s_groupbuy_price;?>:</span><?php echo $s_langpackage->s_money_sign;?>
		               <em class="price"><?php echo  $groupbuyinfo['spec_price'];?></em>
		              <?php echo  $s_langpackage->s_yuan;?></li>
		              
		            <li><span><?php echo $s_langpackage->s_group_buy_state;?>:</span>
		              <label><?php echo $s_langpackage->s_completed;?></label>
		            </li>
		            <?php  } else{?>
		            <li><span><?php echo $s_langpackage->s_groupbuy_time;?>:</span>
		              <label><?php echo  time_left(strtotime($groupbuyinfo['end_time']));?></label>
		            </li>
		            <li><span><?php echo $s_langpackage->s_groupbuy_regiment_number;?>:</span>
		              <label><?php echo  $groupbuyinfo['min_quantity'];?></label>
		            </li>
		            <li><span><?php echo $s_langpackage->s_groupbuy_restult_num;?>:</span>
		              <label  id='purchase'><?php echo  $groupbuyinfo['purchase_num'];?></label>
		            </li>
		           <li><span><?php echo  $i_langpackage->i_one_num;?>:</span>
		              <label id="one_num"><?php echo  $groupbuyinfo['one_num'];?></label></li>
		             <li><span><?php echo  $i_langpackage->i_all_num;?>:</span><label id="all_num"><?php echo  $groupbuyinfo['all_num'];?></label></li>  
		            <li><span><?php echo $s_langpackage->s_groupbuy_old_price;?>:</span><?php echo $s_langpackage->s_money_sign;?>
		              <em><?php echo  $groupbuyinfo['goods_price'];?></em>
		              <?php echo  $s_langpackage->s_yuan;?></li>
		              
		            <li><span><?php echo $s_langpackage->s_groupbuy_price;?>:</span><?php echo $s_langpackage->s_money_sign;?>
		               <em class="price"><?php echo  $groupbuyinfo['spec_price'];?></em>
		              <?php echo  $s_langpackage->s_yuan;?></li>
		            <?php  if($start_time < $now_time and $now_time < $end_time){?>
		            <li><span><?php echo $s_langpackage->s_group_buy_state;?>:</span>
		              <label><?php echo $s_langpackage->s_ongoing;?></label>
		            </li>
		            <?php  } else if($start_time > $now_time){?>
		            <li><span><?php echo $s_langpackage->s_group_buy_state;?>:</span>
		              <label><?php echo $s_langpackage->s_not_published;?></label>
		            </li>
		            <?php  } else if($end_time > $now_time){?>
		            <li><span><?php echo $s_langpackage->s_group_buy_state;?>:</span>
		              <label><?php echo $s_langpackage->s_completed;?></label>
		            </li>
		            <?php }?>
		            <?php }?>
            <?php }?>
            <?php }?>
          </ul>
        </div>
      </div>
      <div class="shopInfo mg12b">
        <h2><a href="<?php echo  shop_url($shop_id,'index');?>" title=""><img src="<?php echo  $SHOP['shop_logo'] ? $SHOP['shop_logo'] : 'skin/default/images/shop_nologo.gif';?>" width="198" height="98" alt="" /></a></h2>
        <h2 class="sName"><a href="<?php echo  shop_url($shop_id,'index');?>"><?php echo  $SHOP['shop_name'];?></a></h2>
        <p><?php echo $s_langpackage->s_nickname;?>： <?php echo  $ranks['user_name'];?></p>
        <p><?php echo  $s_langpackage->s_contact_seller;?>：
            <script src="imshow.php?u=<?php echo  $SHOP['user_id'];?>"></script>
        </p>
        <p><?php echo $s_langpackage->s_goods_num;?>：<?php echo  $SHOP['goods_num'];?></p>
        <p><?php echo  $s_langpackage->s_seller_c;?>：
        	<a href="<?php echo  shop_url($shop_id,'credit');?>" hideFocus=true>
        		<?php  if($credit['SUM(seller_credit)']){?>
        			<img style="margin-left:5px; vertical-align:text-bottom" src="skin/default/images/shop/rank_<?php echo $integral;?>.gif"title="<?php echo $credit['SUM(seller_credit)'];?>" width="80" height="13" />
        		<?php  } else{?>
					0
        		<?php }?>
        	</a>
         </p>

         <p><?php echo $s_langpackage->s_new_login;?>：<?php echo  $ranks['last_login_time'];?></p>
         <p><?php echo $s_langpackage->s_creat_time;?>：<?php echo  $SHOP['shop_creat_time'];?></p>
         <p><span class="left"><?php echo $s_langpackage->s_certification;?>：</span> <a href="javascript:;" title="<?php echo $rank_name['rank_name'];?>"  class="shop_cert left"><?php echo $rank_name['rank_name'];?></a> </</p>
         <p><a class="go2shop" href="<?php echo  shop_url($shop_id,'index');?>" title=""><img src="skin/<?php echo  $SYSINFO['templates'];?>/images/gotoshop.gif" width="183" height="36" alt="<?php echo $s_langpackage->s_seller_shop;?>" /></a></p>
         <p>
         	<input type="hidden" value="<?php echo $USER['user_id'];?>" id="shop_user" />
			<a class="favShop" href="javascript:;" onclick="add_shopFavorite(<?php echo  $shop_id;?>)"><?php echo $s_langpackage->s_store_shop;?></a>
			<a class="setLatter" href="goods.php?id=<?php echo  $groupbuyinfo['group_id'];?>&app=groupbuyinfo#message"><?php echo $s_langpackage->s_send_mail;?></a>
		 </p>
        </div>
    </div>
    <div id="itemDetail" >

       <ul class="list_tab clearfix" >
        <li id="tab_content1" class="now" onclick="show_tabs('1');"><a href="javascript:;" ><?php echo $s_langpackage->s_details;?></a></li>
        <li id="tab_content2" onclick="show_tabs('2');"><a href="javascript:;" ><?php echo $s_langpackage->s_group_buy_introduction;?></a></li>
      </ul>
      <div id="tab1_content1" class="pannel">
      <?php echo  $groupbuyinfo['goods_intro'];?>
      </div>
      <div id="tab1_content2" class="pannel" style="display:none">
      <?php echo  $groupbuyinfo['group_desc'];?>
      </div>
      <div id="message" class="guestbook  bg_gradual mg12b">
      <h3 class="ttl_guestbook"><?php echo $s_langpackage->s_buyer_comm;?></h3>
      <ul>
      <?php foreach($guestbook_list as $key =>$value){?>
          <?php if($value['group_id']){?>
          <li <?php if($key%2==0){?> class='double' <?php }?>>
              <div class="guester">
                <p><a href=""><?php echo  $value['name'];?>：</a></p>
                <p><?php echo  $value['content'];?><span><?php echo  $value['add_time'];?></span></p>
              </div>
           <?php if($value['reply']) {?>
            <div class="shoper">
                <p><a href=""><?php echo $s_langpackage->s_seller_reply;?>：</a></p>
                <p><?php echo  $value['reply'];?> </p>
             </div>
            <?php }?>
          </li>
          <?php }?>
          <?php }?>
          </ul>
          <div class="guestInput">
           <form action="do.php?act=shop_guestbook" name="guestForm" method="post" id="guestForm" onSubmit="return checkForm();">
                  <input maxlength="20" name="name" type="hidden" value="<?php echo $USER['user_name'];?>" />
                  <input maxlength="50" name="email" type="hidden" value="<?php echo $USER['user_email'];?>" />
                  <input maxlength="50" name="group_id" type="hidden" value="<?php echo  $groupbuyinfo['group_id'];?>" />
                  <input maxlength="50" name="group_name" type="hidden" value="<?php echo  $groupbuyinfo['group_name'];?>" />
                  <input maxlength="50" name="goods_id" type="hidden" value="<?php echo  $groupbuyinfo['goods_id'];?>" />
                  <input maxlength="50" name="contact" type="hidden" />
                  <input type="hidden" name="shop_id" value="<?php echo  $shop_id;?>" />
                  <input type="hidden" name="shop_name" value="<?php echo  $SHOP['shop_name'];?>" />
                  <textarea class="border_c" cols="40" rows="4" name="content" id="textareac"></textarea><br/ >
				   <?php if($verifycode['3']==1){?>
                  <input type="text" class="txt_tag" name="veriCode" id="veriCode" style="width:100px" maxlength="4" /> 
          		<img border="0" src="servtools/veriCodes.php" align="absmiddle" id="verCodePic"><a href="javascript:;" onclick="return getVerCode();"><?php echo $i_langpackage->i_change_img;?></a>
					<?php }?>
                  <input class="btnSetmess" type="submit" value="<?php echo $s_langpackage->s_post_comm;?>" />
                </form>
      </div>
      </div>
     <!-- 卖家推荐 -->
     <div class="bg_gary" id="sellrecom">
      <h3 class="ttlm_sellrecom"><?php echo $s_langpackage->s_seller_commend;?></h3>
      <ul class="list_125 clearfix">
            <?php if($best_goods) {
            foreach($best_goods as $value){?>
            <li>
              <p class="photo"><a target="_blank" href="<?php echo  goods_url($value['goods_id']);?>"><img src="<?php echo  $value['is_set_image'] ? str_replace('thumb_','',$value['goods_thumb']) : 'skin/default/images/nopic.gif';?>" alt=""  height="112" width="112" onerror="this.src='skin/default/images/nopic.gif'"/></a></p>
              <h4 class="summary"><a href="<?php echo  goods_url($value['goods_id']);?>"><?php echo  sub_str($value['goods_name'],20,false);?></a></h4>
              <p class="price"><?php echo $i_langpackage->i_money_sign;?><?php echo  $value['goods_price'];?><?php echo $s_langpackage->s_yuan;?></p>
            </li>
            <?php }?>
            <?php }?>
                      </ul>
    </div>
    <!-- 卖家推荐 -->

    </div>
      </div>
    </div>
    <script language="JavaScript" src="servtools/ajax_client/ajax.js"></script>
    <script language="JavaScript">
	<!--
	function checkForm(){
		var textareac = document.getElementById('textareac').value;
		var code = document.getElementById('veriCode').value;
		if(!textareac){
			alert('<?php echo $s_langpackage->s_type_comm_pls;?>');
			return false;
			}
			 <?php if($verifycode['3']==1){?>
		if(!code){
			alert('<?php echo $s_langpackage->s_code_no;?>');
			return false;
			}
			<?php }?>
		}
	function gotoGroupbuy(id) {
			var num = document.getElementById('num').value;
			var groupbuyname = document.getElementById('groupbuyname').value;
			var groupbuytel = document.getElementById('groupbuytel').value;
			var onenum=document.getElementById('one_num').innerHTML;
			var allnum=document.getElementById('all_num').innerHTML;
			var purchase=document.getElementById('purchase').innerHTML;
			var checkfiles=new RegExp("^[0-9]\\d*$");
			if(!checkfiles.test(groupbuytel)) {
					alert("<?php echo $s_langpackage->s_groupbuy_isset_tel_num;?>");
					return;
			}
			if(onenum!=0&&num>onenum){
				alert('<?php echo $s_langpackage->s_groupbuy_not_greater;?>');
                return;
			}
			if(onenum!=0&&num>onenum){
				alert('<?php echo $s_langpackage->s_groupbuy_not_greater;?>');
                return;
			}
			if(allnum!=0&&(allnum-purchase)<onenum){
				alert('<?php echo $s_langpackage->s_groupbuy_not_number;?>');
				return;
				}
			ajax("do.php?act=goods_add_groupbuy","POST","id="+id+"&num="+num+"&groupbuyname="+groupbuyname+"&groupbuytel="+groupbuytel,function(data){
				if (data == -1){
					alert('<?php echo $s_langpackage->s_groupbuy_isset_num;?>');
				}else if (data == -2){
					alert('<?php echo $s_langpackage->s_groupbuy_isset_name;?>');
				}else if (data == -3){
					alert('<?php echo $s_langpackage->s_groupbuy_isset_tel;?>');
				}else if (data == -4){
					alert('<?php echo $s_langpackage->s_groupbuy_isset_one;?>');
				}else if (data == 1){
					alert('<?php echo $s_langpackage->s_groupbuy_isset_true;?>');
					location.href = "<?php echo  $baseUrl;?>goods.php?id="+id+"&app=groupbuyinfo";
				}else if(data==2){
					alert('<?php echo $s_langpackage->s_groupbuy_not_greater_all;?>');
				}else if(data==3){
					alert('<?php echo $s_langpackage->s_groupbuy_not_number;?>');
				}else if(data==4){
					alert('<?php echo $s_langpackage->s_groupbuy_not_greater_all;?>');
				}else if(data==5){
					alert('<?php echo $s_langpackage->s_groupbuy_lock_error;?>');
				}else if(data==6){
					alert('<?php echo $m_langpackage->m_user_locked;?>');
					location.href = "<?php echo  $baseUrl;?>login.php";
					}
			});
		}
		function exitGroupbuy(id) {
			ajax("do.php?act=goods_exit_groupbuy","POST","id="+id,function(data){
				if (data == 1){
					alert('<?php echo $s_langpackage->s_groupbuy_isset_false;?>');
					location.href = "<?php echo  $baseUrl;?>goods.php?id="+id+"&app=groupbuyinfo";
				}else if(data==6){
					alert('<?php echo $m_langpackage->m_user_locked;?>');
					location.href = "<?php echo  $baseUrl;?>login.php";
					}
			});
		}
		function gotoOrder(id) {
			location.href = "<?php echo  $baseUrl;?>modules.php?app=user_group_order_address&gid="+id;
		}
			function show_tabs(flg){
		if (flg =='1'){
			document.getElementById("tab_content1").className ="now";
			document.getElementById("tab_content2").className ="";
			document.getElementById("tab1_content1").style.display ="block";
			document.getElementById("tab1_content2").style.display ="none";
		}
		if (flg == '2'){
			document.getElementById("tab_content1").className ="";
			document.getElementById("tab_content2").className ="now";
			document.getElementById("tab1_content1").style.display ="none";
			document.getElementById("tab1_content2").style.display ="block";
		}
	}

	function add_shopFavorite(id) {
		var user_id = document.getElementById('shop_user').value;
		if (id == user_id){
			alert('<?php echo $s_langpackage->s_myshop_error;?>');
		}else {
			ajax("do.php?act=shop_add_favorite","POST","id="+id,function(data){
				if(data == 1) {
					alert("<?php echo  $s_langpackage->s_g_addedfavorite;?>");
				} else if(data == -1) {
					alert("<?php echo $s_langpackage->s_store_info;?>");
				} else if(data == -2){
					alert("<?php echo $s_langpackage->s_shop_error1;?>");
				}else {
					alert("<?php echo  $s_langpackage->s_g_addfailed;?>");
				}
			});
		}
	}
	function getVerCode() {
		document.getElementById("verCodePic").src="servtools/veriCodes.php?vc="+Math.random();
		return false;
	}
	
	//-->
	</script>
  </div>
  <?php   require("shop/index_footer.php");?> </div>
</body>
</html>
<?php } ?>