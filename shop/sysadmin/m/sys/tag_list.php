<?php
	/*
	***********************************************
	*$ID:tags_list
	*$NAME:tags_list
	*$AUTHOR:E.T.Wei
	*DATE:Sat Jun 05 09:10:13 CST 2010
	***********************************************
	*/
	if(!$IWEB_SHOP_IN) {
		die('Hacking attempt');
	}
	//引入语言包
	$a_langpackage=new adminlp;
	
	$k = short_check(get_args('name'));
	//数据表定义区
	$t_tag = $tablePreStr."tag";
	$t_goods = $tablePreStr."goods";

	$right_array=array(
		"tag_del"    =>   "0",
	    "tag_edit"    =>   "0",
	);
	foreach($right_array as $key => $value){
		$right_array[$key]=check_rights($key);
	}

	//读写分类定义方法
	$dbo = new dbex;
	dbtarget("r",$dbServs);
	
	$sql = "SELECT t.*,g.goods_name,g.goods_id FROM $t_tag  AS t,$t_goods AS g WHERE t.goods_id=g.goods_id ";
$goods_sql = "";
if($k){
	global $ks;
    global $redks;
		
		$k=str_replace("　"," ",$k);
		$k=str_replace("%","\%",$k);
		$k=str_replace("#","\#",$k);
		$k=addslashes($k);
		$ks = explode(' ', $k);
		
		$n_conditions = array();
		$k_conditions = array(); 
		
		foreach($ks as $key)
		{
		    if (!empty($key))
		    {
		        $n_conditions[] = "tag_name like '%$key%'";
		     //   $k_conditions[] = "keyword like '%$key%'";
		        $redks[]="<font color='red'>$key</font>";
		    }
		}
		if (!empty($n_conditions) )
		{   
		    $filter = 'and ('.implode(' OR ', $n_conditions).')';
		    $goods_sql .= " $filter";
		                        
		  //  $filter = '('.implode(' OR ', $k_conditions).')';
		  //  $goods_sql .= ' OR ' . $filter;
		}
}

