<?php
/*
 * 注意：此文件由itpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/shop/credit.html
 * 如果您的模型要进行修改，请修改 models/shop/credit.php
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
if(filemtime("templates/default/shop/credit.html") > filemtime(__file__) || (file_exists("models/shop/credit.php") && filemtime("models/shop/credit.php") > filemtime(__file__)) ) {
	tpl_engine("default","shop/credit.html",1);
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
require_once("foundation/module_credit.php");
require("foundation/module_shop_category.php");

//引入语言包
$s_langpackage=new shoplp;
$i_langpackage=new indexlp;
$m_langpackage=new moduleslp;
/* 数据库操作 */
dbtarget('r',$dbServs);
$dbo=new dbex();
$current_url = get_domain();
/* 定义文件表 */
$t_shop_info = $tablePreStr."shop_info";
$t_user_info = $tablePreStr."user_info";
$t_users = $tablePreStr."users";
$t_shop_category = $tablePreStr."shop_category";
$t_goods = $tablePreStr."goods";
$t_shop_guestbook = $tablePreStr."shop_guestbook";
$t_credit = $tablePreStr."credit";
$t_integral = $tablePreStr."integral";
$t_shop_categories = $tablePreStr."shop_categories";

/* 商铺信息处理 */
$SHOP = get_shop_info($dbo,$t_shop_info,$shop_id);
if(!$SHOP) { trigger_error($s_langpackage->s_no_this_goods);}
//商铺分类
$shop_rank = $SHOP['shop_categories'];
$shop_rank_arr = get_categories_rank($shop_rank,$dbo,$t_shop_categories);
if ($shop_rank_arr){
	$num = count($shop_rank_arr) - 1;
}
$sql = "select rank_id,user_name,last_login_time from $t_users where user_id='".$SHOP['user_id']."'";
$ranks = $dbo->getRow($sql);
$SHOP['rank_id'] = $ranks[0];
/* 获取文章头部 */
$header = get_shop_header($s_langpackage->s_shop_credit,$SHOP);

/* 本页面信息处理 */
$user_id=$SHOP['user_id'];
$sql="select * from $t_credit where buyer=$user_id or seller=$user_id";
$credit = $dbo->getRs($sql);

$seller_credit=$seller_credit_num = $seller_credit_before=$seller_credit_sex=0;
$seller_credit_num_2 = $seller_credit_before_2=$seller_credit_sex_2=0;
$seller_credit_num_1 = $seller_credit_before_1=$seller_credit_sex_1=0;
$seller_credit_num_0 = $seller_credit_before_0=$seller_credit_sex_0=0;
$seller_credit_month=$seller_credit_month_0=$seller_credit_month_1=$seller_credit_month_2=0;
$seller_credit_weed=$seller_credit_weed_0=$seller_credit_weed_1=$seller_credit_weed_2=0;

$buyer_credit=$buyer_credit_num = $buyer_credit_before=$buyer_credit_sex=0;
$buyer_credit_num_2 = $buyer_credit_before_2=$buyer_credit_sex_2=0;
$buyer_credit_num_1 = $buyer_credit_before_1=$buyer_credit_sex_1=0;
$buyer_credit_num_0 = $buyer_credit_before_0=$buyer_credit_sex_0=0;
$buyer_credit_month=$buyer_credit_month_0=$buyer_credit_month_1=$buyer_credit_month_2=0;
$buyer_credit_weed=$buyer_credit_weed_0=$buyer_credit_weed_1=$buyer_credit_weed_2=0;

