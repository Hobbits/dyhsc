<?php
/*
 * 注意：此文件由itpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/modules/shop/create.html
 * 如果您的模型要进行修改，请修改 models/modules/shop/create.php
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
if(filemtime("templates/default/modules/shop/create.html") > filemtime(__file__) || (file_exists("models/modules/shop/create.php") && filemtime("models/modules/shop/create.php") > filemtime(__file__)) ) {
	tpl_engine("default","modules/shop/create.html",1);
	include(__file__);
} else {
/* debug模式运行生成代码 结束 */
?><?php
if(!$IWEB_SHOP_IN) {
	trigger_error('Hacking attempt');
}
//引入语言包
$m_langpackage=new moduleslp;
$i_langpackage=new indexlp;
//
//if(!isset($user_privilege[1])) {
//	set_sess_err_msg($m_langpackage->m_error_createshop);
//	echo '<script language="JavaScript">location.href="modules.php?app=message"</script>';
//	exit;
//}

require("foundation/module_areas.php");
require("foundation/module_shop_category.php");

//数据表定义区
$t_areas = $tablePreStr."areas";
$t_shop_categories = $tablePreStr."shop_categories";

//读写分离定义方法
$dbo=new dbex;
dbtarget('r',$dbServs);

/* 初始化shopinfo */
$shop_info = array(
	'shop_name'		=> '',
	'shop_country'	=> 1,
	'shop_province'	=> 0,
	'shop_city'		=> 0,
	'shop_district'	=> 0,
	'shop_address'	=> '',
	'shop_images'	=> '',
	'shop_template'	=> 'default',
	'shop_intro'	=> '',
	'shop_management' => ''
);
$shop_categories_parent = get_categories_item_parentid($dbo,$t_shop_categories,0);
$areas_info = get_areas_info($dbo,$t_areas);

