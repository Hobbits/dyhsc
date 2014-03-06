<?php
	/*
	***********************************************
	*$ID:
	*$NAME:
	*$AUTHOR:E.T.Wei
	*DATE:Sat Jun 19 11:13:55 CST 2010
	***********************************************
	*/
	if(!$IWEB_SHOP_IN) {
		die('Hacking attempt');
	}
	//文件引入
	require("../foundation/module_nav.php");
	//引入语言包
	$a_langpackage=new adminlp;
	//数据表定义区
	$t_nav = $tablePreStr."nav";
	//读写分类定义方法
	$dbo = new dbex;
	dbtarget("r",$dbServs);
	$id = intval(get_args("nav_id"));
	$nav_info = get_nav_info($id,$t_nav,$dbo);
	$nav_type = $nav_info['type'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title></title>
<link rel="stylesheet" type="text/css" href="skin/css/admin.css">
<link rel="stylesheet" type="text/css" href="skin/css/main.css">
</head>
<body>
<div id="maincontent">
<?php  include("messagebox.php");?>
	<div class="wrap">
	<div class="crumbs"><?php echo $a_langpackage->a_location; ?>&gt;&gt; <?php echo $a_langpackage->a_global_settings; ?>&gt;&gt;<?php echo $a_langpackage->a_add_navigation; ?></div>
        <hr />
	<div class="infobox">
	<h3><span class="left"><?php echo $a_langpackage->a_add_navigation; ?></span><span class="right" style="margin-right:15px;"><a href="m.php?app=nav_list" style="float: right;"><?php echo $a_langpackage->a_return_navigation; ?></a></span></h3>
    <div class="content2">
    	<form action="a.php?act=nav_edit" method="post" name="form" onsubmit="return check();">
		<table class="list_table" >
			<tr>
				<td><?php echo $a_langpackage->a_navigation_name; ?>：</td><td><input type="text" name="nav_name" value="<?php echo $nav_info['nav_name']?>" /></td>
			</tr>
			<tr>
				<td><?php echo $a_langpackage->a_news_links_url; ?>：</td>
				<td>
					<input type="radio" name="type" value="1" <?php if($nav_type==1){echo "checked";}?> onclick="changeurl(this.value)" /><?php echo $a_langpackage->a_goods_category; ?>
					<input type="radio" value="2" name="type" <?php if($nav_type==2){echo "checked";}?> onclick="changeurl(this.value)" /><?php echo $a_langpackage->a_brand_area ?>
					<input type="radio" name="type" value="3" <?php if($nav_type==3){echo "checked";}?> onclick="changeurl(this.value)"  /><?php echo $a_langpackage->a_store_category; ?>
					<input type="radio" name="type" value="4" <?php if($nav_type==4||$nav_type==0){echo "checked";}?> onclick="changeurl(this.value)"/><?php echo $a_langpackage->a_define; ?>
					<input type="text" name="url" id="url_content" value="<?php echo $nav_info['url'];?>" /><div id="url_select"></div>
				</td>
				<input type="hidden" name="nav_id" value="<?php echo $id;?>" />
			</tr>
			<tr>
				<td><?php echo $a_langpackage->a_sort; ?></td>
				<td><input type="text" name="short_order" id="short_order" value="<?php echo $nav_info['short_order'];?>" /></td>
			</tr>
			<tr>
				<td colspan="2"><input type="submit" name="sub" value="<?php echo $a_langpackage->a_submit2; ?>" /></td>
			</tr>
		</table>
		</form>
		</div>
		</div>
	</div>
</div>
</body>
</html>
<script language="JavaScript" src="../servtools/ajax_client/ajax.js"></script>
<script language="JavaScript" type="text/javascript">
	function changeurl(va){
		if(va!=4){
			var objs = document.getElementsByName('type');
			for(i=0;i<objs.length;i++){
				if(va==objs[i].value){
					objs[i].checked=true;
				}else{
					objs[i].checked=false;
				}
			}
			ajax("a.php?act=get_url_content&type="+va,"POST",'',function(data){
				if(data!=0){
					document.getElementById('url_select').innerHTML=data;
					document.getElementById('url_select').style.display="";
					var ns=document.getElementById('nav_select').value;
					document.getElementById('url_content').value =ns;
				}else{
					for(i=0;i<objs.length;i++){
						if(objs[i].value==4){
							objs[i].checked=true;
						}else{
							objs[i].checked=false;
						}
					}
					document.getElementById('url_content').value = "";
				}
			});
		}else{
			document.getElementById('url_content').value = "<?php echo $nav_info['url'];?>";
			document.getElementById('url_select').style.display="none";
		}
	}
	function change(va){
		document.getElementById('url_content').value =va;
	}
	function check(){
		var name=document.getElementsByName("nav_name")[0].value;
		if(name==''){
			ShowMessageBox("<?php echo $a_langpackage->a_link_name_prompt; ?>",'0');
			return false;
		}
		var url=document.getElementsByName("url")[0].value;
		if(url==''){
			ShowMessageBox("<?php echo $a_langpackage->a_link_url_prompt; ?>",'0');
			return false;
		}
		var short_order=document.getElementsByName("short_order")[0].value;
		var checkfiles=new RegExp("^[0-9]\\d*$");
		if(!checkfiles.test(short_order)) {
			ShowMessageBox("<?php echo $a_langpackage->a_is_number; ?>",'0');
				return false;
		}
	}
</script>
