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
    	<form action="a.php?act=nav_add" method="post" onsubmit="return check();">
		<table class="list_table" >
			<tr>
				<td><?php echo $a_langpackage->a_navigation_name; ?>：</td><td><input type="text" name="nav_name" value="" /></td>
			</tr>
			<tr>
				<td><?php echo $a_langpackage->a_news_links_url; ?>：</td><td><input type="radio" name="type" value="1" onclick="changeurl(this.value)" />
				<?php echo $a_langpackage->a_goods_category; ?><input type="radio" value="2" name="type" onclick="changeurl(this.value)" />
				<?php echo $a_langpackage->a_brand_area ?><input type="radio" name="type" value="3" onclick="changeurl(this.value)"  />
				<?php echo $a_langpackage->a_store_category; ?><input type="radio" name="type" value="4" onclick="changeurl(this.value)" checked />
				<?php echo $a_langpackage->a_define; ?><input type="text" name="url" id="url_content" /><div id="url_select"></div></td>
			</tr>
			<tr>
				<td><?php echo $a_langpackage->a_sort; ?></td>
				<td><input type="text" name="short_order" id="short_order" value="50" /></td>
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
			alert(va);
			document.getElementById('url_content').value = "";
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
