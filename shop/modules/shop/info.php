<?php
/*
 * 注意：此文件由itpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/modules/shop/info.html
 * 如果您的模型要进行修改，请修改 models/modules/shop/info.php
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
if(filemtime("templates/default/modules/shop/info.html") > filemtime(__file__) || (file_exists("models/modules/shop/info.php") && filemtime("models/modules/shop/info.php") > filemtime(__file__)) ) {
	tpl_engine("default","modules/shop/info.html",1);
	include(__file__);
} else {
/* debug模式运行生成代码 结束 */
?><?php

if(!$IWEB_SHOP_IN) {
	trigger_error('Hacking attempt');
}

require("foundation/acheck_shop_creat.php");
require("foundation/module_areas.php");
require("foundation/module_shop.php");
require("foundation/module_users.php");
require("foundation/module_shop_category.php");
//引入语言包
$m_langpackage=new moduleslp;
$i_langpackage=new indexlp;

//数据表定义区
$t_areas = $tablePreStr."areas";
$t_shop_info = $tablePreStr."shop_info";
$t_users = $tablePreStr."users";
$t_privilege = $tablePreStr."privilege";
$t_user_rank = $tablePreStr."user_rank";
$t_shop_categories = $tablePreStr."shop_categories";

//读写分离定义方法
$dbo=new dbex;
dbtarget('r',$dbServs);

//判断用户是否锁定，锁定则不许操作
$sql ="select locked from $t_users where user_id=$user_id";
$row = $dbo->getRow($sql);
if($row['locked']==1){
	session_destroy();
	trigger_error($m_langpackage->m_user_locked);//非法操作
}
$shop_info = get_shop_info($dbo,$t_shop_info,$shop_id);

$shop_rank = $shop_info['shop_categories'];

$user_id = get_sess_user_id();
$areas_info = get_areas_info($dbo,$t_areas);
$user_info = get_user_info($dbo,$t_users,$user_id);
//$s_categories_info = get_categories_info($dbo,$t_shop_categories);
$rank_info = get_userrank_info($dbo,$t_user_rank,$user_info['rank_id']);
//echo $user_info['rank_id'];exit();
//echo $rank_info['privilege'];exit();
$privilege = unserialize($rank_info['privilege']);
$shop_categories_parent = get_categories_item_parentid($dbo,$t_shop_categories,0);
$categories_parent = 0;
$categories_child = 0;
if(isset($shop_info['shop_categories'])){
	$shop_categories_info = get_categories_info_catid($dbo,$t_shop_categories,$shop_info['shop_categories']);
	if($shop_categories_info['parent_id'] == 0){
		$categories_parent = $shop_info['shop_categories'];
	} else {
		$categories_parent = $shop_categories_info['parent_id'];
		$categories_child = $shop_info['shop_categories'];
	}
}


