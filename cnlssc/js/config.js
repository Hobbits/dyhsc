var appConfig={
    default:{
        chatPollingcycle:15000,/*单位，毫秒*/
        shopthumb:"images/shop-open-icon.png",
		headerThumb:"images/thumbdefault.png"
    },
    bannerURL:servURL+"appdo.php?act=slide",
    loginURL:servURL+"appdo.php?act=applogin",
    logoutURL:servURL+"appdo.php?act=apploginout",
    regURL:servURL+"appdo.php?act=appregister",
    shop_newShop:servURL+"appdo.php?act=appshopcreate",/*修改店铺*/
    shop_area:servURL+"appdo.php?act=applocation",/*地区获取*/
    shop_ind:servURL+"appdo.php?act=appbusiness",/*所在行业*/
    shop_get:servURL+"appdo.php?act=appshopinfo",/*获取店铺信息*/
    logobaseURL:servURL,/*图片baseurl*/
    goodCatURL:servURL+"appdo.php?act=goodcategory",/*商品类别*/
    goodAddURL:servURL+"appdo.php?act=appgoodsadd",
    goodListURL:servURL+"appdo.php?act=appgoodslist",/*商品列表*/
    goodInfoURL:servURL+"appdo.php?act=appgoodinfo",/*获取商品信息*/
    goodmorePicURL:servURL+"appdo.php?act=appgoodsimg",/*获取商品信息*/
    deleteImgURL:servURL+"appdo.php?act=appdelimg",/*删除图片*/
    makeMainimgURL:servURL+"appdo.php?act=appmakemain",/*设为主图*/
    search:servURL+"appdo.php?act=appsearch",
    nearShop:servURL+"appdo.php?act=nearbyshops",/*附近商品*/
    getqrCodeURL:servURL+"appdo.php?act=phpcode",
	orderInfoURL:servURL+"appdo.php?act=appuserorder", /*提交订单*/
	orderDetailURL:servURL+"appdo.php?act=orderinfo",	/*订单信息和订单详情*/
	orderlistBuy:servURL+"appdo.php?act=checkbuy",  /*我是买家订单列表*/
	orderlistSell:servURL+"appdo.php?act=checksell", /*我是卖家订单列表*/
    dialogueURL:servURL+"appdo.php?act=chat",/*发送对话*/
    dialog_fetchUnreadURL:servURL+"appdo.php?act=getchat",/*获取未读*/
	charlistURL:servURL+"appdo.php?act=records", /*聊天好友记录表*/
	deleteChatRecordURL:servURL+"appdo.php?act=record_del", /*删除聊天记录*/
    dialog_fetchUnreadURL:servURL+"appdo.php?act=getchat",/*对话时获取未读*/
    dialog_prefetch:servURL+"appdo.php?act=chatlist",/*对话时获取曾经的记录*/
	searchFriendURL:servURL+"appdo.php?act=searchfriends", /*查找好友*/
	addFriendURL:servURL+"appdo.php?act=addfriend", /*添加好友*/
	deleteFriendURL:servURL+"appdo.php?act=friend_del", /*删除好友*/
	friendslistURL:servURL+"appdo.php?act=friendslist", /*我的好友列表*/
	addFav:servURL+"appdo.php?act=goods_add_favorite",
	addFav:servURL+"appdo.php?act=goods_add_favorite",/*添加收藏*/
    favList:servURL+"appdo.php?act=favorite_lists",
    favDel:servURL+"appdo.php?act=favorite_del",/*删除收藏*/
	newsCategoryURL:servURL+"appdo.php?act=newcategory",/*新闻分类*/
	newslistURL:servURL+"appdo.php?act=appnews",/*新闻列表*/
    newsInfoURL:servURL+"appdo.php?act=newsinfo"/*新闻内容*/
};
appConfig.api={
    keys:{
        baiduMap:"AA656d80c0b5f0f0c7845a101d0e55f4",
        sinaKey:"793276180",
        txAccount:"740593884",/*腾讯帐号*/
        txappKey:"801384522"
    },
    url:{
        geocodingURL:"http://api.map.baidu.com/geocoder/v2/",
        sinaShare:"https://api.weibo.com/2/statuses/upload_url_text.json",
        txLogin:servURL+"appdo.php?act=tencent&random=",/*腾讯登录*/
        sinaLogin:servURL+"appdo.php?act=sina&random=",/*新浪登录*/
        Logincallback:servURL+"appdo.php?act=3rdLogincallback",
        closeInAppbroCall:"closewindow"/*关闭窗口*/
    },
    sinaRalateUid:""
}


var template={
    logo:{}
}

var isAndroid=(function(){
    return navigator.userAgent.indexOf("Android") > 0;
})();

var isiOS=(function(){
    return ( navigator.userAgent.indexOf("iPhone") > 0 || navigator.userAgent.indexOf("iPad") > 0 || navigator.userAgent.indexOf("iPod") > 0);
})();