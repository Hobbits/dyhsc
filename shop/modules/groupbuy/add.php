<?php
/*
 * 注意：此文件由itpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/modules/groupbuy/add.html
 * 如果您的模型要进行修改，请修改 models/modules/groupbuy/add.php
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
if(filemtime("templates/default/modules/groupbuy/add.html") > filemtime(__file__) || (file_exists("models/modules/groupbuy/add.php") && filemtime("models/modules/groupbuy/add.php") > filemtime(__file__)) ) {
	tpl_engine("default","modules/groupbuy/add.html",1);
	include(__file__);
} else {
/* debug模式运行生成代码 结束 */
?><?php
if(!$IWEB_SHOP_IN) {
	trigger_error('Hacking attempt');
}

require("foundation/acheck_shop_creat.php");
require("foundation/module_category.php");
require("foundation/module_goods.php");
require("foundation/module_shop.php");

//引入语言包
$m_langpackage=new moduleslp;
$i_langpackage=new indexlp;
 if(get_session('shop_open')!=null&&get_session('shop_open')==1){
 	trigger_error("店铺已关闭，请开启后添加!");
 }
//数据表定义区
$t_shop_category = $tablePreStr."shop_category";
$t_groupbuy = $tablePreStr."groupbuy";

//读写分离定义方法
$dbo = new dbex;
dbtarget('r',$dbServs);

$sql="select count(*) from $t_groupbuy where shop_id=$shop_id";
$num=$dbo->getRow($sql);


$goods_info = array(
	'goods_name'	=> '',
	'cat_id'		=> 0,
	'ucat_id'		=> 0,
	'goods_intro'	=> '',
	'goods_number'	=> 99,
	'keyword'		=> '',
	'goods_price'	=> '0.00',
	'is_on_sale'	=> 1,
	'is_best'		=> 0,
	'is_new'		=> 0,
	'is_hot'		=> 0,
	'is_promote'	=> 0,
	'goods_wholesale'=> '',
	'transport_price'=> '0.00'
);

$shop_category = get_shop_category_list($dbo,$t_shop_category,$shop_id);
$html_shop_category = html_format_shop_category($shop_category,$goods_info['ucat_id']);


?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo  $m_langpackage->m_u_center;?></title>
<link rel="stylesheet" type="text/css" href="skin/<?php echo  $SYSINFO['templates'];?>/css/modules.css">
<link rel="stylesheet" type="text/css" href="skin/<?php echo  $SYSINFO['templates'];?>/css/layout.css">
<link rel="stylesheet" type="text/css" href="skin/<?php echo  $SYSINFO['templates'];?>/css/style.css">
<script type="text/javascript" src="skin/<?php echo  $SYSINFO['templates'];?>/js/userchangeStyle.js"></script>

<script type='text/javascript' src='servtools/date/WdatePicker.js'></script>
<style type="text/css">
.red { color:red; }
</style>

