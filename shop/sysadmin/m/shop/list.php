<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

require_once("../foundation/module_areas.php");
require_once("../foundation/module_users.php");
require_once("../foundation/module_shop_category.php");
//引入语言包
$a_langpackage=new adminlp;
//数据表定义区
$t_shop_info = $tablePreStr."shop_info";
$t_areas = $tablePreStr."areas";
$t_user_rank = $tablePreStr."user_rank";
$t_users = $tablePreStr."users";
$t_shop_categories = $tablePreStr."shop_categories";

//读写分离定义方法
$dbo = new dbex;
dbtarget('r',$dbServs);
/* 地区信息 */
$areainfo = get_areas_kv($dbo,$t_areas);

/* 处理系统分类 */
$sql_category = "select * from `$t_shop_categories` order by sort_order asc,cat_id asc";
$result_category = $dbo->getRs($sql_category);

$category_dg = get_dg_category($result_category);

$sql = "select * from `$t_shop_info` as a, `$t_users` as b where a.user_id=b.user_id";
$name = get_args('name');
$start_time = get_args('start_time');
$end_time = get_args('end_time');
$shop_open_status = get_args('shop_open_status');
$shop_categorie = get_args('shop_categorie');
if($name) {
	//权限管理
	$right=check_rights("shop_search");
	if(!$right){
		header('location:m.php?app=error');
	}
	$sql .= " and a.shop_name like '%$name%' ";
}
if($start_time) {
	//权限管理
	$right=check_rights("shop_search");
	if(!$right){
		header('location:m.php?app=error');
	}

	$sql .= " and a.shop_creat_time >= '$start_time'";
}
if($end_time) {
	//权限管理
	$right=check_rights("shop_search");
	if(!$right){
		header('location:m.php?app=error');
	}
	$sql .= " and a.shop_creat_time  <= '$end_time'";
}
if($shop_open_status!="" && $shop_open_status!=2) {
	//权限管理
	$right=check_rights("shop_search");
	if(!$right){
		header('location:m.php?app=error');
	}
	$sql .= " and a.lock_flg = '$shop_open_status'";
}
if($shop_categorie) {
	//权限管理
	$right=check_rights("shop_search");
	if(!$right){
		header('location:m.php?app=error');
	}
	$categories_str = '';
	$parent_id = '';
	foreach($category_dg as $v) {
		if($v['cat_id'] == $shop_categorie) {
			if($v['parent_id']=='0'){
				$parent_id = $v['cat_id'];
			} else {
				$categories_str = $shop_categorie;
			}
			break;
		}
	}
	if($parent_id){
		foreach($category_dg as $v) {
			if($v['parent_id'] == $parent_id){
				$categories_str = $categories_str.','.$v['cat_id'];
			}

		}
	}
	if($categories_str == $shop_categorie){
		$categories_str = '='.$categories_str;
	}else{
		$categories_str = trim($categories_str,",");
		$categories_str =' in ('. $categories_str.')';
	}
		
	$sql .= " and a.shop_categories ".$categories_str;
}
$user_right=check_rights("user_update");
$shop_right=check_rights("shop_update");
$sql .= " order by a.shop_creat_time desc";
$result = $dbo->fetch_page($sql,10);
//print_r($result);
$userrank = get_userrank_list($dbo,$t_user_rank);

$right_array=array(
    "shop_unsale"    =>   "0",
    "shop_update"    =>   "0",
    "shop_lock"    =>   "0",
    "shop_search"    =>   "0",
);

