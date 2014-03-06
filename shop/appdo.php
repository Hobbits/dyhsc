<?php
session_start();
$IWEB_SHOP_IN = true;

//require('foundation/asession.php');
require('configuration.php');
require('includes.php');
dbtarget('r',$dbServs);
$dbo=new dbex();
$callback = isset( $_GET[ 'callback' ] ) ? $_GET[ 'callback' ] : 'callback';
///* appdo 公共信息处理 */
//$userid = $_GET['userid']?$_GET['userid']:'';
//当前登录用户
$sessionuserid = get_session('userid')?get_session('userid'):'';
//当前用户未查看的信息
$user_chat = $tablePreStr."chat";
	
if ($_GET['random']){
	//echo $_GET['random'];exit;
	set_session('random',$_GET['random']);
}
//echo get_session('random').'111';exit;

//当前可访问的action动作,先列出公共部分,然后按各个模块列出
$actArray = array(
//app action
 	'applogin'  => array('action/applogin_act.php'),	
	'appregister'   => array('action/appreg_act.php'),
	'apploginout'   => array('action/applogoutact.php'),
	'appshopcreate' => array('action/shop/appshop_create.php'),
	'appgoodsadd'  => array('action/goods/appgoods_add.php'),
	'appuserorder'		=> array('action/user/apporder.php'),           //订单
	'applocation'  => array('action/shop/applocation.php'),
	'appbusiness'   => array('action/shop/appbusiness.php'),
	'appsearch' => array('appsearch.php'),
	'appshopinfo' => array('action/shop/appshopinfo.php'),
	'appgoodsaction' => array('action/goods/appgoodsaction.php'),
	'appgoodinfo' => array('action/goods/appgoodinfo.php'),
	'appgoodslist' => array('action/goods/appgoodslist.php'),
	'appgoodsimg' => array('action/goods/appgoodsimg.php'),
	'appgetgoodsimgs' => array('action/goods/appgetgoodsimgs.php'),        //获取商品图片
	'appdelimg' => array('action/goods/appdelimg.php'),                   //商品图片删除
	'appmakemain' => array('action/goods/appmakemain.php'),        //设置商品主图
	'appuserinfo' => array('action/user/userinfo.php'),
	'lostpassword' => array('action/appforget.php'),
	'usershare' => array('action/usershare.php'),
	'goodcategory' => array('action/goods/goodcategory.php'),
	'checkorder' => array('action/user/checkorder.php'),    //查看订单
	'checkbuy' => array('action/user/checkbuy.php'),
    'checksell' => array('action/user/checksell.php'),
	'orderinfo' => array('action/user/orderinfo.php'),      //订单详细页面
	'orderaction' => array('action/user/orderaction.php'),   //订单状态处理
    'payorder' => array('appay/alipayapi.php'),             //提交订单
	'messages' => array('action/message.php'),                //站内信息
	'slide' => array('action/slide.php'),         //首页图片轮换
	'nearbyshops' => array('action/nearbyshops.php'),    //搜索附近商家
	'goods_add_favorite' => array('action/goods/favorite.php'),      //商品收藏
	'favorite_lists' => array('action/goods/readfavorite.php'),          //获取收藏数据
	'favorite_del' => array('action/goods/favorite_del.php'),      //删除收藏
	'phpcode' => array('phpcode.php'),                 //商铺二维码
	'download' => array('action/download.php'),
	'chat' => array('action/user/chat.php'),          //聊天
	'chatlist' => array('action/user/chatlist.php'),   //聊天记录
	'getchat' => array('action/user/getchat.php'),    //获取聊天
	'records' => array('action/user/records.php'),     //消息中心
	'record_del' => array('action/user/record_del.php'),     //消息删除
	'addfriend' => array('action/user/addfriend.php'),  //添加好友
	'friendslist' => array('action/user/friendslist.php'),  //好友列表
	'searchfriends' => array('action/user/searchfriends.php'), //查找用户
	'friend_del' => array('action/user/friend_del.php'),
	'newcategory' => array('action/newcategory.php'),     //新闻分类列表
	'appnews' => array('action/appnews.php'),               //新闻动态
	'newsinfo' => array('action/newsinfo.php'),           //新闻详细页面
	'tencent' => array('tencent_login.php'),
	'3rdLogincallback' => array('3rdLogincallback.php'),       //腾讯登陆信息
	'sina' => array('sina_login.php'),
	//'callback' => array('sina/callback.php?sess='.$_SESSION['random']),
	'test' => array('test.php'),
);

$actId=getActId();
$acttarget=$actArray[$actId];
$actarrays = array('appshopcreate','appgoodsadd','appuserorder','appgoodsimg','appdelimg',
'appmakemain','orderaction','chat','chatlist','getchat','records','goods_add_favorite','favorite_lists','addfriend','friendslist','favorite_del','searchfriends','friend_del'
,'record_del');

//echo $actId;exit;
if(in_array($actId, $actarrays)){
	//echo $actId;exit;
	if ($sessionuserid){
		if(isset($acttarget)) {
		$numsql = "select count(*) num from $user_chat where toid= $sessionuserid and isshow = 0";
		if ($dbo->getRow($numsql)){
			$allcount = $dbo->getRow($numsql);
			if ($allcount){
				$chatnums =array('records_num' => $allcount['num']) ;
			}else{
				$chatnums = array('records_num' => '0') ;
			}
		}else {
			$chatnums = array('records_num' => '0') ;
		}
			require($acttarget[0]);
		} else {
			echo 'no pages!';
			exit;
		}
	}else{
		if ($actId == 'appshopinfo' || $actId == 'appgoodinfo'  || $actId == 'appshopcreate'){
			$r = new returnobj('401','');
			echo json_encode( $r );
			exit;	
		}else{
			$r = new returnobj('401','');
			print_r($callback . '(' . json_encode( $r ) . ')');
			exit;	
		}
	}
}else{
	if(isset($acttarget)) {
		if ($sessionuserid){
			$numsql = "select count(*) num from $user_chat where toid= $sessionuserid and isshow = 0";
			if ($dbo->getRow($numsql)){
				$allcount = $dbo->getRow($numsql);
				if ($allcount){
					$chatnums =array('records_num' => $allcount['num']) ;
				}else{
					$chatnums = array('records_num' => '0') ;
				}
			}
		}else{
			$chatnums = array('records_num' => '') ;
		}
		require($acttarget[0]);
	} else {
		echo 'no pages!';
		exit;
	}
}
?>