$SexMonth = $ctime->time_stamp() - (180 * 24 * 60 * 60);
$SexMonth = date('Y-m-d', $SexMonth);
$LastMonth = $ctime->time_stamp() - (30 * 24 * 60 * 60);
$LastMonth = date('Y-m-d', $LastMonth);
$LastWeek = $ctime->time_stamp() - (7 * 24 * 60 * 60);
$LastWeek = date('Y-m-d', $LastWeek);
foreach ($credit as $key=>$val){
	//作为卖家
	if($val['seller']==$user_id){

		if($val['seller_evaltime']<$SexMonth){
			if($val['seller_credit']==1){
				$seller_credit_before_2++;
			}
			if($val['seller_credit']==0){
				$seller_credit_before_1++;
			}
			if($val['seller_credit']==-1){
				$seller_credit_before_0++;
			}
			$seller_credit_before=$seller_credit_before_0+$seller_credit_before_1+$seller_credit_before_2;
		}else
		if($val['seller_evaltime']>=$SexMonth){
			if($val['seller_credit']==1){
				$seller_credit_sex_2++;
			}
			if($val['seller_credit']==0){
				$seller_credit_sex_1++;
			}
			if($val['seller_credit']==-1){
				$seller_credit_sex_0++;
			}
			$seller_credit_sex=$seller_credit_sex_0+$seller_credit_sex_1+$seller_credit_sex_2;

			if($val['seller_evaltime']>=$LastMonth){
				if($val['seller_credit']==1){
					$seller_credit_month_2++;
				}
				if($val['seller_credit']==0){
					$seller_credit_month_1++;
				}
				if($val['seller_credit']==-1){
					$seller_credit_month_0++;
				}
				$seller_credit_month=$seller_credit_month_0+$seller_credit_month_1+$seller_credit_month_2;

				if($val['seller_evaltime']>=$LastWeek){
					if($val['seller_credit']==1){
						$seller_credit_weed_2++;
					}
					if($val['seller_credit']==0){
						$seller_credit_weed_1++;
					}
					if($val['seller_credit']==-1){
						$seller_credit_weed_0++;
					}
					$seller_credit_weed=$seller_credit_weed_0+$seller_credit_weed_1+$seller_credit_weed_2;
				}
			}
		}
		$seller_credit=$seller_credit+$val['seller_credit'];
	}
	//作为买家
	if($val['buyer']==$user_id){

		if($val['buyer_evaltime']<$SexMonth){
			if($val['buyer_credit']==1){
				$buyer_credit_before_2++;
			}
			if($val['buyer_credit']==0){
				$buyer_credit_before_1++;
			}
			if($val['buyer_credit']==-1){
				$buyer_credit_before_0++;
			}
			$buyer_credit_before=$buyer_credit_before_0+$buyer_credit_before_1+$buyer_credit_before_2;
		}else
		if($val['buyer_evaltime']>=$SexMonth){
			if($val['buyer_credit']==1){
				$buyer_credit_sex_2++;
			}
			if($val['buyer_credit']==0){
				$buyer_credit_sex_1++;
			}
			if($val['buyer_credit']==-1){
				$buyer_credit_sex_0++;
			}
			$buyer_credit_sex=$buyer_credit_sex_0+$buyer_credit_sex_1+$buyer_credit_sex_2;

			if($val['buyer_evaltime']>=$LastMonth){
				if($val['buyer_credit']==1){
					$buyer_credit_month_2++;
				}
				if($val['buyer_credit']==0){
					$buyer_credit_month_1++;
				}
				if($val['buyer_credit']==-1){
					$buyer_credit_month_0++;
				}
				$buyer_credit_month=$buyer_credit_month_0+$buyer_credit_month_1+$buyer_credit_month_2;

				if($val['buyer_evaltime']>=$LastWeek){
					if($val['buyer_credit']==1){
						$buyer_credit_weed_2++;
					}
					if($val['buyer_credit']==0){
						$buyer_credit_weed_1++;
					}
					if($val['buyer_credit']==-1){
						$buyer_credit_weed_0++;
					}
					$buyer_credit_weed=$buyer_credit_weed_0+$buyer_credit_weed_1+$buyer_credit_weed_2;
				}
			}
		}
		$buyer_credit=$buyer_credit+$val['buyer_credit'];
	}
}
if( $buyer_credit < 0)
	$buyer_credit = 0;