//echo $shop_info['shop_categories'];
$flag ='0';
foreach ($privilege as $key =>$vlaue){
	if ($key =='10'){
		$flag ='1';
	}
}
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
<script type="text/javascript" src="skin/<?php echo  $SYSINFO['templates'];?>/js/userchangeStyle.js"></script>
<script type="text/javascript" src="skin/<?php echo  $SYSINFO['templates'];?>/js/changeStyle.js"></script>
<style type="text/css">
.red{color:red;}
.templageimg span{float:left; display:block; text-align:left; margin-left:5px;}
.templageimg img{border:2px solid #eee; cursor:pointer;}
</style>
<script type="text/javascript" src="servtools/jquery-1.3.2.min.js?v=1.3.2"></script>
<script type="text/javascript" src="servtools/xheditor/xheditor.min.js?v=1.0.0-final"></script>
<script type="text/javascript">
var introeditor;
$(function(){
	introeditor=$("#shopintro").xheditor({skin:'vista',tools:"Cut,Copy,Paste,Pastetext,Separator,Blocktag,Fontface,FontSize,Bold,Italic,Underline,Strikethrough,FontColor,BackColor,SelectAll,Removeformat,Separator,Align,List,Outdent,Indent,Separator,Link,Unlink,Img,Table,Separator,Fullscreen,About"});

});
</script>
</head>
<body <?php if($SYSINFO['map']=='true') {?> onload="initialize();menu_style_change('shop_info');changeMenu();" <?php  } else{?> onload="menu_style_change('shop_info');changeMenu();" <?php }?> >
	<?php  require("shop/index_header.php");?>
	<div class="site_map">
	  <?php echo $m_langpackage->m_current_position;?><A href="index.php"><?php echo $SYSINFO['sys_name'];?></A>/<a href="modules.php"><?php echo $m_langpackage->m_u_center;?></a>/&nbsp;&nbsp;<?php echo $m_langpackage->m_shop_info;?>
	</div>
    <div class="clear"></div>
    	<?php  require("modules/left_menu.php");?>
        <div class="main_right">
        	<div class="right_top"></div>
            <div class="cont">
                <div class="cont_title"><?php echo  $m_langpackage->m_shop_info;?></div>
                <hr />
				<form action="do.php?act=shop_info" method="post" name="form_shop_info" onsubmit="return checkForm();" enctype="multipart/form-data">
				<table width="100%"  style="border:0;" cellspacing="0">
						<?php  if($SYSINFO['sys_domain']) {?>
							<?php  if($flag) {?>
					<tr>
						<td class="textright" width="15%"><?php echo  $m_langpackage->m_domain;?>:</td>
						<td><input type="text" name="shop_domain" value="<?php echo  $shop_info['shop_domain'];?>" style="width:250px;" maxlength="50" /></td>
					</tr>
							<?php }?>
						<?php }?>
					<tr><td class="textright" width="15%"><?php echo  $m_langpackage->m_shop_name;?>:</td>
						<td><input type="text" name="shop_name" value="<?php echo  $shop_info['shop_name'];?>" style="width:250px;" maxlength="50" />
							<span class="red">*</span></td>
					</tr>
					<tr><td class="textright" width="15%"><?php echo  $m_langpackage->m_shop_categories;?>:</td>
						<td style="float:none;">
							<span id="shop_country">
								<select name="categories_parent" onchange="categorieschanged(this.value)">
									<option value='0'><?php echo  $m_langpackage->m_select_categories;?></option>
									<?php  foreach($shop_categories_parent as $v) {?>
										<option value="<?php echo  $v['cat_id'];?>"
											<?php  if($v['cat_id']==$categories_parent){echo 'selected';}?>><?php echo  $v['cat_name'];?></option>
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
						<td style="float:none;">
							<span id="shop_country">
								<select name="country" onchange="areachanged(this.value,0);">
								<option value='0'><?php echo  $m_langpackage->m_select_country;?></option>
									<?php  foreach($areas_info[0] as $v) {?>
										<option value="<?php echo  $v['area_id'];?>"
											<?php  if($v['area_id']==$shop_info['shop_country']){echo 'selected';}?>><?php echo  $v['area_name'];?></option>
									<?php }?>
								</select>
							</span>
							<span id="shop_province">
								<?php  if($shop_info['shop_country']) {?>
									<select name="province" onchange="areachanged(this.value,1);">
										<option value='0'><?php echo  $m_langpackage->m_select_province;?></option>
										<?php  foreach($areas_info[1] as $v) {
											if($v['parent_id'] == $shop_info['shop_country']) {?>
												<option value="<?php echo  $v['area_id'];?>" <?php  if($v['area_id']==$shop_info['shop_province']){echo 'selected';}?>><?php echo  $v['area_name'];?></option>
											<?php }?>
										<?php }?>
									</select>
								<?php }?>
							<span id="shop_city"><?php  if($shop_info['shop_province']) {?>
							<select name="city" onchange="areachanged(this.value,2);">
								<option value='0'><?php echo  $m_langpackage->m_select_city;?></option>
							<?php  foreach($areas_info[2] as $v) {
									if($v['parent_id'] == $shop_info['shop_province']) {?>
								<option value="<?php echo  $v['area_id'];?>" <?php   if($v['area_id']==$shop_info['shop_city']){echo 'selected';}?>>
								<?php echo  $v['area_name'];?></option>
							<?php }?>
							<?php }?></select>
							<?php }?></span>
							<span id="shop_district"><?php  if($shop_info['shop_city']) {?>
							<select name="district">
								<option value='0'><?php echo  $m_langpackage->m_select_district;?></option>
							<?php  foreach($areas_info[3] as $v) {
									if($v['parent_id'] == $shop_info['shop_city']) {?>
								<option value="<?php echo  $v['area_id'];?>" <?php if($v['area_id']==$shop_info['shop_district']){echo 'selected';}?>>
								<?php echo  $v['area_name'];?></option>
							<?php }?>
							<?php }?></select>
							<?php }?></span>
						<span class="red">*</span></td>
					</tr>
					<tr>
						<td class="textright"><?php echo  $m_langpackage->m_shop_management;?>:</td>
						<td><input type="text" name="shop_management" value="<?php echo  $shop_info['shop_management'];?>" style="width:250px;" maxlength="200" /> <span class="red">*</span> 
							

						</td>
					</tr>

					<tr><td class="textright"><?php echo  $m_langpackage->m_address;?>:</td>
						<td><input type="text" name="shop_address" value="<?php echo  $shop_info['shop_address'];?>" style="width:250px;" maxlength="200" /> <span class="red">*</span>
						<?php if($SYSINFO['map']=='true') {?>
						&nbsp;【<a onclick="discontrol('map_canvas',this)" href="#"><?php echo  $m_langpackage->m_open_map;?></a>】
						<div id="map_canvas" style="width:600px; height:400px;"></div>
						<?php }?>
						</td>
					</tr>
					<tr style="line-height:18px;"><td class="textright"><?php echo  $m_langpackage->m_shop_intro;?>:</td>
						<td>
						<textarea name="shop_intro" id="shopintro" cols="65" rows="10"><?php echo  $shop_info['shop_intro'];?></textarea>
					</td></tr>
					<tr><td class="textright"><?php echo  $m_langpackage->m_select_template;?>:</td><td class="templageimg">
					<?php  foreach($shoptemplate_arr as $v) {?>
						<span><img src="<?php echo  $v['imgurl'];?>" width="95" alt="<?php echo  $v['tplname'];?>" onclick="wshowimg('<?php echo  $v['bigimgurl'];?>')" onmouseover="imgmover(this)" onmouseout="imgmout(this)" onerror="this.src='skin/default/images/nopic.gif'"/><br /><input type="radio" name="shop_template" value="<?php echo  $v['tpltag'];?>" <?php  if($shop_info['shop_template']==$v['tpltag']) {?> checked<?php }?> /> <?php echo  $v['tplname'];?></span>
					<?php }?>
					</td></tr>

					<tr style="display:none;"><td class="textright"><?php echo  $m_langpackage->m_shop_introimg;?>:</td>
					<td><input type="file" name="attach_images[]" /> <?php  if($shop_info['shop_images'])
					{ echo "<img src='".$shop_info['shop_images']."' height='80' onerror=\"javascript:this.src='skin/default/images/no_page.jpg'\"/>";?><?php }?> <?php echo  $m_langpackage->m_shop_introimg_msg;?></td></tr>

					<tr><td class="textright" style="white-space:nowrap"><?php echo  $m_langpackage->m_shop_logoimg;?>:</td>
					<td><input type="file" name="attach_logo[]" /> <?php  if($shop_info['shop_logo'])
					{ echo "<img src='".$shop_info['shop_logo']."' height='80' onerror=\"javascript:this.src='skin/default/images/no_page.jpg'\"/>";?><?php }?> <?php echo  $m_langpackage->m_shop_logoimg_msg;?></td></tr>
					<tr><td class="textright" style="white-space:nowrap"><?php echo  $m_langpackage->m_shop_bannerimg;?>:</td>
					<td><input type="file" name="attach_template[]" /> <?php  if($shop_info['shop_template_img'])
					{echo "<img src='".$shop_info['shop_template_img']."' height='80' onerror=\"javascript:this.src='skin/default/images/no_page.jpg'\"/>";?><?php }?> <?php echo  $m_langpackage->m_shop_bannerimg_msg;?></td></tr>
					<tr><td></td><td><input type="hidden" name="shop_id" value="<?php echo  $shop_id;?>" />
					<input class="submit" type="submit" name="submit" value="<?php echo  $m_langpackage->m_edit_shop;?>" /></td></tr>
					
					<input type="hidden" name="now_x" id="now_x" value="<?php echo $shop_info['map_x'];?>" />
					<input type="hidden" name="now_y" id="now_y" value="<?php echo $shop_info['map_y'];?>" />
					<input type="hidden" name="now_zoom" id="now_zoom" value="<?php echo $shop_info['map_zoom'];?>" />
				</table>
				</form>
            </div>
		    <div class="clear"></div>
			<div class="right_bottom"></div>
			<div class="back_top"><a href="#"></a></div>
        </div>
    <?php  require("shop/index_footer.php");?>
</div>
<div id="showimg" style="display:none; width:408px; text-align:center; border:5px solid #F6A248; position:absolute; padding:4px; background:#fff; top:200px;"><img id="imgsrc" src="skin/default/images/shop_template_default_big.gif" width="400" /></div>
<div style="width:0px; height:0px; overflow:hidden;"><input type="input" id="hiddeninput" onblur="whideimg()" /></div>
<?php if($SYSINFO['map']=='true') {?>
<script src="http://maps.google.com/maps?file=api&v=2.x&key=<?php echo $SYSINFO['map_key'];?>" type="text/javascript"></script>
<?php }?>
<script language="JavaScript" src="servtools/ajax_client/ajax.js"></script>
<script language="JavaScript">
<!--

categorieschanged(<?php echo $categories_parent ?>,<?php echo $categories_child ?>);

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

function areachanged(value,type){
	if(value > 0) {
		ajax("do.php?act=ajax_areas","POST","value="+value+"&type="+type,function(return_text){
			return_text = return_text.replace(/[\n\r]/g,"");
			if(return_text==""){
				alert("<?php echo  $m_langpackage->m_select_again;?>");
			} else {
				if(type==0) {
					document.getElementById("shop_province").innerHTML = return_text;
					show("shop_province");
					hide("shop_city");
					hide("shop_district");
				} else if(type==1) {
					document.getElementById("shop_city").innerHTML = return_text;
					show("shop_city");
					hide("shop_district");
				} else if(type==2) {
					document.getElementById("shop_district").innerHTML = return_text;
					show("shop_district");
				}
			}
		});
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

function categorieschanged(value,child_value){
	if(value > 0) {
		ajax("do.php?act=ajax_categories","POST","value="+value+"&child_value="+child_value,function(return_text){
			return_text = return_text.replace(/[\n\r]/g,"");
			document.getElementById("shop_categories").innerHTML = return_text;
			show("shop_categories");
		});
	}
}

function v_change(value,rank){
	if(value > 0) {
		ajax("do.php?act=shop_categories","POST","value="+value+"&rank="+rank,function(return_text){

			if (rank == '0'){
				document.getElementById("rank1").innerHTML = return_text;
				show("rank1");
				hide("rank2");
				hide("rank3");
				hide("rank4");

			}else if(rank == '1'){
				document.getElementById("rank2").innerHTML = return_text;

				show("rank2");
				hide("rank3");
				hide("rank4");
			}else if(rank == '2'){
				document.getElementById("rank3").innerHTML = return_text;

				show("rank3");
				hide("rank4");
			}else if(rank == '3'){
				document.getElementById("rank4").innerHTML = return_text;

				show("rank4");
			}

		});
	}else {
		if(rank == '3'){
			hide("rank4");
		}else if(rank == '2'){
			hide("rank3");
			hide("rank4");
		}else if(rank == '1'){
			hide("rank2");
			hide("rank3");
			hide("rank4");
		}else if(rank == '0'){
			hide("rank1");
			hide("rank2");
			hide("rank3");
			hide("rank4");
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
	var shop_domain = document.getElementsByName("shop_domain")[0];
	var shop_name = document.getElementsByName("shop_name")[0];
	var shop_address = document.getElementsByName("shop_address")[0];
	var shop_management = document.getElementsByName("shop_management")[0];
	var re=/^(\w){3,10}$/;
	if(!re.test(shop_domain.value)){
		alert("<?php echo  $m_langpackage->m_domain_format_error;?>");
		shop_domain.focus();
		return false;
	}else if(shop_domain.value=='www') {
		alert("<?php echo  $m_langpackage->m_domain_format_error;?>");
		shop_domain.focus();
		return false;
	}else if(shop_name.value=='') {
		alert("<?php echo  $m_langpackage->m_shopname_notnone;?>");
		shop_name.focus();
		return false;
	}else if(document.getElementsByName("categories_parent")[0].value==0) {
		alert("<?php echo  $m_langpackage->m_select_categoriespl;?>");
		return false;
	} 
	else if(document.getElementsByName("country")[0].value==0) {
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
		shop_name.focus();
		return false;
	} else if(shop_management.value=='') {
		alert("<?php echo  $m_langpackage->m_shopmanagement_notnone;?>");
		shop_management.focus();
		return false;
	}
	return true;
}

<?php if($SYSINFO['map']=='true') {?>
// 地图处理开始
var now_x = <?php echo $shop_info['map_x'];?>;
var now_y = <?php echo $shop_info['map_y'];?>;
var now_zoom = <?php echo $shop_info['map_zoom'];?>;

if(now_x=='0' && now_y=='0'){
	var now_x = '116.39328002929687';
	var now_y = '39.89709437260048';
	var now_zoom = '5';
}

function initialize() {
	if (GBrowserIsCompatible()) {
		var map = new GMap2(document.getElementById("map_canvas"));
		var center = new GLatLng(now_y, now_x);
		map.setCenter(center, now_zoom);

		var point = new GLatLng(now_y,now_x);
		var marker = new GMarker(point);
		map.addOverlay(marker);

		GEvent.addListener(map,"click", function(overlay,latlng) {
			if(latlng) {
				var point = new GLatLng(latlng.y,latlng.x); // 根据经纬度创建点
				var marker = new GMarker(point);			// 创建标注
				map.clearOverlays();						// 清除现有地图上的所有标注
				map.addOverlay(marker);						// 添加新标注

				now_x = latlng.x;
				now_y = latlng.y;
				now_zoom = map.getZoom();

				document.getElementById('now_x').value=now_x;
				document.getElementById('now_y').value=now_y;
				document.getElementById('now_zoom').value=now_zoom;
			}
		});

		map.addControl(new GSmallMapControl());
		map.addControl(new GMapTypeControl());
	}
	document.getElementById("map_canvas").style.display = "none";
}

function discontrol(itemid,obj)
{
	if(document.getElementById(itemid).style.display=='') {
		obj.innerHTML = '<?php echo  $m_langpackage->m_open_map;?>';
		document.getElementById(itemid).style.display="none";
	} else {
		obj.innerHTML = '<?php echo  $m_langpackage->m_close_map;?>';
 		document.getElementById(itemid).style.display="";
	}
}
// 地图处理结束
<?php }?>

//-->
</script>

</body>
</html><?php } ?>