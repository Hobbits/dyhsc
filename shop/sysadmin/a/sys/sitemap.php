<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

require("../foundation/csitemap.php");
require_once ("../foundation/furl_rewrite.php");
//权限管理
$right=check_rights("sys_sitemap");
if(!$right){
	action_return(0,$a_langpackage->a_privilege_mess,'m.php?app=error');	
}

//语言包引入
$a_langpackage=new adminlp;

/** 获取参数 */
$tindex_priority=get_args("tindex_priority");//首页更新优先权比值
$uindex_changefreq=get_args("uindex_changefreq");//首页更新时间频率
$tshop_priority=get_args("tshop_priority");//商店更新优先权比值
$ushop_changefreq=get_args("ushop_changefreq");//商店更新时间频率
$tcategory_priority=get_args("tcategory_priority");//分类更新优先权比值
$ucategory_changefreq=get_args("ucategory_changefreq");//分类更新时间频率
$tactivity_priority=get_args("tactivity_priority");//活动更新优先权比值
$uactivity_changefreq=get_args("uactivity_changefreq");//活动更新时间频率
$tbrand_priority=get_args("tbrand_priority");//品牌更新优先权比值
$ubrand_changefreq=get_args("ubrand_changefreq");//品牌更新时间频率
$tgoods_priority=get_args("tgoods_priority");//商品更新优先权比值
$ugoods_changefreq=get_args("ugoods_changefreq");//商品更新时间频率

$catchsitmap=$tindex_priority."|".$uindex_changefreq."|".$tshop_priority."|".$ushop_changefreq.
             "|".$tcategory_priority."|".$ucategory_changefreq."|".$tactivity_priority."|".$uactivity_changefreq.
             "|".$tbrand_priority."|".$ubrand_changefreq."|".$tgoods_priority."|".$ugoods_changefreq;
file_put_contents($webRoot.'cache/'."cachesitemap.txt",$catchsitmap);//写入文件

$tb_credit=$tablePreStr."credit";//店铺评分表
$tb_shopInfo=$tablePreStr."shop_info";//商铺表
$tb_category=$tablePreStr."category";//分类表
$tb_groupbuy=$tablePreStr."groupbuy";//团购表
$tb_brand_category=$tablePreStr."brand_category";//品牌分类表
$tb_brand=$tablePreStr."brand";//品牌
$tb_goods=$tablePreStr."goods";//商品

dbtarget("r",$dbServs);
$dbo=new dbex();

if($fh=fopen($webRoot."sitemap.xml","wb")){
	$sitemap=new sitemap;
	/** 首页 */
	$item=array(
	    'loc' =>"$baseUrl",   //页面链接地址
	    'lastmod'=>date('Y-m-d'),//连接的最后更新时间
	    'changefreq'=>$uindex_changefreq,//更新频率
	    'priority'=>$tindex_priority,    //优先级 
	);
	$sitemap->item($item);
	/** 店铺 */
	$sql="select seller,sum(seller_credit) as sc from $tb_credit ic join $tb_shopInfo si on ".
	     "ic.seller=si.shop_id where si.open_flg=0 and si.lock_flg=0 group by seller order by sc desc limit 20";//原则：总评分前20,未关闭，未锁定的商铺
	$res=mysql_query($sql);
	while($row=mysql_fetch_row($res)){
	//	$surl=$baseUrl.'shop.php?shopid='.$row[0].'&app=index';
		$surl=$baseUrl.shop_url($row[0]);
		$item=array(
		   'loc'  =>$surl,
		   'lastmod' =>date('Y-m-d'),
		   'changefreq'=>$ushop_changefreq,
		   'priority'=>$tshop_priority,
		);
		$sitemap->item($item);
	}
	/** 分类 */
	$sql2="select cat_id from $tb_category";
	$res2=mysql_query($sql2);
	while($row=mysql_fetch_row($res2)){
		//$surl=$baseUrl.'category.php?id='.$row[0];
		$surl=$baseUrl.category_url($row[0]);
		$item=array(
		    'loc' => $surl,
		    'lastmod' => date('Y-m-d'),
		    'changefreq' => $ucategory_changefreq,
		    'priority' => $tcategory_priority,
		);
		$sitemap->item($item);	
	}
	/** 活动 */
	$sql3="select group_id from $tb_groupbuy where start_time<='".date('Y-m-d')."' and '".date('Y-m-d')."'<=end_time";//当前有效商铺
	$res3=mysql_query($sql3);
	while($row=mysql_fetch_row($res3)){
		$surl=$baseUrl.'goods.php?id='.$row[0].'&app=groupbuyinfo';
		$item=array(
		    'loc' => $surl,
		    'lastmod' => date('Y-m-d'),
		    'changefreq' => $uactivity_changefreq,
		    'priority' => $tactivity_priority,
		);
		$sitemap->item($item);
	}
	/** 品牌 */
	$sql4="select ibc.brand_id,ibc.cat_id from $tb_brand_category ibc join $tb_brand ib on ibc.brand_id=ib.brand_id join $tb_category ic ".
	       "on ibc.cat_id=ic.cat_id where ib.is_show=1";
	$res4=mysql_query($sql4);
	while($row=mysql_fetch_row($res4)){
		//$surl=$baseUrl.'category.php?id='.$row[1].'&brand_id='.$row[0];
		$surl=$baseUrl.category_url($row[1]).'&brand_id='.$row[0];
		$item=array(
		    'loc' => $surl,
		    'lastmod' => date('Y-m-d'),
		    'changefreq' => $tbrand_priority,
		    'priority' => $ubrand_changefreq,
		);
		$sitemap->item($item);
	}
	/** 商品 */
	$sql5="select goods_id from $tb_goods where lock_flg=0 and is_delete=1 and is_on_sale=1 order by pv desc limit 20";//关注最高的20,未锁，未删，上架的
	$res5=mysql_query($sql5);
	while($row=mysql_fetch_row($res5)){
	//	$surl=$baseUrl.'goods.php?id='.$row[0];
	    $surl=$baseUrl.goods_url($row[0]);
		$item=array(
		    'loc' => $surl,
		    'lastmod' => date('Y-m-d'),
		    'changefreq' => $ugoods_changefreq,
		    'priority' => $tgoods_priority,
		);
		$sitemap->item($item);
	}
	$out =  $sitemap->generate();
	if(fwrite($fh,$out)===false){
		action_return(0,$a_langpackage->$a_norw_sitemap,'-1');
	}else{
		action_return(1,$a_langpackage->a_sitemap,'-1');
	}
	fclose($fh);//关闭文件
}else{
	action_return(0,$a_langpackage->$a_norw_sitemap,'-1');
}

?>