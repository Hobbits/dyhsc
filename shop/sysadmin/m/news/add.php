<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

require_once("../foundation/module_news.php");

//引入语言包
$a_langpackage=new adminlp;

//定义读操作
dbtarget('r',$dbServs);
$dbo=new dbex;

//数据表定义区
$t_article = $tablePreStr."article";
$t_article_cat = $tablePreStr."article_cat";

$cat_info = get_news_cat_list($dbo,$t_article_cat);

$news_info = array(
	'cat_id'		=> 0,
	'title'			=> '',
	'content'		=> '',
	'is_link'		=> '',
	'link_url'		=> 'http://',
	'is_show'		=> 1
);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
	introeditor=$("#content").xheditor({skin:'vista',tools:"Cut,Copy,Paste,Pastetext,Separator,Blocktag,Fontface,FontSize,Bold,Italic,Underline,Strikethrough,FontColor,BackColor,SelectAll,Removeformat,Separator,Align,List,Outdent,Indent,Separator,Link,Unlink,Img,Table,Separator,Source,Fullscreen,About"});

});
</script>

</head>
<body>
<div id="maincontent"><?php  include("messagebox.php");?>
<div class="wrap">
<div class="crumbs"><?php echo $a_langpackage->a_location; ?> &gt;&gt; <?php echo $a_langpackage->a_promotion_manage;?>
&gt;&gt; <a href=""><?php echo $a_langpackage->a_news_add; ?></a></div>
<hr />
<div class="infobox">
<h3><span class="left"><?php echo $a_langpackage->a_news_add; ?></span><span
	class="right" style="margin-right: 15px;"><a href="m.php?app=news_list"><?php echo $a_langpackage->a_news_list; ?></a></span></h3>
<div class="content2">

<form action="a.php?act=news_add" method="post"
	onsubmit="return checkForm();">
<table class="form-table">
	<tr>
		<td width="75px"><?php echo $a_langpackage->a_select_n_category; ?>：</td>
		<td><select name="cat_id">
			<option value="0"><?php echo $a_langpackage->a_select_n_category; ?></option>
			<?php foreach($cat_info as $value) {?>
			<option value="<?php echo $value['cat_id']; ?>"
			<?php if($value['cat_id']==$news_info['cat_id']){ echo "selected";} ?>><?php echo $value['cat_name']; ?></option>
			<?php }?>
		</select> <span id="position_id_message">*</span></td>
	</tr>
	<tr>
		<td><?php echo $a_langpackage->a_news_title; ?>：</td>
		<td><input class="small-text" type="text" name="title"
			value="<?php echo $news_info['title']; ?>" style="width: 200px;" /> <span
			id="asd_name_message">*</span></td>
	</tr>

	<tr>
		<td><?php echo $a_langpackage->a_title_color; ?>：</td>
		<td><input type="text" style="background: #" name="tilte_color"
			value="" onclick="coloropen(event)" id="inputcolor" />
		<div id="colorpane"
			style="position: absolute; z-index: 999; display: none;"></div>
		</td>
	</tr>
	<tr>
		<td><?php echo $a_langpackage->a_whether_bold; ?>：</td>
		<td><input type="checkbox" name="is_blod" value="1"></td>
	</tr>
	<tr>
		<td><?php echo $a_langpackage->a_title_desc; ?>：</td>
		<td><input type="text" class="small-text" name="short_order" value="" /></td>
	</tr>

	<tr>
		<td valign="top"><?php echo $a_langpackage->a_news_content; ?>：</td>
		<td style="line-height: 18px;"><textarea name="content" id="content"
			cols="90" rows="15"><?php echo $news_info['content'];?></textarea> <iframe
			name="KindImageIframe" id="KindImageIframe" width="90%" height='30'
			align="top" allowTransparency="true" scrolling="no"
			src='m.php?app=upload_form' frameborder=0></iframe></td>
	</tr>
	<tr>
		<td><?php //echo $a_langpackage->a_news_links; ?></td>
		<td><?php //echo $a_langpackage->a_use_news_links; ?><input
			type="hidden" name="is_link" value="1"
			<?php if($news_info['is_link']){ echo "checked"; }?> /></td>
	</tr>
	
	<tr>
		<td><?php echo $a_langpackage->a_news_isshow; ?>：</td>
		<td><input type="checkbox" name="is_show" value="1"
		<?php if($news_info['is_show']){ echo "checked"; }?> /></td>
	</tr>
	<tr>
		<td colspan="2"><span class="button-container"><input
			class="regular-button" type="submit" name="submit"
			value="<?php echo $a_langpackage->a_news_add; ?>" /></span></td>
	</tr>
