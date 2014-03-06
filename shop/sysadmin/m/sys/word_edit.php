<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

require_once("../foundation/module_news.php");

//引入语言包
$a_langpackage=new adminlp;

//定义读操作
dbtarget('r',$dbServs);
$dbo=new dbex;

//数据表定义区
$t_word = $tablePreStr."word";

$word_id = intval(get_args('id'));
if(!$word_id) { exit($a_langpackage->a_error);}

$sql="select * from $t_word where word_id=$word_id";
$row=$dbo->getRow($sql);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link rel="stylesheet" type="text/css" href="skin/css/admin.css">
<link rel="stylesheet" type="text/css" href="skin/css/main.css">
</head>
<body>
<div id="maincontent">
	<div class="wrap">
	<div class="crumbs"><?php echo $a_langpackage->a_location; ?> &gt;&gt; <?php echo $a_langpackage->a_promotion_manage;?> &gt;&gt; <a href=""><?php echo $a_langpackage->a_words_edit; ?></a></div>
        <hr />
	<div class="infobox">
	<h3><span class="left"><?php echo $a_langpackage->a_words_edit; ?></span><span class="right" style="margin-right:15px;"><a href="m.php?app=word_list"><?php echo $a_langpackage->a_sensi_words; ?></a></span></h3>
    <div class="content2">

		<form action="a.php?act=word_edit" method="post" onsubmit="return checkForm();">
		<table class="form-table">
			<tr>
				<td><?php echo $a_langpackage->a_words; ?>：</td>
				<td style="text-align:left;"><input class="small-text" type="text" name="word_name" id="word_name" value="<?php echo $row['word_name']; ?>" style="width:200px;" maxlength="20"/> <span id="asd_name_message">*</span></td>
			</tr>
			<tr>
				<td><?php echo $a_langpackage->a_words_beizhu; ?>：</td>
				<td style="text-align:left;"><input type="hidden" name="word_id" value="<?php echo $row['word_id']; ?>"/>
				<textarea rows="5" cols="30" name="content"><?php echo $row['content']; ?></textarea>
				</td>
			</tr>

			<tr><td colspan="2"><span class="button-container"><input class="regular-button" type="submit" name="submit" value="<?php echo $a_langpackage->a_words_edit; ?>" /></span></td></tr>
		</table>
		</form>
	   </div>
	 </div>
   </div>
</div>
<script language="JavaScript">
function checkForm(){
	if(document.getElementById("word_name").value==""){
		alert("<?php echo $a_langpackage->a_words_kong; ?>");
		return false;
	}
	return true;
}
</script>
</body>
</html>