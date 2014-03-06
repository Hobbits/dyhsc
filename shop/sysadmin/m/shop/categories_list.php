<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

require("../foundation/module_shop_category.php");

//引入语言包
$a_langpackage=new adminlp;

//权限管理
$right=check_rights("shop_categories");
if (!$right){
	header('location:m.php?app=error');
	exit;
}
$right_update=check_rights("cat_update");
//数据表定义区
$t_shop_categories = $tablePreStr."shop_categories";

//读写分离定义方法
$dbo = new dbex;
dbtarget('r',$dbServs);

/* 处理系统分类 */
$sql_category = "select * from `$t_shop_categories` order by sort_order asc,cat_id asc";
$result_category = $dbo->getRs($sql_category);

$category_dg = get_dg_category($result_category);
require ("a/updateJsAjax.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link rel="stylesheet" type="text/css" href="skin/css/admin.css">
<link rel="stylesheet" type="text/css" href="skin/css/main.css">
<style>
td span {color:red;}
.green {color:green;}
.red {color:red;}
#divname{float:left; margin:0px;}
</style>
</head>
<body>
<input type="hidden" id="update_right" value="<?php echo $right_update; ?>" ></input>
<div id="maincontent">
	<div class="wrap">
	<div class="crumbs"><?php echo $a_langpackage->a_location; ?> &gt;&gt; <?php echo $a_langpackage->a_m_shop_mengament;?> &gt;&gt;  <?php echo $a_langpackage->a_shop_category ?></div>
        <hr />
	<div class="infobox">
	<h3><span class="left"><?php echo $a_langpackage->a_shop_category ?></span>
	<span class="right" style="margin-right:15px;"> 
	
	
	<a href="m.php?app=shop_categories_add" style="float:right;"><?php echo $a_langpackage->a_category_add; ?></a>
	
	<a href="m.php?app=shop_categories_import" style="float:right;"><?php echo $a_langpackage->a_shop_categories_import; ?>&nbsp;&nbsp;</a>
	
	<a href="m.php?app=shop_categories_export" style="float:right;"><?php echo $a_langpackage->a_shop_categories_export; ?>&nbsp;&nbsp;</a>
	</span></h3>
    <div class="content2">
		<table class="list_table" style='font-size:12px;'>
			<thead>
			<tr style=" text-align:center;">
				<th width="50px">ID</th>
				<th align="left"><?php echo $a_langpackage->a_category_name; ?></th>
				<th width="65px"><?php echo $a_langpackage->a_shop_num; ?></th>
				<th width="65px"><?php echo $a_langpackage->a_show_sort; ?></th>
				<th width="115px"><?php echo $a_langpackage->a_operate; ?></th>
			</tr>
			</thead>
			<tbody>
			<?php if($category_dg) {
			foreach($category_dg as $value) { ?>
			<tr style=" text-align:center;">
				<td><?php echo $value['cat_id'];?>.</td>
				<td align="left" <?php if($value['parent_id']=='0') {echo 'style="font-weight:bold;"';} ?>>
				<div>
				    <div id="divname"><?php echo $value['str_pad'];?>&nbsp;</div>
				    <div id="divname" onclick="edit(this,<?php echo $value['cat_id'];?>,'divname<?php echo $value['cat_id'];?>','a.php?act=updateAjax','tablename=shop_categories&colname=cat_name&idname=cat_id&idvalue=<?php echo $value['cat_id'];?>&logcontent=<?php echo $a_langpackage->a_edit_category; ?>：&colvalue=',5);"><?php echo $value['cat_name'];?></div>
				    <div id="divname" style="display:none"></div>
				</div>
				</td>
				<td><?php echo $value['shops_num'];?></td>
				<td><div onclick="editnum(this,<?php echo $value['cat_id'];?>,'divorder<?php echo $value['cat_id'];?>','a.php?act=updateAjax','tablename=shop_categories&colname=sort_order&idname=cat_id&idvalue=<?php echo $value['cat_id'];?>&logcontent=<?php echo $a_langpackage->a_edit_category; ?>：&colvalue=',2);"><?php echo $value['sort_order'];?></div>
				    <div style="display:none"></div>
				</td>
				<td>
					<a href="m.php?app=shop_categories_edit&id=<?php echo $value['cat_id'];?>"><?php echo $a_langpackage->a_update; ?></a>
					<a href="a.php?act=shop_categories_del&id=<?php echo $value['cat_id'];?>" onclick="return confirm('<?php echo $a_langpackage->a_del_category_prompt; ?>？');"><?php echo $a_langpackage->a_delete; ?></a>
				</td>
			</tr>
			<?php }} else { ?>
			<tr>
				<td colspan="6"><?php echo $a_langpackage->a_no_list; ?></td>
			</tr>
			<?php } ?>
			</tbody>
		</table>
	  </div>
	 </div>
	</div>
</div>
</body>
</html>