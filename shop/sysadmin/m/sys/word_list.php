<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

require("../foundation/module_news.php");

//引入语言包
$a_langpackage=new adminlp;


//数据表定义区
$t_word = $tablePreStr."word";

//读写分离定义方法
$dbo = new dbex;
dbtarget('r',$dbServs);

$sql = "select * from $t_word where 1 ";
$result = $dbo->fetch_page($sql,13);

//$cat_info = get_news_cat_list($dbo,$t_article_cat);
//print_r($cat_info);
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
<div id="maincontent">
	<div class="wrap">
	<div class="crumbs"><?php echo $a_langpackage->a_location; ?> &gt;&gt; <?php echo $a_langpackage->a_promotion_manage;?> &gt;&gt; <?php echo $a_langpackage->a_sensi_words; ?></div>
        <hr />
	<div class="infobox">
	<h3><span class="left"><?php echo $a_langpackage->a_sensi_words; ?></span> <span class="right" style="margin-right:15px;"><a href="m.php?app=word_add"><?php echo $a_langpackage->a_words_add; ?></a></span></h3>
    <div class="content2">

		<form action="a.php?act=word_del" name="form1" id="form1" method="post">
		<table class="list_table">
		  <thead>
			<tr style=" text-align:center">
				<th width="30px"><input type="checkbox" onclick="checkall(this,'word_id[]');" value='' /></th>
				<th width="30px">ID</th>
				<th width="" align="left"><?php echo $a_langpackage->a_words; ?></th>
				<th width="60px"><?php echo $a_langpackage->a_operate; ?></th>
			</tr>
			</thead>
			<tbody>
			<?php if($result['result']) {
			foreach($result['result'] as $value) { ?>
			<tr style=" text-align:center">
				<td width="30px"><input type="checkbox" name="word_id[]" value="<?php echo $value['word_id'];?>"  /></td>
				<td width="30px"><?php echo $value['word_id'];?></td>
				<td width="" align="left"><?php echo $value['word_name'];?></td>
				<td width="60px">
					<a href="m.php?app=word_edit&id=<?php echo $value['word_id'];?>"><?php echo $a_langpackage->a_update; ?></a>
					<a href="a.php?act=word_del&id=<?php echo $value['word_id'];?>"><?php echo $a_langpackage->a_delete; ?></a>
				</td>
			</tr>
			<?php }?>
			<tr>
				<td colspan="4">
					<span class="button-container"><input class="regular-button" type="submit" name=""  onclick="return delcheck();" value="<?php echo $a_langpackage->a_batch_del; ?>" /></span>
				</td>
			</tr>
			
			<?php } else { ?>
			<tr>
				<td colspan="4" class="center"><?php echo $a_langpackage->a_noword_list; ?>!</td>
			</tr>
			<?php } ?>
			<tr>
				<td colspan="4" class="center"><?php include("m/page.php"); ?></td>
			</tr>
		</table>
		</form>
	   </div>
	  </div>
	 </div>
</div>
<div style="color:red; display:none; width:270px; margin:5px auto;" id="ajaxmessageid">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $a_langpackage->a_loading; ?></div>
<script language="JavaScript" src="../servtools/ajax_client/ajax.js"></script>
<script language="JavaScript">
<!--
var inputs = document.getElementsByTagName("input");

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
        alert("请至少选择一个标题！"); 
        return false; 
    }
    return true;
}
//-->
</script>
</body>
</html>