<?php
/*
 * 注意：此文件由itpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/modules/goods/edit.html
 * 如果您的模型要进行修改，请修改 models/modules/goods/edit.php
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
if(filemtime("templates/default/modules/goods/edit.html") > filemtime(__file__) || (file_exists("models/modules/goods/edit.php") && filemtime("models/modules/goods/edit.php") > filemtime(__file__)) ) {
	tpl_engine("default","modules/goods/edit.html",1);
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
require("foundation/module_attr.php");
require("foundation/module_shop.php");
//引入语言包
$m_langpackage=new moduleslp;
$i_langpackage=new indexlp;
$s_langpackage=new shoplp;
 if(get_session('shop_open')!=null&&get_session('shop_open')==1){
 	trigger_error("店铺已关闭，请开启后修改!");
 }
//数据表定义区
$t_goods = $tablePreStr."goods";
$t_category = $tablePreStr."category";
$t_attribute = $tablePreStr."attribute";
$t_shop_category = $tablePreStr."shop_category";
$t_goods_attr = $tablePreStr."goods_attr";
$t_goods_transport = $tablePreStr."goods_transport";
$t_shop_payment = $tablePreStr."shop_payment";
$t_payment = $tablePreStr."payment";
$t_image_size = $tablePreStr."img_size";
$t_users = $tablePreStr."users";

$goods_id = intval(get_args('id'));

//读写分离定义方法
$dbo = new dbex;
dbtarget('r',$dbServs);
//判断商品是否锁定，锁定则不许操作
include("foundation/fgoods_locked.php");
//判断用户是否锁定，锁定则不许操作
$sql ="select locked from $t_users where user_id=$user_id";
$row = $dbo->getRow($sql);
if($row['locked']==1){
	session_destroy();
	trigger_error($m_langpackage->m_user_locked);//非法操作
}
$goods_info = get_goods_info($dbo,$t_goods,'*',$goods_id,$shop_id);
if(empty($goods_info)) {
	trigger_error($m_langpackage->m_handle_err);//非法操作
}
$transport_template_list = get_transport_template_list($dbo,$t_goods_transport);
$category_info = get_category_info($dbo,$t_category);
$select_category_name="";
$asd_id=1;
$test1=0;
foreach($category_info as $value) {
	if($goods_info['cat_id']==$value['cat_id']) {
		$select_category_name = $value['cat_name'];
		$asd_id= $value['parent_id'];
		$test1=$value['cat_id'];
		if($asd_id!=0){
			$test1=$asd_id;
		}
		break;
	}
}

if($asd_id!=0){
	foreach($category_info as $value) {
		if($asd_id==$value['cat_id']) {
			$select_category_name = $value['cat_name']." > ".$select_category_name;
			$asd_id= $value['parent_id'];
			if($asd_id!=0){
				$test1=$asd_id;
			}
			break;
		}
	}
}
if($asd_id!=0){
	foreach($category_info as $value) {
		if($asd_id==$value['cat_id']) {
			$select_category_name = $value['cat_name']." > ".$select_category_name;
			$asd_id= $value['parent_id'];
			if($asd_id!=0){
				$test1=$asd_id;
			}
			break;
		}
	}
}
if($asd_id!=0){
	foreach($category_info as $value) {
		if($asd_id==$value['cat_id']) {
			$select_category_name = $value['cat_name']." > ".$select_category_name;
			$asd_id= $value['parent_id'];
			if($asd_id!=0){
				$test1=$asd_id;
			}
			break;
		}
	}
}

$shop_category = get_shop_category_list($dbo,$t_shop_category,$shop_id);
$html_shop_category = html_format_shop_category($shop_category,$goods_info['ucat_id']);

$attribute_info = array();
if($goods_info['cat_id']) {
	$attribute_info = get_attribute_info($dbo,$t_attribute,$goods_info['cat_id']);
}
$js_attribute_info = json_encode($attribute_info);

$goods_attr = get_goods_attr($dbo,$t_goods_attr,$goods_id);
/* 判断支付方式 */
$sql = "SELECT b.pay_id,b.pay_code FROM $t_shop_payment AS a, $t_payment AS b WHERE a.pay_id=b.pay_id AND a.shop_id=$shop_id AND a.enabled=1";
$isset_payment = $dbo->getRs($sql);

/** 取出图片 */
$sql2="select * from $t_image_size where goods_id=$goods_id";
$result = $dbo->fetch_page($sql2,10);
$imagelistid="";
if($result){
	foreach ($result['result'] as $v){
		$imagelistid.=$v['id'].",";
	}
	if($imagelistid){
		$imagelistid=substr($imagelistid,0,strlen($imagelistid)-1);
	}
}
set_session("goodsvercode",md5(rand(10000,999999)));
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo  $m_langpackage->m_u_center;?></title>

<link rel="stylesheet" type="text/css" href="skin/<?php echo  $SYSINFO['templates'];?>/css/modules.css">
<link rel="stylesheet" type="text/css" href="skin/<?php echo  $SYSINFO['templates'];?>/css/layout.css">
<link rel="stylesheet" type="text/css" href="skin/<?php echo  $SYSINFO['templates'];?>/css/style.css">

