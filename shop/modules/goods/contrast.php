<?php
/*
 * 注意：此文件由itpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/modules/goods/contrast.html
 * 如果您的模型要进行修改，请修改 models/modules/goods/contrast.php
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
if(filemtime("templates/default/modules/goods/contrast.html") > filemtime(__file__) || (file_exists("models/modules/goods/contrast.php") && filemtime("models/modules/goods/contrast.php") > filemtime(__file__)) ) {
	tpl_engine("default","modules/goods/contrast.html",1);
	include(__file__);
} else {
/* debug模式运行生成代码 结束 */
?><?php
	/*
	***********************************************
	*$ID:
	*$NAME:
	*$AUTHOR:E.T.Wei
	*DATE:Tue Mar 30 09:58:29 CST 2010
	***********************************************
	*/
	if(!$IWEB_SHOP_IN) {
		trigger_error('Hacking attempt');
	}
	//文件引入
	require("foundation/module_goods.php");
	require("foundation/module_category.php");
	/* 用户信息处理 */
	if(get_sess_user_id()) {
		$USER['login'] = 1;
		$USER['user_name'] = get_sess_user_name();
		$USER['user_id'] = get_sess_user_id();
		$USER['user_email'] = get_sess_user_email();
		$USER['shop_id'] = get_sess_shop_id();
	} else {
		$USER['login'] = 0;
		$USER['user_name'] = '';
		$USER['user_id'] = '';
		$USER['user_email'] = '';
		$USER['shop_id'] = '';
	}
	//定义数据表
	$t_goods = $tablePreStr."goods";
	$t_brand= $tablePreStr."brand";
	$t_category= $tablePreStr."category";
	$t_shop_info = $tablePreStr."shop_info";
	//读写分类定义方法
	$dbo=new dbex;
	dbtarget('r',$dbServs);
	//引入语言包
	$m_langpackage=new moduleslp;
	$i_langpackage=new indexlp;
	$s_langpackage=new shoplp;
	//操作
	$id = short_check(get_args("id"));
	$goods_ids = substr(short_check(get_args("contrast_goods_id")),0,-1);

	if ($goods_ids){
		$goods_ids = $goods_ids;
	}else if($id) {
		$goods_ids = $id;
	}else {
		trigger_error($m_langpackage->m_page_request_error);
	}
	$sql=" SELECT shop_id,goods_name,goods_thumb,goods_id,goods_price,brand_id,favpv,cat_id,transport_price,transport_template_price FROM $t_goods WHERE goods_id IN ($goods_ids) ";
	$goods_list = $dbo->getRs($sql);
	/* 获得商品分类 */
	$sub_category=get_parent_cats($goods_list[0]['cat_id'],$dbo,$t_category);

	foreach ($goods_list as $key=>$value){
		$row=$dbo->getRow("SELECT brand_name FROM $t_brand WHERE brand_id='{$value['brand_id']}'");
		$shop_name = $dbo->getRow("select shop_name from $t_shop_info where shop_id='$value[shop_id]'");
		$goods_list[$key]['brand_name']=$row['brand_name'];
		$goods_list[$key]['shop_name']=$shop_name['shop_name'];
	}
	$header['title'] = $m_langpackage->m_goods_pk;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo  $header['title'];?></title>
<link rel="stylesheet" type="text/css" href="skin/<?php echo  $SYSINFO['templates'];?>/css/import.css">
<link rel="stylesheet" type="text/css" href="skin/<?php echo  $SYSINFO['templates'];?>/css/parts.css">
<script language="JavaScript" src="servtools/ajax_client/ajax.js"></script>
<script type="text/javascript" src="skin/<?php echo  $SYSINFO['templates'];?>/js/changeStyle.js"></script>