</head>
<body onload="menu_style_change('groupbuy_list');changeMenu();">
	<?php  require("shop/index_header.php");?>
	<div class="site_map">
	  <?php echo $m_langpackage->m_current_position;?><A href="index.php"><?php echo $SYSINFO['sys_name'];?></A>/<a href="modules.php"><?php echo $m_langpackage->m_u_center;?></a>/&nbsp;&nbsp;<?php echo $m_langpackage->m_add_groupbuy;?>
	</div>
    <div class="clear"></div>
    	<?php  require("modules/left_menu.php");?>
        
    	<?php if(isset($user_privilege[9])&&$num[0]<$user_privilege[9]){?>
        <div class="main_right">
        	<div class="right_top"></div>
            <div class="cont">
                <div class="cont_title"><span class="tr_op"><a href="modules.php?app=groupbuy_list">
			<?php echo $m_langpackage->m_group_list;?></a></span><?php echo $m_langpackage->m_add_groupbuy;?></div>
                <hr />

				<form action="do.php?act=groupbuy_add" method="post" name="from1" enctype="multipart/form-data">
				<table width="100%"  style="border:0;" cellspacing="0">
					<tr>
						<td class="textright" width="20%"><?php echo $m_langpackage->m_group_name;?>：</td>
						<td align="left"><input type="text" name="groupbuy_name" value="" style="width:350px;" maxlength="200" /> <span class="red">*</span></td>
					</tr>
					<tr style="line-height:18px;">
						<td class="textright"><?php echo $m_langpackage->m_sta_time;?>：</td>
						<td align="left">
						<input class="Wdate" type="text" name="start_time" id="start_time" onFocus="WdatePicker({isShowClear:false,readOnly:true})"/>
						
						
						<?php echo $m_langpackage->m_end_time;?>：<input class="Wdate" type="text" name="end_time" id="end_time" onFocus="WdatePicker({isShowClear:false,readOnly:true})"/>
						 <span class="red">*</span></td>
					</tr>
					<tr>
						<td class="textright"><?php echo $m_langpackage->m_group_shows;?>：</td>
						<td align="left"><textarea name="groupbuy_explain" style="width:350px; height:80px;"></textarea> </td>
					</tr>
					<tr>
						<td class="textright" valign="top"><?php echo $m_langpackage->m_select_products;?>：</td>
						<td align="left">
						<input type="text" onclick="discontrol('goods_select',this)" id="goods_name" name="goods_name" value="" style="width:350px;" maxlength="200" /> <span class="red">*</span><br />
						<input type="hidden"id="goods_id" name="goods_id" value="" />
						<div id="goods_select" style="width:585px; display:none;">
							<table width="100%" cellspacing="0">
								<tr>
									<td width="80px"><?php echo $m_langpackage->m_products_name;?>：</td>
									<td><input type="text" id="goodsselect_name" name="goodsselect_name" value="" style="width:255px;" maxlength="200" /></td>
								</tr>
								<tr>
									<td><?php echo $m_langpackage->m_products_sort;?>：</td>
									<td><select id="shop_category" name="shop_category"><option value=""><?php echo $m_langpackage->m_select_pl;?></option><?php echo $html_shop_category;?></select></td>
								</tr>
								<tr>
									<td></td>
									<td><input class="submit" type="button" value="<?php echo $m_langpackage->m_select;?>" onclick="get_goods_list()"></td>
								</tr>
								<tr>
									<td><?php echo $m_langpackage->m_select_products;?>：</td>
									<td>
				                    	<span id="goods_list_id">
					                    	<select  name="goods_list" class="text" style="width:255px;">
					                    		<option value=""><?php echo $m_langpackage->m_search_above;?></option>
					                    	</select>
				                    	</span>
									</td>
								</tr>
							</table>
						</div>
						</td>
					</tr>
					<tr>
						<td class="textright"><?php echo $m_langpackage->m_group_number;?>：</td>
						<td align="left"><input type="text" name="min_quantity" value="" style="width:150px;" maxlength="200" /> <span class="red">*</span></td>
					</tr>
					<tr>
						<td class="textright"><?php echo $m_langpackage->m_group_price;?>：</td>
						<td align="left"><input type="text" name="spec_price" value="" style="width:150px;" maxlength="200" /> <span class="red">*</span></td>
					</tr>
					<tr>
						<td class="textright"><?php echo $m_langpackage->m_group_one_num;?>：</td>
						<td align="left"><input type="text" name="one_num" id="one_num" value="0" style="width:50px;" maxlength="5" /> <span class="red">*</span><?php echo $m_langpackage->m_group_no_purchase;?></td>
					</tr>
					<tr>
						<td class="textright"><?php echo $m_langpackage->m_group_all_num;?>：</td>
						<td align="left"><input type="text" name="all_num" id="all_num" value="0" style="width:50px;" maxlength="5" /> <span class="red">*</span><?php echo $m_langpackage->m_group_purchase;?></td>
					</tr>
					<tr>
						<td class="textright" style="border:0"></td>
						<td style="border:0"><input class="submit" type="button" name="" onclick="checknum();" value="<?php echo $m_langpackage->m_group_submit;?>"  /> </td>
					</tr>
				</table>
				</form>
			</div>
			<div class="right_bottom"></div>
			<div class="back_top"><a href="#"></a></div>
		</div>
		<?php }else{
		echo "<script language='JavaScript'> alert('您所发布的团购数已超出限制，请升级店铺级别或结束已有团购！'); 
											location.href='modules.php?app=groupbuy_list';
				</script>";
		};?>
		



	</div>
    <div class="clear"></div>
    <?php  require("shop/index_footer.php");?>
<div id="bgdiv" style="display:none;"></div>
<div id="category_select" style="display:none;">
	<div class="category_title_1"><span onclick="hidebgdiv();"><?php echo $m_langpackage->m_close;?></span><?php echo $m_langpackage->m_plss_select_cateogry;?></div>
	<ul id="select_first" class="ulselect">
	<?php if(isset($category_info)){?>
		<?php foreach($category_info as $k=>$v){?>
			<?php if($v['parent_id']==0){?>
			<li title="<?php echo  $v['cat_id'];?>"><?php echo  $v['cat_name'];?></li>
			<?php }?>
		<?php }?>
		<?php }?>
	</ul>
	<ul id="select_second" class="ulselect"></ul>
	<ul id="select_third" class="ulselect"></ul>
	<ul id="select_fourth" class="ulselect"></ul>
	<div class="category_com"><input type="button" value="<?php echo $m_langpackage->m_post;?>" onclick="postcatid();" /></div>
