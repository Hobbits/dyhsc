<?php
/*
 * 注意：此文件由itpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/modules/goods/edit_transport_template.html
 * 如果您的模型要进行修改，请修改 models/modules/goods/edit_transport_template.php
 *
 * 修改完成之后需要您进入后台重新编译，才会重新生成。
 * 如果您开启了debug模式运行，那么您可以省去上面这一步，但是debug模式每次都会判断程序是否更新，debug模式只适合开发调试。
 * 如果您正式运行此程序时，请切换到service模式运行！
 *
 * 如您有问题请到官方论坛（http://tech.jooyea.com/bbs/）提问，谢谢您的支持。
 */
?><?php
/*
 * 此段代码由debug模式下生成运行，请勿改动！
 * 如果debug模式下出错不能再次自动编译时，请进入后台手动编译！
 */
/* debug模式运行生成代码 开始 */
if(!function_exists("tpl_engine")) {
	require("foundation/ftpl_compile.php");
}
if(filemtime("templates/default/modules/goods/edit_transport_template.html") > filemtime(__file__) || (file_exists("models/modules/goods/edit_transport_template.php") && filemtime("models/modules/goods/edit_transport_template.php") > filemtime(__file__)) ) {
	tpl_engine("default","modules/goods/edit_transport_template.html",1);
	include(__file__);
} else {
/* debug模式运行生成代码 结束 */
?><?php
	/*
	***********************************************
	*$ID:eidt_transport_template
	*$NAME:eidt_transport_template
	*$AUTHOR:E.T.Wei
	*DATE:Sat Apr 03 10:40:43 CST 2010
	***********************************************
	*/
	if(!$IWEB_SHOP_IN) {
		trigger_error('Hacking attempt');
	}

	//文件引入
	require("foundation/module_goods.php");
	require("foundation/module_areas.php");
	//引入语言包
	$m_langpackage = new moduleslp;
	$i_langpackage=new indexlp;
	//数据表定义区
	$t_areas = $tablePreStr."areas";
	$t_transport_template = $tablePreStr."goods_transport";
	$t_transport = $tablePreStr."transport";
	//读写分类定义方法
	$dbo = new dbex;
	dbtarget("r",$dbServs);
	$id = intval(get_args("id"));
	$sql = "SELECT * FROM $t_transport_template WHERE id='$id'";
	$transport_template_info = $dbo->getRow($sql);
	$transport_type = unserialize($transport_template_info['content']);
	foreach ($transport_type as $value){
		$transport_type[]=$value;
	}
	$arr = unserialize($transport_template_info['content']);
	//查询开启的配送方式
	$sql = "SELECT * FROM $t_transport WHERE ifopen='1'";
	$arr_list=$dbo->getRs($sql);
	
	//循环查出开启的配送方式中，保存的相应的方式
	$type_list = array();
	foreach ($arr_list as $v){
		$tran_type=$v['tranid'];
		$type_list[$v['tranid']]="";	//注:该变量根据$v['tranid']的值的改变而变，通过循环定义
		if (isset($arr[$tran_type])&&count($arr[$tran_type])>1) {
			$emsarea=array();
			foreach ($arr[$tran_type] as $key=>$value){
				if(is_numeric($key)){
					$emsarea["{$value['frist']},{$value['second']}"][]=$key;
				}
			}
			$idlist="";
			$area_name_list="";
			$num=0;
			foreach ($emsarea as $key=>$value){
				foreach ($value as $k=>$v){
					$idlist.=$v.",";
					$sql="SELECT area_name FROM $t_areas WHERE area_id='$v'";
					$area_info = $dbo->getRow($sql);
					$area_name_list.=$area_info['area_name'].",";
				}
				$num++;
				$key_str = explode(",",$key);
				$type_list[$v['tranid']].="&nbsp;&nbsp;&nbsp;&nbsp;<li>至<input type='text' name='ord_item_word'.$tran_type.'[]' value='$area_name_list' onclick=\"eidtarea('$tran_type','$idlist','$num')\" id='item$num'  />
					<input type='hidden' id='itemvalue$num' name='ord_item_dest'.$tran_type.'[]' value='$idlist' />的";
				$type_list[$v['tranid']].=$m_langpackage->m_transport_template_frist;
				$type_list[$v['tranid']].="<input type='text' name='ord_area_frist'.$tran_type.'[]' value='{$key_str[0]}' />".$m_langpackage->m_transport_template_second.
					"<input type='text' name='ord_area_second'.$tran_type.'[]' value='{$key_str[1]}' /></li>";
				$idlist="";
				$area_name_list="";
			}
		}
	}
	//循环生成json
	$post=array();
	foreach ($arr_list as $v){
		if(isset($transport_type[$v['tranid']])){
			$post[$v['tranid']]=json_encode($transport_type[$v['tranid']]);
		}
	}
	$area_list = get_area_list_bytype($dbo,$t_areas,1);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo  $m_langpackage->m_u_center;?></title>
<link rel="stylesheet" type="text/css" href="skin/<?php echo  $SYSINFO['templates'];?>/css/modules.css">
<link rel="stylesheet" type="text/css" href="skin/<?php echo  $SYSINFO['templates'];?>/css/layout.css">
<link rel="stylesheet" type="text/css" href="skin/<?php echo  $SYSINFO['templates'];?>/css/style.css">
<script type="text/javascript" src="skin/<?php echo  $SYSINFO['templates'];?>/js/userchangeStyle.js"></script>

</head>
<body onload="bodyonload();changeMenu();">
<?php  require("shop/index_header.php");?>
	<div class="site_map">
	  <?php echo $m_langpackage->m_current_position;?><A href="index.php"><?php echo $SYSINFO['sys_name'];?></A>/<a href="modules.php"><?php echo $m_langpackage->m_u_center;?></a>/&nbsp;&nbsp;<?php echo  $m_langpackage->m_edit_transport_template;?>
	</div>
    <div class="clear"></div>
	<?php  require("modules/left_menu.php");?>
    <div class="main_right">
		<div class="right_top"></div>
		<div class="cont">
			<div class="title_uc"><span class="tr_op"><a href="javascript:window.close();" ><h5>返回修改页面</h5></a>&nbsp;&nbsp;</span></div>
			<form action="do.php?act=edit_transport_template" method="post" name="form_transport_template" onsubmit="return checkForm(this);">
				<input type="hidden" name="id" value="<?php echo $id;?>" />
				<table id="boxtable" width="100%" style="border:0" cellspacing="0">
					<tr>
						<td width="100px;"><?php echo  $m_langpackage->m_transport_name;?>:</td><td><input type="text" name="transport_name" value="<?php echo $transport_template_info['transport_name'];?>" /><span><?php echo $m_langpackage->m_transport_name_message;?></span></td>
					</tr>
					<tr>
						<td><?php echo  $m_langpackage->m_transport_description;?>:</td><td><input type="text" name="description" value="<?php echo $transport_template_info['description'];?>" /><span><?php echo $m_langpackage->m_transport_description_message;?></span></td>
					</tr>
					<tr>
						<td colspan="3"><b><?php echo  $m_langpackage->m_choose_transport_type;?></b><span><?php echo $m_langpackage->m_choose_transport_type_message;?></span></td>
					</tr>
					<?php if(is_array($arr_list)){?>
						<?php foreach($arr_list as $k=>$value){?>
							<tr>
								<td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="transport_type[]" value="<?php echo $value['tranid'];?>" id="<?php echo $value['tranid'];?>" onclick="showtype('<?php echo $value['tranid'];?>')" /><?php echo $value['tran_name'];?>:</td>
							</tr>
							<tr id="<?php echo $value['tranid'];?>_box" style="display:none;">
								<td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;
									<?php echo $m_langpackage->m_transport_template_frist;?><input type="text" id="frist<?php echo $value['tranid'];?>" name="frist<?php echo $value['tranid'];?>" value="0.00" maxlength="10"/>
									<?php echo $m_langpackage->m_transport_template_second;?><input type="text" id="second<?php echo $value['tranid'];?>" name="second<?php echo $value['tranid'];?>" value="0.00" maxlength="10"/><br />
									<ul id="wordbox_<?php echo $value['tranid'];?>">
									<?php echo $type_list[$v['tranid']];?>
									</ul>
									&nbsp;&nbsp;&nbsp;&nbsp;
									<a href="javascript:;" onclick="showareslist('<?php echo $value['tranid'];?>')" ><b><?php echo $m_langpackage->m_transport_cont;?></b></a>
								</td>
							</tr>
						<?php }?>
					<?php }?>
					<tr>
						<td colspan="3"><input class="submit" type="submit" name="sub" value="<?php echo $m_langpackage->m_shure;?>"  /></td>
					</tr>
				</table>
			</form>
		</div>
	</div>
	<div class="clear"></div>
	<div id="bgdiv" style="display:none;"></div>
	<div id="category_select" style="display:none;">
		<div class="category_title_1"><span onclick="hidebgdiv();"><?php echo $m_langpackage->m_close;?></span><?php echo $m_langpackage->m_plss_select_cateogry;?></div>
		<ul id="select_first" class="ulselect">
		<?php if(isset($category_info)){?>
			<?php foreach($category_info as $k=>$v){?>
				<?php if($v['parent_id']==0){?>
				<li title="<?php echo  $v['cat_id'];?>"><?php echo  $v['cat_name'];?></li>
				<?php }?>
			<?php }?>
			<?php }?>
		</ul>
		<ul id="select_second" class="ulselect"></ul>
		<ul id="select_third" class="ulselect"></ul>
		<ul id="select_fourth" class="ulselect"></ul>
		<div class="category_com"><input type="button" value="<?php echo $m_langpackage->m_post;?>" onclick="postcatid();" /></div>
	</div>
	<div style="position:absolute;style:top:0px;left:0px; padding:5px; background:#f1f1f1; display:none; width:420px;" id="mydiv">
		<?php if(is_array($area_list)){?>
			<?php foreach($area_list as $k=>$value){?>
				<div style="float:left; width:75px;"><input type="checkbox" name="area[]" value="<?php echo $value['area_id'];?>"  /><?php echo $value['area_name'];?></div>
			<?php }?>
		<?php }?>
		<input type="hidden" name="hdnum" value="0" id="hdnum" />
		<input type="hidden" name="hdtxt" value="" id="hdtxt" />
		<input type="hidden" name="iseidt" id="iseidt" value="" />
		<input type="button" name="doselect" value="<?php echo $m_langpackage->m_shure;?>"  onclick="doselect()" />
	</div>
<div class="footer"><?php require("shop/index_footer.php");?></div>
</body>
</html>
<script language="JavaScript" type="text/javascript">
	function showtype(txt){
		var chosid = txt+"_box";
		var actobj = document.getElementById(txt);
		var obj = document.getElementById(chosid);
		if(actobj.checked){
			obj.style.display="";
		}else{
			obj.style.display="none";
		}
	}
	function showareslist(txt){
		var obj = document.getElementById('mydiv');
		var areaobj = document.getElementsByName("area[]");
		var inputname = "ord_item_dest"+txt+"[]";
		var conobj = document.getElementsByName(inputname);
		var arrstr = "";
		for(i=0;i<conobj.length;i++){
			arrstr+=conobj[i].value;
		}
		var arrstr = arrstr.substring(0,arrstr.length-1);
		var strarr = arrstr.split(",");
		if(arrstr.length>0){
			for (a=0;a<areaobj.length;a++){
				for(b=0;b<strarr.length;b++){
					if(areaobj[a].value==strarr[b]){
						areaobj[a].disabled=true;
					}
				}
			}
		}
		document.getElementById('hdtxt').value=txt;

		obj.style.left = document.body.clientWidth/2-(parseInt(500)/2)+"px";
		obj.style.top = document.body.clientHeight/2-(parseInt(300)/2)-30+document.documentElement.scrollTop/2+"px";
		obj.style.display="";
	}
	function doselect(){
		var obj = document.getElementsByName("area[]");
		var str="";
		var num=document.getElementById('hdnum').value;
		var hdtxt=document.getElementById('hdtxt').value;
		var idlist ="";
		for(i=0;i<obj.length;i++){
			if(obj[i].checked){
				str+=obj[i].nextSibling.nodeValue+",";
				idlist+=obj[i].value+",";
			}
			obj[i].disabled=false;
		}
		var boxid = "wordbox_"+hdtxt;
		var boxobj = document.getElementById(boxid);
		if(document.getElementById('iseidt').value==''){
			if(str.length>0){
				boxobj.innerHTML+="&nbsp;&nbsp;&nbsp;&nbsp;<li ><?php echo $m_langpackage->m_to;?><input type='text' name='ord_item_word"+(hdtxt)+"[]' value='"+str+"' "+"onclick=\"eidtarea('"+hdtxt+"','"+idlist+"','"+(num+1)+"')\""+" id='item"+(num+1)+"'  /><input type='hidden' id='itemvalue"+(num+1)+"' name='ord_item_dest"+(hdtxt)+"[]' value='"+idlist+"' /><?php echo $m_langpackage->m_de;?><?php echo $m_langpackage->m_transport_template_frist;?><input type='text' name='ord_area_frist"+(hdtxt)+"[]' value='' /><?php echo $m_langpackage->m_transport_template_second;?><input type='text' name='ord_area_second"+(hdtxt)+"[]' value='' /></li>";
				document.getElementById('hdnum').value=parseInt(num)+1;
				for(i=0;i<obj.length;i++){
					obj[i].checked=false;
				}
			}
		}else{
			var chosid = "itemvalue"+document.getElementById('iseidt').value;
			var chostext = "item"+document.getElementById('iseidt').value;
			var idobj = document.getElementById(chosid);
			var txtobj = document.getElementById(chostext);
			idobj.value=idlist;
			txtobj.value=str;
		}
		document.getElementById('iseidt').value='';
		document.getElementById('mydiv').style.display="none";
	}
	function remove(obj,dx){
		if(isNaN(dx)||dx>obj.length){
			return false;
		}
		for(i=0,n=0;i<obj.length;i++){
			if(obj[i]!=obj[dx]){
				obj[n++]=obj[i];
			}
		}
		obj.length-=1;
	}
	function eidtarea(txt,ids,num){
		var obj = document.getElementById('mydiv');
		var areaobj = document.getElementsByName("area[]");
		var strarr = ids.split(",");
		document.getElementById('iseidt').value=num;
		showareslist(txt);
		for(i=0;i<areaobj.length;i++){
			areaobj[i].disabled=false;
			for(j=0;j<strarr.length;j++){
				if(areaobj[i].value==strarr[j]){
					areaobj[i].checked=true;
				}
			}
		}
	}
	function bodyonload(){
		<?php foreach($post as $k=>$value){?>
			var obj= <?php echo $value;?>;
			if(obj.frist>0){
				document.getElementById("frist<?php echo  $k;?>").value=obj.frist;
				document.getElementById("second<?php echo  $k;?>").value=obj.second;
				document.getElementById('<?php echo  $k;?>').checked=true;
				document.getElementById('<?php echo  $k;?>'+"_box").style.display='';
			}
		<?php }?>
	}
	function checkForm(obj){
		if(obj.transport_name.value==''){
			alert('<?php echo $m_langpackage->m_in_template_name;?>');
			return false;
		}
		if(obj.description.value==''){
			alert('<?php echo $m_langpackage->m_in_template_description;?>');
			return false;
		}
		var transport_type =document.getElementsByName('transport_type[]');
		var a=0;
		for(i=0;i<transport_type.length;i++){
			if(transport_type[i].checked){
				var frist = "frist" + transport_type[i].value;
				var second = "second" + transport_type[i].value;
				a++;
				if(parseInt(document.getElementsByName(frist)[0].value)==0||parseInt(document.getElementsByName(second)[0].value)==0){
					alert('<?php echo $m_langpackage->m_set_shipping_cost;?>');
					return false;
				}
			}
		}
		if(a==0){
			alert('<?php echo $m_langpackage->m_choose_shipping_method;?>');
			return false;
		}
	}
</script>
<?php } ?>