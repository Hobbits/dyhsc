<?php
/*
 * 注意：此文件由itpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/modules/shop/protect_rights.html
 * 如果您的模型要进行修改，请修改 models/modules/shop/protect_rights.php
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
if(filemtime("templates/default/modules/shop/protect_rights.html") > filemtime(__file__) || (file_exists("models/modules/shop/protect_rights.php") && filemtime("models/modules/shop/protect_rights.php") > filemtime(__file__)) ) {
	tpl_engine("default","modules/shop/protect_rights.html",1);
	include(__file__);
} else {
/* debug模式运行生成代码 结束 */
?><?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}
require("foundation/acheck_shop_creat.php");
require("foundation/module_order.php");
require("foundation/module_goods.php");

//语言包引入
$m_langpackage=new moduleslp;
$s_langpackage=new shoplp;

//数据表定义区
$t_order_info = $tablePreStr."order_info";
$t_users = $tablePreStr."users";
$t_order_goods = $tablePreStr."order_goods";
$t_goods = $tablePreStr."goods";
$t_protect_rights = $tablePreStr."protect_rights";
$order_id = intval(get_args('id'));
if(!$order_id) { exit($m_langpackage->m_handle_err); }

//定义写操作
dbtarget('w',$dbServs);
$dbo=new dbex;

//判断商品是否锁定，锁定则不许操作
$sql="select b.goods_id,a.transport_type from $t_order_info as a join $t_order_goods as b on a.order_id=b.order_id where a.order_id=$order_id";
$row1=$dbo->getRow($sql);
if($row1){
	$goods_id=$row1['goods_id'];
}
include("foundation/fgoods_locked.php");

//判断用户是否锁定，锁定则不许操作
$sql ="select locked from $t_users where user_id=$user_id";
$row = $dbo->getRow($sql);
if($row['locked']==1){
	session_destroy();
	trigger_error($m_langpackage->m_user_locked);//非法操作
}

//判断订单是否存在，锁定则不许操作
$sql="select * from $t_order_info where order_id=$order_id and shop_id = $user_id";
$order_info = $dbo->getRow($sql);

if(!$order_info) {
	action_return(0,$m_langpackage->m_noex_thisorder);
}

//判断订单状态，锁定则不许操作
if($order_info['order_status']=='0') 
{
	action_return(0,$m_langpackage->m_order_cancel);
}
elseif($order_info['protect_status']=='0') 
{
	action_return(0,'用户没有申请维权！');
}

set_session("goodsvercode",md5(rand(10000,999999)));

$sql = "select *from `$t_protect_rights` where order_id = $order_id order by protect_date desc";
$result = $dbo->getRs($sql);

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo  $m_langpackage->m_u_center;?></title>
<link rel="stylesheet" type="text/css" href="skin/<?php echo  $SYSINFO['templates'];?>/css/style.css">
<script type="text/javascript" src="skin/<?php echo  $SYSINFO['templates'];?>/js/changeStyle.js"></script>
<script type="text/javascript" src="skin/<?php echo  $SYSINFO['templates'];?>/js/userchangeStyle.js"></script>
<script type="text/javascript" src="servtools/jquery-1.3.2.min.js?v=1.3.2"></script>
<script type="text/javascript" src="servtools/xheditor/xheditor.min.js?v=1.0.0-final"></script>

