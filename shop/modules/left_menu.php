<?php
/*
 * 注意：此文件由itpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/modules/left_menu.html
 * 如果您的模型要进行修改，请修改 models/modules/left_menu.php
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
if(filemtime("templates/default/modules/left_menu.html") > filemtime(__file__) || (file_exists("models/modules/left_menu.php") && filemtime("models/modules/left_menu.php") > filemtime(__file__)) ) {
	tpl_engine("default","modules/left_menu.html",1);
	include(__file__);
} else {
/* debug模式运行生成代码 结束 */
?><?php
	/*
	***********************************************
	*$ID:
	*$NAME:
	*$AUTHOR:E.T.Wei
	*DATE:Mon Mar 22 16:19:15 CST 2010
	***********************************************
	*/
	if(!$IWEB_SHOP_IN) {
		trigger_error('Hacking attempt');
	}

	//文件引入
	include_once("foundation/asystem_info.php");
	include_once("foundation/module_users.php");

	//引入语言包
	$m_langpackage=new moduleslp;
	//数据表定义区
	$user_table = $tablePreStr."users";
	$t_order_info = $tablePreStr."order_info";
	$t_shop_inquiry = $tablePreStr."shop_inquiry";
	$t_shop_guestbook = $tablePreStr."shop_guestbook";
	$t_shop_info = $tablePreStr."shop_info";
	$t_shop_request = $tablePreStr."shop_request";
	//读写分类定义方法
	$dbo=new dbex;
	dbtarget('r',$dbServs);
	$user_id = get_sess_user_id();
	$userinfo = get_user_info($dbo,$user_table,$user_id);
	$user_rank = $userinfo['rank_id'];
	/* 收到的询价 */
	$sql = "select shop_id from `$t_shop_inquiry` where shop_id='$user_id' and shop_del_status=1 and read_status=0";
	$rs = $dbo->getRs($sql);
	$shop_inquiry_num = 0;
	foreach($rs as $value) {
		$shop_inquiry_num++;
	}
	/* 收到的留言 */
	$sql = "SELECT shop_id FROM `$t_shop_guestbook` WHERE shop_id='$user_id' and shop_del_status=1 and read_status=0";
	$rs = $dbo->getRs($sql);
	$shop_guestbook_num = 0;
	foreach($rs as $value) {
		$shop_guestbook_num++;
	}
	/* 我的留言 */
	$sql = "SELECT shop_id FROM `$t_shop_guestbook` WHERE user_id='$user_id' and user_del_status=1";
	$rs = $dbo->getRs($sql);
	$my_guestbook_num = 0;
	foreach($rs as $value) {
		$my_guestbook_num++;
	}
	/* 我的,收到的订单 */
	$sql = "SELECT shop_id,user_id,order_status FROM `$t_order_info` WHERE (shop_id='$user_id' OR user_id='$user_id') and order_status>0";
	$rs = $dbo->getRs($sql);
	$my_order_num = 0;
	$get_order_num = 0;
	$u_order_num = 0;
	$s_order_num = 0;
	foreach($rs as $value) {
		if($value['shop_id']==$user_id) {
			if($value['order_status']=='3') {
				$u_order_num++;
			}else{
				$get_order_num++;
			}
		}
		if($value['user_id']==$user_id) {
			$my_order_num++;
			if($value['order_status']=='3') {
				$s_order_num++;
			}
		}
	}
	
		/* 提醒设置 */
	$sql = "SELECT shop_id FROM `$t_shop_info` WHERE user_id='$user_id'";
	$rs = $dbo->getRs($sql);
	$my_shop_info_num = 0;
	foreach($rs as $value) {
		$my_shop_info_num++;
	}
	$shop_open_flg = 0;
	$shop_lock_flg = 0;
	$shop_pass_flg = 0;
	$shop_exist_flg = 0;
	$sql = "select si.shop_id,si.lock_flg,si.open_flg,sr.status from $t_shop_info as si left join $t_shop_request sr on si.shop_id = sr.user_id where si.user_id='$user_id'";
	$row = $dbo->getRow($sql);
	 // print_r($row);
	if($row){
		$shop_exist_flg = 1;
		if($row["lock_flg"])
			$shop_lock_flg = $row["lock_flg"];
		if($row["open_flg"])
			$shop_open_flg = $row["open_flg"];
		if($row["status"] !=null && $row["status"] == 0)
			$shop_pass_flg = 0;
		else 
			$shop_pass_flg = 1;
	}
