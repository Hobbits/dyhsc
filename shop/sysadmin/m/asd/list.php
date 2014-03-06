<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

require_once("../foundation/module_asd.php");

//引入语言包
$a_langpackage=new adminlp;

//数据表定义区
$t_asd_content = $tablePreStr."asd_content";
$t_asd_position = $tablePreStr."asd_position";

//读写分离定义方法
$dbo = new dbex;
dbtarget('r',$dbServs);

$sql = "select * from `$t_asd_content`";
$sql .= " order by last_update_time desc";

$result = $dbo->fetch_page($sql,13);

$position_info = get_asd_position_all($dbo,$t_asd_position);
/** ajax修改用数组 */
$selecttype=array();
foreach ($position_info as $val){
	$k="";$v="";
	foreach ($val as $key=> $valu){
		if($key=="position_id"){
			$k=$valu;
		}else if($key=="position_name"){
			$v=$valu;
		}
		if($k&&$v){
			$selecttype[$k]=$v;
		}
	}
}
//print_r($selecttype);
$type = array(
	'1' => $a_langpackage->a_image,
	'2' => 'flash',
	'3' => $a_langpackage->a_text,
);
//权限
$right_update=check_rights("adv_edit");

require ("a/updateJsAjax.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link rel="stylesheet" type="text/css" href="skin/css/admin.css">
<link rel="stylesheet" type="text/css" href="skin/css/main.css">
<script type='text/javascript' src="skin/js/jy.js"></script>
<style>
td span {color:red;}
.green {color:green;}
.red {color:red;}
</style>
</head>
<body>
<input type="hidden" id="update_right" value="<?php echo $right_update; ?>" ></input>
<div id="maincontent">
	<div class="wrap">
	<div class="crumbs"><?php echo $a_langpackage->a_location; ?> &gt;&gt; <?php echo $a_langpackage->a_promotion_manage;?> &gt;&gt; <?php echo $a_langpackage->a_asd_list; ?></div>
        <hr />
	<div class="infobox">
	<h3><span class="left"><?php echo $a_langpackage->a_asd_list; ?></span> <span class="right" style="margin-right:15px;"><a href="m.php?app=asd_add" style="float:right;"><?php echo $a_langpackage->a_add_asd; ?></a></span></h3>
    <div class="content2">
		<form action="a.php?act=asd_del" id="form1" method="post">
		<table class="list_table" style="font-size:12px;">
		  <thead>
			<tr style=" text-align:center;">
				<th width="20px"><input type="checkbox" onclick="checkall(this,'asd_id[]');" value='' /></th>
				<th width="30px">ID</th>
				<th width="" align="left"><?php echo $a_langpackage->a_asd_name; ?></th>
				<th width="" align="left"><?php echo $a_langpackage->a_belong_asdpos; ?></th>
				<th width="" align="left"><?php echo $a_langpackage->a_asd_type; ?></th>
				<th align="left"><?php echo $a_langpackage->a_asd_link; ?></th>
				<th align="left"><?php echo $a_langpackage->a_asd_remark; ?></th>
				<th width="140px"><?php echo $a_langpackage->a_operate; ?></th>
			</tr>
			</thead>
			<tbody>
			<?php if($result['result']) {
			foreach($result['result'] as $value) { ?>
			<tr style=" text-align:center;">
				<td><input type="checkbox" name="asd_id[]" value="<?php echo $value['asd_id'];?>" /></td>
				<td><?php echo $value['asd_id'];?></td>
				<td align="left"><a href="m.php?app=asd_edit&id=<?php echo $value['asd_id'];?>"><?php echo $value['asd_name'];?></a></td>
				<td align="left">
				<div style="display:none"><input type="hidden" id="selectid<?php echo $value['asd_id'];?>" value="<?php echo $value['position_id'];?>"/></div>
					<div onclick="editselect(this,<?php echo $value['asd_id'];?>,'divasdname<?php echo $value['asd_id'];?>','a.php?act=updateAjax','tablename=asd_content&colname=position_id&idname=asd_id&idvalue=<?php echo $value['asd_id'];?>&logcontent=修改广告&colvalue=',5);"><?php echo $position_info[$value['position_id']]['position_name'];?></div>
				<div style="display:none;"></div>
				</td>
				<td align="left">
				<div style="display:none"><input type="hidden" id="selectid2<?php echo $value['asd_id'];?>" value="<?php echo $value['media_type'];?>"/></div>
				<div onclick="editselect2(this,<?php echo $value['asd_id'];?>,'divasdtype<?php echo $value['asd_id'];?>','a.php?act=updateAjax','tablename=asd_content&colname=media_type&idname=asd_id&idvalue=<?php echo $value['asd_id'];?>&logcontent=修改广告&colvalue=',5);"><?php echo $type[$value['media_type']];?></div>
				<div style="display:none;"></div>
				</td>
				
				<td align="left"><div onclick="edit(this,<?php echo $value['asd_id'];?>,'divlink<?php echo $value['asd_id'];?>','a.php?act=updateAjax','tablename=asd_content&colname=asd_link&idname=asd_id&idvalue=<?php echo $value['asd_id'];?>&logcontent=修改广告&colvalue=',20);"><?php echo $value['asd_link'];?></div>
				<div style="displya:none";></div>
				</td>
				<td align="left"><div onclick="edit(this,<?php echo $value['asd_id'];?>,'divremark<?php echo $value['asd_id'];?>','a.php?act=updateAjax','tablename=asd_content&colname=remark&idname=asd_id&idvalue=<?php echo $value['asd_id'];?>&logcontent=修改广告&colvalue=',5);"><?php echo $value['remark'];?></div>
				<div style="displya:none";></div>
				</td>
				<td>
					<a href="m.php?app=asd_position_view&id=<?php echo $value['asd_id'];?>" target="_blank"><?php echo $a_langpackage->a_view_asd; ?></a>
					<a href="m.php?app=asd_edit&id=<?php echo $value['asd_id'];?>"><?php echo $a_langpackage->a_update; ?></a>
					<a href="a.php?act=asd_del&id=<?php echo $value['asd_id'];?>" onclick="return confirm('<?php echo $a_langpackage->a_sure_delasd; ?>');"><?php echo $a_langpackage->a_delete; ?></a>
				</td>
			</tr>
			<?php }?>
			<tr>
				<td colspan="8">
					<span class="button-container"><input class="regular-button" type='submit' onclick="return confirm('<?php echo $a_langpackage->a_operate_message;?>');" name="" value="<?php echo $a_langpackage->a_batch_del;?>"  /></span>
				</td>
			</tr>
			<?php } else { ?>
			<tr>
				<td colspan="8"><?php echo $a_langpackage->a_noasd_list; ?>!</td>
			</tr>
			<?php } ?>
			<tr>
				<td colspan="8"><?php include("m/page.php"); ?></td>
			</tr>
			<tr>
				<td colspan="8">&nbsp;<?php echo $a_langpackage->a_asdposition_remark; ?></td>
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