if( $seller_credit < 0)
	$seller_credit = 0;
$seller_integral=get_integral($dbo,$t_integral,$seller_credit);
$seller_credit_num = $seller_credit_before+$seller_credit_sex;
$seller_credit_num_2 = $seller_credit_before_2+$seller_credit_sex_2;
$seller_credit_num_1 = $seller_credit_before_1+$seller_credit_sex_1;
$seller_credit_num_0 = $seller_credit_before_0+$seller_credit_sex_0;
$seller_percentage=0;
if($seller_credit_num!=0){
	$seller_percentage = sub_str($seller_credit_num_2/$seller_credit_num,6)*100;
}

$buyer_integral=get_integral($dbo,$t_integral,$buyer_credit);
$buyer_credit_num = $buyer_credit_before+$buyer_credit_sex;
$buyer_credit_num_2 = $buyer_credit_before_2+$buyer_credit_sex_2;
$buyer_credit_num_1 = $buyer_credit_before_1+$buyer_credit_sex_1;
$buyer_credit_num_0 = $buyer_credit_before_0+$buyer_credit_sex_0;
$buyer_percentage=0;
if($buyer_credit_num!=0){
	$buyer_percentage = sub_str($buyer_credit_num_2/$buyer_credit_num,6)*100;
}
//echo $sql;
//echo $buyer_credit_weed_2;
$nav_selected=3;
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
<style>
<?php if($SHOP['shop_template_img']){?>
#shopHeader {background:transparent url( <?php echo  $SHOP['shop_template_img'];?>)no-repeat scroll 0 0 #4A9DA5;}
<?php }?>