$shoptemplate_arr[] = array(
	'imgurl' => 'skin/default/images/default_small.gif',
	'bigimgurl' => 'skin/default/images/default.gif',
	'tpltag' => 'default',
	'tplname' => $m_langpackage->m_default_template
);
$shoptemplate_arr[] = array(
	'imgurl' => 'skin/default/images/green_small.gif',
	'bigimgurl' => 'skin/default/images/green.gif',
	'tpltag' => 'green',
	'tplname' => $m_langpackage->m_green_template
);
$shoptemplate_arr[] = array(
	'imgurl' => 'skin/default/images/blue_small.gif',
	'bigimgurl' => 'skin/default/images/blue.gif',
	'tpltag' => 'blue',
	'tplname' => $m_langpackage->m_blue_template
);
$shoptemplate_arr[] = array(
	'imgurl' => 'skin/default/images/red_small.gif',
	'bigimgurl' => 'skin/default/images/red.gif',
	'tpltag' => 'red',
	'tplname' => $m_langpackage->m_red_template
);
$shoptemplate_arr[] = array(
	'imgurl' => 'skin/default/images/purple_small.gif',
	'bigimgurl' => 'skin/default/images/purple.gif',
	'tpltag' => 'purple',
	'tplname' => $m_langpackage->m_purple_template
);
$shoptemplate_arr[] = array(
	'imgurl' => 'skin/default/images/gray_small.gif',
	'bigimgurl' => 'skin/default/images/gray.gif',
	'tpltag' => 'gray',
	'tplname' => $m_langpackage->m_gray_template
);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo  $m_langpackage->m_u_center;?></title>
<link rel="stylesheet" type="text/css" href="skin/<?php echo  $SYSINFO['templates'];?>/css/modules.css">
<link rel="stylesheet" type="text/css" href="skin/<?php echo  $SYSINFO['templates'];?>/css/layout.css">
<link rel="stylesheet" type="text/css" href="skin/<?php echo  $SYSINFO['templates'];?>/css/style.css">
<style type="text/css">
.red{color:red;}
.templageimg span{float:left; display:block; text-align:left; margin-left:1px;}
.templageimg img{border:2px solid #eee; cursor:pointer;}
</style>
</head>
<script type="text/javascript" src="servtools/jquery-1.3.2.min.js?v=1.3.2"></script>
<script type="text/javascript" src="servtools/xheditor/xheditor.min.js?v=1.0.0-final"></script>
<script type="text/javascript">
var introeditor;
$(function(){
	introeditor=$("#shop_intro").xheditor({skin:'vista',tools:"Cut,Copy,Paste,Pastetext,Separator,Blocktag,Fontface,FontSize,Bold,Italic,Underline,Strikethrough,FontColor,BackColor,SelectAll,Removeformat,Separator,Align,List,Outdent,Indent,Separator,Link,Unlink,Img,Table,Separator,Source,Fullscreen,About"});

});
</script>
<body>
	<?php  require("shop/index_header.php");?>
	<div class="site_map">
	  <?php echo $m_langpackage->m_current_position;?><A href="index.php"><?php echo $SYSINFO['sys_name'];?></A>/<a href="modules.php"><?php echo $m_langpackage->m_u_center;?></a>/&nbsp;&nbsp;<?php echo $m_langpackage->m_create_shop;?>
	</div>
    <div class="clear"></div>
    <div class="apart">
    	<?php  require("modules/left_menu.php");?>
        <div class="main_right">
        	<div class="right_top"></div>
            <div class="cont">
                <div class="cont_title"><?php echo  $m_langpackage->m_create_shop;?></div>
                <div id="stepTip">
			     <ul class="list_step clearfix">
			     <li><?php echo  $m_langpackage->m_u_first;?>:<br /><?php echo  $m_langpackage->m_a_info;?></li>
			     <li class="now"><?php echo  $m_langpackage->m_u_secound;?>:<br /><?php echo  $m_langpackage->m_a_shop_info;?></li>
			     <li><?php echo  $m_langpackage->m_u_third;?>:<br /><?php echo  $m_langpackage->m_a_manager_info;?></li>
			     <li style="padding-right:0"><?php echo  $m_langpackage->m_u_fore;?>:<br /><?php echo  $m_langpackage->m_accomplish;?></li>
			     </ul>
			     </div>
                <hr />
			<form action="do.php?act=shop_create" method="post" name="form_shop_create" onsubmit="return checkForm();">
			<table width="100%" border="0" cellspacing="0">
				<tr><td class="textright" width="15%"><?php echo  $m_langpackage->m_shop_name;?>:</td>
					<td><input type="text" name="shop_name" value="<?php echo  $shop_info['shop_name'];?>" style="width:250px;" maxlength="50" />
						<span class="red">*</span></td></tr>
				<tr><td class="textright" width="15%"><?php echo  $m_langpackage->m_shop_categories;?>:</td>
						<td style="float:none;">
							<span id="shop_country">
								<select name="categories_parent" onchange="categorieschanged(this.value)">
									<option value='0'><?php echo  $m_langpackage->m_select_categories;?></option>
									<?php  foreach($shop_categories_parent as $v) {?>
										<option value="<?php echo  $v['cat_id'];?>"><?php echo  $v['cat_name'];?></option>
									<?php }?>
								</select>
							</span>
							<span id="shop_categories">
	
							</span>
						<span class="red">*</span>
						</td>
				</tr>
				<tr>
					<td class="textright"><?php echo  $m_langpackage->m_stayarea;?>:</td>
					<td>
						<span id="shop_country"><select name="country" onchange="areachanged(this.value,0);">
							<option value='0'><?php echo  $m_langpackage->m_select_country;?></option>
						<?php  foreach($areas_info[0] as $v) {?>
							<option value="<?php echo  $v['area_id'];?>" <?php  if($v['area_id']==$shop_info['shop_country']){echo 'selected';}?>>
								<?php echo  $v['area_name'];?></option>
						<?php }?>
						</select></span>
						<span id="shop_province"><?php  if($shop_info['shop_country']){?>
						<select name="province" onchange="areachanged(this.value,1);">
							<option value='0'><?php echo  $m_langpackage->m_select_province;?></option>
						<?php  foreach($areas_info[1] as $v) {
								if($v['parent_id'] == $shop_info['shop_country']) {?>
							<option value="<?php echo  $v['area_id'];?>" <?php  if($v['area_id']==$shop_info['shop_province']){echo 'selected';}?>>
								<?php echo  $v['area_name'];?></option>
						  <?php }?>
							<?php }?>
						</select>
						<?php }?></span>
						<span id="shop_city"><?php  if($shop_info['shop_province']) {?>
						<select name="city" onchange="areachanged(this.value,2);">
							<option value='0'><?php echo  $m_langpackage->m_select_city;?></option>
						<?php  foreach($areas_info[2] as $v) {
								if($v['parent_id'] == $shop_info['shop_province']){?>
							<option value="<?php echo  $v['area_id'];?>" <?php  if($v['area_id']==$shop_info['shop_city']){echo 'selected';}?>>
								<?php echo  $v['area_name'];?></option>
						<?php }?>
						<?php  }?></select>
						<?php }?></span>
						<span id="shop_district"><?php  if($shop_info['shop_city']) {?>
						<select name="district">
							<option value='0'><?php echo  $m_langpackage->m_select_district;?></option>
						<?php foreach($areas_info[3] as $v) {
								if($v['parent_id'] == $shop_info['shop_city']) {?>
							<option value="<?php echo  $v['area_id'];?>" <?php  if($v['area_id']==$shop_info['shop_district']){echo 'selected';}?>><?php echo  $v['area_name'];?></option>
						<?php }?>
						<?php }?></select>
						<?php }?></span>
					<span class="red">*</span></td>
				</tr>
				<tr><td class="textright"><?php echo  $m_langpackage->m_address;?>:</td><td><input type="text" name="shop_address" value="<?php echo  $shop_info['shop_address'];?>" style="width:250px;" maxlength="200" /> <span class="red">*</span></td></tr>
				<tr><td class="textright"><?php echo  $m_langpackage->m_shop_management;?>:</td><td><input type="text" name="shop_management" value="<?php echo  $shop_info['shop_management'];?>" style="width:250px;" maxlength="200" /> <span class="red">*</span></td></tr>
				<tr><td class="textright"><?php echo  $m_langpackage->m_select_template;?>:</td><td class="templageimg">
				<?php  foreach($shoptemplate_arr as $v) {?>
					<span><img src="<?php echo  $v['imgurl'];?>" width="95" alt="<?php echo  $v['tplname'];?>" onclick="wshowimg('<?php echo  $v['bigimgurl'];?>')" onmouseover="imgmover(this)" onmouseout="imgmout(this)" onerror="this.src='skin/default/images/nopic.gif'"/><br /><input type="radio" name="shop_template" value="<?php echo  $v['tpltag'];?>" <?php  if($shop_info['shop_template']==$v['tpltag']) {?> checked<?php }?> /> <?php echo  $v['tplname'];?></span>
				<?php }?>
				</td></tr>
				<tr style="line-height:18px;"><td class="textright"><?php echo  $m_langpackage->m_shop_intro;?>:</td><td>
				<textarea name="shop_intro" id="shop_intro" cols="75" rows="5"><?php echo  $shop_info['shop_intro'];?></textarea>
				</td></tr>
				<tr><td colspan="2" align="center"><input type="submit" name="submit" value="<?php echo  $m_langpackage->m_create_shop;?>" /></td></tr>
			</table>
		</form>
            </div>
			<div class="right_bottom"></div>
			<div class="back_top"><a href="#"></a></div>
        </div>
    <div class="clear"></div>
    <?php  require("shop/index_footer.php");?>
<div id="showimg" style="display:none; width:408px; text-align:center; border:5px solid #F6A248; position:absolute; padding:4px; background:#fff; top:200px;"><img id="imgsrc" src="skin/default/images/shop_template_default_big.gif" width="400" /></div>
<div style="width:0px; height:0px; overflow:hidden;"><input type="input" id="hiddeninput" onblur="whideimg()" /></div>
<script language="JavaScript" src="servtools/ajax_client/ajax.js"></script>
<script language="JavaScript">
<!--
var utype = '';
function areachanged(value,type){
	utype = type;
	if(value > 0) {
		ajax("do.php?act=ajax_areas","POST","value="+value+"&type="+type);
	} else {
		if(type==2) {
			hide("shop_district");
		} else if(type==1) {
			hide("shop_district");
			hide("shop_city");
		} else if(type==0) {
			hide("shop_district");
			hide("shop_city");
			hide("shop_province");
		}
	}
}

function categorieschanged(value){
	if(value > 0) {
		ajax("do.php?act=ajax_categories","POST","value="+value,function(return_text){
			return_text = return_text.replace(/[\n\r]/g,"");
			document.getElementById("shop_categories").innerHTML = return_text;
			show("shop_categories");
		});
	}
}

function ajaxCallback (return_text){
	return_text = return_text.replace(/[\n\r]/g,"");
	if(return_text==""){
		alert("<?php echo  $m_langpackage->m_select_again;?>");
	} else {
		if(utype==0) {
			document.getElementById("shop_province").innerHTML = return_text;
			show("shop_province");
			hide("shop_city");
			hide("shop_district");
		} else if(utype==1) {
			document.getElementById("shop_city").innerHTML = return_text;
			show("shop_city");
			hide("shop_district");
		} else if(utype==2) {
			document.getElementById("shop_district").innerHTML = return_text;
			show("shop_district");
		}
	}
}

function hide(id) {
	document.getElementById(id).style.display = 'none';
}
function show(id) {
	document.getElementById(id).style.display = '';
}

function checkForm() {
	var shop_name = document.getElementsByName("shop_name")[0];
	var shop_address = document.getElementsByName("shop_address")[0];
	var shop_management = document.getElementsByName("shop_management")[0];
	if(shop_name.value=='') {
		alert("<?php echo  $m_langpackage->m_shopname_notnone;?>");
		shop_name.focus();
		return false;
	} else if(document.getElementsByName("country")[0].value==0) {
		alert("<?php echo  $m_langpackage->m_select_countrypl;?>");
		return false;
	} else if(document.getElementsByName("province")[0].value==0) {
		alert("<?php echo  $m_langpackage->m_select_provincepl;?>");
		return false;
	} else if(document.getElementsByName("city")[0].value==0) {
		alert("<?php echo  $m_langpackage->m_select_citypl;?>");
		return false;
	} else if(document.getElementsByName("district")[0].value==0) {
		alert("<?php echo  $m_langpackage->m_select_districtpl;?>");
		return false;
	} else if(shop_address.value=='') {
		alert("<?php echo  $m_langpackage->m_address_notnone;?>");
		shop_address.focus();
		return false;
	} else if(shop_management.value=='') {
		alert("<?php echo  $m_langpackage->m_shopmanagement_notnone;?>");
		shop_management.focus();
		return false;
	}
	return true;
}

function imgmover(obj) {
	obj.style.border = '2px solid #E38016';
}

function imgmout(obj) {
	obj.style.border = '2px solid #eee';
}

function wshowimg(v) {
	var width = document.body.clientWidth;
	var showimg = document.getElementById("showimg");
	var imgsrc = document.getElementById("imgsrc");

	var left = "100";
	if(width) {
		left = (width-400)/2;
	}
	showimg.style.left = left+"px";
	showimg.style.display = '';
	imgsrc.src = v;
	document.getElementById("hiddeninput").focus();
}

function whideimg() {
	var showimg = document.getElementById("showimg");
	showimg.style.display = 'none';
}
//-->
</script>
</body>
</html><?php } ?>