<script type="text/javascript" src="servtools/swfupload/swfupload.js"></script>
<script type="text/javascript" src="servtools/swfupload/swfupload.queue.js"></script>
<script type="text/javascript" src="servtools/swfupload/fileprogress.js"></script>
<script type="text/javascript" src="servtools/swfupload/handlers.js"></script>
<script type="text/javascript">
		var swfu;

		function winload() {
			var settings = {
				flash_url : "servtools/swfupload/swfupload.swf",
				upload_url: "swfupload.php",
				post_params: {"ps" : "<?php echo session_id(); ?>","gcv":"<?php echo  get_session('goodsvercode');?>"},
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
	     };
		 if (document.all){
			window.attachEvent('onload',winload)//IE中
			}
		else{
			window.addEventListener('load',winload,false);//firefox
			}
</script>
<script type="text/javascript">
var introeditor;
$(function(){
	introeditor=$("#protect_content").xheditor({skin:'vista',tools:"Cut,Copy,Paste,Pastetext,Separator,Blocktag,Fontface,FontSize,Bold,Italic,Underline,Strikethrough,FontColor,BackColor,SelectAll,Removeformat,Separator,Align,List,Outdent,Indent,Separator,Link,Unlink,Img,Table,Separator,Fullscreen,About"});

});
function introimage(id,imagepath){
	var imagestr="<li id='imgli'><p class='photo'><img src="+imagepath+" width='100' height='100' /></p><p><a href='javascript:;'  onclick='return addIntroImg(this)' >插入</a><a href='javascript:;' name='"+id+"' onclick='return delIntroImg(this)'>删除</a></p></li>";
	$("#introimage").append(imagestr);

}
function checkeck(){
	var protect_content1 = $.trim($("#protect_content").val());
	if(protect_content1==""){
		alert("维权内容不能为空！");
		return false;
	}
}
function delIntroImg(obj){
	if(!confirm('你真的要删除这张图片吗?')){
       return;
		}
	var path=$(obj).parent().parent().children(".photo").children("img").attr("src");
	var iid=$(obj).attr('name');
    var param={
          iid:iid,
          path:path
    	  };
    $.post("do.php?act=del_goodsImage",param,function(data){
        if(data=='1'){
          		$(obj).parent().parent().remove();
             }else{
                alert('删除失败');
              }
        });
}
function addIntroImg(obj){
    var li=$(obj).parent().parent().children(".photo").children("img").attr("src");
    var str=li.substring(li.indexOf("uploadfiles"));
	introeditor.appendHTML("<img src="+str+"/>");
	return false;
}

</script>
<style type="text/css">
.list .master{
	background-color:#FFEFE8}
.list .ttls{
	font-weight:bolder;
	border-bottom:2px solid #FF6600}
.list .txt{
	padding:5px 0  0 15px}	
.list .master,.list .customer{
	padding:10px 15px}	
</style>
</head>
<body onload="menu_style_change('shop_my_order');changeMenu();">
<?php  require("shop/index_header.php");?>
<div class="site_map"> <?php echo $m_langpackage->m_current_position;?><A href="index.php"><?php echo $SYSINFO['sys_name'];?></A>/<a href="modules.php"><?php echo $m_langpackage->m_u_center;?></a>/&nbsp;&nbsp;商铺退款 </div>
<div class="clear"></div>
<?php  require("modules/left_menu.php");?>
<div class="main_right">
	<div class="right_top"></div>
	<div class="cont">
		<div >
			<h3 class="cont_title">维权信息</h3>
		</div>
		<hr />
		<form action="do.php?act=shop_protect_rights&id=<?php echo $order_id;?>" method="post"  onsubmit="return checkeck();">
			<table class="form_table_02">
				<tr>
					<th colspan="2" width="5%">维权内容:</th>
				</tr>
				<tr>
					<td  colspan="2">
					 <div id="display_order" class="tab_box">
					<textarea type="text" id="protect_content" name="protect_content"  cols="73" rows="15" ></textarea>
						<div id="img_select2" style="width:600px;">
							<div id="img_list2" class="imgPan">
								<ul id="introimage" class="clearfix">
								</ul>
							</div>
						</div>
						<div id="fsUploadProgress"></div>
						<div id="divStatus"></div>
						<div> <span id="spanButtonPlaceHolder"></span> <input id="btnCancel" type="button" value="取消" onclick="swfu.cancelQueue();" disabled="disabled" style="display:none" /> </div>
						<span >按ctrl键选择多个文件</span></div></td>
				</tr>
				<tr>
					<th>是否同意:</th>
				
					<td><select name="agree">
							<option value='1'>同意</option>
							<option value='0'>不同意</option>
						</select></td>
				</tr>
			
				<tr>
					<td colspan="2"><input type="submit" value="<?php echo  $m_langpackage->m_send;?>"/></td>
				</tr>
			</table>
		</form>
	 <ul class="list">
		<?php if(!empty($result)) {
			foreach($result as $v) {?>
				<li <?php if($v['user_type']==0) {?> class="customer" <?php } else {?> class="master" <?php }?>>
					<p class="ttls" >
						<?php if($v['user_type']==0) {?>
							客户
						<?php } else {?>
							我
						<?php }?>
						于 <?php echo $v['protect_date'];?> 
						<?php if($v['status']==1) {?> 
							<font color="red">同意客户的维权</font>并且
						<?php }?>
						说：
					</p>
					<p class="txt"><?php echo $v['content'];?></p>
				</li>
			<?php }?>
		<?php } else {?>
			<li class="customer"><p class="txt"><?php echo  $m_langpackage->m_nolist_record;?></p></li>
		<?php }?>
	 </ul>
	</div>
</div>
<div class="clear"></div>
<?php  require("shop/index_footer.php");?>
</body>
</html><?php } ?>