<link rel="stylesheet" type="text/css" href="skin/<?php echo  $SYSINFO['templates'];?>/css/common.css">
<script type="text/javascript" src="skin/<?php echo  $SYSINFO['templates'];?>/js/changeStyle.js"></script>
<script type="text/javascript" src="skin/<?php echo  $SYSINFO['templates'];?>/js/userchangeStyle.js"></script>

<style type="text/css">
.red { color:red; }
.edit span{background:#efefef;}
.search {margin:5px;}
.search input {color:#444;}
.clear {clear:both;}
td{text-align:left;}
#bgdiv { background-color:#333; position:absolute; width:980px; left:0px; top:0px; opacity:0.4; filter:alpha(opacity=40); height:1000px; z-index:960}
#category_select { width:800px; z-index:961; position:absolute; filter:alpha(opacity=95); left:100px; top:160px; background-color:#fff; height:270px}
.category_title_1 {background:#FFE1C2; color:#F67A06; padding-left:10px; line-height:25px; font-weight:bold; font-size:14px;}
.category_title_1 span {float:right; padding-right:5px; cursor:pointer;}
.ulselect {width:198px; height:210px; overflow-x:hidden; overflow-y:scroll; border:1px solid #efefef; float:left;}
.ulselect li {line-height:21px; padding-left:5px; cursor:pointer;width:100%;float:left;text-align:left;}
.ulselect li:hover {background:#F6A248; color:#fff;}
.ulselect li.select {background:#F6A248; color:#fff;}
.category_com {height:30px; line-height:30px; text-align:center;}
.attr_class { background:#FFF2E6; }
.attr_class div.div {border:2px solid #fff; padding:3px;}
.attr_class div span.left{display:block; width:150px; float:left; margin-left:10px; text-align:right; _line-height:24px;}
.attr_class div span.right{display:block; width:350px; float:left; margin-left:5px; text-align:left;}
.attr_class div span.right input {margin-left:5px;}

#picspan {width:82px; height:82px; padding:1px; border:1px solid #efefef; line-height:80px; text-align:center; display:inline-block; overflow:hidden; float:right;}
</style>
<script type="text/javascript" src="servtools/jquery-1.3.2.min.js?v=1.3.2"></script>
<script type="text/javascript" src="servtools/xheditor/xheditor.min.js?v=1.0.0-final"></script>
<link href="servtools/swfupload/css/default.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="servtools/swfupload/swfupload.js"></script>
<script type="text/javascript" src="servtools/swfupload/swfupload.queue.js"></script>
<script type="text/javascript" src="servtools/swfupload/fileprogress.js"></script>
<script type="text/javascript" src="servtools/swfupload/handlers.js"></script>
<script type="text/javascript">
		var swfu;

		window.onload = function() {
			var settings = {
				flash_url : "servtools/swfupload/swfupload.swf",
				upload_url: "swfupload.php",
				post_params: {"ps" : "<?php echo session_id(); ?>","gcv":"<?php echo  get_session('goodsvercode');?>","gid":"<?php echo  $goods_id;?>"},
				file_size_limit : "1 MB",
				file_types : "*.jpg;*.jpge;*.png;*.gif",
				file_types_description : "images Files",
				file_upload_limit : 30,
				file_queue_limit : 30,
				file_post_name:"Filedata[]",
				custom_settings : {
					progressTarget : "fsUploadProgress",
					cancelButtonId : "btnCancel"
				},
				debug: false,

				
				button_image_url: "servtools/swfupload/images/TestImageNoText_65x29.png",
				button_width: "65",
				button_height: "29",
				button_placeholder_id: "spanButtonPlaceHolder",
				button_text: '<span class="theFont">上传图片</span>',
				button_text_style: ".theFont { font-size: 12; }",
				button_text_left_padding: 5,
				button_text_top_padding: 3,
				button_window_mode : SWFUpload.WINDOW_MODE.OPAQUE,
				button_cursor : SWFUpload.CURSOR.HAND,
				
				
				file_queued_handler : fileQueued,
				file_queue_error_handler : fileQueueError,
				file_dialog_complete_handler : fileDialogComplete,
				upload_start_handler : uploadStart,
				upload_progress_handler : uploadProgress,
				upload_error_handler : uploadError,
				upload_success_handler : uploadGoodsSuccess,
				upload_complete_handler : uploadComplete,
				queue_complete_handler : queueComplete	// Queue plugin event
			};

			swfu = new SWFUpload(settings);
			bodyonload();
			menu_style_change('goods_list');
			changeMenu();
	     };
	</script>
<script type="text/javascript">
var introeditor;
$(function(){
	introeditor=$("#goods_intro").xheditor({skin:'vista',tools:"Cut,Copy,Paste,Pastetext,Separator,Blocktag,Fontface,FontSize,Bold,Italic,Underline,Strikethrough,FontColor,BackColor,SelectAll,Removeformat,Separator,Align,List,Outdent,Indent,Separator,Link,Unlink,Img,Table,Separator,Fullscreen,About"});

});

function introimage(id,imagepath){
	var is=$("#image_size_id").val();
	if(is==""){
		$("#image_size_id").val(id);
	}else{
		$("#image_size_id").val(is+","+id);
	}
	var imagestr="<li id='imgli'><p class='photo'><img src="+imagepath+" width='100' height='100' /></p><p><a href='javascript:;'  onclick='return addIntroImg(this)' >插入</a><a href='javascript:;' name='"+id+"' onclick='return delIntroImg(this)'>删除</a></p></li>";
	$("#introimage").append(imagestr);

}

function addIntroImg(obj){
    var li=$(obj).parent().parent().children(".photo").children("img").attr("src");
    var str=li.substring(li.indexOf("uploadfiles"));
	introeditor.appendHTML("<img src="+str+"/>");
	return false;
}

function delIntroImg(obj){
	if(!confirm('你真的要删除这张图片吗?')){
       return;
		}
	var path=$(obj).parent().parent().children(".photo").children("img").attr("src");
	var is=$("#image_size_id").val();
	var iid=$(obj).attr('name');
	if(is==""){
		return;
	}
    var param={
          iid:iid,
          path:path
    	  };
    $.post("do.php?act=del_goodsImage",param,function(data){
        if(data=='1'){
            	var is=$("#image_size_id").val();
          		var myArray=is.split(",");
          		var a;
          		for(i=0;i<myArray.length;i++){
                      if(myArray[i]==iid){
                      	a=i;
                      	break;
                        }
          		}
          		myArray.splice(a,1);
          		var isid=myArray.join(",");
          		$("#image_size_id").val(isid);
          		$(obj).parent().parent().remove();
             }else{
                alert('删除失败');
                 }
        });
}

function AddContentImg(ImgName,classId){
	var obj = document.getElementById("goods_intro").previousSibling.children[0];
	obj.innerHTML = obj.innerHTML + "<br><IMG src='./"+ImgName+"' /><br>";
}

function checkForm() {
	var goods_name = document.getElementsByName("goods_name")[0];
	var goods_price = document.getElementById("goods_price");
	var transport_price = document.getElementById("transport_price");
	var goods_number = document.getElementById("goods_number");

	var num = /^[0-9]+(.[0-9]*)?$/;

	if (document.getElementsByName("cat_id")[0].value==0){
		alert("<?php echo   $m_langpackage->m_select_categorypl;?>");
		return false;
	}else if (goods_name.value==''){
		alert("<?php echo  $m_langpackage->m_goodsname_notnone;?>");
		goods_name.focus();
		return false;
	}
	if (goods_price.value !=''){
		if (!goods_price.value.match(num)){
			alert('<?php echo $m_langpackage->m_goods_price_error;?>');
			goods_price.focus();
			return false;
		}
	}
	if(transport_price.value !=''){
		if (!transport_price.value.match(num)){
			alert("<?php echo $m_langpackage->m_transport_error;?>");
			transport_price.focus();
			return false;
		}
	}
	if (goods_number.value !=''){
		if(!goods_number.value.match(num)){
			alert('<?php echo $m_langpackage->m_store_form_error;?>');
			goods_number.focus();
			return false;
		}
	}
	return true;
}
</script>
</head>
<body>
<?php  require("shop/index_header.php");?>
	<div class="site_map">
	  <?php echo $m_langpackage->m_current_position;?><A href="index.php"><?php echo $SYSINFO['sys_name'];?></A>/<a href="modules.php"><?php echo $m_langpackage->m_u_center;?></a>/&nbsp;&nbsp;<?php echo $m_langpackage->m_edit_goods;?>
	</div>
    <div class="clear"></div>
	<?php  require("modules/left_menu.php");?>
    <div class="main_right">
    	<div class="right_top"></div>
        <div class="cont">
            <div class="cont_title">
            	<span class="tr_op">
					<a href="modules.php?app=goods_list" ><?php echo $m_langpackage->m_back_list;?></a>&nbsp;&nbsp;</span><?php echo $m_langpackage->m_edit_goods;?>
			</div><hr />
			<form action="do.php?act=goods_edit" method="post" name="form_goods_edit" onsubmit="return checkForm();" enctype="multipart/form-data">
				<table width="100%" style="border:0" cellspacing="0">
					<tr><td width="100"class="textright"><?php echo  $m_langpackage->m_goods_category;?>：</td>
						<td align="left">&nbsp;<span id="show_cat_name"><?php echo $select_category_name;?></span> &nbsp;&nbsp;<a href="javascript:;" onclick="showbgdiv();" style="color:#F1A24C; font-weight:bold;text-decoration:underline;"><?php echo $m_langpackage->m_edit_cateogry;?></a>
						<input name="cat_id" value="<?php echo  $goods_info['cat_id'];?>" type="hidden"></td>
					</tr>
					<tr>
						<td class="textright"><?php echo $m_langpackage->m_goods_brand;?>：</td>
						<td align="left" id="brand_box">&nbsp;</td>
					</tr>
					<tr>
						<td class="textright"><?php echo $m_langpackage->m_goods_type;?>：</td>
						<td align="left"><input type="radio" name="type_id" value="1" <?php if($goods_info['type_id']=='1'){?>checked<?php }?> /><?php echo $m_langpackage->m_goods_new;?> &nbsp;&nbsp;
						<input type="radio" name="type_id" value="2" <?php if($goods_info['type_id']=='2'){?>checked<?php }?> /><?php echo $m_langpackage->m_goods_notnew;?> &nbsp;&nbsp;
						<input type="radio" name="type_id" value="3" <?php if($goods_info['type_id']=='3'){?>checked<?php }?> /><?php echo $m_langpackage->m_goods_isnull;?> </span></td>
					</tr>
					<tr id="goods_attr_tr">
						<td class="textright"><?php echo $m_langpackage->m_goods_attr;?>：</td>
						<td align="left" class="attr_class" id="attr_content"></td>
					</tr>
					<tr>
						<td class="textright"><?php echo  $m_langpackage->m_goods_name;?>：</td>
						<td align="left"><input type="text" name="goods_name" value="<?php echo  $goods_info['goods_name'];?>" style="width:395px;" maxlength="200" /> <span class="red">*</span></td>
					</tr>
					<tr><td class="textright"><?php echo  $m_langpackage->m_shop_category;?>：</td>
						<td align="left"><select name="ucat_id">
							<option value="0"><?php echo $m_langpackage->m_select_cateogry;?></option>
							<?php echo  $html_shop_category;?>
						</select> <span class="red">*</span>
						<span id="ucate_add"><a href="javascript:;" onclick="showinput();"><?php echo   $m_langpackage->m_add_cat;?></a></span>
						<span id="ucate_span" style="display:none;"><input type="text" value="" style="width:115px; margin-right:10px" id="ucat_input" /><input class="submit" type="button" value="<?php echo   $m_langpackage->m_add;?>" onclick="addnewucat();" /></span></td>
					</tr>
					<tr>
						<td class="textright"><?php echo   $m_langpackage->m_goods_price;?>：</td>
						<td align="left"><input type="type" name="goods_price" id="goods_price" value="<?php echo   $goods_info['goods_price'];?>" style="width:80px;
							text-align:right;" maxlength="8" /> <?php echo   $m_langpackage->m_yuan;?> (<?php echo   $m_langpackage->m_goods_pricezero;?>)</td>
					</tr>
					<tr>
						<td class="textright"><?php echo $m_langpackage->m_stort_type;?>：</td>
						<td class="">
							<input type="radio" value="1" id="is_transport_template" onclick="chostransporttype(1)" <?php if($goods_info['is_transport_template']){?> checked  <?php }?>   name="is_transport_template" /> <?php echo $m_langpackage->m_is_transport_template;?>&nbsp;&nbsp;
							<input type="radio"  onclick="chostransporttype(0)" value="0" <?php if(!$goods_info['is_transport_template']){?> checked  <?php }?>   name="is_transport_template" /><?php echo   $m_langpackage->m_transport_price;?>
						</td>
					</tr>
					<?php if($goods_info['is_transport_template']){?>
						<tr id="transport1" style="">
					<?php  } else{?>
						<tr id="transport1" style="display:none;">
					<?php }?>
						<td class="textright"><?php echo $m_langpackage->m_postage_template;?>：</td>
						<td align="left">
						<?php if(is_array($transport_template_list)){?>
							<?php foreach($transport_template_list as $value){?>
								<input type="radio" name="transport_template_id"  value="<?php echo $value['id'];?>" <?php if($goods_info['transport_template_id']==$value['id']){?> checked <?php }?> /><?php echo $value['transport_name'];?>&nbsp;<a href="modules.php?app=edit_transport_template&id=<?php echo $value['id'];?>" target="_blank"><?php echo  $m_langpackage->m_eidt_transport_template;?></a><br />
							<?php }?>
						<?php }?>
						<br />
						<a href="modules.php?app=add_transport_template" target="_blank"><?php echo  $m_langpackage->m_add_transport_template;?></a>
						</td>
					</tr>
					<?php if(!$goods_info['is_transport_template']){?>
						<tr id="transport2" style="">
					<?php  } else{?>
						<tr id="transport2" style="display:none;">
					<?php }?>
						<td class="textright"><?php echo $m_langpackage->m_stort_expense;?>：</td>
						<td align="left"><input type="type" name="transport_price" id="transport_price" value="<?php echo   $goods_info['transport_price'];?>" style="width:80px; text-align:right;" maxlength="8" /> <?php echo $m_langpackage->m_yuan;?></td>
					</tr>
					<tr><td class="textright"><span id="picspan"><?php if($goods_info['goods_thumb']){?><img src="<?php echo $goods_info['goods_thumb'];?>" onerror="this.src='skin/default/images/nopic.gif'"/><?php  }else{?><?php echo  $m_langpackage->m_showgoods_photo;?><?php }?></span></td><td align="left"><input type="file" name="attach[]" onchange="showimg(this)" />
					<!-- <input type="button" value="使用已上传图片" onclick="get_img_list('img_select1','1','img_list1',this)"> <span class="red">*</span> --><br />
						<?php echo $m_langpackage->m_goods_picinfo;?><?php echo $SYSINFO['height2'];?></>x<?php echo $SYSINFO['width2'];?><?php echo $m_langpackage->m_px;?>
						<!-- <div id="img_select1" style="width:600px;  display:none;">
	                    	<span id="img_list1">

	                    	</span>
						</div> -->
					</td></tr>
					<tr><td valign="top" class="textright"><?php echo  $m_langpackage->m_goods_intro;?>：</td>
						<td style=" line-height:18px">
			                  <div class="index_tab">
			                	<ul>
			                      <li><a id="style1" style="font-size:12px;color:#333;font-weight:normal; text-decoration:none" class="current" href="javascript:;" onclick="change_style('style1')"><?php echo $m_langpackage->m_goods_intro;?></a></li>
			                      <li><a id="style2" style="font-size:12px;color:#333;font-weight:normal; text-decoration:none" href="javascript:;" onclick="change_style('style2');get_img_list('img_select3','2','img_list3',this)"><?php echo $m_langpackage->m_user_upload_pic;?></a></li>
			                    </ul>
			                  </div>
			                  <div id="display_order" class="tab_box">
								<textarea name="goods_intro" id="goods_intro" cols="65" rows="15"><?php echo  $goods_info['goods_intro'];?></textarea>
								<div id="img_select2" style="width:600px;">
			                    	<div id="img_list2" class="imgPan">
										<ul id="introimage" class="clearfix">
										<?php foreach($result['result'] as $v){?>
										<li>
											<p class="photo"><img src="<?php echo  $v['img_url'] ;?>" width="100" height="100" onerror="this.src='skin/default/images/nopic.gif'"/></p>
											<p><a href='javascript:;'  onclick='return addIntroImg(this)' >插入</a><a href='javascript:;' name='<?php echo $v["id"];?>' onclick='return delIntroImg(this)'>删除</a></p>
										</li>
										<?php }?>
										</ul>
			                    	</div>
								</div>
						<div id="fsUploadProgress">
						</div>
						<div id="divStatus"></div>
						<div>
							<span id="spanButtonPlaceHolder"></span>
							<input id="btnCancel" type="button" value="取消" onclick="swfu.cancelQueue();" disabled="disabled" style="display:none" />
							<input type="hidden" id="image_size_id" name="image_size_id" value="<?php echo  $imagelistid ;?>"/>
						</div>
						<span >按ctrl键选择多个文件</span>
							  </div>
			                  <div id="display_favorite" class="tab_box" style="display:none;">
								<div id="img_select3" style="width:600px;">
			                    	<div id="img_list3" class="imgPan">
										<ul id="introimage1" class="clearfix">
										<?php foreach($result['result'] as $v){?>
										<li>
											<p class="photo"><img src="<?php echo  $v['img_url'] ;?>" width="100" height="100" onerror="this.src='skin/default/images/nopic.gif'"/></p>
											<p><a href='javascript:;'  onclick='return addIntroImg(this)' >插入</a><a href='javascript:;' name='<?php echo $v["id"];?>' onclick='return delIntroImg(this)'>删除</a></p>
										</li>
										<?php }?>
										</ul>
			                    	</div>
								</div>
			                  </div>
					</td></tr>
					<tr><td class="textright"><?php echo   $m_langpackage->m_wholesale;?>：</td>
						<td align="left">
					<textarea name="goods_wholesale" cols="45" rows="3"><?php echo   $goods_info['goods_wholesale'];?></textarea>
					</td></tr>
					<tr><td class="textright"><?php echo   $m_langpackage->m_goods_number;?>：</td>
						<td align="left"><input type="type" name="goods_number" id="goods_number" value="<?php echo   $goods_info['goods_number'];?>" style="width:80px; text-align:right;" maxlength="5" /> <?php echo   $m_langpackage->m_jian;?></td></tr>
					<tr><td class="textright"><?php echo   $m_langpackage->m_keyword;?>：</td>
						<td align="left"><input type="type" name="keyword" value="<?php echo   $goods_info['keyword'];?>" style="width:250px;" maxlength="200" /> <?php echo $m_langpackage->m_more_keyword_exp;?></td></tr>
					<tr><td class="textright"><?php echo   $m_langpackage->m_on_sale;?>：</td>
						<td align="left"><input type="checkbox" name="is_on_sale" value="1" <?php if($goods_info['is_on_sale']){ echo "checked";}?>/> <?php echo   $m_langpackage->m_view_status;?></td></tr>
					<tr><td class="textright"><?php echo   $m_langpackage->m_add_recommend;?>：</td>
						<td align="left"><input type="checkbox" name="is_best" value="1" <?php if($goods_info['is_best']){ echo "checked";}?> />
						<?php echo   $m_langpackage->m_best;?>&nbsp;
						<input type="checkbox" name="is_promote" value="1" <?php if($goods_info['is_promote']){ echo "checked";}?> />
						<?php echo  $m_langpackage->m_promote;?>&nbsp;
						<input type="checkbox" name="is_new" value="1" <?php if($goods_info['is_new']){ echo "checked";}?> />
						<?php echo   $m_langpackage->m_new;?>&nbsp;
						<input type="checkbox" name="is_hot" value="1" <?php if($goods_info['is_hot']){ echo "checked";}?> />
						<?php echo   $m_langpackage->m_hot;?>&nbsp;
						<?php echo  $m_langpackage->m_set_num;?><?php echo $user_privilege['4'];?><?php echo  $m_langpackage->m_best;?>，<?php echo $user_privilege['5'];?><?php echo  $m_langpackage->m_promote;?>，<?php echo $user_privilege['6'];?><?php echo  $m_langpackage->m_new;?>，<?php echo $user_privilege['7'];?><?php echo  $m_langpackage->m_hot;?>，<?php echo  $m_langpackage->m_num_much;?>
					</td></tr>
					<tr><td colspan="2" class="center"><input type="hidden" name="goods_id" value="<?php echo   $goods_info['goods_id'];?>" />
					<input class="submit" type="submit" name="submit" value="<?php echo  $m_langpackage->m_edit_goods;?>" /></td></tr>
				</table>
			</form>
        </div>
    </div>
<div class="clear"></div>
<?php  require("shop/index_footer.php");?>
<div id="bgdiv" style="display:none;"></div>
<div id="category_select" style="display:none;">
		<div class="category_title_1">
		<?php if($isset_payment){?>
<!--		<span onclick="hidebgdiv();"><?php echo $m_langpackage->m_close;?></span>-->
		<?php echo $m_langpackage->m_plss_select_cateogry;?></div>
		<ul id="select_first" class="ulselect">
			<?php foreach($category_info as $k=>$v){?>
				<?php if($v['parent_id']==0){?>
				<li title="<?php echo  $v['cat_id'];?>" <?php if($test1==$v['cat_id']) {echo "class='select'"; }?>><?php echo  $v['cat_name'];?></li>
				<?php }?>
			<?php }?>
		</ul>
		<ul id="select_second" class="ulselect"></ul>
		<ul id="select_third" class="ulselect"></ul>
		<ul id="select_fourth" class="ulselect"></ul>
		<div class="category_com"><input type="button" value="<?php echo $m_langpackage->m_post;?>" onclick="postcatid();" /></div>
		<?php  } else {?>
		<span onclick="hidebgdiv();"><?php echo $m_langpackage->m_close;?></span>
		<?php echo $m_langpackage->m_plss_select_cateogry;?></div>
		<div align="center"><?php echo $m_langpackage->m_isset_payment;?></div>
		<?php }?>
	</div>
<script language="JavaScript" src="servtools/ajax_client/ajax.js"></script>
<script language="JavaScript">
<!--
var attribute = <?php echo  $js_attribute_info;?>;
var goodsAttr = new Array();
<?php if($goods_attr) {
	foreach($goods_attr as $v) {
		$v['attr_values'] = preg_replace("/[\r\n]+/",'|',$v['attr_values']);
		if(substr($v['attr_values'],'-1') == '|') {
			$v['attr_values'] = substr($v['attr_values'],'0','-1');
		}
		echo "goodsAttr['".$v['attr_id']."'] = '".$v['attr_values']."'; \r\n";
	}
}?>

var select_value = {'first':'','second':'','third':'','fourth':'','value':'0'};
var asd = '<?php echo  $select_category_name;?>';
var a,b,c,d=0;
var aaa,bbb,ccc,ddd ;
var prend_id = '<?php echo  $test1;?>';
var aaaa=document.getElementById("select_first");
function showbgdiv() {
	var bgdiv = document.getElementById("bgdiv");
	var goods_attr_tr = document.getElementById("goods_attr_tr");
	var category_select = document.getElementById("category_select");
	var ucat_id = document.getElementsByName("ucat_id")[0];
	var brand_box = document.getElementById("brand_box");
	ucat_id.style.display = "none";
	goods_attr_tr.style.display = "none";
	bgdiv.style.display = '';
	brand_box.style.display = 'none';
	category_select.style.display = '';
	var width = document.body.clientWidth;
	var left = "100";
	if(width) {
		left = (width-800)/2;
	}
	category_select.style.left = left+"px";
	bgdiv.style.left = (width-980)/2+"px";
	if(select_value.first==''){
		var asdarr=asd.split(' > ');
		for(var i=0;i<asdarr.length;i++){
			if(i==0){
				select_value.first=asdarr[i];
				aaa=asdarr[i];
				a=1;
				}
			if(i==1){
				select_value.second=' > '+asdarr[i];
				bbb=asdarr[i];
				b=1;
				}
			if(i==2){
				select_value.third=' > '+asdarr[i] ;
				ccc=asdarr[i];
				c=1;
				}
			if(i==3){
				select_value.fourth=' > '+asdarr[i];
				ddd=asdarr[i];
				d=1;
				}
			}
		}
	
	var test_id=0;
	if(b=1){
		var nextul = document.getElementById("select_second");
		if(nextul.innerHTML==''){
			ajax("do.php?act=category_get_catlist","POST","cat_id="+prend_id,function(data){
				if(data!='-1') {
					var newli;
					for(var i=0; i<data.length; i++) {
						aaaa=nextul;
						newli = document.createElement("li");
						newli.onclick = selectli;
						newli.title = data[i].cat_id;
						if(data[i].cat_name==bbb){
							newli.className = "select";
							if(c=1){
								var nextul1 = document.getElementById("select_third");
								if(nextul1.innerHTML==''){
									ajax("do.php?act=category_get_catlist","POST","cat_id="+data[i].cat_id,function(data1){
										if(data1!='-1') {
											var newli1;
											for(var j=0; j<data1.length; j++) {
												newli1 = document.createElement("li");
												aaaa=nextul1;
												newli1.onclick = selectli;
												newli1.title = data1[j].cat_id;
												if(data1[j].cat_name==ccc){
													newli1.className = "select";
													if(d=1){
														var nextul2 = document.getElementById("select_fourth");
														if(nextul2.innerHTML==''){
															ajax("do.php?act=category_get_catlist","POST","cat_id="+data1[j].cat_id,function(data2){
																if(data2!='-1') {
																	var newli2;
																	for(var k=0; k<data2.length; k++) {
																		newli2 = document.createElement("li");
																		aaaa=nextul2;
																		newli2.onclick = selectli;
																		newli2.title = data2[k].cat_id;
																		if(data2[k].cat_name==ccc){
																			newli2.className = "select";
																		}
																		newli2.innerHTML = data2[k].cat_name;
																		nextul2.appendChild(newli2);
																	}
																}
															},'JSON');
														}
													}
												}
												newli1.innerHTML = data1[j].cat_name;
												nextul1.appendChild(newli1);
											}
										}
									},'JSON');
								}
							}
						}
						newli.innerHTML = data[i].cat_name;
						nextul.appendChild(newli);
					}
				}
			},'JSON');
		}
	}
}

function hidebgdiv() {
	var bgdiv = document.getElementById("bgdiv");
	var category_select = document.getElementById("category_select");
	var goods_attr_tr = document.getElementById("goods_attr_tr");
	var ucat_id = document.getElementsByName("ucat_id")[0];
	var brand_box = document.getElementById("brand_box");
	ucat_id.style.display = "";
	bgdiv.style.display = 'none';
	category_select.style.display = 'none';
	brand_box.style.display = '';
	goods_attr_tr.style.display = "";
}

function bodyonload() {
	var cat_id = document.getElementsByName("cat_id")[0];
	if(cat_id.value>0) {
		get_brand_list(cat_id.value)
	} else {
		showbgdiv();
	}
	var lis = document.getElementsByTagName("li");
	for(var i=0; i<lis.length; i++) {
		lis[i].onclick = selectli;
	}
}

function selectli() {
	var tlis = this.parentNode.childNodes;
	for(var j=0; j<tlis.length; j++) {
		tlis[j].className = '';
	}
	this.className = "select";

	var nextul = null;
	if(this.parentNode.id=='select_first') {
		nextul = document.getElementById("select_second");
		select_value.first = this.innerHTML;
		select_value.second = '';
		select_value.third = '';
		select_value.fourth = '';
		nextul.innerHTML = '';
		document.getElementById("select_third").innerHTML = '';
		document.getElementById("select_fourth").innerHTML = '';
	} else if(this.parentNode.id=='select_second') {
		nextul = document.getElementById("select_third");
		select_value.second = ' > '+this.innerHTML;
		select_value.third = '';
		select_value.fourth = '';
		nextul.innerHTML = '';
		document.getElementById("select_fourth").innerHTML = '';
	} else if(this.parentNode.id=='select_third') {
		nextul = document.getElementById("select_fourth");
		select_value.third = ' > '+this.innerHTML;
		select_value.fourth = '';
		nextul.innerHTML = '';
	} else if(this.parentNode.id=='select_fourth'){
		select_value.fourth = ' > '+this.innerHTML;
	}
	select_value.value = this.title;
	if(nextul) {
		var cat_id = this.title;
		ajax("do.php?act=category_get_catlist","POST","cat_id="+cat_id,function(data){
			if(data!='-1') {
				var newli;
				for(var i=0; i<data.length; i++) {
					aaaa=nextul;
					newli = document.createElement("li");
					newli.onclick = selectli;
					newli.title = data[i].cat_id;
					newli.innerHTML = data[i].cat_name;
					nextul.appendChild(newli);
				}
			}
		},'JSON');
	}
}

function postcatid() {
	var tlis = aaaa.childNodes;
	var flag=false;
	for(var j=0; j<tlis.length; j++) {
		if(tlis[j].className == 'select'){
			flag=true;
			var cat_id = document.getElementsByName("cat_id")[0];
			var show_cat_name = document.getElementById("show_cat_name");
			show_cat_name.innerHTML = select_value.first + select_value.second + select_value.third + select_value.fourth;
			cat_id.value = select_value.value;
			changeAttr(select_value.value);
			hidebgdiv();
			}
	}
}

function changeAttr(value) {
	ajax("do.php?act=goods_attr_list","POST","v="+value,function(data){
		changeAttrTr(data);
	},'JSON');
}

function changeAttrTr(objvalue) {
	var attr_content = document.getElementById("attr_content");
	attr_content.innerHTML = '';
	var html = '';
	var temp = '';
	for(var i=0; i<objvalue.length; i++) {
		temp = formatFormElement(objvalue[i].attr_id,objvalue[i].input_type,objvalue[i].attr_name,objvalue[i].attr_values);
		html += '<div class="div"><span class="left">'+objvalue[i].attr_name+'：</span><span class="right">'+temp+'</span><div class="clear"></div></div>';
	}
	attr_content.innerHTML = html;
}

//属性input类型 0:TEXT,1:SELECT,2:radio,3:checkbox
function formatFormElement(id,type,name,value) {
	var optionValue;
	var cValue = str = '';
	if(goodsAttr[id]) {
		cValue = goodsAttr[id];
	}
	if(type==0) {
		str = '<input type="text" name="attr[' + id + ']" value="'+cValue+'" maxlength="200" />';
	} else if (type==1 && value!='') {
		optionValue = value.split("\r\n");
		str = '<select name="attr[' + id + ']">';
		str += '<option value="0"><?php echo  $m_langpackage->m_select_pl;?>' + name + '</option>';
		for(var i=0; i<optionValue.length; i++) {
			if(optionValue[i] == cValue) {
				str += '<option value="'+optionValue[i]+'" selected>' + optionValue[i] + '</option>';
			} else {
				str += '<option value="'+optionValue[i]+'">' + optionValue[i] + '</option>';
			}
		}
		str += '</select>';
	} else if (type==2 && value!='') {
		optionValue = value.split("\r\n");
		for(var i=0; i<optionValue.length; i++) {
			if(optionValue[i] == cValue) {
				str += '<input type="radio" name="attr[' + id + ']" value="'+optionValue[i]+'" checked />' + optionValue[i] + ' ';
			} else {
				str += '<input type="radio" name="attr[' + id + ']" value="'+optionValue[i]+'" />' + optionValue[i] + ' ';
			}
		}
	} else if (type==3 && value!='') {
		var regv = cValue.replace(/[\r\n]/g,"|");
		if(regv) {
			var re = new RegExp("(("+regv+")|([^\r\n]+))[\r\n]*","g");
		} else {
			var re = new RegExp("((iwebshop)|([^\r\n]+))[\r\n]*","g");
		}
		var str = value.replace(re,"<input type='checkbox' name='attr[" + id + "][]' value='$1' checked$3 />$1 ");
	}
	return str;
}

changeAttrTr(attribute);

function showimg(obj) {
	var picspan = document.getElementById("picspan");
	picspan.innerHTML = '';
	var Img = new Image();
	Img.id = "goods_pic";

	if(navigator.userAgent.indexOf("MSIE")>0) {
		Img.src = obj.value;
	} else {
		Img.src = obj['files'][0].getAsDataURL();
	}
	picspan.appendChild(Img);
	//imgwh();
	setTimeout("imgwh()",100);
}

function imgwh() {
	var Img = document.getElementById("goods_pic");
	var w = Img.width;
	var h = Img.height
	if(w>h) {
		Img.height = h*80/w;
		Img.width = '80';
		Img.style.marginTop = (80-Img.height)/2+'px';
	} else {
		Img.width = w*80/h;
		Img.height = '80';
	}
}

function showinput() {
	var ucate_add = document.getElementById("ucate_add");
	var ucate_span = document.getElementById("ucate_span");
	ucate_add.style.display = 'none';
	ucate_span.style.display = '';
}
function hideinput() {
	var ucate_add = document.getElementById("ucate_add");
	var ucate_span = document.getElementById("ucate_span");
	ucate_add.style.display = '';
	ucate_span.style.display = 'none';
}

function addnewucat() {
	var ucat_input = document.getElementById("ucat_input");
	var ucat_id = document.getElementsByName("ucat_id")[0];
	v = ucat_input.value;
	if(v=='') {
		alert("<?php echo  $m_langpackage->m_categoryname_notnone;?>");
		return false;
	} else {
		ajax("do.php?act=goods_ucategory_add","POST","name="+v,function(data){
			if(data!='-1') {
				var newoption = document.createElement("option");
				newoption.value = data;
				newoption.innerHTML = v;
				newoption.selected = 'selectes';
				ucat_id.appendChild(newoption);
				alert("<?php echo  $m_langpackage->m_add_success;?>");
			} else {
				alert("<?php echo  $m_langpackage->m_add_fail;?>");
			}
		},'JSON');
		hideinput();
	}
}
function get_brand_list(cat_id_value){
	ajax("do.php?act=get_brand_list&cat_id="+cat_id_value,"POST","",function(data){
		var str="<select name='brand_id'>";
		for(i=0;i<data.length;i++){
			str+="<option value='"+data[i].brand_id+"'";
			if(data[i].brand_id==<?php echo $goods_info['brand_id'];?>){
				str+="selected";
			}
			str+=">"+data[i].brand_name+"</option>";
		}
		str+="<option value='0'><?php echo $m_langpackage->m_other_brand;?></option>";
		str+="</select>";
		document.getElementById("brand_box").innerHTML=str;
		document.getElementById("brand_box").style.display='';
	},'JSON');
}
function chostransporttype(m){
	var obj=document.form_goods_edit;
	var radioobj=document.getElementsByName("transport_template_id");
	if(m==1){
		obj.transport_price.value=0.00;
		document.getElementById("is_transport_template").checked=true;
		document.getElementById("transport1").style.display='';
		document.getElementById("transport2").style.display='none';
		var b=0;
		for(i=0;i<radioobj.length;i++){
			if(radioobj[i].checked){
				b++;
			}
		}
		if(b!=0){
			radioobj[0].checked=true;
		}
	}else{
		document.getElementById("transport2").style.display='';
		document.getElementById("transport1").style.display='none';
		for(i=0;i<radioobj.length;i++){
			radioobj[i].checked=false;
		}
	}
}
function change_style(flag) {
	if (flag =='style1'){
		document.getElementById('style1').className="current";
		document.getElementById('style2').className="";
		document.getElementById('display_order').style.display="block";
		document.getElementById('display_favorite').style.display="none";
	}
	if (flag =='style2'){
		document.getElementById('style1').className="";
		document.getElementById('style2').className="current";
		document.getElementById('display_order').style.display="none";
		document.getElementById('display_favorite').style.display="block";
	}
}
function get_img_list(itemid,i,imgid,page){
	ajax("do.php?act=shop_img_select","POST","page="+page,function(data){
		document.getElementById(imgid).innerHTML = data;
		var a=data.substring(0,data.indexOf("</span>"));
		var b=a.substring(a.indexOf(">")+1);
		document.getElementById("image_size_id").value=b;
	});

}
//-->
</script>
</body>
</html><?php } ?>