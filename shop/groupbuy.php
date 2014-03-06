<?php
/*
 * 注意：此文件由itpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/groupbuy.html
 * 如果您的模型要进行修改，请修改 models/groupbuy.php
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
if(filemtime("templates/default/groupbuy.html") > filemtime(__file__) || (file_exists("models/groupbuy.php") && filemtime("models/groupbuy.php") > filemtime(__file__)) ) {
	tpl_engine("default","groupbuy.html",1);
	include(__file__);
} else {
/* debug模式运行生成代码 结束 */
?><?php
header("content-type:text/html;charset=utf-8");
$IWEB_SHOP_IN = true;

require("foundation/asession.php");
require("configuration.php");
require("includes.php");
require_once("foundation/fstring.php");
require("foundation/flefttime.php");
require("foundation/module_tag.php");
require("foundation/module_nav.php");

/* 用户信息处理 */
require 'foundation/alogin_cookie.php';
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

//引入语言包
$i_langpackage = new indexlp;
$s_langpackage=new shoplp;

/* 定义文件表 */
$t_shop_info = $tablePreStr."shop_info";
$t_user_info = $tablePreStr."user_info";
$t_users = $tablePreStr."users";
$t_shop_category = $tablePreStr."shop_category";
$t_goods = $tablePreStr."goods";
$t_groupbuy = $tablePreStr."groupbuy";
$t_areas = $tablePreStr."areas";
$t_tag = $tablePreStr."tag";
$t_nav = $tablePreStr."nav";
$t_category = $tablePreStr."category";

/* 数据库操作 */
dbtarget('r',$dbServs);
$dbo=new dbex();

/* 产品处理 */
$sql_best = "SELECT * FROM $t_goods WHERE is_on_sale=1 AND is_best=1 and lock_flg=0 order by pv desc limit 4";
$sql_hot = "SELECT * FROM $t_goods WHERE is_on_sale=1 AND is_hot=1 and lock_flg=0 order by pv desc limit 10";
$goods_best = $dbo->getRs($sql_best);
$goods_hot = $dbo->getRs($sql_hot);

/* 浏览记录 */
$getcookie = get_hisgoods_cookie();
$goodshistory = array();
if($getcookie) {
	arsort($getcookie);
	$getcookie = array_keys($getcookie);
	$gethisgoodsid = implode(",",array_slice($getcookie, 0, 4));
	$sql = "select is_set_image,goods_id,goods_name,goods_thumb,goods_price from $t_goods where goods_id in ($gethisgoodsid)";
	$goodshistory = $dbo->getRs($sql);
}

$header['title'] = $i_langpackage->i_lay_out." - ".$SYSINFO['sys_title'];
$header['keywords'] = $i_langpackage->i_lay_out.','.$SYSINFO['sys_keywords'];
$header['description'] = $SYSINFO['sys_description'];

/* 时间处理 */
$now_time = new time_class();
$now_time = $now_time -> short_time();

$group_id=array();
$sql="select group_id from $t_groupbuy where group_condition ='-1' and examine='1'";
$groups_id = $dbo->getRs($sql);
foreach($groups_id as $key=>$val){
	$group_id[$key]=$val[0];
}
$group_id=implode(',',$group_id);

$sql="update $t_groupbuy set group_condition ='0' where  start_time <= '$now_time' and '$now_time' <= end_time ";
if($group_id){
	$sql.=" and group_id in($group_id)";
}
$dbo->exeUpdate($sql);

$group_id=array();
$sql="select group_id from $t_groupbuy where group_condition ='0' and examine='1'";
$groups_id = $dbo->getRs($sql);
foreach($groups_id as $key=>$val){
	$group_id[$key]=$val[0];
}
$group_id=implode(',',$group_id);

$sql="update $t_groupbuy set group_condition ='1' where '$now_time' >= end_time ";
if($group_id){
	$sql.=" and group_id in($group_id)";
}
$dbo->exeUpdate($sql);


$sql = "SELECT b.*,g.* FROM `$t_groupbuy` b left join `$t_goods` g on b.goods_id = g.goods_id";
$sql .= " WHERE b.recommended = 0 and g.lock_flg =0 and b.group_condition ='0' and b.examine = '1'";
//$sql .= " and b.start_time <= '$now_time' and '$now_time' <= b.end_time";
$result = $dbo->fetch_page($sql,$SYSINFO['product_page']);
$tag_list = get_tag_list($dbo,$t_tag,15);


