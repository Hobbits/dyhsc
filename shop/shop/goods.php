<?php
/*
 * 注意：此文件由itpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/shop/goods.html
 * 如果您的模型要进行修改，请修改 models/shop/goods.php
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
if(filemtime("templates/default/shop/goods.html") > filemtime(__file__) || (file_exists("models/shop/goods.php") && filemtime("models/shop/goods.php") > filemtime(__file__)) ) {
	tpl_engine("default","shop/goods.html",1);
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
require("foundation/module_category.php");
require("foundation/module_tag.php");
require("foundation/asystem_info.php");

//引入语言包
$s_langpackage=new shoplp;
$i_langpackage=new indexlp;

/* 定义数据表 */
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
$t_areas = $tablePreStr."areas";
$t_transport_template = $tablePreStr."goods_transport";
$t_user_rank = $tablePreStr."user_rank";
$t_category = $tablePreStr."category";
$t_tag = $tablePreStr."tag";
$t_category = $tablePreStr."category";
$verifycode = unserialize($SYSINFO['verifycode']);
/**
 * 获取ip
 */
function GetIP()  {
	if(!empty($_SERVER["HTTP_CLIENT_IP"])){
		$cip = $_SERVER["HTTP_CLIENT_IP"];
	}else if(!empty($_SERVER["HTTP_X_FORWARDED_FOR"])){
		$cip = $_SERVER["HTTP_X_FORWARDED_FOR"];
	}else if(!empty($_SERVER["REMOTE_ADDR"])){
		$cip = $_SERVER["REMOTE_ADDR"];
	}else {
		$cip = "0.0.0.0";
	}
	 return $cip;
 }

/* 数据库操作 */
dbtarget('w',$dbServs);
$dbo=new dbex();
/*
 * 将游览的商品id放入cookie中，防刷新
 */
if(get_cookie('visitIwebMallGoods')){
	$remotegoods=explode(",",get_cookie('visitIwebMallGoods'));
	$i=true;
	foreach ($remotegoods as $v){
		if($v==$goods_id){
			$i=false;
		}
	}
	if($i){
		set_cookie('visitIwebMallGoods',get_cookie('visitIwebMallGoods').",".$goods_id,3600*24);
		$sql = "update $t_goods set pv=pv+1 where goods_id='$goods_id'";
	    $dbo->exeUpdate($sql);
	}

}else{
	$remoteip=GetIP();
	set_cookie('visitIwebMallGoods',$remoteip.','.$goods_id,3600*24);
	$sql = "update $t_goods set pv=pv+1 where goods_id='$goods_id'";
	$dbo->exeUpdate($sql);
}
/* 数据库操作 */
dbtarget('r',$dbServs);
$dbo=new dbex();

/* 产品信息获取 */
$sql = "select * from `$t_goods` where goods_id=$goods_id and is_on_sale=1";

$goodsinfo = $dbo->getRow($sql);
if($goodsinfo['lock_flg']) { trigger_error($s_langpackage->s_goods_locked); }
if(!$goodsinfo) { trigger_error($s_langpackage->s_shop_locked); }
//获得商品分类
$sub_category=get_parent_cats($goodsinfo['cat_id'],$dbo,$t_category);

//获得地区列表
$area_list = get_area_list_bytype($dbo,$t_areas,1);

//获取商家信用值
$shop_id = $goodsinfo['shop_id'];
$credit=get_credit($dbo,$t_credit,$shop_id);
$credit['SUM(seller_credit)'] = intval($credit['SUM(seller_credit)']);
$integral=get_integral($dbo,$t_integral,$credit['SUM(seller_credit)']);

$sql="select b.rank_name from $t_users as a,$t_user_rank as b where a.user_id=$shop_id and a.rank_id=b.rank_id";
$rank_name=$dbo->getRow($sql);

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
if(!$SHOP) { trigger_error($s_langpackage->s_shop_error);}

$sql = "select rank_id,user_name,last_login_time from $t_users where user_id='".$SHOP['user_id']."'";
$ranks = $dbo->getRow($sql);

$SHOP['rank_id'] = $ranks[0];

$sql = "select goods_id,goods_name,goods_price,goods_thumb,is_set_image from `$t_goods` where shop_id=$shop_id and is_on_sale=1 order by is_best desc,is_hot desc,is_promote desc,is_new desc,goods_id desc limit 7";
$best_goods = $dbo->getRs($sql);

