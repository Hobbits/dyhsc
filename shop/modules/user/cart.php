<?php
/*
 * 注意：此文件由itpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/modules/user/cart.html
 * 如果您的模型要进行修改，请修改 models/modules/user/cart.php
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
if(filemtime("templates/default/modules/user/cart.html") > filemtime(__file__) || (file_exists("models/modules/user/cart.php") && filemtime("models/modules/user/cart.php") > filemtime(__file__)) ) {
	tpl_engine("default","modules/user/cart.html",1);
	include(__file__);
} else {
/* debug模式运行生成代码 结束 */
?><?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}
//引入文件
require_once("foundation/fsqlitem_set.php");
require_once("foundation/module_goods.php");
require_once("foundation/module_cart.php");
//引入语言包
$m_langpackage=new moduleslp;
$i_langpackage=new indexlp;
$s_langpackage=new shoplp;

$k = short_check(get_args('k'));
$cat = intval(get_args('cat'));

//数据表定义区
$t_cart = $tablePreStr."cart";
$t_goods = $tablePreStr."goods";
$t_shop_info = $tablePreStr."shop_info";
$user_id = get_sess_user_id();
//读写分离定义方法
$dbo = new dbex;
dbtarget('r',$dbServs);
$sql="SELECT goods_id FROM $t_cart WHERE user_id='$user_id'";
$rs = $dbo->getRs($sql);
$arr = array();
foreach ($rs as $k=>$v){
	$arr[]=$v['goods_id'];
}
$goods_ids="";
$dbo = new dbex;
dbtarget('w',$dbServs);
if (get_session('cart')) {
	$car=get_session('cart');
	foreach ($car as $key=>$value){
		if ($user_id) {
			if (!in_array($key,$arr)) {
				$insert_array = array(
					'user_id' => $user_id,
					'goods_id' => $key,
					'goods_number' => $car[$key]['num'],
					'add_time' => $ctime->long_time(),
				);
				$goods_info = get_goods_info($dbo,$t_goods,array('goods_name','goods_price','goods_number'),$key);
				$item_sql = get_insert_item($insert_array);
				$sql = "insert into `$t_cart` $item_sql ";
				if($dbo->exeUpdate($sql)) {
					$new_goods_num = $goods_info['goods_number'] - $car[$key]['num'];
					$sql = "update `$t_goods` set goods_number='$new_goods_num' where goods_id='$key'";
					$dbo->exeUpdate($sql);
				}
			}
		}
		$goods_ids.="($key,";
	}
	set_session('cart',$car);
}
$goods_ids = substr($goods_ids,0,-1);
$goods_ids.=")";
//读写分离定义方法
$dbo = new dbex;
dbtarget('r',$dbServs);
if ($user_id) {
	$result = get_cart_info($dbo,$t_cart,$t_goods,$t_shop_info,$user_id,10);
}else{
	$result = get_cart_session($dbo,$t_goods,$t_shop_info,$goods_ids,10);
	$car=get_session('cart');
	foreach ($result['result'] as $k=>$v){
		$result['result'][$k]['add_time']=$car[$v['goods_id']]['add_time'];
		$result['result'][$k]['goods_number']=$car[$v['goods_id']]['num'];
		$result['result'][$k]['cart_id']=0;
	}
	set_session('cart',$car);
}
$sql="SELECT sum(a.goods_number*b.goods_price) as sumvalue FROM $t_cart AS a, $t_goods AS b, $t_shop_info as c WHERE a.goods_id=b.goods_id AND b.shop_id=c.shop_id AND a.user_id=$user_id order by c.shop_id desc,a.add_time desc";
$row=$dbo->getRow($sql);

