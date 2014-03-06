<?php
/*
 * 注意：此文件由itpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/shop/index.html
 * 如果您的模型要进行修改，请修改 models/shop/index.php
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
if(filemtime("templates/default/shop/index.html") > filemtime(__file__) || (file_exists("models/shop/index.php") && filemtime("models/shop/index.php") > filemtime(__file__)) ) {
	tpl_engine("default","shop/index.html",1);
	include(__file__);
} else {
/* debug模式运行生成代码 结束 */
?><?php
if(!$IWEB_SHOP_IN) {
	 trigger_error('Hacking attempt');
}
/* 公共信息处理 header, left, footer */
require("foundation/module_shop.php");
require("foundation/module_users.php");
require("foundation/asystem_info.php");
require("foundation/module_shop_category.php");

//引入语言包
$s_langpackage=new shoplp;
$i_langpackage=new indexlp;
$m_langpackage=new moduleslp;
/* 数据库操作 */
dbtarget('r',$dbServs);
$dbo=new dbex();

/* 定义文件表 */
$t_shop_info = $tablePreStr."shop_info";
$t_user_info = $tablePreStr."user_info";
$t_users = $tablePreStr."users";
$t_shop_category = $tablePreStr."shop_category";
$t_goods = $tablePreStr."goods";
$t_shop_guestbook = $tablePreStr."shop_guestbook";
$t_shop_categories = $tablePreStr."shop_categories";
$t_user_rank = $tablePreStr."user_rank";
$verifycode = unserialize($SYSINFO['verifycode']);

/* 商铺信息处理 */
include("foundation/fshop_locked.php");

//判断用户是否锁定，锁定则不许操作
$user_id = get_sess_user_id();
if($user_id > 0){
	$sql ="select locked from $t_users where user_id=$user_id";
	$row = $dbo->getRow($sql);
	if($row['locked']==1){
		session_destroy();
		trigger_error($m_langpackage->m_user_locked);//非法操作
	}
}

//商铺分类
$shop_rank = $SHOP['shop_categories'];
$shop_rank_arr = get_categories_rank($shop_rank,$dbo,$t_shop_categories);
if ($shop_rank_arr){
	$num = count($shop_rank_arr) - 1;
}

$sql = "select rank_id,user_name,last_login_time from $t_users where user_id='".$SHOP['user_id']."'";
$ranks = $dbo->getRow($sql);
$SHOP['rank_id'] = $ranks[0];

$sql = "select * from $t_user_rank where rank_id='".$ranks[0]."'";
$user_rank = $dbo->getRow($sql);

$best_num = 10;
$privilege = unserialize($user_rank[2]);
if($privilege){
	$best_num = $privilege[4];
}

/* 获取文章头部 */
$header = get_shop_header($s_langpackage->s_shop_index,$SHOP);
/* 本页面信息处理 */
$sql = "select goods_id,goods_name,goods_price,goods_thumb,is_set_image,transport_template_price from `$t_goods` where shop_id='$shop_id' and is_best=1 and is_on_sale=1 and lock_flg=0 order by sort_order asc,goods_id desc limit ".$best_num;
$best_goods = $dbo->getRs($sql);

$sql = "select goods_id,goods_name,goods_price,goods_thumb,is_set_image,transport_template_price from `$t_goods` where shop_id='$shop_id' and is_on_sale=1 and lock_flg=0 order by sort_order asc,goods_id desc limit 12";
$new_goods = $dbo->getRs($sql);


$sql = "SELECT * FROM $t_shop_guestbook WHERE shop_id='$shop_id' AND shop_del_status='1' order by add_time desc limit 10";
$guestbook_list = $dbo->getRs($sql);
$nav_selected="";

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo  $header['title'];?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<meta name="keywords" content="<?php echo  $header['keywords'];?>" />
<meta name="description" content="<?php echo  $header['description'];?>" />
<base href="<?php echo  $baseUrl;?>" />
<link href="skin/<?php echo  $SYSINFO['templates'];?>/css/import.css" type="text/css" rel="stylesheet" />
<link href="skin/<?php echo  $SYSINFO['templates'];?>/css/shop.css" rel="stylesheet" type="text/css" />
<link href="skin/<?php echo  $SYSINFO['templates'];?>/css/shop_<?php echo  $SHOP['shop_template'];?>.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="skin/<?php echo  $SYSINFO['templates'];?>/js/changeStyle.js"></script>
</head>
<body>
<!-- wrapper -->
<div id="wrapper"> <?php  require("shop/index_header.php");?>
  <!-- contents -->
  <div id="contents" class="clearfix" >
    <div id="pkz">