?><div class="main_body">
<!--main_left左侧导航菜单开始-->
<div class="main_left">
	<div class="memc_title"></div>
	<div class="back_home"> <a href="modules.php"><?php echo  $m_langpackage->m_personal_home;?></a> </div>
	<!--点击回到个人中心首页-->
	<div class="menu">
		<div class="menu_title"> <span class="put"><a href="javascript:;" hidefocus="true" title="<?php echo $m_langpackage->m_programa;?>"></a></span> <a class="menuicon" id="buyer" href="javascript:;"><?php echo  $m_langpackage->m_buyer;?></a> </div>
		<div class="menu_li">
			<ul>
				<li><a id="user_cart" onclick="menu_style_change('user_cart')" href="modules.php?app=user_cart"><?php echo  $m_langpackage->m_my_cart;?></a></li>
				<li><a id="user_my_order" onclick="menu_style_change('user_my_order')" href="modules.php?app=user_my_order"><?php echo  $m_langpackage->m_my_order;?></a></li>
				<li><a id="user_group" onclick="menu_style_change('user_group')" href="modules.php?app=user_group"><?php echo  $m_langpackage->m_my_groupbuy;?></a></li>
				<li><a id="user_favorite" onclick="menu_style_change('user_favorite')" href="modules.php?app=user_favorite"><?php echo  $m_langpackage->m_my_favorite;?></a></li>
				<li><a id="user_guestbook" onclick="menu_style_change('user_guestbook')" href="modules.php?app=user_guestbook"><?php echo  $m_langpackage->m_my_guestbook;?></a></li>
				<li><a id="user_address" onclick="menu_style_change('user_address')" href="modules.php?app=user_address"><?php echo $m_langpackage->m_getgoods_address;?></a></li>
			</ul>
		</div>
		<div class="menu_title"> <span class="put"><a href="javascript:;" hidefocus="true" title="<?php echo $m_langpackage->m_programa;?>"></a></span> <a class="menuicon" id="seller" href="javascript:;"><?php echo  $m_langpackage->m_seller;?></a> </div>
		<div class="menu_li">
			<ul>
				<?php if(isset($user_privilege[1]) && $user_privilege[1]==1){?>
					<?php if($shop_exist_flg == 1){?>
						<?php if($shop_pass_flg ==1){?>
						   <?php if($shop_lock_flg == 0){?>
								<li style="position:relative"> 
								<a style="_margin-bottom:-18px" id="shop_info" onclick="menu_style_change('shop_info')" href="modules.php?app=shop_info">
									<?php echo  $m_langpackage->m_shop_info;?>
								</a>
								<span id="shop_flg" style="position:absolute;width:37px;right:20px;top:4px;_top:3px"> 
								<?php if($shop_open_flg ==1){?> 
								<label onclick="change_open_status('0')" style="color:red; cursor:pointer; font-weight:normal">
								<?php echo  $m_langpackage->m_open;?>
								</label> 
								<?php  } else {?> 
								<label  onclick="change_open_status('1')" style="color:red; cursor:pointer; font-weight:normal"><?php echo  $m_langpackage->m_close;?></label> 
								<?php }?> </span> </li>
								<li>
								<a href="<?php echo shop_url($shop_id);?>" target="_blank"><?php echo  $m_langpackage->m_shop_view;?></a>
								</li>
								<!-- <li><a href="modules.php?app=shop_honor"><?php echo  $m_langpackage->m_shop_honor;?></a></li> -->
								<li>
								<a id="shop_category" onclick="menu_style_change('shop_category')" href="modules.php?app=shop_category"><?php echo  $m_langpackage->m_shop_category;?></a></li>
								<li>
								<a id="goods_list" onclick="menu_style_change('goods_list')" href="modules.php?app=goods_list"><?php echo  $m_langpackage->m_goods_list;?></a>
								</li>
								<!-- <li><a id="goods_add" onclick="menu_style_change('goods_add')" href="modules.php?app=goods_add"><?php echo  $m_langpackage->m_add_newgoods;?></a></li> -->
								<li>
								<a id="groupbuy_list" onclick="menu_style_change('groupbuy_list')" href="modules.php?app=groupbuy_list">
								<?php echo  $m_langpackage->m_groupbuy_list;?></a>
								</li>
								<!--<li><a id="groupbuy_add" onclick="menu_style_change('groupbuy_add')" href="modules.php?app=groupbuy_add"><?php echo  $m_langpackage->m_add_groupbuy;?></a></li>-->
								<!--<li><a id="csv_export" onclick="menu_style_change('csv_export')" href="modules.php?app=csv_export"><?php echo  $m_langpackage->m_csv_export;?></a></li>
										<li><a id="csv_import" onclick="menu_style_change('csv_import')" href="modules.php?app=csv_import"><?php echo  $m_langpackage->m_csv_import;?></a></li>-->
								<li>
								<a id="shop_my_order" onclick="menu_style_change('shop_my_order')" href="modules.php?app=shop_my_order">
								<?php echo  $m_langpackage->m_rc_order;?>(<?php echo  $get_order_num;?>)<?php if($get_order_num>0){?>
								<img src="skin/<?php echo $SYSINFO['templates'];?>/images/woo.gif" width="21" height="12" /><?php }?>
								</a>
								</li>
								<li>
								<a id="shop_guestbook" style="_padding-top:5px;_margin-bottom:-5px" onclick="menu_style_change('shop_guestbook')" href="modules.php?app=shop_guestbook">
								<?php echo  $m_langpackage->m_rc_guestbook;?>(<?php echo  $shop_guestbook_num;?>)<?php if($shop_guestbook_num>0){?>
								<img src="skin/<?php echo $SYSINFO['templates'];?>/images/woo.gif" width="21" height="12" /><?php }?>
								</a>
								</li>
								<li>
								<a id="shop_askprice" onclick="menu_style_change('shop_askprice')" href="modules.php?app=shop_askprice">
								<?php echo  $m_langpackage->m_rc_askprice;?>(<?php echo $shop_inquiry_num;?>)<?php if($shop_inquiry_num>0){?>
								<img src="skin/<?php echo $SYSINFO['templates'];?>/images/woo.gif" width="21" height="12" />
								<?php }?>
								</a>
								</li>
								<li><a id="shop_notice" onclick="menu_style_change('shop_notice')" href="modules.php?app=shop_notice"><?php echo  $m_langpackage->m_shop_notice;?></a></li>
								<!-- <li><a href="modules.php?app=shop_news"><?php echo  $m_langpackage->m_shopnews_manage;?></a></li> -->
								<!-- <li><a href="modules.php?app=shop_news_add"><?php echo  $m_langpackage->m_add_shopnews;?></a></li> -->
								<li>
								<a id="shop_payment" onclick="menu_style_change('shop_payment')" href="modules.php?app=shop_payment">
								<?php echo  $m_langpackage->m_payment_setting;?>
								</a>
								</li>
								<li>
								<a id="shop_receiv_list" onclick="menu_style_change('shop_receiv_list')" href="modules.php?app=shop_receiv_list">
								收款单
								</a>
								</li>
								<li>
								<a id="shop_shipping_list" onclick="menu_style_change('shop_shipping_list')" href="modules.php?app=shop_shipping_list">
								发货单
								</a>
								</li>
								<li>
								<a id="shop_refund_list" onclick="menu_style_change('shop_refund_list')" href="modules.php?app=shop_refund_list">
								退款单
								</a>
								</li>
							<?php  } else {?>
								<li><a href=""><?php echo  $m_langpackage->m_shop_lock;?></a></li>
							<?php }?>
						<?php  } else {?>
							<li><a href=""><?php echo  $m_langpackage->m_shop_pass;?></a></li>
						<?php }?>
					<?php  } else {?>
						<?php if($user_privilege[1]==1){?>
							<li><a id="shop_request" onclick="menu_style_change('shop_request')" href="modules.php?app=shop_request" style="color:#1E88C0"><?php echo $m_langpackage->m_reg_com_user;?></a></li>
						<?php }?>
					<?php }?>
				<?php  } else {?>
					<?php if($user_rank<2){?>
						<li><a id="shop_request" onclick="menu_style_change('shop_request')" href="modules.php?app=shop_request" style="color:#1E88C0"><?php echo $m_langpackage->m_reg_com_user;?></a></li>
					<?php }?>
				<?php }?>
			</ul>
		</div>
		<div class="menu_title"> <span class="put"><a href="javascript:;" hidefocus="true" title="<?php echo $m_langpackage->m_programa;?>"></a></span> <a class="menuicon" name="shoprate_manage" id="comment" href="javascript:;"><?php echo  $m_langpackage->m_shoprate_manage;?></a> </div>
		<div class="menu_li">
			<ul>
				<li><a id="shop_rate_buyer" onclick="menu_style_change('shop_rate_buyer')" href="modules.php?app=shop_rate&t=buyer"><?php echo  $m_langpackage->m_shoprate_frombuyer;?></a></li>
				<li><a id="shop_rate_seller" onclick="menu_style_change('shop_rate_seller')" href="modules.php?app=shop_rate&t=seller"><?php echo  $m_langpackage->m_shoprate_fromseller;?></a></li>
				<li><a id="shop_rate_bymain" onclick="menu_style_change('shop_rate_bymain')" href="modules.php?app=shop_rate&t=bymain"><?php echo  $m_langpackage->m_shoprate_topep;?></a></li>
			</ul>
		</div>
		<div class="menu_title"> <span class="put"><a href="javascript:;" hidefocus="true" title="<?php echo $m_langpackage->m_programa;?>"></a></span> <a class="menuicon" name="base_setting" id="option" href="javascript:;"><?php echo  $m_langpackage->m_base_setting;?></a> </div>
		<div class="menu_li">
			<ul>
				<li><a id="user_profile" onclick="menu_style_change('user_profile')" href="modules.php?app=user_profile"><?php echo  $m_langpackage->m_profile;?></a></li>
				<?php if($my_shop_info_num>0){?>
				<li><a id="user_remind" onclick="menu_style_change('user_remind')" href="modules.php?app=user_remind"><?php echo  $m_langpackage->m_remind_setting;?></a></li>
				<li><a id="user_remind_info" onclick="menu_style_change('user_remind_info')" href="modules.php?app=user_remind_info"><?php echo  $m_langpackage->m_my_remind;?></a></li>
				<?php }?>
				<?php if($im_enable){?>
				<li><a href="modules.php?app=user_ico"><?php echo  $m_langpackage->m_userico_setting;?></a></li>
				<?php }?>
				<li><a id="user_passwd" onclick="menu_style_change('user_passwd')" href="modules.php?app=user_passwd"><?php echo  $m_langpackage->m_edit_password;?></a></li>
				<li><a href="do.php?act=logout"><?php echo  $m_langpackage->m_logout;?></a></li>
			</ul>
		</div>
		<!-- plugins !-->
		<div id="user_menu_buttun"> <?php echo isset($plugins['user_menu_buttun'])?show_plugins($plugins['user_menu_buttun']):'';?> </div>
		<!-- plugins !-->
	</div>
	<!--menu结束-->
</div>
<script language="JavaScript" src="servtools/ajax_client/ajax.js"></script>
<script language="JavaScript">
<!--
function change_open_status(flg) {
	if(flg==1){
		var open=confirm('<?php echo  $m_langpackage->m_open_message;?>');

		if (open){
			ajax("do.php?act=shop_open_flg","POST","value="+flg,function(return_text){
				return_text = return_text.replace(/[\n\r]/g,"");
				document.getElementById("shop_flg").innerHTML = return_text;
			});
		}
	}else {
		ajax("do.php?act=shop_open_flg","POST","value="+flg,function(return_text){
			return_text = return_text.replace(/[\n\r]/g,"");
			document.getElementById("shop_flg").innerHTML = return_text;
		});
	}
}
function menu_style_change(flg) {
	document.getElementById(flg).className="current";
}
//-->
</script>
<?php } ?>