</style>
</head>
<body>
<div id="wrapper"> <?php  require("shop/index_header.php");?>
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
      <p class="shopName"><?php echo  $SHOP['shop_name'];?></p>
      <div class="shop_nav"> <?php  require("shop/menu.php");?> </div>
    </div>
    <?php  require("shop/left.php");?>
    <div id="rightCloumn">
      <div class="wrp_b mg12b">
        <h3 class="ttlm_font"><?php echo $s_langpackage->s_seller_c;?></h3>
        <table class="tab_credit " width="96%">
          <tr>
            <td style="background:#FFF3E8; text-align:right; border-right:0px; font-weight:bold;" colspan="2"><?php echo $s_langpackage->s_seller_credit;?>：<?php echo $seller_credit;?>
            <td style="text-align:left; background:#FFF3E8; border-right:0px;"><span class="icon<?php echo $seller_integral['int_grade'];?>" style="float:left;"></span></td>
            </td>
            <td style="background:#FFF3E8; text-align:right;" colspan="3"><?php echo  $s_langpackage->s_good_pro;?>：<?php echo $seller_percentage;?>%&nbsp;</td>
          </tr>
          <tr>
            <th width="30"></th>
            <th width="100"><?php echo $s_langpackage->s_week;?></th>
            <th width="110"><?php echo $s_langpackage->s_month;?></th>
            <th width="120"><?php echo $s_langpackage->s_sex_month;?></th>
            <th width="130"><?php echo $s_langpackage->s_before_smonth;?></th>
            <th><?php echo $s_langpackage->s_sum;?></th>
          </tr>
          <tr>
            <td><?php echo $s_langpackage->s_good;?></td>
            <td><a href="javascript:get_appraise('buyer',<?php echo $user_id;?>,1,'<?php echo $LastWeek;?>',1);"><?php echo $seller_credit_weed_2;?></a></td>
            <td><a href="javascript:get_appraise('buyer',<?php echo $user_id;?>,1,'<?php echo $LastMonth;?>',1);"><?php echo $seller_credit_month_2;?></a></td>
            <td><a href="javascript:get_appraise('buyer',<?php echo $user_id;?>,1,'<?php echo $SexMonth;?>',1);"><?php echo $seller_credit_sex_2;?></a></td>
            <td><a href="javascript:get_appraise('buyer',<?php echo $user_id;?>,1,'-1',1);"><?php echo $seller_credit_before_2;?></a></td>
            <td><a href="javascript:get_appraise('buyer',<?php echo $user_id;?>,1,'',1);"><?php echo $seller_credit_num_2;?></a></td>
          </tr>
          <tr>
            <td><?php echo $s_langpackage->s_centre;?></td>
            <td><a href="javascript:get_appraise('buyer',<?php echo $user_id;?>,0,'<?php echo $LastWeek;?>',1);"><?php echo $seller_credit_weed_1;?></td>
            <td><a href="javascript:get_appraise('buyer',<?php echo $user_id;?>,0,'<?php echo $LastMonth;?>',1);"><?php echo $seller_credit_month_1;?></td>
            <td><a href="javascript:get_appraise('buyer',<?php echo $user_id;?>,0,'<?php echo $SexMonth;?>',1);"><?php echo $seller_credit_sex_1;?></td>
            <td><a href="javascript:get_appraise('buyer',<?php echo $user_id;?>,0,'-1',1);"><?php echo $seller_credit_before_1;?></td>
            <td><a href="javascript:get_appraise('buyer',<?php echo $user_id;?>,0,'',1);"><?php echo $seller_credit_num_1;?></td>
          </tr>
          <tr>
            <td><?php echo $s_langpackage->s_diff;?></td>
            <td><a href="javascript:get_appraise('buyer',<?php echo $user_id;?>,-1,'<?php echo $LastWeek;?>',1);"><?php echo $seller_credit_weed_0;?></td>
            <td><a href="javascript:get_appraise('buyer',<?php echo $user_id;?>,-1,'<?php echo $LastMonth;?>',1);"><?php echo $seller_credit_month_0;?></td>
            <td><a href="javascript:get_appraise('buyer',<?php echo $user_id;?>,-1,'<?php echo $SexMonth;?>',1);"><?php echo $seller_credit_sex_0;?></td>
            <td><a href="javascript:get_appraise('buyer',<?php echo $user_id;?>,-1,'-1',1);"><?php echo $seller_credit_before_0;?></td>
            <td><a href="javascript:get_appraise('buyer',<?php echo $user_id;?>,-1,'',1);"><?php echo $seller_credit_num_0;?></td>
          </tr>
          <tr>
            <td><?php echo $s_langpackage->s_sum;?></td>
            <td><a href="javascript:get_appraise('buyer',<?php echo $user_id;?>,'','<?php echo $LastWeek;?>',1);"><?php echo $seller_credit_weed;?></td>
            <td><a href="javascript:get_appraise('buyer',<?php echo $user_id;?>,'','<?php echo $LastMonth;?>',1);"><?php echo $seller_credit_month;?></td>
            <td><a href="javascript:get_appraise('buyer',<?php echo $user_id;?>,'','<?php echo $SexMonth;?>',1);"><?php echo $seller_credit_sex;?></td>
            <td><a href="javascript:get_appraise('buyer',<?php echo $user_id;?>,'','-1',1);"><?php echo $seller_credit_before;?></td>
            <td><a href="javascript:get_appraise('buyer',<?php echo $user_id;?>,'','',1);"><?php echo $seller_credit_num;?></td>
          </tr>
        </table>
      </div>
      <div class="wrp_b mg12b">
        <h3 class="ttlm_font"><?php echo $s_langpackage->s_buyer_com;?></h3>
        <table class="tab_credit " width="96%">
          <tr>
            <td style="background:#FFF3E8; text-align:right; border-right:0px; font-weight:bold;" colspan="2"><?php echo $s_langpackage->s_buyer_credit;?>：<?php echo $buyer_credit;?>
            <td style="text-align:left; background: #FFF3E8; border-right:0px;"><span class="icon<?php echo $buyer_integral['int_grade'];?>" style="float:left;"></span></td>
            </td>
            <td style="background: #FFF3E8; text-align:right;" colspan="3"><?php echo  $s_langpackage->s_good_pro;?>：<?php echo $buyer_percentage;?>%&nbsp;</td>
          </tr>
          <tr>
            <th width="30"></th>
            <th width="100"><?php echo $s_langpackage->s_week;?></th>
            <th width="110"><?php echo $s_langpackage->s_month;?></th>
            <th width="120"><?php echo $s_langpackage->s_sex_month;?></th>
            <th width="130"><?php echo $s_langpackage->s_before_smonth;?></th>
            <th><?php echo $s_langpackage->s_sum;?></th>
          </tr>
          <tr>
            <td><?php echo $s_langpackage->s_good;?></td>
            <td><a href="javascript:get_appraise('seller',<?php echo $user_id;?>,1,'<?php echo $LastWeek;?>',1);"><?php echo $buyer_credit_weed_2;?></td>
            <td><a href="javascript:get_appraise('seller',<?php echo $user_id;?>,1,'<?php echo $LastMonth;?>',1);"><?php echo $buyer_credit_month_2;?></td>
            <td><a href="javascript:get_appraise('seller',<?php echo $user_id;?>,1,'<?php echo $SexMonth;?>',1);"><?php echo $buyer_credit_sex_2;?></td>
            <td><a href="javascript:get_appraise('seller',<?php echo $user_id;?>,1,'-1',1);"><?php echo $buyer_credit_before_2;?></td>
            <td><a href="javascript:get_appraise('seller',<?php echo $user_id;?>,1,'',1);"><?php echo $buyer_credit_num_2;?></td>
          </tr>
          <tr>
            <td><?php echo $s_langpackage->s_centre;?></td>
            <td><a href="javascript:get_appraise('seller',<?php echo $user_id;?>,0,'<?php echo $LastWeek;?>',1);"><?php echo $buyer_credit_weed_1;?></td>
            <td><a href="javascript:get_appraise('seller',<?php echo $user_id;?>,0,'<?php echo $LastMonth;?>',1);"><?php echo $buyer_credit_month_1;?></td>
            <td><a href="javascript:get_appraise('seller',<?php echo $user_id;?>,0,'<?php echo $SexMonth;?>',1);"><?php echo $buyer_credit_sex_1;?></td>
            <td><a href="javascript:get_appraise('seller',<?php echo $user_id;?>,0,'-1',1);"><?php echo $buyer_credit_before_1;?></td>
            <td><a href="javascript:get_appraise('seller',<?php echo $user_id;?>,0,'',1);"><?php echo $buyer_credit_num_1;?></td>
          </tr>
          <tr>
            <td><?php echo $s_langpackage->s_diff;?></td>
            <td><a href="javascript:get_appraise('seller',<?php echo $user_id;?>,-1,'<?php echo $LastWeek;?>',1);"><?php echo $buyer_credit_weed_0;?></td>
            <td><a href="javascript:get_appraise('seller',<?php echo $user_id;?>,-1,'<?php echo $LastMonth;?>',1);"><?php echo $buyer_credit_month_0;?></td>
            <td><a href="javascript:get_appraise('seller',<?php echo $user_id;?>,-1,'<?php echo $SexMonth;?>',1);"><?php echo $buyer_credit_sex_0;?></td>
            <td><a href="javascript:get_appraise('seller',<?php echo $user_id;?>,-1,'-1',1);"><?php echo $buyer_credit_before_0;?></td>
            <td><a href="javascript:get_appraise('seller',<?php echo $user_id;?>,-1,'',1);"><?php echo $buyer_credit_num_0;?></td>
          </tr>
          <tr>
            <td><?php echo $s_langpackage->s_sum;?></td>
            <td><a href="javascript:get_appraise('seller',<?php echo $user_id;?>,'','<?php echo $LastWeek;?>',1);"><?php echo $buyer_credit_weed;?></td>
            <td><a href="javascript:get_appraise('seller',<?php echo $user_id;?>,'','<?php echo $LastMonth;?>',1);"><?php echo $buyer_credit_month;?></td>
            <td><a href="javascript:get_appraise('seller',<?php echo $user_id;?>,'','<?php echo $SexMonth;?>',1);"><?php echo $buyer_credit_sex;?></td>
            <td><a href="javascript:get_appraise('seller',<?php echo $user_id;?>,'','-1',1);"><?php echo $buyer_credit_before;?></td>
            <td><a href="javascript:get_appraise('seller',<?php echo $user_id;?>,'','',1);"><?php echo $buyer_credit_num;?></td>
          </tr>
        </table>
      </div>
      <!-- 评介内容列表 begin -->

        <ul  class="list_tab_02 clearfix">
          <li id="seller_selected" class="selected"><a href="javascript:get_appraise('buyer',<?php echo $user_id;?>,'','',1);" hidefocus="true"><?php echo $s_langpackage->s_from_seller_credit;?></a></li>
          <li id="buyer_selected" class=""><a href="javascript:get_appraise('seller',<?php echo $user_id;?>,'','',1);" hidefocus="true"><?php echo $s_langpackage->s_from_buyer_credit;?></a></li>
        </ul>

        <div id="credit">
        <!-- 评介内容列表 end -->
      </div>
    </div>
  </div>
  <?php   require("shop/index_footer.php");?> </div>
