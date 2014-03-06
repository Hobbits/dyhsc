<?php
/*
 * 注意：此文件由itpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/shop/left.html
 * 如果您的模型要进行修改，请修改 models/shop/left.php
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
if(filemtime("templates/default/shop/left.html") > filemtime(__file__) || (file_exists("models/shop/left.php") && filemtime("models/shop/left.php") > filemtime(__file__)) ) {
	tpl_engine("default","shop/left.html",1);
	include(__file__);
} else {
/* debug模式运行生成代码 结束 */
?><?php
if(!$IWEB_SHOP_IN) {
	trigger_error('Hacking attempt');
}

require_once("foundation/module_credit.php");

$t_credit = $tablePreStr."credit";
$t_integral = $tablePreStr."integral";
$t_user_rank = $tablePreStr."user_rank";
$t_users = $tablePreStr."users";



/* 处理商铺自定义分类 */
$category_list = get_shop_category_list($dbo,$t_shop_category,$shop_id);
$category_list_new = array();
if(!empty($category_list)) {
	foreach($category_list as $v) {
		$category_list_new[$v['shop_cat_id']]['shop_cat_id'] = $v['shop_cat_id'];
		$category_list_new[$v['shop_cat_id']]['shop_cat_name'] = $v['shop_cat_name'];
		$category_list_new[$v['shop_cat_id']]['parent_id'] = $v['parent_id'];
		$category_list_new[$v['shop_cat_id']]['shop_cat_unit'] = $v['shop_cat_unit'];
		$category_list_new[$v['shop_cat_id']]['sort_order'] = $v['sort_order'];
	}
}
unset($category_list);

	function get_sub_category ($category_list,$parent_id) {
		$array = array();
		foreach($category_list as $k=>$v) {
			if($v['parent_id']==$parent_id) {
				$array[$k] = $v;
			}
		}
		return $array;
	}

$sql="select b.rank_name from $t_users as a,$t_user_rank as b where a.user_id=$shop_id and a.rank_id=b.rank_id";
$rank_name=$dbo->getRow($sql);

//获取商家信用值
$credit=get_credit($dbo,$t_credit,$shop_id);
$credit['SUM(seller_credit)']=intval($credit['SUM(seller_credit)']);
$integral=get_integral($dbo,$t_integral,$credit['SUM(seller_credit)']);
if( $credit['SUM(seller_credit)'] < 0 )
	$credit['SUM(seller_credit)'] = 0;
$seller_credit = $credit['SUM(seller_credit)'];
$sql = "select * from `$t_integral` where $seller_credit>=int_min and $seller_credit <= int_max";
$credit_row = $dbo->getRow($sql);

//引入语言包
if(!isset($s_langpackage)){
	$s_langpackage=new shoplp;
}
?>    <div id="shopContents" class="clearfix">
      <div id="leftCloumn">
        <div class="shopInfo mg12b" >
          <h2><p><img src="<?php echo  $SHOP['shop_logo'] ? $SHOP['shop_logo'] : 'skin/default/images/shop_nologo.gif';?>" alt="<?php echo  $SHOP['shop_name'];?>"   /></p></h2>
          <p><?php echo $s_langpackage->s_nickname;?>：<span><a target="_blank" href="" title="<?php echo  $ranks['user_name'];?>"><?php echo  $ranks['user_name'];?></a></span></p>
          <?php if($im_enable==true){?><p><?php echo $s_langpackage->s_contact_seller;?>：<script src="imshow.php?u=<?php echo $SHOP['user_id'];?>"></script></p><?php }?>
          <p><?php echo $s_langpackage->s_goods_num;?>：<span><?php echo  $SHOP['goods_num'];?></span></p>

          <p><?php echo $s_langpackage->s_seller_c;?>：<a href="shop_rank.php" hideFocus=true>
		  <img style="margin-left:5px; vertical-align:text-bottom" src="<?php echo $credit_row['int_img'];?>" title="<?php echo $credit['SUM(seller_credit)'];?>" />
		  </a></p>


          <p><?php echo $s_langpackage->s_new_login;?>：<span><?php echo  $ranks['last_login_time'];?></span></p>
          <p><?php echo $s_langpackage->s_creat_time;?>：<span><?php echo  $SHOP['shop_creat_time'];?></span></p>
          <p><?php echo $s_langpackage->s_approve_info;?>：<span><a href="javascript:;" title="<?php echo $rank_name['rank_name'];?>"  class="shop_cert left"><?php echo $rank_name['rank_name'];?></a></span></p>
		  <p><a class="favShop" onclick="add_shopFavorite(<?php echo  $shop_id;?>)" href="javascript:;"><?php echo $s_langpackage->s_store_shop;?></a>