</table>
</form>
</div>
</div>
</div>
</div>
<script language="JavaScript">
<!--
var ColorHex=new Array('00','33','66','99','CC','FF')
var SpColorHex=new Array('FF0000','00FF00','0000FF','FFFF00','00FFFF','FF00FF')
var current=null
function initcolor(evt)
{
var colorTable=''
for (i=0;i<2;i++)
{
for (j=0;j<6;j++)
{
colorTable=colorTable+'<tr height=15>'
colorTable=colorTable+'<td width=10 style="background-color:#000000">'
if (i==0){
colorTable=colorTable+'<td width=10 style="cursor:pointer;background-color:#'+ColorHex[j]+ColorHex[j]+ColorHex[j]+'" onclick="doclick(this.style.backgroundColor)">'}
else{
colorTable=colorTable+'<td width=10 style="cursor:pointer;background-color:#'+SpColorHex[j]+'" onclick="doclick(this.style.backgroundColor)">'}
colorTable=colorTable+'<td width=10 style="background-color:#000000">'
for (k=0;k<3;k++)
{
for (l=0;l<6;l++)
{
colorTable=colorTable+'<td width=10 style="cursor:pointer;background-color:#'+ColorHex[k+i*3]+ColorHex[l]+ColorHex[j]+'" onclick="doclick(this.style.backgroundColor)">'
}
}
}
}
colorTable='<table border="0" cellspacing="0" cellpadding="0" style="border:1px #000000 solid;border-bottom:none;border-collapse: collapse;width:200px;" bordercolor="000000">'
+'<tr height=20><td colspan=21 bgcolor=#ffffff style="font:12px tahoma;padding-left:2px;">'
+'<span style="float:left;color:#999999;"><?php echo $a_langpackage->a_color_select;?></span>'
+'<span style="float:right;padding-right:3px;cursor:pointer;" onclick="colorclose()">×<?php echo $a_langpackage->a_close;?></span>'
+'</td></table>'
+'<table border="1" cellspacing="0" cellpadding="0" style="border-collapse: collapse" bordercolor="000000" style="cursor:pointer;">'
+colorTable+'</table>';
document.getElementById("colorpane").innerHTML=colorTable;
var current_x = document.getElementById("inputcolor").offsetLeft;
var current_y = document.getElementById("inputcolor").offsetTop;
//alert(current_x + "-" + current_y)
document.getElementById("colorpane").style.left = current_x + "px";
document.getElementById("colorpane").style.top = current_y + "px";
}
function doclick(obj){
	document.getElementById('inputcolor').value=obj;
	document.getElementById('inputcolor').style.background=obj;
	colorclose();
}
function colorclose(){
document.getElementById("colorpane").style.display = "none";
}
function coloropen(){
document.getElementById("colorpane").style.display = "";
}
window.onload = initcolor;

function checkForm() {
	var title = document.getElementsByName("title")[0];
	//var site_url = document.getElementsByName('link_url')[0];
	//var checkfiles=new RegExp("((^http)|(^https)|(^ftp)):\/\/(\\w)+\.(\\w)+");
//	if(site_url.value!='') {
//		if(!checkfiles.test(site_url.value)) {
//			ShowMessageBox("<?php echo $a_langpackage->a_brand_site_url_error; ?>",'0');
//			return false;
//		}
//	}
	if(title.value=='') {
		ShowMessageBox("<?php echo $a_langpackage->a_news_title_notnone; ?>",'0');
		title.focus();
		return false;
	} else if(document.getElementsByName("cat_id")[0].value==0) {
		ShowMessageBox("<?php echo $a_langpackage->a_plsselectcategory; ?>",'0');
		return false;
	}
	return true;
}
function AddContentImg(ImgName,classId){
	introeditor.appendHTML("<img src=../"+ImgName+"/><br>");
}
function AddContentImg2(ImgName,classId){
	introeditor.appendHTML("<img src="+ImgName+"/><br>");
}
//-->
</script>
</body>
</html>
