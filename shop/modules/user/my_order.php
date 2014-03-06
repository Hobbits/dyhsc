<?php
/*
 * 注意：此文件由itpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/modules/user/my_order.html
 * 如果您的模型要进行修改，请修改 models/modules/user/my_order.php
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
if(filemtime("templates/default/modules/user/my_order.html") > filemtime(__file__) || (file_exists("models/modules/user/my_order.php") && filemtime("models/modules/user/my_order.php") > filemtime(__file__)) ) {
	tpl_engine("default","modules/user/my_order.html",1);
	include(__file__);
} else {
/* debug模式运行生成代码 结束 */
?><?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}
require('foundation/module_start.php');

//引入语言包
$m_langpackage=new moduleslp;
$i_langpackage=new indexlp;
$s_langpackage=new shoplp;

//数据表定义区
$t_order_info = $tablePreStr."order_info";
$t_goods = $tablePreStr."goods";
$t_shop_info = $tablePreStr."shop_info";
$t_order_goods = $tablePreStr."order_goods";
//读写分离定义方法
$dbo = new dbex;
dbtarget('r',$dbServs);
$state=intval(get_args('state'));
$user_id = get_sess_user_id();
$result = get_myorder_info($dbo,$t_order_info,$t_shop_info,$t_goods,$t_order_goods,$user_id,$state,10);

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo $m_langpackage->m_u_center;?></title>
<link rel="stylesheet" type="text/css" href="skin/<?php echo  $SYSINFO['templates'];?>/css/modules.css">
<link rel="stylesheet" type="text/css" href="skin/<?php echo  $SYSINFO['templates'];?>/css/layout.css">
<script type="text/javascript" src="skin/<?php echo  $SYSINFO['templates'];?>/js/changeStyle.js"></script>
<link rel="stylesheet" type="text/css" href="skin/<?php echo  $SYSINFO['templates'];?>/css/style.css">
<script type="text/javascript" src="skin/<?php echo  $SYSINFO['templates'];?>/js/userchangeStyle.js"></script>

