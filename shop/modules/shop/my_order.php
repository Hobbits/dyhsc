<?php
/*
 * 注意：此文件由itpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/modules/shop/my_order.html
 * 如果您的模型要进行修改，请修改 models/modules/shop/my_order.php
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
if(filemtime("templates/default/modules/shop/my_order.html") > filemtime(__file__) || (file_exists("models/modules/shop/my_order.php") && filemtime("models/modules/shop/my_order.php") > filemtime(__file__)) ) {
	tpl_engine("default","modules/shop/my_order.html",1);
	include(__file__);
} else {
/* debug模式运行生成代码 结束 */
?><?php
if(!$IWEB_SHOP_IN) {
	trigger_error('Hacking attempt');
}

require("foundation/acheck_shop_creat.php");
require("foundation/module_payment.php");
require("foundation/module_order.php");
require("foundation/module_shop.php");

//引入语言包
$m_langpackage=new moduleslp;
$i_langpackage=new indexlp;
$s_langpackage=new shoplp;
//数据表定义区
$t_order_info = $tablePreStr."order_info";
$t_goods = $tablePreStr."goods";
$t_shop_info = $tablePreStr."shop_info";
$t_payment = $tablePreStr."payment";
$t_order_goods = $tablePreStr."order_goods";
$t_users = $tablePreStr."users";

$group_id = intval(get_args('id'));
$state = intval(get_args('state'));
$dbo = new dbex;
dbtarget('r',$dbServs);
/* 商铺信息处理 */
include("foundation/fshop_locked.php");
//判断用户是否锁定，锁定则不许操作
$sql ="select locked from $t_users where user_id=$user_id";
$row = $dbo->getRow($sql);
if($row['locked']==1){
	session_destroy();
	trigger_error($m_langpackage->m_user_locked);//非法操作
}
if(empty($group_id)){
	$result = get_myoder_list($dbo,$t_order_info,$t_order_goods,$t_goods,$t_shop_info,$shop_id,13,'shop',$state,$t_users);
}else{
	$result = get_myoder_list($dbo,$t_order_info,$t_order_goods,$t_goods,$t_shop_info,$group_id,13,'groupbuy',$state,$t_users);
}
$payment_info = get_payment_info($dbo,$t_payment);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo  $m_langpackage->m_u_center;?></title>
<link rel="stylesheet" type="text/css" href="skin/<?php echo  $SYSINFO['templates'];?>/css/modules.css">
<link rel="stylesheet" type="text/css" href="skin/<?php echo  $SYSINFO['templates'];?>/css/layout.css">
<link rel="stylesheet" type="text/css" href="skin/<?php echo  $SYSINFO['templates'];?>/css/style.css">
<script type="text/javascript" src="skin/<?php echo  $SYSINFO['templates'];?>/js/changeStyle.js"></script>
<script type="text/javascript" src="skin/<?php echo  $SYSINFO['templates'];?>/js/userchangeStyle.js"></script>