$nav_selected =6;
$nav_list = get_nav_list($t_nav,$dbo);

	/* 处理系统分类 */
$sql_category = "select * from `$t_category` order by sort_order asc,cat_id asc,sort_order asc";
$result_category = $dbo->getRs($sql_category);

$CATEGORY = array();
if($result_category) {
	foreach($result_category as $v) {
		$CATEGORY[$v['parent_id']][$v['cat_id']] = $v;

	}
}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo  $header['title'];?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<meta name="keywords" content="<?php echo  $header['keywords'];?>" />
<meta name="description" content="<?php echo  $header['description'];?>" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<base href="<?php echo  $baseUrl;?>" />
<link href="skin/<?php echo  $SYSINFO['templates'];?>/css/index.css" rel="stylesheet" type="text/css" />
<link href="skin/<?php echo  $SYSINFO['templates'];?>/css/parts.css" rel="stylesheet" type="text/css" />
<link href="skin/<?php echo  $SYSINFO['templates'];?>/css/import.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="skin/<?php echo  $SYSINFO['templates'];?>/js/changeStyle.js"></script>
</head>
<body>
<div id="wrapper">
<?php  include("shop/index_header.php");?>
  <input type="hidden" name="name" value="">
  <input type="hidden" name="order" value="">
  <!--header end -->
  <div id="contents" class="clearfix"  >
  	<div id="channel" class="clearfix">
      <ul class="clearfix">
        <li >
           <h2><img onmouseover="show_obj('category_box')" onmouseout="hidden_obj('category_box')" src="skin/default/images/ttl_channel_all.gif" alt="<?php echo $i_langpackage->i_allgoodsheader_category;?>"  onerror="this.src='skin/default/images/nopic.gif'"/></h2>
        </li>
        <?php
        	foreach ($nav_list as $value){
        ?>
        <li><span><a href="<?php echo $value['url']?>"><?php echo $value['nav_name']?></a>|</span></li>
		<?php
        	}
		?>
      </ul>
      </div>
	    <div id="category_box" class="allMerchan" style=" display:none" onmouseover="show_obj(this)"  onmouseout="hidden_obj(this)">
        <ul  >
        <?php  foreach(array_slice ($CATEGORY[0], 0) as $key=>$cat){?>
        	<li class="clearfix">
            <h3><a href="<?php echo  category_url($cat['cat_id']);?>" title="<?php echo  $cat['cat_name'];?>"><?php echo  $cat['cat_name'];?></a></h3>
            <?php if(isset($CATEGORY[$cat['cat_id']]) && $CATEGORY[$cat['cat_id']]){?>
            <p>
                <?php  foreach(array_slice ($CATEGORY[$cat['cat_id']], 0, 8) as $subcat){?>
                    <a href="<?php echo  category_url($subcat['cat_id']);?>" title="<?php echo  $cat['cat_name'];?>"><?php echo  $subcat['cat_name'];?></a>|
                <?php }?>
             </p>
             <?php }?>
            </li>
		<?php }?>
        </ul>
    </div>
    </div>

    <div id="leftColumn">
      <div id="leftMian">
        <div class="top2 clearfix">
          <!--<span class="right"><a id="list" onclick="changeStyle2('list',this)" class="selected" href="javascript:void(0);" hidefocus="true"><?php echo $i_langpackage->i_list;?></a><a id="window" onclick="changeStyle2('window',this)" href="javascript:void(0);" hidefocus="true"><?php echo $i_langpackage->i_show_window;?></a></span> -->
          <h3 class="ttlm_selitems"><?php echo $i_langpackage->i_choice_good;?></h3>
        </div>
        <div class="groupShow clearfix">
          <table class="tab_group " width="100%">
            <tbody>
              <tr>
                <th class="proName"><?php echo $s_langpackage->s_groupbuy_goods;?></th>
                <th class="groupPic"><?php echo $s_langpackage->s_groupbuy_price;?></th>
                <th class="groupQut"><?php echo $s_langpackage->s_groupbuy_num;?></th>
                <th class="groupName"><?php echo $s_langpackage->s_goods_name;?></th>
                <th class="timeLeft"><?php echo $s_langpackage->s_groupbuy_time;?></th>
              </tr>
            <?php  if($result['result']) {
            foreach($result['result'] as $v){?>
            <tr>
              <td valign="middle" class="proName"><div class="photo"><a href="goods.php?id=<?php echo  $v['group_id'];?>&app=groupbuyinfo"><img src="<?php echo  $v['is_set_image'] ? $v['goods_thumb'] : 'skin/default/images/nopic.gif';?>" width="95" height="95" alt="<?php echo  $v['goods_name'];?>"  onerror="this.src='skin/default/images/nopic.gif'"/></a> </div>
                <div class="proInfo">
                  <h3 class="mg12b"><a href="goods.php?id=<?php echo  $v['group_id'];?>&app=groupbuyinfo"><?php echo  sub_str($v['group_name'],22,false);?></a></h3>
                  <p>[<?php echo $i_langpackage->i_groupbuy_say;?>]<?php echo  $v['group_desc'];?></p>
                </div></td>
              <td class="groupPic"><em class="pic"><?php echo $i_langpackage->i_money_sign;?><?php echo  $v['spec_price'];?><?php echo  $s_langpackage->s_yan;?></em></td>
              <td class="groupQut"><?php echo  $v['min_quantity'];?></td>
              <td class="groupName"><a href="goods.php?id=<?php echo  $v['goods_id'];?>"><?php echo  sub_str($v['goods_name'],22,false);?></a></td>
              <td class="timeleft"><?php echo  time_left(strtotime($v['end_time']));?></td>
            </tr>
            <?php }?>
            <?php  }else {?>

              <td  style='text-align:left' colspan="5">&nbsp;<?php echo $i_langpackage->i_no_groupbuy;?>！</td>
            </tr>
            <?php }?>
            </tbody>

          </table>
  		<div class="pagenav clearfix">
			<?php  require("modules/page.php");?>
		</div>
        </div>
      </div>
      <!-- main end -->

      <!-- leftColumn -->
    </div>
    <div id="rightColumn">
      <div class="tagSet bg_gary mg12b">
        <h3 class="ttlm_hottag"><?php echo $i_langpackage->i_hot_label;?></h3>
        <div class="tags">
			<?php foreach($tag_list as $value){?>
        	<a href="<?php echo $value['url'];?>" style="color:<?php echo $value['tag_color'];?>;<?php if($value['is_blod']){?>font-weight:bold;<?php }?>"><?php echo $value['tag_name'];?></a>
        	<?php }?>
       </div>
      <div class="hotgoods bg_gary mg12b">
        <h3 class="ttlm_hotgoods"><?php echo $i_langpackage->i_goods_commend;?></h3>
        <ul>
          <?php foreach($goods_hot as $key => $v){?>
          <li <?php if($key%2!=0){?> class="doublenum"<?php }?>>
            <p class="photo"><a href="<?php echo  goods_url($v['goods_id']);?>" target="_blank"><img src="<?php echo  $v['is_set_image'] ? $v['goods_thumb'] : 'skin/default/images/nopic.gif';?>" alt="" width="58" height="58"  onerror="this.src='skin/default/images/nopic.gif'"/></a></p>
            <h4><a href="<?php echo  goods_url($v['goods_id']);?>" target="_blank"><?php echo  sub_str($v['goods_name'],38);?></a></h4>
            <p class="price"><?php echo $i_langpackage->i_money_sign;?><?php echo $v['goods_price'];?></p>
          </li>
          <?php }?>
        </ul>
      </div>
      <div class="viewrecord bg_gary mg12b">
        <h3 class="ttlm_viewrecord"><?php echo $i_langpackage->i_brower_register;?></h3>
        <ul class="clearfix">
          <?php foreach($goodshistory as $k=> $v){?>
          <li <?php if($k%2!=0){?>class="lst"<?php }?>>
            <p class="photo"><a href="<?php echo  goods_url($v['goods_id']);?>" target="_blank"><img src="<?php echo  $v['is_set_image'] ? $v['goods_thumb'] : 'skin/default/images/nopic.gif';?>" alt="" width="58" height="58"  onerror="this.src='skin/default/images/nopic.gif'"/></a></p>
            <p class="price"><?php echo $i_langpackage->i_money_sign;?><?php echo $v['goods_price'];?></p>
          </li>
          <?php }?>
        </ul>
      </div>
      <!-- /rightColumn -->
    </div>
  </div>
  <?php  require("shop/index_footer.php");?>
  <!--footer end-->
  </div>
</body>
</html><?php } ?>