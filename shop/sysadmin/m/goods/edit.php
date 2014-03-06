<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

require_once("../foundation/module_goods.php");
//引入语言包
$a_langpackage=new adminlp;

$goods_id = intval(get_args('goods_id'));
if(!$goods_id) {
	trigger_error($a_langpackage->a_error);
}

//数据表定义区
$t_goods = $tablePreStr."goods";

//读写分离定义方法
$dbo = new dbex;
dbtarget('r',$dbServs);

$array = array("lock_flg","goods_name","goods_intro","shop_id");
$info = get_goods_info($dbo,$t_goods,$array,$goods_id);

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
	introeditor=$("#goods_intro").xheditor({skin:'vista',tools:"Cut,Copy,Paste,Pastetext,Separator,Blocktag,Fontface,FontSize,Bold,Italic,Underline,Strikethrough,FontColor,BackColor,SelectAll,Removeformat,Separator,Align,List,Outdent,Indent,Separator,Link,Unlink,Img,Table,Separator,Source,Fullscreen,About"});
});
</script>
<style>
td span {color:red;}
.green {color:green;}
.red {color:red;}
</style>
</head>
<body>
<div id="maincontent">
<?php  include("messagebox.php");?>
	<div class="wrap">
	<div class="crumbs"><?php echo $a_langpackage->a_location; ?> &gt;&gt; <?php echo $a_langpackage->a_m_aboutgoods_management;?> &gt;&gt; <?php echo $a_langpackage->a_good_xiu?></div>
        <hr />
	<div class="infobox">
	<h3><span class="left"><?php echo $a_langpackage->a_good_xiu?></span></h3>
    <div class="content2">
		<form action="a.php?act=goods_edit" method="post">
		<table class="form-table">
		 <tbody>
			<tr>
				<td width="80px"><?php echo $a_langpackage->a_good_state; ?>：</td>
				<td><select name="lock_flg">
					<option value="0" <?php if($info['lock_flg']==0){echo "selected";}?>><?php echo $a_langpackage->a_flag_off; ?></option>
					<option value="1" <?php if($info['lock_flg']==1){echo "selected";}?>><?php echo $a_langpackage->a_flag_on; ?></option>
				</select></td>
			</tr>
			<tr>
				<td><?php echo $a_langpackage->a_goods_name; ?>：</td>
				<td><input class="small-text" type="text" name=goods_name value="<?php echo $info['goods_name']; ?>" style="width:200px;" /></td>
			</tr>
			<tr>
				<td><?php echo $a_langpackage->a_good_intro; ?>：</td>
				<td><textarea name="goods_intro" id="goods_intro" cols="100" rows="15"><?php echo $info['goods_intro'];?></textarea></td>
			</tr>
			<tr>
				<input type="hidden" name="good_id" value="<?php echo $goods_id;?>"><input type="hidden" name="shop_id" value="<?php echo $info['shop_id'];?>">
				<td colspan="2"><span class="button-container"><input class="regular-button" type="submit" name="submit" value="<?php echo $a_langpackage->a_good_xiu?>" /></span></td>
			</tr>
		  </tbody>
		</table>
		</form>
	   </div>
	 </div>
	</div>
</div>
</body>
</html>