<style type="text/css">
.red{color:#fc0000;}
.green {color:green;}
</style>
</head>
<body onload="menu_style_change('user_my_order');changeMenu();">
<?php  require("shop/index_header.php");?>
	<div class="site_map">
	  <?php echo $m_langpackage->m_current_position;?><A href="index.php"><?php echo $SYSINFO['sys_name'];?></A>/<a href="modules.php"><?php echo $m_langpackage->m_u_center;?></a>/&nbsp;&nbsp;<?php echo $m_langpackage->m_my_order;?>
	</div>
    <div class="clear"></div>
	<?php  require("modules/left_menu.php");?>
	<div class="main_right">
		<div class="right_top"></div>
		<div class="cont">
			<div class="cont_title">
				 <span class="tr_op">
				<form action="modules.php?app=user_my_order" method="post">
					<select name="state">
						<option value='' <?php if($state=="") {echo 'selected'; }?>>全部</option>
						<option value='1' <?php if($state=="1"){echo "selected";}?>>未确定</option>
						<option value='2' <?php if($state=="2"){echo "selected";}?>>已确定</option>
						<option value='3' <?php if($state=="3"){echo "selected";}?>>未支付</option>
						<option value='4' <?php if($state=="4"){echo "selected";}?>>已支付</option>
						<option value='5' <?php if($state=="5"){echo "selected";}?>>未发货</option>
						<option value='6' <?php if($state=="6"){echo "selected";}?>>已发货</option>
						<option value='7' <?php if($state=="7"){echo "selected";}?>>已完成</option>
						<option value='8' <?php if($state=="8"){echo "selected";}?>>已发货待确认</option>
						<option value='9' <?php if($state=="9"){echo "selected";}?>>未评价</option>
					</select>&nbsp;&nbsp;&nbsp;&nbsp;
					<input class="btn_ser" type="submit" value="查询" />&nbsp;&nbsp;&nbsp;&nbsp;
				</form>
				</span>
				<?php echo $m_langpackage->m_my_order;?>
				<!-- <a href="javascript:;" onclick="merge_sub()"><?php echo $m_langpackage->m_merge_order;?></a> -->
			</div>
			<hr />
 			 <table class="commodityCart" width="100%" border="0" cellspacing="0">
        <tbody>
          <tr>
            <th width="90px" align="center"><?php echo $m_langpackage->m_showgoods_photo;?></th>
            <!--限定宽度，不让图片太宽把右侧的文字挤换行！-->
            <th width=""><?php echo $m_langpackage->m_order_goods_info;?></th>
            <th width="190"><?php echo $m_langpackage->m_order_orderinfo;?></th>
            <th width="60" align="center"><?php echo $m_langpackage->m_count;?></th>
            <th width="90"><?php echo $m_langpackage->m_status;?></th>
            <th width="80"><?php echo $m_langpackage->m_manage;?></th>
          </tr>
           <?php if(!empty($result['result'])) {
				foreach($result['result'] as $v) {?>
          <!-- order01 -->
          <tr class="orderInfo">
            <td colspan="6"><?php echo $m_langpackage->m_order_group;?>：<?php echo $v['payid'];?></td>
          </tr>
          <?php $num =count($v['order_goods']); foreach($v['order_goods'] as $k=> $goods){?>
          <tr>
            <td><img src="<?php echo $goods['goods_thumb'];?>" alt="<?php echo $goods['goods_name'];?>" width="80" width="80" onerror="this.src='skin/default/images/nopic.gif'"/></td>
            <td><a href="modules.php?app=user_photo_view&id=<?php echo $goods['id'];?>&path=user_my_order" target="_blank" ><?php echo $goods['goods_name'];?></a></td>
            <!-- 合并  -->
            <?php if($k==0){?>
            <td class="border_l" rowspan="<?php echo $num;?>"  ><?php echo $m_langpackage->m_order_ordertime;?>：<?php echo $v['order_time'];?><br /><?php echo $m_langpackage->m_order_shops;?>：<?php echo $v['shop_name'];?></td>
             <td class="border_l" rowspan="<?php echo $num;?>"  ><?php echo $m_langpackage->m_money_sign;?><?php echo $v['order_value'];?></td>
			  <td class="border_l" rowspan="<?php echo $num;?>" >
            	<?php  if($goods['lock_flg']==1){
            		echo "<span class='black'>".$s_langpackage->s_goods_locked."</span><br />";
            	}else if($v['open_flg']==1){
            		echo "<span class='black'>".$m_langpackage->m_favitor_close."</span><br />";
            	}else if($v['lock_flg']==1){
            		echo "<span class='black'>".$m_langpackage->m_favitor_lock."</span><br />";
            	}else{
	            	if($v['order_status']==0){
							echo "<span class='black'>".$m_langpackage->m_order_cancel."</span><br />";
						} elseif($v['protect_status']==1) {
							echo "<span class='red'>维权中</span><br />";
						}elseif($v['protect_status']==2) {
							echo "<span class='red'>同意维权</span><br />";
						} elseif($v['protect_status']==3) {
							echo "<span class='red'>维权结束</span><br />";
						} elseif($v['order_status']==3) {
							echo "<span class='green'>".$m_langpackage->m_order_combuy."</span><br />";
						}else {
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
            <td class="border_l"  rowspan="<?php echo $num;?>" >
            <?php  if($goods['lock_flg']==1){?>
				<a href="modules.php?app=user_order_view&order_id=<?php echo  $v['order_id'];?>" title="<?php echo  $m_langpackage->m_view_orderinfo;?>"><?php echo  $m_langpackage->m_view_orderinfo2;?></a><br />
				<?php if(empty($v['get_back_time'])&&$v['pay_status']==1&&$v['order_status']>0&&$v['order_status']<3&&time()>(strtotime($v['pay_time'])+24*3600)){?>
					<a href="do.php?act=get_back_money&order_id=<?php echo  $v['order_id'];?>" ><?php echo  $m_langpackage->m_refund;?></a>
				<?php }?>
			<?php  }else if($v['open_flg']==1){?>
					<span class='black'><?php echo  $m_langpackage->m_favitor_close;?></span><br />
			<?php  }else if($v['lock_flg']==1){?>
					<span class='black'>"<?php echo  $m_langpackage->m_favitor_lock;?>"</span><br />
			<?php }else{?>
				<?php if($v['order_status']==1  && $v['pay_status']==0) {?>
					<a href="do.php?act=user_order_del&id=<?php echo  $v['order_id'];?>" onclick="return confirm('<?php echo  $m_langpackage->m_sure_cancelthisorder;?>');"><?php echo  $m_langpackage->m_cancelorder;?></a><br />
					<a href="modules.php?app=user_payment_message&id=<?php echo  $v['order_id'];?>"><?php echo  $m_langpackage->m_pay;?></a><br />
				<?php }?>
				<?php if($v['order_status']==1 && $v['pay_status']==1 &&$v['transport_status']==0) {?>
					<a href="do.php?act=ask_back_money&id=<?php echo  $v['order_id'];?>">申请退款</a><br />
				<?php }?>
				<?php if($v['order_status']==1  && $v['pay_status']==3) {?>
					<a href="do.php?act=sure_back_money&id=<?php echo  $v['order_id'];?>">确认退款</a><br />
				<?php }?>
				
				<?php if($v['transport_status']==1 && $v['order_status']==3 && $v['protect_status']==0) {?>
					<a href="modules.php?app=user_protect_rights&id=<?php echo  $v['order_id'];?>">申请维权</a><br />
				<?php }?>
				
				<?php if($v['protect_status']!=0 && $v['protect_status']!=3) {?>
					<a href="do.php?act=user_cancel_protect&id=<?php echo  $v['order_id'];?>"><font color="red">结束维权</font></a><br />
				<?php }?>
				
				<?php if($v['protect_status']==1 || $v['protect_status']==2) {?>
					<a href="modules.php?app=user_protect_rights&id=<?php echo  $v['order_id'];?>"><font color="red">查看维权</font></a><br />
				<?php }?>
				
				<?php if($v['transport_status']==1 && $v['order_status']==1) {?>
					<a href="do.php?act=user_order_checkget&id=<?php echo  $v['order_id'];?>"  onclick="return confirm('<?php echo  $m_langpackage->m_sure_thisgoodsreceive;?>');"><?php echo  $m_langpackage->m_sure_receive;?></a><br />
					申请维权<br />
				<?php }?>
				<a href="modules.php?app=user_order_view&order_id=<?php echo  $v['order_id'];?>" title="<?php echo  $m_langpackage->m_view_orderinfo;?>"><?php echo  $m_langpackage->m_view_orderinfo2;?></a><br />
				<!-- 订单投诉 开始 -->
				<?php   if($v['pay_status']!=0 && $v['pay_status']!=4 && $v['order_status']!=3) {?>
					<?php   if($v['complaint']==0) {?>
					<a href="modules.php?app=user_complaint&order_id=<?php echo  $v['order_id'];?>" ><?php echo  $m_langpackage->m_complaints;?></a><br />
					<?php }else{?>
					<?php echo $m_langpackage->m_already_complain ;?><br />
					<?php }?>
				<?php }?>
				<!-- 订单投诉 结束 -->
				<!-- 订单评价 开始 -->
				<?php if($v['transport_status']==1 && $v['order_status']==3 && $v['buyer_reply']==0) {?>
					<a href="modules.php?app=shop_credit_add&id=<?php echo  $v['order_id'];?>&t=buyer" ><?php echo  $m_langpackage->m_evaluate;?></a><br />
				<?php }else if($v['transport_status']==1 && $v['order_status']==3 && $v['buyer_reply']==1){?>
					<?php echo $m_langpackage->m_already_valuation;?><br />
				<?php }?>
				<!-- 订单评价 结束 -->
			<?php  }?>
			</td>
            <!-- 合并  -->
            <?php }?>
          <?php }?>
          <tr>
          <?php }?>
           <tr><td colspan="6" ><div class="page"><?php  require("modules/page.php");?></div></td></tr>
          <?php } else {?>
				<tr><td colspan="6" class="center"><?php echo  $m_langpackage->m_nolist_record;?></td></tr>
				<?php }?>
        </tbody>
      </table>
		</div>
		<div class="clear"></div>
		<div class="right_bottom"></div>
		<div class="back_top"><a href="#"></a></div>
	</div>
	<form action="do.php?act=merge" method="post" id="merge_form" >
		<div id="order_id_box"></div>
		<input type="hidden" name="shop_id_value" id="shop_id_value" value="0" />
	</form>
<?php  require("shop/index_footer.php");?>
</body>
</html>
<script language="JavaScript" src="servtools/ajax_client/ajax.js"></script>
<script language="JavaScript">
function add_merge(order_id,shop_id,bl,ck_obj){
	if(bl){
		if(document.getElementById("shop_id_value").value==0){
			document.getElementById("shop_id_value").value=shop_id;
		}
		if(shop_id!=document.getElementById('shop_id_value').value){
			alert("<?php echo $m_langpackage->m_same_order_error;?>！");
			ck_obj.checked=false;
		}else{
			document.getElementById("order_id_box").innerHTML+="<input type='hidden' name='order_id[]' value='"+order_id+"' />";
		}

	}else{
		document.getElementById("order_id_box").innerHTML="";
		var obj=document.getElementsByName("order_id[]");
		for(i=0;i<obj.length;i++){
			if(obj[i].value != order_id){
				document.getElementById("order_id_box").innerHTML+="<input type='hidden' name='order_id[]' value='"+obj[i].value+"' />";
			}
		}
		if(obj.length<=0){
			document.getElementById("shop_id_value").value=0;
		}
	}
}

function merge_sub (){
	var obj=document.getElementsByName("order_id[]");
	if(obj.length<=0){
		alert("<?php echo $m_langpackage->m_select_order;?>");
	}else if(obj.length<=1){
		alert("<?php echo $m_langpackage->m_tow_order;?>！");
	}else{
		if(confirm("<?php echo $m_langpackage->m_merge_prompt;?>")){
			document.getElementById("merge_form").submit();
		}else{
			window.location.reload();
		}
	}
}

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
</script><?php } ?>