$shoparray=array();
if(!empty($result['result'])){
	foreach ($result['result'] as $k=>$v){
		foreach ($v as $ke=>$va){
			if($ke=="shop_id"){
				$shoparray[$k]=$va['shop_id'];
			}
		}

	}
}
//print_r($result);
//exit;
$shoparray=array_unique($shoparray);
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
.edit span{background:#efefef;}
.search {margin:5px;}
.search input {color:#444;}
td.img img{cursor:pointer}
</style>
</head>
<body onload="menu_style_change('user_cart');changeMenu();">
<?php  require("shop/index_header.php");?>
	<div class="site_map">
	  <?php echo $m_langpackage->m_current_position;?><A href="index.php"><?php echo $SYSINFO['sys_name'];?></A>/<a href="modules.php"><?php echo $m_langpackage->m_u_center;?></a>/&nbsp;&nbsp;<?php echo $m_langpackage->m_my_cart;?>
	</div>
    <div class="clear"></div>
    <?php  require("modules/left_menu.php");?>
	<form action="do.php?act=user_cart_del" name="form" id="form1" method="get" onsubmit="return submitform();">
	    <div class="main_right">
			<div class="right_top"></div>
			<div class="cont">
				<div class="cont_title">
					<span class="tr_op">
					<a href="javascript:;" onclick="return go_to_buy()"><?php echo $m_langpackage->m_check_out;?></a><a href="index.php" target="_blank"><?php echo $m_langpackage->m_go_buy;?></a>
					</span>
					<?php echo $m_langpackage->m_my_cart;?>
				</div>
				<hr />
				<table class="commodityCart" width="100%" border="0" cellspacing="0">
				  <tr>
					<th width="40"></th>
					<th width="150"><?php echo  $m_langpackage->m_goods_image;?></th>
					<th><?php echo  $m_langpackage->m_goods_info;?></th>
					<th width="80"><?php echo  $m_langpackage->m_buy_num;?></th>
					<th width="130"><?php echo  $m_langpackage->m_manage;?></th>
				  </tr>
				  <?php if(!empty($result['result'])) {
					foreach($result['result'] as $k=> $v) {
					    foreach ($shoparray as $ke=>$va){
					    	if($v['shop_id']==$va){
					    		 unset($shoparray[$ke]);?>
					    	
					
    <tr class="shopInfo">
     	<td colspan="5"><?php echo  $m_langpackage->m_order_shops;?>：<a href="<?php echo shop_url($v['shop_id']);?>" target="_blank" ><?php echo  $v['shop_name'];?></a></td>
     </tr>
     <?php }  }?>
				<tr class="commodity">
					<td align="center"><input type="checkbox" id="good_check" name="goods[]" onclick="add_buy(<?php echo $v['goods_id'];?>,<?php echo $v['shop_id'];?>,<?php echo $v['goods_number'];?>,this,this.checked)" value="<?php echo  $v['cart_id'];?>" /></td>
						<td align="center"><a href="<?php echo  goods_url($v['goods_id']);?>" target="_blank"><img src="<?php echo  $v['goods_thumb'];?>" width="80" height="80" onerror="this.src='skin/default/images/nopic.gif'"/></a></td>
					<!--	<input type="hidden" name="gid[]" value="<?php echo $v['goods_id'];?>" />-->
						<td class="name"><a href="<?php echo  goods_url($v['goods_id']);?>" target="_blank"><?php echo  $v['goods_name'];?></a>
						<br /> <?php echo  $m_langpackage->m_order_shops;?>：<a href="<?php echo  shop_url($v['shop_id'],'index');?>" target="_blank"><?php echo  $v['shop_name'];?></a>
						<br />  <?php echo  $m_langpackage->m_price;?>：<?php echo $m_langpackage->m_money_sign;?><span><?php echo  $v['goods_price'];?></span><?php echo  $m_langpackage->m_yuan;?>
						<br /> <?php echo  $m_langpackage->m_add_time;?>：<?php echo  substr($v['add_time'],0,16);?> &nbsp;&nbsp; <script src="imshow.php?u=<?php echo  $v['user_id'];?>"></script>
						</td>
						<!--<input type="hidden" name="v[]" value="<?php //echo $v['goods_number']?>" />-->
						<td align="center" id="goodssortid_<?php echo  $v['cart_id'];?>">
							<span onclick="edit_sort(this,<?php echo  $v['cart_id'];?>)">&nbsp;<?php echo  $v['goods_number'];?>&nbsp;</span></td>
						<td align="center">
						<?php if($v['lock_flg']=='1') { ;?>
							<font color='red'><?php echo  $m_langpackage->m_other_shop_lock;?></font>
						<?php } else if($v['open_flg']=='1'){?>
							<font color='red'><?php echo  $m_langpackage->m_other_shop_close;?></font>
						<?php } else {?>
							<input type="hidden" id="shop_id_<?php echo  $v['goods_id'];?>" value="<?php echo  $v['shop_id'];?>" />
							<a href="javascript:addFavorite(<?php echo  $v['goods_id'];?>);">收藏</a>
							<br />
							<a id="num_<?php echo  $v['cart_id'];?>" href="modules.php?app=user_order_adress&gid=<?php echo  $v['goods_id'];?>&v=<?php echo  $v['goods_number'];?>"><?php echo  $m_langpackage->m_ccbuy;?></a>
						<?php }?><br />
						<a href="do.php?act=user_cart_del&id=<?php echo  $v['cart_id'];?><?php if($v['cart_id']==0){?>&goods_id=<?php echo $v['goods_id'];?><?php }?>" onclick="return confirm('<?php echo  $m_langpackage->m_sure_delcartgoods;?>');"><?php echo  $m_langpackage->m_del;?></a>
						</td>
					</tr>
				
					<?php }?>
						<?php if(!empty($row['sumvalue'])) {?>
							<tr><td colspan="5" style="border-bottom:0"><div><?php echo  $m_langpackage->m_car_sum;?><?php echo  $row['sumvalue'];?><?php echo  $m_langpackage->m_yuan;?></div></td></tr>
						<?php }?>
                    <tr><td colspan="5" style="border-bottom:0"><div class="page"><?php  require("modules/page.php");?></div></td></tr>
					<!--<tr><th width="40"><input type="checkbox" onclick="checkall(this);" /></th><th align="left" colspan="4"><input class="submit" type="button" onclick="select_all()" value="全选"> <input class="submit" type="button" onclick="select_last()" value="反选"> <INPUT class="submit" type=submit value=<?php echo $m_langpackage->m_pl_del;?> name=deletesubmit></th></tr>-->
					<?php  } else {?>
					<tr><th colspan="5" class="center"><?php echo  $m_langpackage->m_nolist_record;?></td></tr>
					<?php }?>
					<input type="hidden" name="app" value="user_order" />
					<input type="hidden" id="shop_user" value="<?php echo $user_id;?>" />
					<input type="hidden" name="iscart" value="1" />
				</table>
			</div>
			<div class="clear"></div>
			<div class="right_bottom"></div>
			<div class="back_top"><a href="#"></a></div>

		</div>
	</form>
	<form action="modules.php?app=user_order_adress" method="post" id="form2">
		<div id="gid_box"></div>
		<div id="shop_box"><input type="hidden" name="sid" id="sid" value="0" /></div>
		<div id="gnum_box"></div>
		<input type="hidden" name="app" value="user_order_adress" />
	</form>
<?php  require("shop/index_footer.php");?>
<script language="JavaScript" src="servtools/ajax_client/ajax.js"></script>
<script>
	function addFavorite(id) {
			var shop_id = document.getElementById('shop_id_'+id).value;
			var user_id = document.getElementById('shop_user').value;
			if (shop_id == user_id){
				alert('<?php echo $s_langpackage->s_mygoods_error;?>');
			}else {
				ajax("do.php?act=goods_add_favorite","POST","id="+id,function(data){
					if(data == 1) {
						alert("<?php echo  $s_langpackage->s_g_addedfavorite;?>");
					} else if(data == -1) {
						alert("<?php echo  $s_langpackage->s_g_stayfavorite;?>");
					} else {
						alert("<?php echo  $s_langpackage->s_g_addfailed;?>");
					}
				});
			}
		}
		
</script>
</body>
</html>

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

var inputs = document.getElementsByTagName("input");
function submitform() {
	var status = document.getElementsByName("goods");
	var checknum = 0;
	for(var i=0; i<inputs.length; i++) {
		if(inputs[i].type=='checkbox') {
			if(inputs[i].checked) {
				checknum++;
			}
		}
	}
	if(checknum==0) {
		alert("<?php echo $m_langpackage->m_selceted_one;?>");
		return false;
	}else {
		var flg = confirm('<?php echo $m_langpackage->m_manage_sure_del;?>');
		if (flg){
			return true;
		}
	}
	return false;
}

function checkall(obj) {
	if(obj.checked) {
		for(var i=0; i<inputs.length; i++) {
			if(inputs[i].type=='checkbox') {
				inputs[i].checked = true;
			}
		}
	} else {
		for(var i=0; i<inputs.length; i++) {
			if(inputs[i].type=='checkbox') {
				inputs[i].checked = false;
			}
		}
	}
}

var sort_value,number_value,price_value;
function edit_sort(span,id) {
	obj = document.getElementById("goodssortid_"+id);
	sort_value = span.innerHTML;
	sort_value = sort_value.replace(/&nbsp;/ig,"");
	obj.innerHTML = '<input style="width:35px" type="text" id="input_goodssortid_' + id + '" value="' + sort_value + '" onblur="edit_sort_post(this,' + id + ')"  maxlength="2" />';
	document.getElementById("input_goodssortid_"+id).focus();
}

function edit_sort_post(input,id) {
	var obj = document.getElementById("goodssortid_"+id);
	var num = document.getElementById("num_"+id);
	var re = /v=[0-9]+/g;
	if(isNaN(input.value)) {
		alert("<?php echo $m_langpackage->m_input_numpl;?>");
		obj.innerHTML = '<span onclick="edit_sort(this,' + id + ')">&nbsp;' + sort_value + '&nbsp;</span>';
		return ;
	}
	if(sort_value==input.value) {
		obj.innerHTML = '<span onclick="edit_sort(this,' + id + ')">&nbsp;' + sort_value + '&nbsp;</span>';
	} else {
		ajax("do.php?act=goods_num_edit","POST","id="+id+"&v="+input.value,function(data){
			if(data==1) {
				num.href = num.href.replace(re, "v="+input.value);
				obj.innerHTML = '<span onclick="edit_sort(this,' + id + ')">&nbsp;' + input.value + '&nbsp;</span>';
			} else {
				obj.innerHTML = '<span onclick="edit_sort(this,' + id + ')">&nbsp;' + sort_value + '&nbsp;</span>';
			}
		});
	}
}

function select_all() {
	for(var i=0; i<inputs.length; i++) {
		if(inputs[i].type=='checkbox') {
			inputs[i].checked = true;
		}
	}
}

function select_last() {
	for(var i=0; i<inputs.length; i++) {
		if(inputs[i].type=='checkbox') {
			if (inputs[i].checked == true){
				inputs[i].checked = false;
			}else if (inputs[i].checked == false){
				inputs[i].checked = true;
			}
		}
	}
}
function go_to_buy(){
	var obj = document.getElementById('form2');
//	obj.action="modules.php?app=user_order";
	var gids = document.getElementsByName('gid[]');
	if(gids.length<=0){
		alert("<?php echo $m_langpackage->m_select_goods;?>");
	}else{
		obj.submit();
	}
	return false;
}
function add_buy(gid,shop_id,gnum,obj,bl){
	if(bl){
		if(document.getElementById("sid").value==0){
			document.getElementById("sid").value=shop_id;
		}
		if(document.getElementById('sid').value==shop_id){
			document.getElementById("gid_box").innerHTML+="<input type='hidden' name='gid[]'value='"+gid+"' />";
			document.getElementById("gnum_box").innerHTML+="<input type='hidden' name='v[]'value='"+gnum+"' />";
//			obj.checked=true;
		}else{
			alert("<?php echo $m_langpackage->m_select_goods_error;?>");
			obj.checked=false;
		}
	}else{
		var gids = document.getElementsByName('gid[]');
		var nums = document.getElementsByName("v[]");
		var temp_gid_box = "";
		var temp_gnum_box = "";
		for(i=0;i<gids.length;i++){
		    if(gid!=gids[i].value){
		        temp_gid_box+="<input type='hidden' name='gid[]' value='"+gids[i].value+"' />";
		        temp_gnum_box+="<input type='hidden' name='v[]' value='"+nums[i].value+"' />";
		    }
		}
		document.getElementById("gid_box").innerHTML=temp_gid_box;
		document.getElementById("gnum_box").innerHTML=temp_gnum_box;
		if(temp_gid_box.length<=0){
		    document.getElementById("sid").value=0;
		}
	}
}
//-->
</script><?php } ?>