<!--    	<?php echo $s_langpackage->s_this_location;?><a href="index.php"><?php echo  $SYSINFO['sys_name'];?></a> &gt; <a href="shop_list.php"><?php echo $s_langpackage->s_shop_category;?></a> &gt;-->
<!--    	<?php foreach($shop_rank_arr as $k=>$value){?>-->
<!--    		<?php  if($num == $k){?>-->
<!--    			<a href="" ><?php echo $value['cat_name'];?></a>-->
<!--    		<?php  } else{?>-->
<!--    			<a href="" ><?php echo $value['cat_name'];?></a> &gt;-->
<!--    		<?php }?>-->
<!--    	<?php }?>-->
    </div>

    <div id="shopHeader" class=" mg12b clearfix">
    <!-- 店铺顶部图片-->
      <p><img src="<?php echo  $SHOP['shop_template_img'];?>" alt="" width="960" height="150" onerror="this.src='skin/default/images/nopic.gif'"/></p>
    <!-- /店铺顶部图片-->
      <p class="shopName"><?php echo  $SHOP['shop_name'];?></p>
      <div class="shop_nav"> <?php  require("shop/menu.php");?> </div>
    </div>
    <?php  require("shop/left.php");?>
    <div id="rightCloumn">
      <div class="recom bg_gradual mg12b">
      	<h3 class="ttlm_recom"><?php echo $s_langpackage->s_shop_notices;?></h3>
      	<!-- <img src="<?php echo  $SHOP['shop_notice'];?>" alt=""  width="710" height="226" /> -->
      	<br />
      	<?php  if($SHOP['shop_notice']){?>
      		<?php echo  $SHOP['shop_notice'];?>
      	<?php  } else{?>
			&nbsp;&nbsp;&nbsp;<?php echo $s_langpackage->s_no_notice;?>
      	<?php }?>

      </div>
      <div class="recom bg_gradual mg12b">
        <h3 class="ttlm_recom"><?php echo $s_langpackage->s_goods_commend;?></h3>
        <div id="winItems">
          <ul style="margin-left:-5px;padding-top:4px" class="clearfix">
            <?php if($best_goods) {
            foreach($best_goods as $value){?>
            <li>
              <div class="photo"><a target="_blank" href="<?php echo  goods_url($value['goods_id']);?>">
              <img src="<?php echo  $value['is_set_image'] ? str_replace('thumb_','',$value['goods_thumb']) : 'skin/default/images/nopic.gif';?>" alt="" width="190" height="190" onerror="this.src='skin/default/images/nopic.gif'"/></a></div>
              <div>
                <h4><a href="<?php echo  goods_url($value['goods_id']);?>"><?php echo  sub_str($value['goods_name'],50,false);?></a></h4>
              </div>
              <div class="price"> <span><?php echo $s_langpackage->s_money_sign;?><?php echo  $value['goods_price'];?><?php echo $s_langpackage->s_yuan;?></span> <span class="ship"><?php echo $s_langpackage->s_freight;?>：<?php echo  $value['transport_template_price'];?></span> </div>
            </li>
            <?php }?>
            <?php }?>
          </ul>
        </div>
      </div>
      <div class="newgoods bg_gradual mg12b">
        <h3 class="ttlm_newgoods"><?php echo $s_langpackage->s_new_goods;?></h3>
        <ul class="list_125 clearfix">
          <?php if($new_goods) {
          foreach($new_goods as $value){?>
          <li>
            <p class="photo"><a href="<?php echo  goods_url($value['goods_id']);?>">
            <img src="<?php echo  $value['is_set_image'] ? $value['goods_thumb'] : 'skin/default/images/nopic.gif';?>" width="112" height="112" alt="<?php echo  $value['goods_name'];?>"  onerror="this.src='skin/default/images/nopic.gif'"/></a></p>
            <h4 ><a href="<?php echo  goods_url($value['goods_id']);?>"><?php echo  sub_str($value['goods_name'],30,false);?></a></h4>
            <p class="price"><?php echo $s_langpackage->s_money_sign;?><?php echo  $value['goods_price'];?></p>
          </li>
          <?php }?>
          <?php }?>
        </ul>
      </div>
      <div class="guestbook  bg_gradual" id="message">
        <h3 class="ttl_guestbook"><?php echo $s_langpackage->s_buyer_comm;?></h3>
        <ul>
          <?php foreach($guestbook_list as $key =>$value){?>
          <li <?php if($key%2==0){?> class='double' <?php }?>>
            <div class="guester">

             <p><a><?php echo  $value['name'];?></a>:</p>
             <p class="g_txt"><?php echo  $value['content'];?>
             <span>[<?php echo  $value['add_time'];?>]</span></p>

            </div>
            <div class="shoper"> <?php if($value['reply']) {?>
             <p><a><?php echo $s_langpackage->s_seller_reply;?>:</a></p>
             <p class="g_txt"><?php echo  $value['reply'];?> </p>
              <?php }?> </div>
          </li>
          <?php }?>
        </ul>
        <div class="guestInput">
          <form action="do.php?act=shop_guestbook" name="guestForm" method="post" id="guestForm" onSubmit="return checkForm();">
            <input maxlength="20" name="name" type="hidden" value="<?php echo $USER['user_name'];?>" />
            <input maxlength="50" name="email" type="hidden" value="<?php echo $USER['user_email'];?>" />
            <input maxlength="50" name="contact" type="hidden" />
            <input type="hidden" name="shop_id" value="<?php echo  $shop_id;?>" />
            <input type="hidden" name="shop_name" value="<?php echo  $SHOP['shop_name'];?>" />
            <p class="line"></p>
            <table id="sendbox" cellpadding="0" cellspacing="0" border="0" >
              <tr>
                <td align="right" valign="top"><?php echo $s_langpackage->s_buyer_comm;?>：</td>
                <td><textarea class="border_c" cols="80" rows="8"  name="content" id="textareac" onkeyup="this.value=this.value.slice(0,300);"></textarea></td>
              </tr>
			   <?php if($verifycode['3']==1){?>
              <tr>
                <td></td>
                <td><input type="text" class="border_c" name="veriCode" id="veriCode" style="width:100px" maxlength="4" /> 
          	<img border="0" src="servtools/veriCodes.php" align="absmiddle"  id="verCodePic"><a href="javascript:;" onclick="return getVerCode();"><?php echo $i_langpackage->i_change_img;?></a></td>
              </tr>
			  <?php }?>
              <tr>
                <td></td>
                <td><input class="btnSetmess" type="submit" value="<?php echo $s_langpackage->s_wantto_comm;?>" /></td>
              </tr>
            </table>
          </form>
          <!--<p class="mg12b">
            <input style="margin-left:60px;" class="btnSetmess" type="button" value="<?php echo $s_langpackage->s_wantto_comm;?>" onclick="this.style.display='none';document.getElementById('sendbox').style.display='block'" />
          </p>-->
        </div>
      </div>
    </div>
  </div>
</div>
<?php   require("shop/index_footer.php");?>
</div>
<script>
function checkForm() {

	var name = document.getElementsByName("name")[0];
	var textareac = document.getElementById("textareac");
	var veriCode = document.getElementById("veriCode").value;
	if(!name.value) {
		alert("<?php echo $s_langpackage->s_login_pls;?>");
		return false;
	}
	if(!textareac.value) {
		alert("<?php echo $s_langpackage->s_type_comm_pls;?>");
		return false;
	}
	if(textareac.value.length>300){
		alert("<?php echo $s_langpackage->s_work_count_error;?>");
		textareac.focus();
		return false;
	}
	 <?php if($verifycode['3']==1){?>
		if(!veriCode){
			alert('<?php echo $i_langpackage->i_verifycode_notnone;?>');
			return false;
		}
	 <?php }?>
	return true;
}
function getVerCode() {
	document.getElementById("verCodePic").src="servtools/veriCodes.php?vc="+Math.random();
	return false;
}
</script>
</body>
</html>
<?php } ?>