$goods_sql=$sql.$goods_sql." group by tag_name";

	$result = $dbo->fetch_page($goods_sql,$SYSINFO['product_page']);
	$tag_list = $result['result'];
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
</head>
<body>
<div id="maincontent">
 <?php  include("messagebox.php");?>
	<div class="wrap">
	<div class="crumbs"><?php echo $a_langpackage->a_location; ?> &gt;&gt; <?php echo $a_langpackage->a_m_aboutgoods_management;?> &gt;&gt;<?php echo $a_langpackage->a_tags_manage; ?></div>
        <hr />
        <div class="seachbox">
	<form action="m.php?app=tag_list" name="searchForm" method="get">
				<table class="form_table">
				  <tbody>
				  	<tr>
				  		<td width="28px"><img border="0" alt="SEARCH" src="skin/images/icon_search.gif" /></td>
						<td width="180px">
							<span style="margin:1px 0px 0px 0px; float:left; color: #000" >
								<?php echo $a_langpackage->a_tag_name; ?>:
							</span>
							<input class="small-text" type="text" name="name" value="<?php echo $k; ?>"></input> 
							<input type="hidden" name="app" value="tag_list" />
						</td>
						<td>
							<input class="regular-button" type="submit" value="<?php echo $a_langpackage->a_search; ?>" />
						</td>
				    </tr>
				  </tbody>
				</table>
            </form>
            
            </div>
	<div class="infobox">
	    	<h3><?php echo $a_langpackage->a_tags_manage; ?></h3>
	        <div class="content2">
			<form action="a.php?act=tag_del" method="post">
			<table class="list_table">
			<thead>
				<tr style="text-align:center;">
					<th width="25"><input type="checkbox" onclick="checkall(this,'tagkey[]');" /></th>
					<th><?php echo $a_langpackage->a_tag_name; ?></th>
					<th><?php echo $a_langpackage->a_tag_goods; ?></th>
					<th><?php echo $a_langpackage->a_tag_num; ?></th>
					<th><?php echo $a_langpackage->a_whether_bold; ?></th>
					<th><?php echo $a_langpackage->a_commend; ?></th>
					<th><?php echo $a_langpackage->a_sort; ?></th>
					<th><?php echo $a_langpackage->a_operate;?></th>
				</tr>
			</thead>
			<tbody>
			<?php if($tag_list) {
				foreach($tag_list as $value) { ?>
				<tr style="text-align:center;">
					<td><input type="checkbox" name="tagkey[]" value="<?php echo  $value['tag_id'];?>" /></td>
					<td style="color:<?php echo $value['tag_color'];?>;<?php if($value['is_blod']) echo "font-weight:bold;";?>"><?php echo $value['tag_name']?></td>
					<td><?php echo $value['goods_name']?></td>
					<td><?php echo $value['tag_num']?></td>
					<td><?php echo $value['is_blod']==1?"yes":"no";?></td>
					<td><?php if($value['is_recommend']==1) {?>
						<img src="../skin/default/images/yes.gif" onclick="toggle_show(this,'no','<?php echo $value['tag_id'];?>')" style="cursor:pointer;" alt="前台只显示20家店铺"/>
						<?php }else{?>
						<img src="../skin/default/images/no.gif" onclick="toggle_show(this,'yes','<?php echo $value['tag_id'];?>')" style="cursor:pointer;" alt="前台只显示20家店铺"/>
						<?php }?>
						&nbsp;&nbsp;</td>
					<td><?php echo $value['short_order']?></td>
					<td><a href="m.php?app=tag_edit&tag_id=<?php echo $value['tag_id'];?>"><?php echo $a_langpackage->a_update; ?></a>&nbsp;<a href="a.php?act=tag_del&tagkey=<?php echo $value['tag_id']?>"><?php echo $a_langpackage->a_delete; ?></a></td>
				</tr>
				<?php }?>
				<tr>
					<td colspan="6">
					<span style="margin:14px 14px 0px 0px; float:left;" >
						<select name="v">
							<option value="0"><?php echo $a_langpackage->a_dele; ?></option>
							<option value="1"><?php echo $a_langpackage->acommend; ?></option>
							<option value="2"><?php echo $a_langpackage->a_commend_no; ?></option>
						</select>
					</span>
					<span class="button-container"><input class="regular-button" type="submit" name=""  onclick="return delcheck();" value="<?php echo $a_langpackage->a_batch_handle;?>" /></span>
					</td>
					<td><span id="updateKeyword_message"></span></td>
				</tr>
				<tr>
					<td colspan="7"><?php include("m/page.php"); ?></td>
				</tr>
			<?php }else{?>
				<tr><td colspan="7"><?php echo $a_langpackage->a_no_data;?></td></tr>
			<?php }?>
			</tbody>
			</table>
			</form>
			</div>
		</div>
	</div>
</div>
<script language="JavaScript" src="../servtools/ajax_client/ajax.js"></script>
<script language="JavaScript" type="text/javascript">
function toggle_show(obj,yn,id){
	var re = /yes/i;
	var src = obj.src;
	var s = 1;
	var searchv = src.search(re);
	if(searchv > 0) {
		s = 0;
	}
	ajax("a.php?act=tagcommend","POST","tag_id="+id+"&tagcommend="+s,function(data){
		if(data) {
			var a=data.substring(0,data.indexOf("."));
			var b=data.substring(data.indexOf(".")+1);
			if(b>7){
				ShowMessageBox("前台只显示20家店铺,现在已设置了"+b+"家",'1');
				}
			obj.src = '../skin/default/images/'+a+'.gif';
		}
	});
}

function delcheck(i){
	var inputs = document.getElementsByName("tagkey[]");
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
        ShowMessageBox("请至少选择一个标题！",'1'); 
        return false; 
    }
    return true;
}
</script>
</body>
</html>