<script language="JavaScript" src="servtools/ajax_client/ajax.js"></script>
<script>
function checkForm() {
	var name = document.getElementsByName("name")[0];
	var textareac = document.getElementById("textareac")[0];
	if(!name.value) {
		alert("<?php echo $s_langpackage->s_login_pls;?>");
		return false;
	}
	if(textareac.value) {
		alert("<?php echo $s_langpackage->s_type_comm_pls;?>");
		return false;
	}
	return true;
}

function get_appraise(t,userid,credit,time,page){
	var new_credit=credit;
	var new_time=time;
	ajax("<?php echo $current_url;?>/do.php?act=shop_appraise&t="+t+"&userid="+userid+"&credit="+credit+"&time="+time+"&page="+page,"GET",'',function(data){
		var obj_credit = document.getElementById("credit");
		var seller_selected=document.getElementById("seller_selected");
		var buyer_selected=document.getElementById("buyer_selected");
		if(data!='-1'){
			var obj = document.getElementById("page");
			var prepage=data.prepage;
			var nextpage=data.nextpage;
			var firstpage=data.firstpage;
			var lastpage=data.lastpage;
			var page=data.page;
			var countpage=data.countpage;
			var seller_credit='';
			var pagehtml="<tr><td id='page' colspan='4'><A href=\"javascript:get_appraise('"+t+"\',"+userid+",'"+new_credit+"','"+time+"',"+firstpage+");\"><?php echo $s_langpackage->s_page_first;?></A> <A href=\"javascript:get_appraise('"+t+"',"+userid+",'"+new_credit+"','"+time+"',"+prepage+");\"><?php echo $s_langpackage->s_page_pre;?></A> <A href=\"javascript:get_appraise('"+t+"',"+userid+",'"+new_credit+"','"+time+"',"+nextpage+");\"><?php echo $s_langpackage->s_page_next;?></A> <A href=\"javascript:get_appraise('"+t+"',"+userid+",'"+new_credit+"','"+time+"',"+lastpage+");\"><?php echo $s_langpackage->s_page_last;?></A> <?php echo $s_langpackage->s_page_num1;?>"+page+"<?php echo $s_langpackage->s_page_num2;?>"+countpage+"<?php echo $s_langpackage->s_page_num3;?></td></tr>";

			var result = data.result;
			var credit='';
			if(t=='buyer'){

				seller_selected.className="selected";
				buyer_selected.className="";
				for($i=0;$i<result.length;$i++){
					scredit=result[$i].seller_credit;
					if(scredit=='1'){
						seller_credit="<?php echo $s_langpackage->s_credit_good;?>";
					}else
					if(scredit=='0'){
						seller_credit="<?php echo $s_langpackage->s_credit_middle;?>";
					}else
					if(scredit=='-1'){
						seller_credit="<?php echo $s_langpackage->s_credit_bad;?>";
					}
					if(result[$i].seller_explanation==null)
						result[$i].seller_explanation="";
					credit+='<tr><td class="rate">'+seller_credit+'</td><td class="comment"><p>'+result[$i].seller_evaluate+'</p><p class="explan">[<?php echo $s_langpackage->s_explain;?>]'+result[$i].seller_explanation+'</p><p>['+result[$i].seller_evaltime+']</p></td><td><a href="goods.php?id='+result[$i].goods_id+'" target="_blank" style="font-size:12px; font-weight:bold; color:#0044DD" title="'+result[$i].goods_name+'">'+result[$i].goods_name+'</a><br /><?php echo $s_langpackage->s_price;?>：<?php echo $m_langpackage->m_money_sign;?><span style="color:#FF6600; font-weight:bold;">'+result[$i].goods_price+'</span><?php echo $s_langpackage->s_yan;?><br/>'+result[$i].user_name+'</td></tr>';
				}
			}else
			if(t=='seller'){
				seller_selected.className="";
				buyer_selected.className="selected";
				for($i=0;$i<result.length;$i++){
					bcredit=result[$i].buyer_credit;
					if(bcredit=='1'){
						buyer_credit="<?php echo $s_langpackage->s_credit_good;?>";
					}else
					if(bcredit=='0'){
						buyer_credit="<?php echo $s_langpackage->s_credit_middle;?>";
					}else
					if(bcredit=='-1'){
						buyer_credit="<?php echo $s_langpackage->s_credit_bad;?>";
					}
					if(result[$i].buyer_explanation==null)
						result[$i].buyer_explanation="";
					if(result[$i].buyer_evaluate==null)
						result[$i].buyer_evaluate="";
					credit+='<tr><td>'+buyer_credit+'</td><td><p>'+result[$i].buyer_evaluate+'</p><p class="explan">[<?php echo $s_langpackage->s_explain;?>]'+result[$i].buyer_explanation+'</p><p>['+result[$i].buyer_evaltime+']</p></td><td><a href="goods.php?id='+result[$i].goods_id+'" target="_blank" style="font-size:12px; font-weight:bold; color:#0044DD" title="'+result[$i].goods_name+'">'+result[$i].goods_name+'</a><br /><?php echo $s_langpackage->s_price;?>：<?php echo $m_langpackage->m_money_sign;?><span style="color:#FF6600; font-weight:bold;">'+result[$i].goods_price+'</span><?php echo $s_langpackage->s_yan;?><br/>'+result[$i].user_name+'</td></tr>';
				}
			}
			obj_credit.innerHTML = "<table class='tab_credit_des' width='100%'>"+credit+pagehtml+"</table>";
		}else{
			if(t=='buyer'){
				seller_selected.className="selected";
				buyer_selected.className="";
				obj_credit.innerHTML = "<table  class='tab_credit_des' width='100%'><tr><td><?php echo $s_langpackage->s_no_seller_credit;?></td></tr></table>";
			}else
			if(t=='seller'){
				seller_selected.className="";
				buyer_selected.className="selected";
				obj_credit.innerHTML = "<table  class='tab_credit_des' width='100%'><tr><td><?php echo $s_langpackage->s_no_buyer_credit;?></td></tr></table>";
			}
		}

	},'JSON');
}

get_appraise('buyer',<?php echo $user_id;?>,'','',1);
</script>
</body>
</html>
<?php } ?>