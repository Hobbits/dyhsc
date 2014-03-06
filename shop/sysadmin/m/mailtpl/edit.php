<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

//引入语言包
$a_langpackage=new adminlp;

require("../foundation/module_mailtpl.php");

//数据表定义区
$t_mailtpl = $tablePreStr."mailtpl";

$id = intval(get_args('id'));

//定义读操作
dbtarget('r',$dbServs);
$dbo=new dbex;

$row = get_tplid($dbo,$t_mailtpl,$id);
//print_r($row);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link rel="stylesheet" type="text/css" href="skin/css/admin.css">
<link rel="stylesheet" type="text/css" href="skin/css/main.css">
<script type="text/javascript" src="../servtools/jquery-1.3.2.min.js?v=1.3.2"></script>
<script type="text/javascript" src="skin/xheditor/xheditor.min.js?v=1.0.0-final"></script>
<script type="text/javascript">
var introeditor;
$(function(){
	introeditor=$("#tplcontent").xheditor({skin:'vista',tools:"Cut,Copy,Paste,Pastetext,Separator,Blocktag,Fontface,FontSize,Bold,Italic,Underline,Strikethrough,FontColor,BackColor,SelectAll,Removeformat,Separator,Align,List,Outdent,Indent,Separator,Link,Unlink,Img,Table,Separator,Fullscreen,About"});

});
</script>
</head>
<body>
<div id="maincontent">
	<div class="wrap">
	<div class="crumbs"><?php echo $a_langpackage->a_location; ?> &gt;&gt; <?php echo $a_langpackage->a_global_settings; ?> &gt;&gt; <?php echo $a_langpackage->a_mailtpl_edit; ?></div>
        <hr />
	<div class="infobox">
	<h3><span class="left"><?php echo $a_langpackage->a_mailtpl_edit; ?></span> <span class="right" style="margin-right:15px;" ><a href="m.php?app=mailtpl_set"><?php echo $a_langpackage->a_mailtpl_list; ?></a></span></h3>
    <div class="content2">
		<form name="cpform" method="post" action="a.php?act=mailtpl_upd" >
		<input type="hidden" name="id" value="<?php echo $id?>" />
		<table class="form-table">
            <tr><td width="55px"><?php echo $a_langpackage->a_mail_name; ?>:</td>
            <td><input class="small-text" name="tpl_title" value="<?php echo $row['tpl_title']?>" type="text" style="width:520px" /></td></tr>
            <tr><td><?php echo $a_langpackage->a_mail_content; ?>:</td>
            <td><textarea name="tpl_content" id="tplcontent" cols="75" rows="15"><?php echo $row['tpl_content']?></textarea></td>
            <tfoot>
            	<tr><td colspan="2"><input type="submit" class="regular-button" value="<?php echo $a_langpackage->a_mail_post; ?>" /></td></tr>
			</tfoot>
		</table>
		</form>
		</div>
	   </div>
     </div>
</div>
</body>
</html>