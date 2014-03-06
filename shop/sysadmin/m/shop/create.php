<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}
//语言包引入
$a_langpackage=new adminlp;

require("../foundation/module_areas.php");
require("../foundation/module_shop_category.php");

//数据表定义区
$t_areas = $tablePreStr."areas";
$t_shop_categories = $tablePreStr."shop_categories";
$uid = intval(get_args('id'));
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
	'imgurl' => '../skin/default/images/default_small.gif',
	'bigimgurl' => '../skin/default/images/default.gif',
	'tpltag' => 'default',
	'tplname' => $a_langpackage->a_default_template
);
$shoptemplate_arr[] = array(
	'imgurl' => '../skin/default/images/green_small.gif',
	'bigimgurl' => '../skin/default/images/green.gif',
	'tpltag' => 'green',
	'tplname' => $a_langpackage->a_green_template
);
$shoptemplate_arr[] = array(
	'imgurl' => '../skin/default/images/blue_small.gif',
	'bigimgurl' => '../skin/default/images/blue.gif',
	'tpltag' => 'blue',
	'tplname' => $a_langpackage->a_blue_template
);
$shoptemplate_arr[] = array(
	'imgurl' => '../skin/default/images/red_small.gif',
	'bigimgurl' => '../skin/default/images/red.gif',
	'tpltag' => 'red',
	'tplname' => $a_langpackage->a_red_template
);
$shoptemplate_arr[] = array(
	'imgurl' => '../skin/default/images/purple_small.gif',
	'bigimgurl' => '../skin/default/images/purple.gif',
	'tpltag' => 'purple',
	'tplname' => $a_langpackage->a_purple_template
);
$shoptemplate_arr[] = array(
	'imgurl' => '../skin/default/images/gray_small.gif',
	'bigimgurl' => '../skin/default/images/gray.gif',
	'tpltag' => 'gray',
	'tplname' => $a_langpackage->a_gray_template
);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<link rel="stylesheet" type="text/css" href="skin/css/admin.css">
<link rel="stylesheet" type="text/css" href="skin/css/main.css">

<style>
td span {
	color: red;
}
</style>
<script type="text/javascript"
	src="../servtools/jquery-1.3.2.min.js?v=1.3.2"></script> <script
	type="text/javascript"
	src="skin/xheditor/xheditor.min.js?v=1.0.0-final"></script> <script
	type="text/javascript">
var introeditor;
$(function(){
	introeditor=$("#shop_intro").xheditor({skin:'vista',tools:"Cut,Copy,Paste,Pastetext,Separator,Blocktag,Fontface,FontSize,Bold,Italic,Underline,Strikethrough,FontColor,BackColor,SelectAll,Removeformat,Separator,Align,List,Outdent,Indent,Separator,Link,Unlink,Img,Table,Separator,Source,Fullscreen,About"});

});
</script>

</head>
<body>
<div id="maincontent">
<?php  include("messagebox.php");?>
	<div class="wrap">
<div class="crumbs"><?php echo $a_langpackage->a_location; ?> &gt;&gt; <?php echo $a_langpackage->a_m_shop_mengament;?> &gt;&gt; <?php echo $a_langpackage->a_create_shop; ?></div>
<hr />
<div class="infobox">
<h3><span class="left"><?php echo $a_langpackage->a_create_shop; ?></span><span
	class="right" style="margin-right: 15px;"><a href="m.php?app=shop_list"><?php echo $a_langpackage->a_memeber_list; ?></a></span></h3>