foreach($right_array as $key => $value){
	$right_array[$key]=check_rights($key);
}



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link rel="stylesheet" type="text/css" href="skin/css/admin.css">
<link rel="stylesheet" type="text/css" href="skin/css/main.css">
<script type='text/javascript' src="skin/js/jy.js"></script>
<script type='text/javascript' src='../servtools/date/WdatePicker.js'></script>
<style>
td span {color:red;}
.green {color:green;}
.red {color:red;}
</style>
</head>
<body>
<input type="hidden" name="user_right" id="user_right" value="<?php echo $user_right; ?>" />
<input type="hidden" name="shop_right" id="shop_right" value="<?php echo $shop_right; ?>" />
<div id="maincontent">
<?php  include("messagebox.php");?>
	<div class="wrap">
	<div class="crumbs"><?php echo $a_langpackage->a_location; ?> &gt;&gt; <?php echo $a_langpackage->a_m_shop_mengament;?> &gt;&gt; <?php echo $a_langpackage->a_shop_list;?></div>
        <hr />
	<div class="seachbox">
        <div class="content2">
        	<form action="m.php?app=shop_list" name="searchForm" method="get">
            <table class="form-table">
            	<tbody>
            	  <tr>
                   	<td width="10px">
                   		<span style="margin:1px -5px 0px 0px; float:right; color: #000" >
                   			<img src="skin/images/icon_search.gif" border="0" alt="SEARCH" />
                   		</span>
                   	</td>
                    <td >
                    	<span style="margin:1px 2px 0px -10px; float:left; color:#000" >
                    		<?php echo $a_langpackage->a_shop_name;?>:
                    	</span>
						
                    	<input type="text" class="small-text" name="name" value="<?php echo $name; ?>" style="width:100px" />
						<?php echo $a_langpackage->a_shop_time;?>：
						<input class="Wdate" type="text" name="start_time" id="start_time" onFocus="WdatePicker({isShowClear:false,readOnly:true})" value="<?php echo $start_time;?>" /><?php echo $a_langpackage->a_to;?>
						
						
						<input class="Wdate" type="text" name="end_time" id="end_time" onFocus="WdatePicker({isShowClear:false,readOnly:true})"  value="<?php echo $end_time;?>"/>
						<?php //echo $a_langpackage->a_shop_lock_status;?>
						<!-- <select name='shop_open_status'>
							<option value ="2"><?php echo $a_langpackage->a_shop_lock_status_all;?></option>
							<option value ="1" <?php if($shop_open_status=='1') echo "selected"?>><?php echo $a_langpackage->a_lock;?></option>
							<option value ="0" <?php if($shop_open_status=='0') echo "selected"?>><?php echo $a_langpackage->a_unlock;?></option>
						</select>   -->
							<?php echo $a_langpackage->a_shop_category;?>：
							<select name='shop_categorie'>
							<option value ="0"><?php echo $a_langpackage->a_select_n_category;?></option>
						<?php if($category_dg) {
								foreach($category_dg as $value) {
									if($value['parent_id']=='0'){
								?>
									<option value ="<?php echo $value['cat_id'];?>" <?php if($shop_categorie==$value['cat_id']) echo "selected"?>><?php echo $value['cat_name'];?></option>
								<?php } else {?>
									<option value ="<?php echo $value['cat_id'];?>" <?php if($shop_categorie==$value['cat_id']) echo "selected"?>><?php echo "----|".$value['cat_name'];?></option>
								<?php }
								}
							}?>
						</select>

						<input type="hidden" name="app" value="shop_list" />
                    </td>
                    <td>
                    <span style="margin:-2px 0px 0px -10px; float:left;" >
                    	<input class="regular-button" type="submit" value="<?php echo $a_langpackage->a_serach;?>" />
                    </span>
                    </td>
                  </tr>
                </tbody>
            </table>
            </form>
        </div>
    </div>
	<div class="infobox">
	<h3><span class="left"><?php echo $a_langpackage->a_shop_list;?></span><span class="right" style="margin-right:15px;"> <a href="m.php?app=shopadd_list" style="float:right;"><?php echo $a_langpackage->a_shop_add; ?></a></span></h3>
    <div class="content2">
			<form action="a.php?act=lock_shop" name="form1" id="form1" method="post">
			<table class="list_table">
			  <thead>
				<tr style="text-align: center;">
					<th width="2px"><input type="checkbox" onclick="checkall(this,'shop_id[]');" value='' /></th>
					<th width="40px"><?php echo $a_langpackage->a_ID;?></th>
					<th align="left"><?php echo $a_langpackage->a_shopkeeper;?>/<?php echo $a_langpackage->a_shop_name;?></th>
					<th width="120px"><?php echo $a_langpackage->a_shop_area;?></th>
					<th width="100px" align="left"><?php echo $a_langpackage->a_shop_range;?></th>
					<!-- <th width="60px"><?php echo $a_langpackage->a_shop_status;?></th>
					<th width="60px"><?php echo $a_langpackage->a_commend; ?></th> 
					<th width="80px"><?php echo $a_langpackage->a_shop_approve;?></th> -->
					<th width="85px"><?php echo $a_langpackage->a_shop_time;?></th>
					<th width="61px"><?php echo $a_langpackage->a_operate;?></th>
				</tr>
			  </thead>
			  <tbody>
				<?php if($result['result']) {
				foreach($result['result'] as $value) { ?>
				<tr style="text-align:center;">
					<td width="2px"><input type="checkbox" name="shop_id[]" value="<?php echo $value['shop_id'];?>" /></td>
					<td width="40px"><?php echo $value['shop_id'];?>.</td>
					<td width="" align="left"><?php echo $value['user_name']?><br />
						<a href="../shop.php?shopid=<?php echo $value['shop_id'];?>&app=index" target="_blank"><?php echo $value['shop_name'];?></a>
						(<a href="m.php?app=goods_list&shopid=<?php echo $value['shop_id'];?>"><?php echo $a_langpackage->a_view_product;?></a>)
					</td>
					<td><?php if (isset($areainfo[$value['shop_province']])) echo $areainfo[$value['shop_province']]; if (isset($areainfo[$value['shop_city']])) echo ','.$areainfo[$value['shop_city']];?></td>
					<td align="left"><?php echo $value['shop_management'];?></td>
					
					<td><?php echo substr($value['shop_creat_time'],0,10);?></td>
					<td>
						<a href="a.php?act=shop_goodsdownsale&id=<?php echo $value['shop_id']; ?>" onclick="return confirm('<?php echo $a_langpackage->a_goods_out_sale_message1.$value['shop_name'].$a_langpackage->a_goods_out_sale_message2;?>');"><?php echo $a_langpackage->a_goods_out_sale;?></a><br />
						<a href="m.php?app=member_reinfo&id=<?php echo $value['user_id']; ?>"><?php echo $a_langpackage->a_update_rank;?></a><br />
						<?php if($value['lock_flg']==0){?>
						<a href="a.php?act=lock_shop&id=<?php echo $value['shop_id']; ?>&v=1" onclick="return confirm('<?php echo $a_langpackage->a_free_shop_mess.$value["shop_name"].$a_langpackage->a_free_shop_mess1;?>')"><?php echo $a_langpackage->a_lock_shop;?></a><br />
						<?php }else{?>
						<a href="a.php?act=lock_shop&id=<?php echo $value['shop_id']; ?>&v=0" ><?php echo $a_langpackage->a_free_shop;?></a><br />
						<?php }?>
						<a href="m.php?app=shop_edit&id=<?php echo $value['shop_id']; ?>" ><?php echo $a_langpackage->a_shop_updat;?></a>
					</td>
				</tr>
				<?php }?>
				<tr>
					<td colspan="15">
						<span style="margin:14px 14px 0px 0px; float:left;" >
							<select name="v">
								<option value="1"><?php echo $a_langpackage->a_lock_shop;?></option>
								<option value="0"><?php echo $a_langpackage->a_free_shop;?></option>
							</select>
						</span>
						<span class="button-container"><input class="regular-button" type="submit" name=""  onclick="return delcheck();" value="<?php echo $a_langpackage->a_batch_handle;?>" /></span>
						<span class="button-container"><input class="regular-button" type='button' onclick='jump_diff("a.php?act=shop_goodsdownsale");' value='<?php echo $a_langpackage->a_batch_down;?>' /></span>
					</td>
				</tr>
				<?php } else { ?>
				<tr>
					<td colspan="9"><?php echo $a_langpackage->a_no_list;?></td>
				</tr>
				<?php } ?>
				<tr>
					<td colspan="9"><?php include("m/page.php"); ?></td>
				</tr>
				</tbody>
				<input type="hidden" name="test" id="test"/>
			</table>
			</form>
		</div>
	  </div>
	</div>