set_hisgoods_cookie($goodsinfo['goods_id']);
$nav_selected =4;
$header['title'] = $goodsinfo['goods_name']." - ".$SHOP['shop_name'];
$header['keywords'] = $goodsinfo['goods_name'].','.$goodsinfo['keyword'];
$header['description'] = sub_str(strip_tags($goodsinfo['goods_intro']),100);

$tag_list = get_tag_list($dbo,$t_tag,15,$goods_id);
if( $credit['SUM(seller_credit)'] < 0)
	$credit['SUM(seller_credit)']=0;
	
$seller_credit = $credit['SUM(seller_credit)'];
$sql = "select * from `$t_integral` where $seller_credit>=int_min and $seller_credit <= int_max";
$credit_row = $dbo->getRow($sql);
	
	/* 处理系统分类 */
$sql_category = "select * from `$t_category` order by sort_order asc,cat_id asc,sort_order asc";
$result_category = $dbo->getRs($sql_category);

$CATEGORY = array();
if($result_category) {
	foreach($result_category as $v) {
		$CATEGORY[$v['parent_id']][$v['cat_id']] = $v;

	}
}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo  $header['title'];?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<meta name="keywords" content="<?php echo  $header['keywords'];?>" />
<meta name="description" content="<?php echo  $header['description'];?>" />
<base href="<?php echo  $baseUrl;?>" />
<link href="skin/<?php echo  $SYSINFO['templates'];?>/css/index.css" rel="stylesheet" type="text/css" />
<link href="skin/<?php echo  $SYSINFO['templates'];?>/css/import.css" type="text/css" rel="stylesheet" />
<link href="skin/<?php echo  $SYSINFO['templates'];?>/css/shop.css" type="text/css" rel="stylesheet" />
<script language="JavaScript" src="servtools/ajax_client/ajax.js"></script>
<script type="text/javascript" src="skin/<?php echo  $SYSINFO['templates'];?>/js/changeStyle.js"></script>
<script type="text/javascript" src="skin/<?php echo  $SYSINFO['templates'];?>/js/izoom.js"></script>
<script type="text/javascript">
window.onload = function(){
    magnifier.init({
                   cont : document.getElementById('magnifier'),
                   img : document.getElementById('magnifierImg'),
                   mag : document.getElementById('mag'),
                   scale : 3
                   });
}
function changeImage(obj){
	var ia=obj.parentNode;
	var rev=ia.rev;//中图
	//var ref=ia.rel;//大图
	//magnifier = null;
	document.getElementById("img").src=rev;
	magnifier.init({
                   cont : document.getElementById('magnifier'),
                   img : document.getElementById('magnifierImg'),
                   mag : document.getElementById('mag'),
                   scale : 3
                   });
	
}
</script>
<style type="text/css">
#magnifier { width:300px; height:300px; position:relative; font-size:0; border:1px solid #DDD; }
#img { width:300px; height:300px; }
#Browser { border:1px solid #000; z-index:100; position:absolute; background:#555; }
#mag { border:1px solid #DDD; overflow:hidden; z-index:100; }
</style>
</head>
<body>
<div id="wrapper" style=""> <?php  include("shop/index_header.php");?>
	<div id="contents" class="clearfix" >
		<div id="sub_channel">
			<ul class="clearfix">
				<li>
					<h3><img onmouseover="show_obj('category_box')" onmouseout="hidden_obj('category_box')" alt="<?php echo $s_langpackage->s_all_category;?>" src="skin/<?php echo  $SYSINFO['templates'];?>/images/part/ttl_channel_all.gif"  /></h3>
				</li>
				<?php foreach($sub_category as $value){?>
				<li><a href="<?php echo $value['url'];?>"><?php echo $value['cat_name'];?></a></li>
				<?php }?>
			</ul>
		</div>
		<div id="category_box" class="allMerchan" style=" display:none" onmouseover="show_obj(this)"  onmouseout="hidden_obj(this)">
			<ul  >
				<?php  foreach(array_slice ($CATEGORY[0], 0) as $key=>$cat){?>
				<li class="clearfix">
					<h3><a href="<?php echo  category_url($cat['cat_id']);?>" title="<?php echo  $cat['cat_name'];?>"><?php echo  $cat['cat_name'];?></a></h3>
					<?php if(isset($CATEGORY[$cat['cat_id']]) && $CATEGORY[$cat['cat_id']]){?>
					<p> <?php  foreach(array_slice ($CATEGORY[$cat['cat_id']], 0, 8) as $subcat){?> <a href="<?php echo  category_url($subcat['cat_id']);?>" title="<?php echo  $cat['cat_name'];?>"><?php echo  $subcat['cat_name'];?></a>|
						<?php }?> </p>
					<?php }?> </li>
				<?php }?>
			</ul>
		</div>
		<div id="itemContents" class="clearfix">
			<div id="intro" >
				<h3><?php echo  $goodsinfo['goods_name'];?></h3>
				<div class="box" >
					<div id="magnifier"> <img id="img" alt="" src="<?php echo  isset($gallery[0]['img_original']) ? $gallery[0]['img_original'] : 'skin/default/images/nopic_big.gif';?>">
						<div id='Browser'></div>
					</div>
					<div id="mag"><img id="magnifierImg" /></div>
					<div class="pic_box clear" > <a class="left_button" href="javascript:void(0);" onclick="img_pre('list1_1');"></a>
						<div id="thumbbox">
							<div class="long_box" id="list1_1"> <?php foreach($gallery as $val){?> <a href="javascript:;" rev="<?php echo $val['img_url'];?>" rel="<?php echo $val['img_original'];?>" onclick="javascript:return false;"> <img src="<?php echo $val['thumb_url'];?>" onclick="changeImage(this)" onerror="this.src='skin/default/images/nopic.gif'"></a> <?php }?> </div>
						</div>
						<a class="right_button" href="javascript:void(0);" onclick="img_next('list1_1');"></a> </div>
				</div>
				<div class="itemProperty">
					<ul>
						<li> <span><?php echo $s_langpackage->s_goods_price;?>：</span> <?php  if($goodsinfo['goods_price']=='0.00') {?> <em class="price"><?php echo  $s_langpackage->s_no_price;?></em> <?php  } else{?>
							<?php echo $s_langpackage->s_money_sign;?><em class="price"><?php echo  $goodsinfo['goods_price'];?></em> <?php echo  $s_langpackage->s_yuan;?>
							<?php }?> </li>
						<li> <span><?php echo $s_langpackage->s_goods_transport;?>：</span>
							<?php  if($goodsinfo['is_transport_template']=='1') {?> 
							<span style="display:bolck; position:relative" onmouseover="showarealist(1)"><span id="area_name"><?php echo $s_langpackage->s_area;?></span>
							<div style="position:absolute;style:top:0px;left:-70px; border:3px #eee solid; padding:10px; padding-left:25px; background:#f8f8f8;display:none; width:300px;" id="areabox"> <?php foreach($area_list as $value){?>
								<div style="float:left; width:60px;" ><a href="javascript:;" onclick="gettransport_price(<?php echo $value['area_id'];?>,'<?php echo $value['area_name'];?>')"><?php echo $value['area_name'];?></a></div>
								<?php }?> <input class="new_button" type="button" name="btu" value="<?php echo $s_langpackage->s_close;?>" onclick="showarealist(0)" /> </div>
							</span> <label id="transport_price"></label>
							<?php  } else{?>
							<span><?php echo  $goodsinfo['transport_price'];?></span>
							<?php }?>
							</li>
						<li> <span><?php echo $s_langpackage->s_goods_wtbuy;?>：</span> <span> <input type="text" size="4" value="1" maxvalue="1" minvalue="1" id='num' /> <input type="hidden" value="<?php echo $goodsinfo['goods_number'];?>" id="goods_number" /> <input type="hidden" value="<?php echo $shop_id;?>" id="shop_id" /> <input type="hidden" value="<?php echo $USER['user_id'];?>" id="shop_user" /> <input type="hidden" value="<?php echo  $goodsinfo['favpv'];?>" id="favpv_num"> <label></label> </span> (<?php echo $s_langpackage->s_may_buy;?><?php echo $goodsinfo['goods_number'];?> <?php echo $s_langpackage->s_piece;?>) </li>
						<?php  if($goodsinfo['goods_price']=='0.00') {?>
						<li class="b_none clearfix"> <a class="btn_inquiry" href="inquiry.php?gid=<?php echo  $goodsinfo['goods_id'];?>" title="<?php echo  $s_langpackage->s_g_askprice;?>"></a> <?php  } else {?>
						<li class="b_none clearfix"> <?php  if($goodsinfo['goods_number']=='0') {?> <a class="btn_buy" href="javascript:alert('<?php echo  $s_langpackage->s_kucun_0;?>');" title="<?php echo  $s_langpackage->s_g_buy;?>"></a> <?php  } else {?> <a class="btn_buy" href="javascript:gotoOrder(<?php echo  $goodsinfo['goods_id'];?>);" title="<?php echo  $s_langpackage->s_g_buy;?>"></a> <?php }?> <a class="btn_add" href="javascript:addCart(<?php echo  $goodsinfo['goods_id'];?>);" title="<?php echo  $s_langpackage->s_g_tocart;?>"></a> <?php }?> <a class="btn_fav" href="javascript:addFavorite(<?php echo  $goodsinfo['goods_id'];?>);" title="<?php echo  $s_langpackage->s_g_tofavorite;?>"></a> </li>
						<li><span><?php echo  $s_langpackage->s_company_Support;?>：</span> <?php  if($payment_info) {?>
							<?php foreach($payment_info as $val){?> <a><img src="plugins/<?php echo $val;?>/min_logo.gif" height="25" /></a> <?php }?>
							<?php  } else{?> <label class='fc'><?php echo  $s_langpackage->s_no_payment;?></label> <?php }?> </li>
						<li><span><?php echo $s_langpackage->s_goods_number;?>：</span> <?php echo str_replace("{num}","<em>".$goodsinfo['goods_number']."</em>",$s_langpackage->s_goods_mum);?> </li>
						<li><span><?php echo $s_langpackage->s_goods_pv;?>：</span> <?php echo str_replace("{pv}","<em>".$goodsinfo['pv']."</em>",$s_langpackage->s_goods_pvnum);?> </li>
						<li><span><?php echo $s_langpackage->s_collect_num;?>：</span><?php echo $s_langpackage->s_have;?><em><span id="favpv"><?php echo  $goodsinfo['favpv'];?></span></em><?php echo  $s_langpackage->s_collect;?> </li>
						<li><span><?php echo $s_langpackage->s_send_address;?>：</span> <?php echo  $areainfo[$SHOP['shop_province']];?>.<?php echo  $areainfo[$SHOP['shop_city']];?> </li>
						<li class="b_none"> <span class="colorOr"><?php echo $s_langpackage->s_share;?></span> <a class="link_renren" href=javascript:window.open('http://share.xiaonei.com/share/buttonshare.do?title='+encodeURIComponent(document.title)+'&link='+encodeURIComponent(document.location.href),'favit','');void(0)><?php echo $s_langpackage->s_renren;?></a> <a class="link_kaixin" href=javascript:window.open('http://www.kaixin001.com/repaste/share.php?rtitle='+encodeURIComponent(document.title)+'&rurl='+encodeURIComponent(document.location.href),'favit','');void(0)><?php echo $s_langpackage->s_kaixin;?></a> <a class="link_douban" href=javascript:window.open('http://www.douban.com/recommend/?title='+encodeURIComponent(document.title)+'&url='+encodeURIComponent(location.href),'favit','');void(0)><?php echo $s_langpackage->s_douban;?></a> </li>
					</ul>
				</div>
			</div>
			<div class="shopInfo mg12b" >
				<h2><a href="<?php echo  shop_url($shop_id,'index');?>" ><img src="<?php echo  $SHOP['shop_logo'] ? $SHOP['shop_logo'] : 'skin/default/images/shop_nologo.gif';?>" width="198" height="98" onerror="this.src='skin/default/images/no_page.jpg'"/></a></h2>
				<h2 class="sName"><a href="<?php echo  shop_url($shop_id,'index');?>"><?php echo  $SHOP['shop_name'];?></a></h2>
				<p> <?php echo $s_langpackage->s_nickname;?>：<span><?php echo  $ranks['user_name'];?></span> </p>
				<?php if($im_enable==true){?>
				<p><?php echo  $s_langpackage->s_contact_seller;?>：
					<script src="imshow.php?u=<?php echo  $SHOP['user_id'];?>"></script>
				</p>
				<?php }?>
				<p><?php echo $s_langpackage->s_goods_num;?>：<span><?php echo  $SHOP['goods_num'];?></span></p>
				<p><?php echo  $s_langpackage->s_seller_c;?>： <a href="<?php echo  shop_url($shop_id,'credit');?>" hideFocus=true> <img style="margin-left:5px; vertical-align:text-bottom" src="<?php echo $credit_row['int_img'];?>" title="<?php echo $credit['SUM(seller_credit)'];?>" /> </a> </p>
				<p><?php echo $s_langpackage->s_new_login;?>：<span><?php echo  $ranks['last_login_time'];?></span></p>
				<p><?php echo $s_langpackage->s_creat_time;?>：<span><?php echo  $SHOP['shop_creat_time'];?></span></p>
				<p><?php echo $s_langpackage->s_certification;?>：<span><?php echo $rank_name['rank_name'];?></span></p>
				<p><a href="<?php echo  shop_url($shop_id,'index');?>"><img src="skin/<?php echo  $SYSINFO['templates'];?>/images/gotoshop.gif" width="183" height="36" alt="<?php echo $s_langpackage->s_seller_shop;?>" /></a></p>
				<p><a class="favShop" href="javascript:;" onclick="add_shopFavorite(<?php echo  $shop_id;?>)"><?php echo $s_langpackage->s_store_shop;?></a>
					<!--        <a class="setLatter" href="shop.php?shopid=<?php echo  $shop_id;?>&app=index#message"><?php echo $s_langpackage->s_send_mail;?></a>-->
				</p>
			</div>
		</div>
		<div id="itemDetail">
			<ul class="list_tab clearfix" >
				<li id="tab_content1" class="now" onclick="show_tabs('1');"><a href="javascript:;" ><?php echo $s_langpackage->s_details;?></a></li>
				<li id="tab_content2" onclick="show_tabs('2');"><a href="javascript:;" ><?php echo $s_langpackage->s_wholesale;?></a></li>
				<li id="tab_content3" onclick="show_tabs('3');"><a href="javascript:;" >商品评价</a></li>
				<li id="tab_content4" onclick="show_tabs('4');"><a href="javascript:;" >成交记录</a></li>
			</ul>
			<div class="pannel" id="tab1_content1">
				<table cellspacing="0">
					<tr> <?php 
						if($attr_status) {
						$i = 0;
						foreach($attr as $key=>$value){?>
						<td class="text_right"><?php echo  $attribute[$key];?>:</td>
						<td class="text_left"><?php echo  $value;?></td>
						<?php 
						if($i%2) {
						echo "</tr>
					<tr>";
						}
						$i++;
						
						} }?> </tr>
				</table>
				<p><?php echo  $goodsinfo['goods_intro'];?></p>
			</div>
			<div id="tab1_content2" class="pannel" style="display:none">
				<p><?php echo  $goodsinfo['goods_wholesale'];?> </p>
			</div>
			<!-- 商品评价 -->
			<div id="tab1_content3" class="pannel" style="display:none"> </div>
			<!-- 商品成交记录 -->
			<div id="tab1_content4" class="pannel" style="display:none"> </div>
		</div>
		<div id="goodTags">
			<h3><?php echo $s_langpackage->s_goods_label;?></h3>
			<div class="link_tags"> <?php foreach($tag_list as $value){?>
				<?php foreach($value['tag_num'] as $v){?>
				<?php  if($v['num'] != 1){?> <a href="<?php echo $value['url'];?>" style="color:<?php echo $value['tag_color'];?>;<?php if($value['is_blod']){?>font-weight:bold;<?php }?>" ><?php echo $value['tag_name'];?>(<?php echo  $v['num'];?>)</a> <?php } else {?> <a href="<?php echo $value['url'];?>" style="color:<?php echo $value['tag_color'];?>;<?php if($value['is_blod']){?>font-weight:bold;<?php }?>" ><?php echo $value['tag_name'];?></a> <?php }?>
				<?php }?>
				<?php }?> </div>
			<div class="addTags">
				<form action="do.php?act=good_tag_add" method="post" onsubmit="return submitform();">
					<input class="txt_tag" size="25" type="text" name="tag" id="tag" onblur="inputTxt(this,'set');" onfocus="inputTxt(this,'clean');" value="<?php echo $s_langpackage->s_enter_label;?>" /> <?php if($verifycode['4']==1){?> <input type="text" class="txt_tag" name="veriCode" id="veriCode" style="width:100px" maxlength="4" /> <img border="0" align="absmiddle" src="servtools/veriCodes.php" id="verCodePic"><a href="javascript:;" onclick="return getVerCode();"><?php echo $i_langpackage->i_change_img;?></a> <?php }?> <input class="btn_ser" type="submit" value="<?php echo $s_langpackage->s_add;?>" /> <input type="hidden" name="goods_id" value="<?php echo  $goods_id;?>"  /> <input type="hidden" name="tag_userid" id="tag_userid" value="<?php echo  $USER['user_id'];?>" />
				</form>
			</div>
		</div>
		<div id="sellrecom" class="bg_gary">
			<h3 class="ttlm_sellrecom"><?php echo $s_langpackage->s_seller_commend;?></h3>
			<ul class="list_125 clearfix">
				<?php if($best_goods) {
				foreach($best_goods as $value){?>
				<li>
					<p class="photo"><a href="<?php echo  goods_url($value['goods_id']);?>"><img src="<?php echo  $value['is_set_image'] ? str_replace('thumb_','',$value['goods_thumb']) : 'skin/default/images/nopic.gif';?>"  width="112" height="112" onerror="this.src='skin/default/images/nopic.gif'"/></a></p>
					<h4 class="summary"><a href="<?php echo  goods_url($value['goods_id']);?>"><?php echo  sub_str($value['goods_name'],20);?></a></h4>
					<p class="price"><?php echo $i_langpackage->i_money_sign;?><?php echo  $value['goods_price'];?><?php echo $i_langpackage->i_yan;?></p>
				</li>
				<?php }?>
				<?php }?>
			</ul>
		</div>
	</div>
	<?php   require("shop/index_footer.php");?> </div>