<div class="content2">
<form method="post" action="a.php?act=shop_create"	name="form_shop_request" onsubmit="return checkForm()">
<table>
	<tr>
		<td width="140px;"><?php echo $a_langpackage->a_shopname; ?>：</td>
		<td><input type="text" name="shop_name"
			value="<?php echo $shop_info['shop_name']; ?>" style="width: 250px;"
			maxlength="50" /><span class="red">*</span></td>
	</tr>
	<input type="hidden" name="uid" value="<?php echo $uid; ?>" />
	<tr>
		<td><?php echo $a_langpackage->a_categories_parent; ?>：</td>
		<td><span id="shop_country"> <select name="categories_parent"
			onchange="categorieschanged(this.value)">
			<option value='0'><?php echo $a_langpackage->a_selecttype; ?></option>
					<?php 
					foreach ($shop_categories_parent as $v){
					?>
					<option value="<?php echo $v['cat_id']; ?>"><?php echo $v['cat_name']; ?></option>
					<?php
					}
					?>
				</select></span> <span id="shop_categories"> </span><span
			class="red">*</span></td>
	</tr>
	<tr>
		<td><?php echo $a_langpackage->a_shop_country; ?>：</td>
		<td>		<span id="shop_country">
						<select name="country"	onchange="areachanged(this.value,0);">
							<option value='0'><?php echo $a_langpackage->a_selectcount; ?></option>
							<?php 
							foreach ($areas_info[0] as $v){
							?>
							<option value="<?php echo $v['area_id']; ?>"<?php if($v['area_id']==$shop_info['shop_country']){echo 'selected';}?>>
								<?php echo $v['area_name']; ?></option>
							<?php
							}
							?>
						</select>
						</span> 
						<span id="shop_province">
						<?php 
						if($shop_info['shop_country']){
							?>
							<select name="province" onchange="areachanged(this.value,1);">
								<option value='0'><?php echo $a_langpackage->a_select_province; ?></option>
								<?php 
								foreach ($areas_info[1] as $v){
								?>
								<option value="<?php echo $v['area_id']; ?>"<?php if($v['area_id']==$shop_info['shop_province']){echo 'selected';}?>>
									<?php echo $v['area_name']; ?></option>
								<?php
								}
								?>
							</select>
							<?php 
						}
						?>
						</span>
						<span id="shop_city">
						<?php 
						if($shop_info['shop_province']){
							?>
							<select name="city" onchange="areachanged(this.value,2);">
								<option value='0'><?php echo $a_langpackage->a_select_city; ?></option>
								<?php 
								foreach ($areas_info[2] as $v){
									if($v['parent_id'] == $shop_info['shop_province']){
								?>
								<option value="<?php echo $v['area_id']; ?>"<?php if($v['area_id']==$shop_info['shop_city']){echo 'selected';}?>>
									<?php echo $v['area_name']; ?></option>
								<?php
									}
								}
								?>
							</select>
							<?php 
						}
							?>
						</span>
						<span id="shop_district">
						<?php 
						if($shop_info['shop_city']){
							?>
							<select name="district">
								<option value='0'><?php echo $a_langpackage->a_select_dir; ?></option>
								<?php 
								foreach($areas_info[3] as $v){
									if($v['parent_id'] == $shop_info['shop_city']){
										?>
										<option value="<?php echo $v['area_id']; ?>"<?php if($v['area_id']==$shop_info['shop_district']){echo 'selected';}?>>
											<?php echo $v['area_name']; ?></option>
										<?php 
									}
								}
								?>
						</select>
							<?php
						}
						?>
						</span> <span class="red">*</span></td>
	</tr>
	<tr>
		<td><?php echo $a_langpackage->a_shop_address; ?>：</td>
		<td><input type="text" name="shop_address"
			value="<?php echo $shop_info['shop_address']; ?>"
			style="width: 250px;" maxlength="200" /> <span class="red">*</span></td>
	</tr>

	<tr>
		<td><?php echo $a_langpackage->a_shop_management; ?>：</td>
		<td><input type="text" name="shop_management"
			value="<?php echo $shop_info['shop_management']; ?>"
			style="width: 250px;" maxlength="200" /> <span class="red">*</span></td>
	</tr>
	<tr>
		<td><?php echo $a_langpackage->a_shop_template; ?>：</td>
		<td class="templageimg">
				<?php 
				foreach($shoptemplate_arr as $v){
					?>
					<span><img src="<?php echo $v['imgurl']; ?>" width="95"	alt="<?php echo $v['tplname']; ?>"	onclick="wshowimg('<?php echo $v['bigimgurl']; ?>')" onmouseover="imgmover(this)" onmouseout="imgmout(this)" onerror="this.src='../skin/default/images/nopic.gif'" /><br />	<input type="radio" name="shop_template"	value="<?php echo $v['tpltag']; ?>"	<?php if($shop_info['shop_template']==$v['tpltag']){echo 'checked';}?> /> <?php echo $v['tplname']; ?></span> 
				<?php
				}
				?>
				</td>
	</tr>
	<tr>
		<td><?php echo $a_langpackage->a_shop_intro; ?>：</td>
		<td><textarea name="shop_intro" id="shop_intro" cols="75" rows="15"><?php echo $shop_info['shop_intro']; ?></textarea></td>
	</tr>
	<tr>
		<td colspan="2"><span class="button-container"><input
			class="regular-button" type="submit" name="btn_submit"
			value="<?php echo $a_langpackage->a_create_shop; ?>" /></span></td>
	</tr>
</table>
</form>
</div>
</div>
</div>
</div>
<div id="showimg" style="display:none; width:408px; text-align:center; border:5px solid #F6A248; position:absolute; padding:4px; background:#fff; top:200px;"><img id="imgsrc" src="skin/default/images/shop_template_default_big.gif" width="400" /></div>
<div style="width:0px; height:0px; overflow:hidden;"><input type="input" id="hiddeninput" onblur="whideimg()" /></div>
<script language="JavaScript" src="../servtools/ajax_client/ajax.js"></script>
<script language="JavaScript">
<!--
var utype = '';
function areachanged(value,type){
	utype = type;
	if(value > 0) {
		ajax("a.php?act=ajax_areas","POST","value="+value+"&type="+type);
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
		ajax("a.php?act=ajax_categori","POST","value="+value,function(return_text){
			return_text = return_text.replace(/[\n\r]/g,"");
			document.getElementById("shop_categories").innerHTML = return_text;
			show("shop_categories");
		});
	}
}

function ajaxCallback (return_text){
	return_text = return_text.replace(/[\n\r]/g,"");
	if(return_text==""){
		alert("<?php echo $a_langpackage->a_select_again; ?>");
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
			show("shop_district");
			document.getElementById("shop_district").innerHTML = return_text;
			
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
		alert("<?php echo $a_langpackage->a_shopname_notnone; ?>");
		shop_name.focus();
		return false;
	} else if(document.getElementsByName("country")[0].value==0) {
		alert("<?php echo $a_langpackage->a_select_countrypl; ?>");
		return false;
	} else if(document.getElementsByName("province")[0].value==0) {
		alert("<?php echo $a_langpackage->a_select_provincepl; ?>");
		return false;
	} else if(document.getElementsByName("city")[0].value==0) {
		alert("<?php echo $a_langpackage->a_select_citypl; ?>");
		return false;
	} else if(document.getElementsByName("district")[0].value==0) {
		alert("<?php echo $a_langpackage->a_select_districtpl; ?>");
		return false;
	} else if(shop_address.value=='') {
		alert("<?php echo $a_langpackage->a_address_notnone; ?>");
		shop_address.focus();
		return false;
	} else if(shop_management.value=='') {
		alert("<?php echo $a_langpackage->a_shopmanagement_notnone; ?>");
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
</html>