</div>
<script language="JavaScript" src="servtools/ajax_client/ajax.js"></script>
<script language="JavaScript">
<!--
function discontrol(itemid,obj)
{
	if(document.getElementById(itemid).style.display=='') {
		document.getElementById(itemid).style.display="none";
	} else {
 		document.getElementById(itemid).style.display="";
	}
}

function get_goods_list(){
	var goodsselect_name = document.getElementById("goodsselect_name").value;
	var shop_category = document.getElementById("shop_category").value;
	ajax("do.php?act=groupbuy_selectgoods","POST","shop_category="+shop_category+"&goodsselect_name="+goodsselect_name,function(data){
		var str_data = "<select  name='goods_list' class='text' style='width:310px;' size='7' ondblclick='select_goods_id(this)'>";
		str_data+=data;
		str_data+="</select>";
		document.getElementById("goods_list_id").innerHTML = str_data;
	});
}

function select_goods_id(obj){
	document.getElementById("goods_name").value = obj.options[obj.selectedIndex].text;
	document.getElementById("goods_id").value = obj.value;
	document.getElementById("goods_select").style.display="none";
}
function checknum(){
	var one_num=document.getElementById("one_num").value;
	var all_num=document.getElementById("all_num").value;
	var goods_id = document.getElementsByName('goods_id')[0].value;
	one_num = parseInt(one_num);
    all_num = parseInt(all_num);
    if(checkform()){
        if(all_num==0){
            ajax("do.php?act=check_num","POST","goods_id="+goods_id+"&num="+one_num,function(data){
                     if(data=='0'){
                         alert("单人限购数不能大于总限购数或库存数");
                         return false;
                      }else{
                        document.from1.submit();
                          }
                });
        }else{
          if(one_num>all_num){
                alert('单人限购数不能大于总限购数');
                return false;
          }
          ajax("do.php?act=check_num","POST","goods_id="+goods_id+"&num="+all_num,function(data){
              if(data=='0'){
                  alert("总限购数不能大于库存数");
                  return false;
               }else{
            	   document.from1.submit();
                   }
         });
         
        }
        
    }
    return false;
	
}
function checkform(){
    var groupbuy_name = document.getElementsByName('groupbuy_name')[0];
    var cday = new Date();
    var cdate=cday.getFullYear()+"-"+(cday.getMonth()+1)+"-"+cday.getDate();
    if(groupbuy_name.value==''){
        alert('<?php echo $m_langpackage->m_group_no_name;?>');
        return false;
    }
    var start_time = document.getElementsByName('start_time')[0];
    if(start_time.value==''){
        alert('<?php echo $m_langpackage->m_sta_no_time;?>');
        return false;
    }
    var end_time = document.getElementsByName('end_time')[0];
    if(end_time.value==''){
        alert('<?php echo $m_langpackage->m_end_no_time;?>');
        return false;
    }
    if(isNaN(DateDiff(start_time.value,end_time.value))){
        alert('<?php echo $m_langpackage->m_timeformat_error;?>');
           return false;
        }
    if(DateDiff(start_time.value,end_time.value)>0){
        alert('<?php echo $m_langpackage->m_start_time_error;?>');
        return false;
    }
    if(DateDiff(start_time.value,cdate)<0){
        alert('<?php echo $m_langpackage->m_startend_time_error;?>');
        return false;
    }
    var d1 = new Date(start_time.value.replace(/-/g, "/")); 
    var d2 = new Date(end_time.value.replace(/-/g, "/")); 
    if (Date.parse(d1) - Date.parse(d2) == 0) { 
    	alert('<?php echo $m_langpackage->m_start_end_time_error;?>');
      return false; 
    } 
      
    var goods_id = document.getElementsByName('goods_id')[0];
    if(goods_id.value==''){
        alert('<?php echo $m_langpackage->m_products_no_name;?>');
        return false;
    }
    var min_quantity = document.getElementsByName('min_quantity')[0];
    if(min_quantity.value==''){
        alert('<?php echo $m_langpackage->m_group_no_number;?>');
        return false;
    }
    var spec_price = document.getElementsByName('spec_price')[0];
    if(spec_price.value==''){
        alert('<?php echo $m_langpackage->m_group_no_price;?>');
        return false;
    }
	var one_num = document.getElementsByName('one_num')[0];
    if(one_num.value==''){
        alert('<?php echo $m_langpackage->m_group_no_one_num;?>');
        return false;
    }
    var all_num = document.getElementsByName('all_num')[0];
    if(all_num.value==''){
        alert('<?php echo $m_langpackage->m_group_no_all_num;?>');
        return false;
    }
    return true;
}

function DateDiff(d1,d2){
    var result = Date.parse(d1.replace(/-/g,"/"))- Date.parse(d2.replace(/-/g,"/"));
    return result;
    }

//-->
</script>
</body>
</html><?php } ?>