<!--		  <a class="setLatter" href="shop.php?shopid=<?php echo  $shop_id;?>&app=index#message"><?php echo $s_langpackage->s_send_mail;?></a>-->
		  </p>
        </div>
        <div class="shopSearch bg_gary mg12b">
          <h3 class="ttlm_shopsec"><a class="highlight" href="ucategory.php?s=<?php echo  $SHOP['shop_id'];?>"><?php echo $s_langpackage->s_store_insearch;?></a></h3>
          <form action="ucategory.php" method="get">
            <input name="s" value="<?php echo  $SHOP['shop_id'];?>" type="hidden" />
          <p>
            <input class="txt_ser" name="k" type="text" />
            <input class="btn_ser mg20b" value="<?php echo $s_langpackage->s_search;?>" type="submit" />
          </p>
          <input type="hidden" name="shop_user" id="shop_user" value="<?php echo $USER['user_id'];?>">
          </form>
        </div>
        <div class="itemsCate bg_gary">
          <h3 class="ttlm_itemsCate"><a href="<?php echo  shop_url($shop_id,'products');?>"><?php echo $s_langpackage->s_goods_category;?></a></h3>
          <ul class="items">
            <?php  if(empty($category_list_new)){?>
            <li class="unflod">
            <h4><a href=""><?php echo  $s_langpackage->s_shop_noaddcategory;?></a></h4>
            </li>
            <?php } else {
                $category_0 = get_sub_category($category_list_new,0);
                foreach($category_0 as $v) {?>
            <li class="unflod">
            <h4><a href="<?php echo  ucategory_url($v['shop_cat_id']);?>"><?php echo  $v['shop_cat_name'];?></a></h4>
            <?php 
                $category_sub = get_sub_category($category_list_new,$v['shop_cat_id']);
                if(!empty($category_sub)){?>
            <ul class="per_items">
                <?php foreach($category_sub as $value) {?>
                    <li><h4><a href="<?php echo  ucategory_url($value['shop_cat_id']);?>"><?php echo  $value['shop_cat_name'];?></a></h4></li>
                <?php  }?>
            </ul>
                <?php  }?>
            </li>
            <?php  }?>
            <?php }?>
          </ul>
        </div>
      </div>
<script language="JavaScript" src="servtools/ajax_client/ajax.js"></script>
<script language="JavaScript">
	<!--

		function add_shopFavorite(id) {
			var user_id = document.getElementById('shop_user').value;
			if (id == user_id){
				alert("<?php echo $s_langpackage->s_myshop_error;?>");
			}else {
				ajax("do.php?act=shop_add_favorite","POST","id="+id,function(data){
					if(data == 1) {
						alert("<?php echo  $s_langpackage->s_g_addedfavorite;?>");
					} else if(data == -1) {
						alert("<?php echo  $s_langpackage->s_store_info;?>");
					} else if(data == -2){
						alert("<?php echo  $s_langpackage->s_shop_error1;?>");
					}else {
						alert("<?php echo  $s_langpackage->s_g_addfailed;?>");
					}
				});
			}
		}

	//-->
</script>
<?php } ?>