</div>
</body>
<script language="JavaScript" src="../servtools/ajax_client/ajax.js"></script>
<script language="JavaScript">

<!--

function toggle_show(obj,yn,id){
	var re = /yes/i;
	var src = obj.src;
	var s = 1;
	var searchv = src.search(re);
	if(searchv > 0) {
		s = 0;
	}
	ajax("a.php?act=shopcommend","POST","shopid="+id+"&shopcommend="+s,function(data){
		if(data) {
			var arraydata = data.split(".");
			if(arraydata[2]=="1")
			{
				ShowMessageBox("商店尚未通过,不能推荐！",'0');
				return;
			}
			if(arraydata[2]=="2")
			{
				ShowMessageBox("商铺被锁定，不能推荐！",'0');
				return;
			}
			if(arraydata[2]=="3")
			{
				ShowMessageBox("商铺为开放，不能推荐！",'0');
				return;
			}
			if(arraydata[1]>7){
				ShowMessageBox("前台只显示7家店铺,现在已设置了"+arraydata[1]+"家",'0');
				}
			obj.src = '../skin/default/images/'+arraydata[0]+'.gif';
		}
	});
}


var inputs = document.getElementsByTagName("input");

function jump_diff(link_href){
	var checked = false; 
    for (var i = 0; i < inputs.length; i++) 
    {
    	if (inputs[i].checked == true) 
        {
            checked = true;
            if(confirm('<?php echo $a_langpackage->a_exe_message; ?>')){
            	document.getElementById('form1').action=link_href;
            	document.getElementById('form1').submit();
            	break; 
                }else{
                	return false;
                	break; 
                    }
        }
    }
    if (!checked) 
    { 
        ShowMessageBox("请至少选择一个店铺！",'0'); 
        return false; 
    }
    return true;
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
        ShowMessageBox("请至少选择一个店铺！",'0'); 
        return false; 
    }
    return true;
}
//-->
</script>
</html>