</head>
<body>
<div id="wrapper">
  <?php  include("shop/index_header.php");?>
  <div id="contents" class="clearfix" >
    <div id="sub_channel">
      <ul class="clearfix">
        <li>
          <h3><img src="skin/default/images/part/ttl_channel_all.gif" alt="<?php echo $m_langpackage->m_all_category;?>" /></h3>
        </li>
			<?php foreach($sub_category as $value){?>
		        <?php  if($value['cat_id'] != $goods_list[0]['cat_id']) {?>
			        <li>
			        	<a href="<?php echo $value['url'];?>"><?php echo $value['cat_name'];?></a>
			        </li>
			    <?php }?>
	        <?php }?>
      </ul>
    </div>
  <table cellspacing="0" cellpadding="0" id="CompareTable">
     <tbody>
     <tr class="toolbar">
          <th scope="col"><a href="search.php"><?php echo $m_langpackage->m_all_remove;?></a></th>
          <?php foreach($goods_list as $k=>$value) {?>
          <th scope="col"><a onclick="move_pk(<?php echo  $value['goods_id'];?>);" href="javascript:;" ><?php echo $m_langpackage->m_remove;?></a> / <a onclick="add_shopFavorite(<?php echo  $value['goods_id'];?>,<?php echo  $value['shop_id'];?>,<?php echo $k;?>)" href="javascript:;" ><?php echo $m_langpackage->m_collect;?></a></th>
          <?php }?>
    </tr>

    <tr>
      <th scope="row"><?php echo $m_langpackage->m_pic;?></th>
      <?php if(is_array($goods_list)){?>
      <?php foreach($goods_list as $value) {?>
      <td class="picName"><a href="goods.php?id=<?php echo $value['goods_id'];?>" ><img height="80" width="80" alt="" src="<?php echo $value['goods_thumb'];?>" onerror="this.src='skin/default/images/nopic.gif'"></a></td> <?php }?>
    <?php }?>
    </tr>
    <tr>
      <th scope="row"><?php echo $m_langpackage->m_goods_name;?></th>
       <?php if(is_array($goods_list)){?>
      <?php foreach($goods_list as $value) {?>
      <td class="picName"><a target="_blank" href="goods.php?id=<?php echo $value['goods_id'];?>"><?php echo $value['goods_name'];?></a></td> <?php }?>
    <?php }?>
    </tr>
    <tr>
    <th scope="row"><?php echo $m_langpackage->m_move_cart;?></th>
     <?php if(is_array($goods_list)){?>
      <?php foreach($goods_list as $value) {?>
      <td class="picName"><a onclick ="addCart(<?php echo  $value['goods_id'];?>,<?php echo  $value['shop_id'];?>);" href="javascript:;"><img height="33" width="109" alt="放入购物车" src="skin/default/images/shop/btn_addgoods.gif"></a></td> <?php }?>
    <?php }?>
    </tr>
    <tr>
    <th scope="row"><?php echo $m_langpackage->m_order_shops;?></th>
    <?php if(is_array($goods_list)){?>
      <?php foreach($goods_list as $value) {?>
      <td><a target="_blank" href="shop.php?shopid=<?php echo $value['shop_id'];?>&app=index"><?php echo $value['shop_name'];?></a></td><?php }?>
    <?php }?>
    </tr>
    <tr>
     <th scope="row"><?php echo $m_langpackage->m_goods_price;?></th>
    <?php if(is_array($goods_list)){?>
      <?php foreach($goods_list as $value) {?>
      <td  class="picPrice"><?php echo $m_langpackage->m_money_sign;?><?php echo $value['goods_price'];?></td><?php }?>
    <?php }?>
    </tr>
    <tr>
      <th scope="row"><?php echo $m_langpackage->m_expense_country;?></th>
      <?php if(is_array($goods_list)){?>
      <?php foreach($goods_list as $value) {?>
      <td>
      	<?php echo $m_langpackage->m_money_sign;?><?php echo $value['transport_template_price'];?>
      </td>
      <?php }?>
      <?php }?>
    </tr>
    <tr>
    	<th scope="row"><?php echo $m_langpackage->m_collect_num;?></th>
      <?php if(is_array($goods_list)){?>
      <?php foreach($goods_list as $k=>$value) {?>
      	<td><span id="fid_<?php echo  $k;?>"><?php echo $value['favpv'];?></span></td>
      <?php }?>
      <?php }?>
    </tr>
     <tr class="toolbar">
          <th scope="col"><a href="search.php"><?php echo $m_langpackage->m_all_remove;?></a></th>
          <?php foreach($goods_list as $k=>$value) {?>
          	<th scope="col">
          		<a onclick="move_pk(<?php echo  $value['goods_id'];?>);" href="javascript:;"><?php echo $m_langpackage->m_remove;?></a> / <a onclick="add_shopFavorite(<?php echo  $value['goods_id'];?>,<?php echo  $value['shop_id'];?>,<?php echo $k;?>)" href="javascript:;" ><?php echo $m_langpackage->m_collect;?></a>
          	</th>
          <?php }?>
    </tr>
  </table>
  <form name="form1" action="" method="get" >
  	<input type="hidden" id="goods_ids" value="<?php echo  $goods_ids;?>"/>
  	<input type="hidden" id="shop_user" value="<?php echo  $USER['user_id'];?>" />
  </form>
</div>
<?php  include("shop/index_footer.php");?>
<script language="JavaScript" src="servtools/ajax_client/ajax.js"></script>
<script language="JavaScript" type="text/javascript">
	function addCart(id,shop_id) {
		var user_id = document.getElementById('shop_user').value;
		if (shop_id == user_id){
			alert('<?php echo  $m_langpackage->m_mygoods_error;?>');
		}else {
			var num = 1;
			ajax("do.php?act=goods_add_cart","POST","id="+id+"&num="+num,function(data){
				if(data == 1) {
					alert("<?php echo  $s_langpackage->s_g_addedcart;?>");
				} else if(data == -1) {
					alert("<?php echo  $s_langpackage->s_staycart;?>");
				} else if(data == -2) {
					alert("<?php echo  $s_langpackage->s_nomachgoods;?>");
				} else {
					alert("<?php echo  $s_langpackage->s_g_addfailed;?>");
				}
			});
		}
	}

	function add_shopFavorite(id,shop_id,k) {
		var user_id = document.getElementById('shop_user').value;
		var fid = "fid_"+k;
		var favpv = document.getElementById(fid).innerHTML;
		var favpv_num = Number(favpv) + Number(1);
		if (shop_id == user_id){
			alert('<?php echo  $m_langpackage->m_store_mygoods_error;?>');
		}else {
			ajax("do.php?act=goods_add_favorite","POST","id="+id,function(data){
				if(data == 1) {
					document.getElementById(fid).innerHTML = favpv_num;
					alert("<?php echo  $s_langpackage->s_g_addedfavorite;?>");
				} else if(data == -1) {
					alert("<?php echo $m_langpackage->m_store_info;?>");
				} else if(data == -2){
					alert("<?php echo $m_langpackage->m_shop_error_login;?>");
				}else {
					alert("<?php echo  $s_langpackage->s_g_addfailed;?>");
				}
			});
		}
	}

	function move_pk(id){
		var arr = document.getElementById('goods_ids').value;
		if (id == arr){
			location.href = "<?php echo  $baseUrl;?>search.php";
		}else {
			ajax("do.php?act=goods_movepk","POST","id="+id+"&goods_ids="+arr,function(data){
				if(data) {
					location.href = "<?php echo  $baseUrl;?>modules.php?app=contrast&id="+data;
				} else {
					alert("<?php echo $m_langpackage->m_sys_error;?>");
				}
			});
		}
	}

</script>
</body>
</html><?php } ?>