<style type="text/css">
th{background:#EFEFEF}
.edit span{background:#efefef;}
.search {margin:5px;}
.search input {color:#444;}
td.img img{cursor:pointer}
.red {color:red;}
.green {color:green;}
.black {color:black;}
</style>
</head>
<body onload="menu_style_change('shop_my_order');changeMenu();">
<?php  require("shop/index_header.php");?>
	<div class="site_map">
	  <?php echo $m_langpackage->m_current_position;?><A href="index.php"><?php echo $SYSINFO['sys_name'];?></A>/<a href="modules.php"><?php echo $m_langpackage->m_u_center;?></a>/&nbsp;&nbsp;<?php echo $m_langpackage->m_recver_order;?>
	</div>
    <div class="clear"></div>
  	<?php  require("modules/left_menu.php");?>
        <div class="main_right">
        	<div class="right_top"></div>
            <div class="cont">
                <div class="cont_title">
                <span class="tr_op">
				<form action="modules.php?app=shop_my_order" method="post">
					<select name="state">
						<option value='' <?php if($state=="") {echo 'selected'; }?>>全部</option>
						<option value='1' <?php if($state=="1"){echo "selected";}?>>未确定</option>
						<option value='2' <?php if($state=="2"){echo "selected";}?>>已确定</option>
						<option value='3' <?php if($state=="3"){echo "selected";}?>>未支付</option>
						<option value='4' <?php if($state=="4"){echo "selected";}?>>已支付</option>
						<option value='5' <?php if($state=="5"){echo "selected";}?>>未发货</option>
						<option value='6' <?php if($state=="6"){echo "selected";}?>>已发货</option>
						<option value='7' <?php if($state=="7"){echo "selected";}?>>已完成</option>
						<option value='8' <?php if($state=="8"){echo "selected";}?>>已收款未发货</option>
						<option value='9' <?php if($state=="9"){echo "selected";}?>>未评价</option>
					</select>&nbsp;&nbsp;&nbsp;&nbsp;
					<input class="btn_ser" type="submit" value="查询" />&nbsp;&nbsp;&nbsp;&nbsp;
				</form>
				</span>
                <?php echo $m_langpackage->m_recver_order;?></div>
                <hr />
			<table width="100%" border="0" cellspacing="0">
				<tr class="center"><th colspan="2"><?php echo  $m_langpackage->m_order_goods_info;?></th>
					<th width=""><?php echo  $m_langpackage->m_count;?></th>
					<th width="200"><?php echo  $m_langpackage->m_order_orderinfo;?></th>
					<th width="60"><?php echo  $m_langpackage->m_status;?></th>
					<th width="75"><?php echo  $m_langpackage->m_manage;?></th>
				</tr>
				<?php 
				if(!empty($result['result'])) {
					foreach($result['result'] as $v) {?>
					<?php $num =count($v['order_goods']);foreach($v['order_goods'] as $k=>$val){?>
				<tr class="trcolor">
						<td class=" center" width="82"><a href="modules.php?app=user_photo_view&id=<?php echo $val['id'];?>&path=shop_my_order" target="_blank"><img src="<?php echo $val['goods_thumb'];?>" width="80" height="80" onerror="this.src='skin/default/images/nopic.gif'"/></a></td>
						<td width="280"><a href="modules.php?app=user_photo_view&id=<?php echo $val['id'];?>&path=shop_my_order"
						 target="_blank" style="color:#0044DD;"><?php echo  $val['goods_name'];?></a><br/>
						<?php echo  $m_langpackage->m_order_shops;?>：<a href="shop.php?shopid=<?php echo  $val['shop_id'];?>&app=index" target="_blank"><?php echo  $val['shop_name'];?></a>  <script src="imshow.php?u=<?php echo  $val['user_id'];?>"></script>
						</td>
						<!-- 合并  -->
	            <?php if($k==0){?>
					<td class="border_l center"  rowspan="<?php echo $num;?>"><?php echo  $v['order_amount'];?></td>
					<td class="border_l textleft"  rowspan="<?php echo $num;?>">
						<?php echo  $m_langpackage->m_order_payids;?>：
						<a href="modules.php?app=shop_order_view&order_id=<?php echo  $v['order_id'];?>" title="<?php echo  $m_langpackage->m_view_orderinfo;?>" style="color:#E38016;"><?php echo  $v['payid'];?></a>
						<?php  if(!empty($v['group_id'])) {?> <a href="goods.php?app=groupbuyinfo&id=<?php echo  $v['group_id'];?>" class="green" target="_blank">[<?php echo  $m_langpackage->m_group_buy;?>]</a>
						<?php }?><br />
						<?php echo  $m_langpackage->m_order_ordertime;?>：<?php echo  substr($v['order_time'],0,16);?><br />
						<?php echo  $m_langpackage->m_buyer_yes;?>：<?php echo  $v['dname'][0];?>
					</td>
					<td class="center border_l"  rowspan="<?php echo $num;?>">
						<?php  if($val['lock_flg']==1){
		            		echo "<span class='black'>".$s_langpackage->s_goods_locked."</span><br />";
		            		if($v['order_status']==3) {
								echo "<span class='green'>".$m_langpackage->m_order_combuy."</span><br />";
							}
		            	}else{
							 	if($v['order_status']==0){
									echo "<span class='black'>".$m_langpackage->m_order_dell."</span><br />";
								}elseif($v['protect_status']==1){
										echo "<span class='red'>维权中</span><br /> ";
								}elseif($v['protect_status']==2){
										echo "<span class='red'>同意维权</span><br /> ";
								}elseif($v['protect_status']==3){
										echo "<span class='red'>维权结束</span><br /> ";
								}elseif($v['order_status']==3) {
									echo "<span class='green'>".$m_langpackage->m_order_combuy."</span><br />";
								} else {
									if($v['pay_status']==0) {
										echo "<span class='red'>".$m_langpackage->m_order_nopayed."</span><br /> ";
									} elseif($v['pay_status']==2){
										echo "<span class='red'>待退款</span><br /> ";
									} elseif($v['pay_status']==3){
										echo "<span class='red'>已退款</span><br /> ";
									} elseif($v['pay_status']==4){
										echo "<span class='red'>退款成功</span><br /> ";
									}else {
										if($v['transport_status']) {
											echo "<span class='red'>".$m_langpackage->m_order_transported."</span><br /> ";
										} else {
											echo "<span class='red'>".$m_langpackage->m_order_notransported."</span><br />";
										}
									}	
							}
						}?>
					</td>
					<td class="center border_l"  rowspan="<?php echo $num;?>">
						<?php  if($val['lock_flg']==1){?>
							<a href="modules.php?app=shop_order_view&order_id=<?php echo  $v['order_id'];?>" title="<?php echo  $m_langpackage->m_view_orderinfo;?>"><?php echo  $m_langpackage->m_view_orderinfo2;?></a>
						<?php  }else{?>
							<?php  if($v['order_status']==1 && $v['pay_status']==0) {?>
							<a href="do.php?act=shop_order_del&id=<?php echo  $v['order_id'];?>" onclick="return confirm('<?php echo  $m_langpackage->m_sure_thisorder;?>');"><?php echo  $m_langpackage->m_cancelorder;?></a>
							<br />
							<?php }?>
							<?php  if($v['transport_status']==0 && $v['order_status']==1 && $v['pay_status']==1) {?>
								<?php  if($payment_info[$v['pay_id']]['pay_code']=='alipay') {?>
								<a href="plugins/alipay/comput.php?id=<?php echo  $v['order_id'];?>" target="_blank"><?php echo  $m_langpackage->m_sure_shippingnow;?></a><br />
								<?php  } else {?>
								<a href="modules.php?app=shop_sure_recevi&order_id=<?php echo  $v['order_id'];?>" onclick="javascript:if(confirm('<?php echo  $m_langpackage->m_clicksure_s;?>')){return true;} else {return false;}"><?php echo  $m_langpackage->m_sure_shippingnow;?></a><br />
								<?php }?>
							<?php }?>
							<?php  if($v['transport_status']==0 && $v['order_status']==1 && $v['pay_status']==2) {?>
								<a href="modules.php?app=shop_back_money&order_id=<?php echo  $v['order_id'];?>">退款</a><br/>
							<?php }?>
							<?php  if($v['protect_status']==1 || $v['protect_status']==2) {?>
								<a href="modules.php?app=shop_protect_rights&id=<?php echo  $v['order_id'];?>"><font color='red'>查看维权</font></a><br/>
							<?php }?>
							<a href="modules.php?app=shop_order_view&order_id=<?php echo  $v['order_id'];?>" title="<?php echo  $m_langpackage->m_view_orderinfo;?>">
							<?php echo  $m_langpackage->m_view_orderinfo2;?></a><br />
							<!-- 订单评价 开始 -->
							<?php  if($v['transport_status']==1 && $v['order_status']==3 && $v['seller_reply']==0) {?>
								<a href="modules.php?app=shop_credit_add&id=<?php echo  $v['order_id'];?>&t=seller" ><?php echo  $m_langpackage->m_evaluate;?></a><br />
							<?php }else if($v['transport_status']==1 && $v['order_status']==3 && $v['seller_reply']==1){?>
								<?php echo $m_langpackage->m_already_valuation;?>
							<?php }?>
							<!-- 订单评价 结束 -->
							
						<?php  }?>
					</td>
					<!-- 合并  -->
            <?php }?>
				</tr>
				<?php }?>
				<?php }?>
				<tr><td colspan="6" class="page"><?php  require("modules/page.php");?></td></tr>
				<?php  } else {?>
				<tr><td colspan="6" class="center"><?php echo  $m_langpackage->m_nolist_record;?></td></tr>
				<?php }?>
			</table>
			
			</div>
			<div class="right_bottom"></div>
			<div class="back_top"><a href="#"></a></div>
		</div>
	</div>
    <div class="clear"></div>
    <?php  require("shop/index_footer.php");?>
<script language="JavaScript" src="servtools/ajax_client/ajax.js"></script>
<script language="JavaScript">
<!--
function toggle_show(obj,id) {
	var re = /yes/i;
	var src = obj.src;
	var isshow = 1;
	var sss = src.search(re);
	if(sss > 0) {
		isshow = 0;
	}
	ajax("do.php?act=shop_isshow_toggle","POST","id="+id+"&s="+isshow,function(data){
		if(data) {
			obj.src = 'skin/default/images/'+data+'.gif';
		}
	});
}
//-->
</script>
</body>
</html><?php } ?>