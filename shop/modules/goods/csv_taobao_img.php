<?php
/*
 * 注意：此文件由itpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/modules/goods/csv_taobao_img.html
 * 如果您的模型要进行修改，请修改 models/modules/goods/csv_taobao_img.php
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
if(filemtime("templates/default/modules/goods/csv_taobao_img.html") > filemtime(__file__) || (file_exists("models/modules/goods/csv_taobao_img.php") && filemtime("models/modules/goods/csv_taobao_img.php") > filemtime(__file__)) ) {
	tpl_engine("default","modules/goods/csv_taobao_img.html",1);
	include(__file__);
} else {
/* debug模式运行生成代码 结束 */
?><?php
if(!$IWEB_SHOP_IN) {
	trigger_error('Hacking attempt1');
}
//引入语言包
$m_langpackage=new moduleslp;
$i_langpackage=new indexlp;

set_session("goodsvercode",md5(rand(10000,999999)));

?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?php echo  $m_langpackage->m_u_center;?></title>
<link rel="stylesheet" type="text/css" href="skin/<?php echo  $SYSINFO['templates'];?>/css/modules.css">
<link rel="stylesheet" type="text/css" href="skin/<?php echo  $SYSINFO['templates'];?>/css/layout.css">
<link rel="stylesheet" type="text/css" href="skin/<?php echo  $SYSINFO['templates'];?>/css/style.css">
<script type="text/javascript" src="skin/<?php echo  $SYSINFO['templates'];?>/js/userchangeStyle.js"></script>
<style type="text/css">
.red { color:red; }
.edit span{background:#efefef;}
.search {margin:5px;}
.search input {color:#444;}
.clear {clear:both;}
td{text-align:left;}
#bgdiv { background-color:#333; position:absolute; width:965px; left:230px; top:130px; opacity:0.4; filter:alpha(opacity=40); height:1313px; z-index:960}
#category_select { width:680px; z-index:961; position:absolute; filter:alpha(opacity=95); left:400px; top:350px; background-color:#fff; height:270px}
.category_title_1 {background:#FFE1C2; color:#F67A06; padding-left:10px; line-height:25px; font-weight:bold; font-size:14px;}
.category_title_1 span {float:right; padding-right:5px; cursor:pointer;}
.ulselect {width:168px; height:200px; overflow-x:hidden; margin-bottom:10px; overflow-y:scroll; border:1px solid #efefef; float:left;}
.ulselect li {line-height:21px; padding-left:5px; cursor:pointer;width:100%;float:left;text-align:left;}
.ulselect li:hover {background:#F6A248; color:#fff;}
.ulselect li.select {background:#F6A248; color:#fff;}
.category_com {height:30px; padding-bottom:10px; line-height:30px; text-align:center;}
.attr_class { background:#FFF2E6; }
.attr_class div.div {border:2px solid #fff; padding:3px;}
.attr_class div span.left{display:block; width:150px; float:left; margin-left:10px; text-align:right; _line-height:24px;}
.attr_class div span.right{display:block; width:350px; float:left; margin-left:5px; text-align:left;}
.attr_class div span.right input {margin-left:5px;}

#picspan {width:82px; height:82px; padding:1px; border:1px solid #efefef; line-height:80px; text-align:center; display:inline-block; overflow:hidden; float:right;}
</style>

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
		post_params: {"ps" : "<?php echo session_id(); ?>","gcv":"<?php echo  get_session('goodsvercode');?>","act":"csvtaobao"},
		file_size_limit : "1 MB",
		file_types : "*.tbi",
		file_types_description : "tbi Files",
		file_upload_limit : 1000,
		file_queue_limit : 1000,
		file_post_name:"Filedata[]",
		custom_settings : {
			progressTarget : "fsUploadProgress",
			cancelButtonId : "btnCancel"
		},
		debug: false,

		
		button_image_url: "servtools/swfupload/images/TestImageNoText_65x291.png",
		button_width: "100",
		button_height: "40",
		button_placeholder_id: "spanButtonPlaceHolder",
		button_text: '<span class="theFont"></span>',
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
		upload_success_handler : uploadSuccess,
		upload_complete_handler : uploadComplete,
		queue_complete_handler : queueComplete	// Queue plugin event
	};

	swfu = new SWFUpload(settings);

	menu_style_change('goods_list');
	changeMenu();
 };
</script>
</head>
<body>
	<?php  require("shop/index_header.php");?>
	<div class="site_map">
	  <?php echo $m_langpackage->m_current_position;?><A href="index.php"><?php echo $SYSINFO['sys_name'];?></A>/<a href="modules.php"><?php echo $m_langpackage->m_u_center;?></a>/&nbsp;&nbsp;<?php echo  $m_langpackage->m_add_newgoods;?>
	</div>
    <div class="clear"></div>
    <?php  require("modules/left_menu.php");?>
     <div class="main_right">
    	<div class="right_top"></div>
        <div class="cont">
            
			<div class="cont_title"><span class="tr_op">
				<a href="modules.php?app=goods_list"><?php echo  $m_langpackage->m_back_list;?></a>
				</span>上传tbi文件
			</div>
            <hr />
            

						<div id="img_select2" style="width:600px;">
	                    	<div id="img_list2" class="imgPan">
								<ul id="introimage" class="clearfix"></ul>
	                    	</div>
						</div>
						<div id="fsUploadProgress">
			
			</div>
		<div id="divStatus"></div>
		
			<div>
				<span id="spanButtonPlaceHolder"></span>
				
				<input id="btnCancel" type="button" value="取消" onclick="swfu.cancelQueue();" disabled="disabled" style="display:none" />
				<input type="hidden" id="image_size_id" name="image_size_id" value=""/>
			</div><span >可同时选择多个tbi文件</span>     
           
           
    </div>
    </div>
    
</body>
</html><?php } ?>