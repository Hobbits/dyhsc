<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}
require("../foundation/flefttime.php");

//引入语言包
$a_langpackage=new adminlp;

//数据表定义区
$t_groupbuy = $tablePreStr."groupbuy";
$t_goods = $tablePreStr."goods";

//读写分离定义方法
$dbo = new dbex;
dbtarget('r',$dbServs);

$sql = "SELECT b.*,g.* FROM `$t_groupbuy` b left join `$t_goods` g on b.goods_id = g.goods_id";
//$sql .= " WHERE b.recommended = 0 and g.lock_flg =0 and b.group_condition ='0' and b.examine = '1'";
$result = $dbo->fetch_page($sql,$SYSINFO['product_page']);
//echo $sql;
//print_r($result);

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
td img {cursor:pointer;}
</style>
</head>
<body>
<div id="maincontent">
<?php  include("messagebox.php");?>
	<div class="wrap">
	<div class="crumbs"><?php echo $a_langpackage->a_location; ?> &gt;&gt; <?php echo $a_langpackage->a_m_aboutgoods_management;?> &gt;&gt; <?php echo $a_langpackage->a_groupbuy_list;?></div>
        <hr />

	<div class="infobox">
	<h3><?php echo $a_langpackage->a_goods_list; ?></h3>
    <div class="content2">
		<form action="a.php?act=groupbuy_edit" name="form1" method="post">
		<table class="list_table" width="100%">
		  <thead>
			<tr style="text-align: center;">
				<th width="2px"><input type="checkbox" onclick="checkall(this,'id[]');" value='' /></th>
				<th align="center" width="40px">ID</th>
				<th align="left" width=""><?php echo $a_langpackage->a_groupbuy_name;?></th>
				<th align="center" width=""><?php echo $a_langpackage->a_groupbuy_price; ?></th>
				<th width="80px"><?php echo $a_langpackage->a_groupbuy_num; ?></th>
				<th align="center" width="150px"><?php echo $a_langpackage->a_goods_name; ?></th>
				<th width="60px"><?php echo $a_langpackage->a_leave_time ?></th>
				<th width="80px"><?php echo $a_langpackage->a_operate; ?></th>
			</tr>
			</thead>
			<tbody>
			<?php if($result['result']) {
			foreach($result['result'] as $v) { ?>
			<tr style="text-align: center;">
			<td ><input type="checkbox" name="id[]" value="<?php echo $v['group_id'];?>" /></td>
			<td align="center"><?php echo  $v['group_id'];?></td>
   <td align="left" style="padding-left:10px" ><a href="../goods.php?id=<?php echo  $v['group_id'];?>&app=groupbuyinfo" target="_blank" ><img src="../<?php echo  $v['goods_thumb'] ?>" width="95" height="95" style="float:left;padding-right:15px" alt="<?php echo  $v['goods_name'];?>" onerror="this.src='../skin/default/images/nopic.gif'"/></a>
                  <div><a href="../goods.php?id=<?php echo  $v['group_id'];?>&app=groupbuyinfo" target="_blank" ><?php echo  sub_str($v['group_name'],22,false);?></a><br />

                  [<?php echo $a_langpackage->a_groupbuy_explain; ?>]<?php echo  $v['group_desc'];?></div>
              </td>
   <td align="center"  class=""><em class="pic"><?php echo $a_langpackage->a_money_sign; ?><?php echo  $v['spec_price'];?><?php echo $a_langpackage->a_yuan; ?></em></td>
   <td class=""><?php echo  $v['min_quantity'];?></td>
   <td class=""><a href="../goods.php?id=<?php echo  $v['goods_id'];?>" target="_blank"><?php echo  sub_str($v['goods_name'],22,false);?></a></td>
   <td class=""><?php echo  time_left(strtotime($v['end_time']));?>
              <?php if($v['group_condition']==1 and $v['examine']==1) echo  $a_langpackage->a_complate;if($v['examine']==0) echo  $a_langpackage->a_no_auditing;?>

              </td>

				<td style=" text-align:center;">
				<?php if($v['examine']==0) { ?>
					<a href="a.php?act=groupbuy_edit&group_id=<?php echo  $v['group_id'];?>&examine=1"><?php echo $a_langpackage->a_pass_auditing; ?></a>
				<?php }else if($v['examine']==1) { ?>
					<a href="a.php?act=groupbuy_edit&group_id=<?php echo  $v['group_id'];?>&examine=0"><?php echo $a_langpackage->a_cancel_auditing; ?></a>
				<?php } ?>

				</td>
			</tr>
			<?php }?>
			<tr>
				<td colspan="15">
					<span style="margin:14px 14px 0px 0px; float:left;" >
						<select name="examine">
							<option value="1"><?php echo $a_langpackage->a_pass_auditing; ?></option>
							<option value="0"><?php echo $a_langpackage->a_cancel_auditing; ?></option>
						</select>
					</span>
					<span class="button-container"><input class="regular-button" type="submit" name=""  onclick="return delcheck();" value="<?php echo $a_langpackage->a_batch_handle;?>" /></span>
				</td>
			</tr>
			<?php } else { ?>
			<tr>
				<td colspan="13"><?php echo $a_langpackage->a_no_list; ?></td>
			</tr>
			<?php } ?>
			<tr>
				<td colspan="13" class="center"><?php include("m/page.php"); ?></td>
			</tr>
			</tbody>
		</table>
		</form>
	   </div>
	  </div>
	</div>
</div>
<script language="JavaScript" src="../servtools/ajax_client/ajax.js"></script>
<script language="JavaScript">
<!--
var inputs = document.getElementsByTagName("input");

function examine_edit(group_id,examine) {

	var rights=document.getElementById(name).value;
	ajax("a.php?act=groupbuy_edit","POST","group_id="+group_id+"&examine="+examine,function(data){
		if(data) {

		}
	});

}
function delcheck(){
	var checked = false; 
    for (var i = 0; i < inputs.length; i++) 
    { 
    	if (inputs[i].checked == true) 
        {
            checked = true;
            if(confirm('<?php echo $a_langpackage->a_exe_message; ?>')){
            	break; 
                }else{
                	return false;
                	break; 
                    }
        }
    } 
    if (!checked) 
    { 
        ShowMessageBox("请至少选择一个标题！",'0'); 
        return false; 
    }
    return true;
}
//-->
</script>
</body>
</html>