<script>
  function inputTxt(obj,act){
	var str="<?php echo $s_langpackage->s_enter_label;?>";
	if(obj.value==''&&act=='set')
	{
		obj.value=str;
		obj.style.color="#cccccc"
	}
	if(obj.value==str&&act=='clean')
	{
		obj.value='';
		obj.style.color="#000000"
	}
}
  </script>
<script language="JavaScript" src="servtools/ajax_client/ajax.js"></script>
<script language="JavaScript">
	<!--
		function addFavorite(id) {
			var shop_id = document.getElementById('shop_id').value;
			var user_id = document.getElementById('shop_user').value;
			var favpv = document.getElementById('favpv_num').value;
			if (shop_id == user_id){
				alert('<?php echo $s_langpackage->s_mygoods_error;?>');
			}else {
				ajax("do.php?act=goods_add_favorite","POST","id="+id,function(data){
					if(data == 1) {
						var favpv_num = Number(favpv) + Number(1);
						document.getElementById('favpv').innerHTML = "<span id='favpv'>"+favpv_num+"</span>";
						alert("<?php echo  $s_langpackage->s_g_addedfavorite;?>");
					} else if(data == -1) {
						alert("<?php echo  $s_langpackage->s_g_stayfavorite;?>");
					} else {
						alert("<?php echo  $s_langpackage->s_g_addfailed;?>");
					}
				});
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

		function addCart(id) {
			var num = document.getElementById('num');

			var shop_id = document.getElementById('shop_id').value;
			var user_id = document.getElementById('shop_user').value;
			
			var num_reg = /^(\d+)$/;
			if(!num_reg.test(num.value)){
				alert('<?php echo $i_langpackage->i_num_format_error;?>');
				return;
			}
			if(num.value=='0'){
				alert('<?php echo $s_langpackage->s_g_buy_num_not_zero;?>');
				return;
			}

			if (shop_id == user_id){
				alert('<?php echo $s_langpackage->s_store_mygoods_error;?>');
			}else{
				ajax("do.php?act=goods_add_cart","POST","id="+id+"&num="+num.value,function(data){
					if(data == 1) {
						alert("<?php echo  $s_langpackage->s_g_addedcart;?>");
					} else if(data == -1) {
						alert("<?php echo  $s_langpackage->s_staycart;?>");
					} else if(data == -2) {
						alert("<?php echo  $s_langpackage->s_nomachgoods;?>");
					} else {
						alert("<?php echo  $s_langpackage->s_g_addfailed;?>");
					}
				});
			}
		}
		function gotoOrder(id) {
			var goods_number = document.getElementById('goods_number').value;
			var value = document.getElementById('num').value;
			
			var shop_id = document.getElementById('shop_id').value;
			var user_id = document.getElementById('shop_user').value;
			
			var num_reg = /^(\d+)$/;
			if(!num_reg.test(value)){
				alert('<?php echo $i_langpackage->i_num_format_error;?>');
				return;
			}

			if (shop_id == user_id){
				alert('<?php echo $s_langpackage->s_buy_mygoods;?>');
			}else {
				if(parseInt(value) > parseInt(goods_number)){
					alert("<?php echo $s_langpackage->s_less_stock;?>");
				}else {
					location.href = "<?php echo  $baseUrl;?>modules.php?app=user_order_adress&gid="+id+"&v="+value;
				}
			}
		}
		
	

	//-->
	</script>
</body>
</html>
<script language="JavaScript" type="text/javascript">
	function showarealist(n){
		var obj = document.getElementById("areabox");
		
		if(n){
			obj.style.display="";
		}else{
			obj.style.display="none";
		}
	}
	function gettransport_price(n,areaname){
		var goods_id = <?php echo $goodsinfo['goods_id'];?>;
		ajax("do.php?act=get_transport_price","POST","goods_id="+goods_id+"&area_id="+n,function(data){
			document.getElementById("transport_price").innerHTML=data;
			document.getElementById("area_name").innerHTML=areaname;
			showarealist(0);
		});
	}
	function show_tabs(flg){
		if (flg =='1'){
			document.getElementById("tab_content1").className ="now";
			document.getElementById("tab_content2").className ="";
			document.getElementById("tab_content3").className ="";
			document.getElementById("tab_content4").className ="";
			document.getElementById("tab1_content1").style.display ="block";
			document.getElementById("tab1_content2").style.display ="none";
			document.getElementById("tab1_content3").style.display ="none";
			document.getElementById("tab1_content4").style.display ="none";
		}
		if (flg == '2'){
			document.getElementById("tab_content1").className ="";
			document.getElementById("tab_content2").className ="now";
			document.getElementById("tab_content3").className ="";
			document.getElementById("tab_content4").className ="";
			document.getElementById("tab1_content1").style.display ="none";
			document.getElementById("tab1_content2").style.display ="block";
			document.getElementById("tab1_content3").style.display ="none";
			document.getElementById("tab1_content4").style.display ="none";
		}
		if (flg == '3'){
			document.getElementById("tab_content1").className ="";
			document.getElementById("tab_content2").className ="";
			document.getElementById("tab_content3").className ="now";
			document.getElementById("tab_content4").className ="";
			document.getElementById("tab1_content1").style.display ="none";
			document.getElementById("tab1_content2").style.display ="none";
			document.getElementById("tab1_content3").style.display ="block";
			document.getElementById("tab1_content4").style.display ="none";
			get_goods_credit(<?php echo $goods_id;?>,1);
		}
		if (flg == '4'){
			document.getElementById("tab_content1").className ="";
			document.getElementById("tab_content2").className ="";
			document.getElementById("tab_content3").className ="";
			document.getElementById("tab_content4").className ="now";
			document.getElementById("tab1_content1").style.display ="none";
			document.getElementById("tab1_content2").style.display ="none";
			document.getElementById("tab1_content3").style.display ="none";
			document.getElementById("tab1_content4").style.display ="block";
			get_order_record(<?php echo $goods_id;?>,1);
		}
	}
	String.prototype.Trim = function()
	{ return this.replace(/(^\s*)|(\s*$)/g, ""); }
	function submitform(){
		var tag_userid = document.getElementById("tag_userid").value;
		var tag = document.getElementById("tag").value.Trim();
		var veriCode = document.getElementById("veriCode").value;
		

		if (tag_userid){
			if (tag == '<?php echo $s_langpackage->s_enter_label;?>'){
				alert('<?php echo $s_langpackage->s_enter_goods_label;?>');
				return false;
			}else if (!tag){
				alert('<?php echo $s_langpackage->s_enter_goods_label;?>');
				return false;
			}
			 <?php if($verifycode['4']==1){?>
			if(!veriCode){
				alert('<?php echo $i_langpackage->i_verifycode_notnone;?>');
				return false;
			}
			<?php }?>
			return true;
		}else {
			alert('<?php echo $s_langpackage->s_no_login;?>');
			return false;
		}
	}
	function getVerCode() {
		document.getElementById("verCodePic").src="servtools/veriCodes.php?vc="+Math.random();
		return false;
	}
	//获取商品评价
	function get_goods_credit(goods_id,page){
	ajax("do.php?act=get_goods_credit&goods_id="+goods_id+"&page="+page,"GET",'',function(data){
		var obj_credit = document.getElementById("tab1_content3");
		if(data!='-1'){
			var obj = document.getElementById("page");
			var prepage=data.prepage;
			var nextpage=data.nextpage;
			var firstpage=data.firstpage;
			var lastpage=data.lastpage;
			var page=data.page;
			var countpage=data.countpage;
			var buyer_credit='';
			var pagehtml="<tr><td id='page' colspan='4'><A href=\"javascript:get_goods_credit("+goods_id+","+firstpage+");\"><?php echo $s_langpackage->s_page_first;?></A> <A href=\"javascript:get_goods_credit("+goods_id+","+prepage+");\"><?php echo $s_langpackage->s_page_pre;?></A> <A href=\"javascript:get_goods_credit("+goods_id+","+nextpage+");\"><?php echo $s_langpackage->s_page_next;?></A> <A href=\"javascript:get_goods_credit("+goods_id+","+lastpage+");\"><?php echo $s_langpackage->s_page_last;?></A> <?php echo $s_langpackage->s_page_num1;?>"+page+"<?php echo $s_langpackage->s_page_num2;?>"+countpage+"<?php echo $s_langpackage->s_page_num3;?></td></tr>";

			var result = data.result;
			var credit='';
			for($i=0;$i<result.length;$i++){
					scredit=result[$i].buyer_credit;
					if(scredit=='1'){
						buyer_credit="<?php echo $s_langpackage->s_credit_good;?>";
					}else
					if(scredit=='0'){
						buyer_credit="<?php echo $s_langpackage->s_credit_middle;?>";
					}else
					if(scredit=='-1'){
						buyer_credit="<?php echo $s_langpackage->s_credit_bad;?>";
					}
					
					credit+='<tr><td align="center">'+buyer_credit+'</td><td style="text-align:left">'+result[$i].buyer_evaluate+'</td><td><span class="c_gray">'+result[$i].buyer_evaltime+'</span></td><td>'+result[$i].user_name+'</td></tr>';
				}
			obj_credit.innerHTML = "<table class=\"tab_com\" width=\"100%\"><tr>"+
					"<th width=\"15%\" >评价等级</th>"+
					"<th width=\"55%\" style=\"text-align:left\">评价内容</th>"+
					"<th width=\"15%\">时间</th>"+
					"<th width=\"15%\">买家</th></tr>"+credit+pagehtml+"</table>";
		}else{
			obj_credit.innerHTML = "<table class=\"tab_com\" width=\"100%\"><tr><td>没有商品评价!</td></tr></table>";
		}

	},'JSON');
}
	//获取商品成交记录
	function get_order_record(goods_id,page){
	ajax("do.php?act=get_order_record&goods_id="+goods_id+"&page="+page,"GET",'',function(data){
		var obj_record = document.getElementById("tab1_content4");
		if(data!='-1'){
			var obj = document.getElementById("page");
			var prepage=data.prepage;
			var nextpage=data.nextpage;
			var firstpage=data.firstpage;
			var lastpage=data.lastpage;
			var page=data.page;
			var countpage=data.countpage;
			var pagehtml="<tr><td id='page' colspan='4'><A href=\"javascript:get_order_record("+goods_id+","+firstpage+");\"><?php echo $s_langpackage->s_page_first;?></A> <A href=\"javascript:get_order_record("+goods_id+","+prepage+");\"><?php echo $s_langpackage->s_page_pre;?></A> <A href=\"javascript:get_order_record("+goods_id+","+nextpage+");\"><?php echo $s_langpackage->s_page_next;?></A> <A href=\"javascript:get_order_record("+goods_id+","+lastpage+");\"><?php echo $s_langpackage->s_page_last;?></A> <?php echo $s_langpackage->s_page_num1;?>"+page+"<?php echo $s_langpackage->s_page_num2;?>"+countpage+"<?php echo $s_langpackage->s_page_num3;?></td></tr>";

			var result = data.result;
			var record='';
			for($i=0;$i<result.length;$i++){
				record+='<tr><td>'+result[$i].user_name+'</td><td style="text-align:left"><a href="<?php echo goods_url($goods_id);?>">'+result[$i].goods_name+'</a></td><td>'+result[$i].goods_price+'</td><td>'+result[$i].order_num+'</td><td>'+result[$i].shipping_time+'</td><td>成交</td></tr>';
			}
			obj_record.innerHTML = "<table class=\"tab_record\" width=\"100%\"><tr><th width=\"10%\">买家</th><th width=\"45%\"  style=\"text-align:left\">商品名称</th><th width=\"10%\">出价记录</th><th width=\"10%\">数量</th><th width=\"15%\">成交时间</th><th width=\"10%\">状态</th></tr>"+record+pagehtml+"</table>";
		}else{
			obj_record.innerHTML = "<table class=\"tab_record\" width=\"100%\"><tr><td>没有成交记录!</td></tr></table>";
		}

	},'JSON');
}

</script>
<?php } ?>