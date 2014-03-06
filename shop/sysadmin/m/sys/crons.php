<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

//引入语言包
$a_langpackage=new adminlp;

require("../foundation/module_crons.php");

//数据表定义区
$t_crons = $tablePreStr."crons";

dbtarget('r',$dbServs);
$dbo=new dbex;

$result = get_crons_list($dbo,$t_crons);

$selecttype=array(
    "1"=>$a_langpackage->a_useable,
    "0"=>$a_langpackage->a_no_useable, 
);

$week=array(
	"0"=>"日",
	"1"=>"一",
	"2"=>"二",
	"3"=>"三",
	"4"=>"四",
	"5"=>"五",
	"6"=>"六",
);
$right_array=array(
	"programme_edit"    =>   "0",
    "programme_exe"    =>   "0",
    "programme_del"    =>   "0",
);
foreach($right_array as $key => $value){
	$right_array[$key]=check_rights($key);
}

$right_update=check_rights("crons_add");

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

</style>
<?php require ("a/updateJsAjax.php");?>
</head>
<body>
<?php  include("messagebox.php");?>
<input type="hidden" id="update_right" value="<?php echo $right_update; ?>" ></input>
<div id="maincontent">
	<div class="wrap">
	<div class="crumbs"><?php echo $a_langpackage->a_location; ?> &gt;&gt; <?php echo $a_langpackage->a_sys_setting;?>&gt;&gt;<?php echo $a_langpackage->a_plan_managment;?></div>
        <hr />
	<div class="infobox">
	<h3><span class="left"><?php echo $a_langpackage->a_sys_cron; ?></span><span class="right" style="margin-right:15px;"><a href="m.php?app=sys_crons_edit" style="float: right;"><?php echo $a_langpackage->a_add_new_plan;?></a></span></h3>
    <div class="content2">
		<form action="a.php?act=sys_crons_del" method="post" onsubmit="return submitform();">
		<input type="hidden" id="programme_exe" value="<?php echo $right_array['programme_exe'];?>">
		<table class="list_table" >
		<thead>
			<tr style="text-align:center;">
				<th width="2px"><input type="checkbox" onclick="checkall(this,'searchkey[]');" value='' /></th>
				<th width="190px" align="left"><?php echo $a_langpackage->a_name;?></th>
				<th width="" align="left"><?php echo $a_langpackage->a_php_exe_file;?></th>
				<th width="40px"><?php echo $a_langpackage->a_useable;?></th>
				<th width="40px"><?php echo $a_langpackage->a_type;?></th>
				<th width="100px"><?php echo $a_langpackage->a_exe_rule;?></th>
				<th width="251px"><?php echo $a_langpackage->a_before_exe_time;?>/<?php echo $a_langpackage->a_next_exe_time;?></th>
				<th width="40px"><?php echo $a_langpackage->a_operate;?></th>
			</tr>
		</thead>
		<tbody>
		<?php if($result) {
			foreach($result as $value) { ?>
			<tr style="text-align:center;">
				<td width="20px"><input type="checkbox" name="searchkey[]" <?php if($value['type']==-1){echo "disabled value='' ";} else {echo ' value="'.$value['id'].'" ';} ?> /></td>
				<td align="left"><div onclick="edit(this,<?php echo $value['id'];?>,'divname<?php echo $value['id'];?>','a.php?act=updateAjax','tablename=crons&colname=name&idname=id&idvalue=<?php echo $value['id'];?>&logcontent=更新计划任务&colvalue=',25);"><?php echo $value['name']?></div>
				<div style="display:none"></div>
				</td>
				<td align="left"><div onclick="edit(this,<?php echo $value['id'];?>,'divfile<?php echo $value['id'];?>','a.php?act=updateAjax','tablename=crons&colname=phpfile&idname=id&idvalue=<?php echo $value['id'];?>&logcontent=更新计划任务&colvalue=',25);"><?php echo $value['phpfile']?></div>
				<div style="display:none"></div>
				</td>
				<td><div style="display:none"><input type="hidden" id="selectid<?php echo $value['id'];?>" value="<?php echo $value['available']; ?>" /></div>
				<div onclick="editselect(this,<?php echo $value['id'];?>,'divava<?php echo $value['id'];?>','a.php?act=updateAjax','tablename=crons&colname=available&idname=id&idvalue=<?php echo $value['id'];?>&logcontent=更新计划任务&colvalue=',5);"><?php if($value['available']==0){echo $a_langpackage->a_no_useable;}elseif($value['available']==1){echo $a_langpackage->a_useable;}?></div>
				<div style="display:none;"></div>
				</td>
				<td><?php if($value['type']==-1){echo $a_langpackage->a_sys;}elseif($value['type']==1){echo $a_langpackage->a_define;}?></td>
				<td><?php if($value['weekday']!=-1){echo $a_langpackage->a_weekly.$week[$value['weekday']];}
				elseif ($value['weekday']==-1&&$value['day']!=-1){echo $a_langpackage->a_monthly.$value['day'].$a_langpackage->a_date;}else{echo $a_langpackage->a_day;}
				if($value['hour']!=-1){echo $value['hour'].$a_langpackage->a_hour;}else{echo $a_langpackage->a_hours;}
				if($value['minute']!=-1){echo $value['minute'].$a_langpackage->a_minute;}
				?></td>
				<td><?php echo date('Y-m-d H:i:s',$value['lastrun'])?><br /><?php echo date('Y-m-d H:i:s',$value['nextrun'])?></td>
				<td>
				<?php if($value['type']!=-1){ ?>
				<a href="a.php?act=sys_crons_del&id=<?php echo $value['id'];?>"><?php echo $a_langpackage->a_dele;?></a><br /><?php }?>
				<a href="m.php?app=sys_crons_edit&id=<?php echo $value['id'];?>"><?php echo $a_langpackage->a_edit;?></a><br />
				<a href="javascript:exejs(<?php echo $value['id'];?>);"><?php echo $a_langpackage->a_exe;?></a>
				</td>
			</tr>
			<?php }?>
			<tr><td colspan="9"><span class="button-container"><INPUT class="regular-button" onclick="return confirm('<?php echo $a_langpackage->a_exe_message;?>');" type=submit value="<?php echo $a_langpackage->a_dele;?>" name=deletesubmit></span> </td></tr>
		<?php }else{?>
			<tr><td colspan="9"><?php echo $a_langpackage->a_no_data;?></td></tr>
		<?php }?>
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
function submitform() {
	var checknum = 0;
	for(var i=0; i<inputs.length; i++) {
		if(inputs[i].type=='checkbox') {
			if(inputs[i].checked && inputs[i].value) {
				checknum++;
			}
		}
	}
	if(checknum==0) {
		ShowMessageBox('<?php echo $a_langpackage->a_del_message;?>','0');
		return false;
	}
	return true;
}

function exejs(id){
	var rights=document.getElementById("programme_exe").value;
	if(rights != '0'){
		ajax("../crons.php?id="+id,"GET",'',function(data){
			if(data==1) {
				ShowMessageBox('<?php echo $a_langpackage->a_exe_over;?>','1');
			} else {
				ShowMessageBox('<?php echo $a_langpackage->a_exe_fail;?>','0');
			}
		});
	}else{
		ShowMessageBox('<?php echo $a_langpackage->a_no_rights;?>','0');
		location.href="m.php?app=error";
	}
}
//-->
</script>
</body>
</html>