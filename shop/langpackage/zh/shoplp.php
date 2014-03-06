<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

class shoplp{

	var $s_time = "时间";
	var $s_yuan = "元";
	var $s_more = "更多";
	var $s_logout = "退出";
	var $s_login = "登录";

	var $s_cart = "购物车";
	var $s_favorite = "收藏夹";
	var $s_back_index = "返回首页";
	var $s_want_buy = "我要买";
	var $s_want_sell = "我要卖";

	var $s_u_center = "用户中心";
	var $s_hi = "您好";
	var $s_company_news = "企业资讯";
	var $s_guestbook = "留言簿";

	var $s_intro = "店铺简介";
	var $s_products = "商品展示";
	var $s_honor = "荣誉资质";
	var $s_job = "招聘中心";
	var $s_contact = "联系我们";
	var $s_register_free = "免费注册";
	var $s_no_goods = "没有商品！";
	var $s_goods_category = "商品分类";

	var $s_search = "搜索";
	var $s_kucun_0 = "库存为0，您暂时无法购买！";
	var $s_shop_indexs = "店铺首页";
	var $s_shop_credit = "信用评价";
	var $s_shop_intro = "店铺介绍";
	var $s_shop_notices = "店铺公告";
	var $s_shop_groupbuy = "团购商品";
	var $s_shop_seat = "店铺位置";
	var $s_shop_smallimg = "小图";
	var $s_shop_bigimg = "大图";
	var $s_shop_allgoods = "所有商品";
	var $s_buyer_comm = "买家留言";
	var $s_post_comm = "发表留言";
	var $s_wantto_comm = "我要留言";
	var $s_login_pls = "您还没有登陆！";
	var $s_type_comm_pls = "您的留言内容不能为空！";
	var $s_want_mkstore = "我要开店";
	var $s_shop_help = "商城帮助";
	var $s_click_viewbigimg = "移动鼠标看大图";

	var $s_goods_price = "售　　价";
	var $s_no_price = "面议";
	var $s_goods_transport = "运　　费";
	var $s_goods_number = "库　　存";
	var $s_goods_pv = "关 注 度";
	var $s_send_address = "发 货 地";

	var $s_goods_wtbuy = "购买数量";
	var $s_g_askprice = "立即询价";
	var $s_g_buy = "立即购买";
	var $s_g_tocart = "加入购物车";
	var $s_g_tofavorite = "加入收藏夹";
	var $s_certification = "认证信息";
	var $s_g_addedfavorite = "已成功添加到您的收藏夹！";
	var $s_g_stayfavorite = "此商品已在您的收藏夹里！";
	var $s_g_addfailed = "添加失败，请确认您是否已登陆！";
	var $s_g_buy_num_not_zero = "购买数量不能为0！";
	var $s_g_addedcart = "已成功添加到您的购物车！";
	var $s_staycart = "此商品已在您的购物车里！";
	var $s_nomachgoods = "库存里没有这么多商品！";
	var $s_seller_shop = "逛逛卖家店铺";
	var $s_details = "详细介绍";
	var $s_wholesale = "批发说明";

	var $s_goods_mum = "还剩{num}件";
	var $s_goods_pvnum = "已有{pv}关注";
	var $s_company_Support = "商家支持";
	var $s_buy_n = "(可购 N 件)";
	var $s_collect = "人收藏";
	var $s_collect_num = "收藏人气";
	var $s_contact_seller = "联系卖家";
	var $s_seller_c = "卖家信用";
	var $s_no_payment = "此商家没有开通任何一种支付方式";
	var $s_shop_index = "商铺首页";

	var $s_shop_noaddcategory = "本商铺还没有添加分类！";
	var $s_question_see = "常见问题";
	var $s_safe_compp = "安全交易";
	var $s_process_of_purchase = "购买流程";
	var $s_howto_pay = "如何付款";
	var $s_contact_us = "联系我们";
	var $s_make_a_proposal = "合作提案";
	var $s_site_map = "网站地图";
	var $s_approve_company = "认证商家";
	var $s_noapprove_company = "未认证商家";
	var $s_approve_info = "认证信息";
	var $s_store_insearch = "店内搜索";

	var $s_com = "商家信息";

	var $s_seller_credit = "卖家累积信用";
	var $s_week = "最近1周";
	var $s_month = "最近1个月";
	var $s_sex_month = "最近6个月";
	var $s_before_smonth = "6个月前";
	var $s_sum = "总计";
	var $s_good = "好评";
	var $s_centre = "中评";
	var $s_diff = "差评";
	var $s_good_pro = "好评率";
	var $s_buyer_com = "买家信息";
	var $s_buyer_credit = "买家累积信用";
	var $s_no_seller_credit = "没有来自买家的评价";
	var $s_no_buyer_credit = "没有来自卖家的评价";
	var $s_from_seller_credit = "来自买家的评价";
	var $s_from_buyer_credit = "来自卖家的评价";

	var $s_seller_reply = "店主回复";

	var $s_nickname = "卖家昵称";
	var $s_goods_num = "商品数量";
	var $s_new_login = "最近登录";
	var $s_creat_time = "创店时间";
	var $s_yan = "元";

	/* page */
	var $s_page_num = "共{num}条记录";
	var $s_page_first = "首页";
	var $s_page_pre = "上一页";
	var $s_page_next = "下一页";
	var $s_page_last = "尾页";
	var $s_page_now = "当前";
	var $s_page_count = "共{num}页";

	/* 团购 */
	var $s_goods_name = "商品名称";
	var $s_groupbuy_price = "团购价";
	var $s_groupbuy_num = "成团数";
	var $s_groupbuy_goods = "团购名称";
	var $s_groupbuy_time = "剩余时间";
	var $s_groupbuy = "团购";
	var $s_groupbuy_start_time = "起始时间";
	var $s_groupbuy_regiment_number = "成团件数";
	var $s_groupbuy_restult_num = "已购件数";
	var $s_groupbuy_old_price = "原价";
	var $s_groupbuy_buy_num = "购买数量";
	var $s_groupbuy_real_name = "真实姓名";
	var $s_groupbuy_tel = "联系电话";
	var $s_groupbuy_add = "参加团购";
	var $s_groupbuy_del = "退出团购";
	var $s_groupbuy_isset_num = "请填写购买数量!";
	var $s_groupbuy_isset_name = "请填写真实姓名!";
	var $s_groupbuy_isset_tel = "请填写联系电话!";
	var $s_groupbuy_isset_tel_num = "联系电话格式不正确!";
	var $s_groupbuy_isset_one = "购买数量不正确!";
	var $s_groupbuy_isset_true = "已成功参加团购!";
	var $s_groupbuy_isset_false = "已成功退出团购!";
	var $s_group_buy_state ="团购状态";
	var $s_completed ="已完成";
	var $s_detriment ="购买";
	var $s_ongoing ="进行中";
	var $s_required ="必填";
	var $s_not_published ="未发布";
	var $s_group_buy_introduction ="团购介绍";
	var $s_isset_login = "您还没有登录";
	var $s_groupbuy_shows = "团购说明";
	var $s_groupbuy_not_greater = "不能大于限购数!";
	var $s_groupbuy_not_number="可购数量不足，请修改";
	var $s_groupbuy_not_greater_all = "不能大于限购总数!";
	
	
	var $s_no_category="没有分类！";
	var $s_no_message="没有资讯！";
	var $s_message_center="资讯中心";
	var $s_no_goods2="没有商品";
	var $s_no_news="不存在此资讯!";
	var $s_this_location="当前位置：";
	var $s_mall_intro="商城简介";
	var $s_mall_intro2="关于商城";
	var $s_no_this_goods="没有此商铺";
	var $s_shop_category="店铺分类";
	var $s_credit_good="好";
	var $s_credit_middle="中";
	var $s_credit_bad="差";
	var $s_explain="解释";
	var $s_price="价格";
	var $s_money_sign="￥";
	var $s_page_num1="当前第";
	var $s_page_num2="页/总共";
	var $s_page_num3="页";
    
	var $s_goods_locked="此商品已被锁定";
    var $s_goods_error="没有此商品";
    var $s_shop_error="没有此商铺！";
    var $s_country="全国";
    var $s_all_category="全部分类";
    var $s_may_buy="可购";
    var $s_piece="件";
    var $s_have="已有";
    var $s_share="分&nbsp;享&nbsp;到：";
    var $s_renren="人人";
    var $s_kaixin="开心";
    var $s_douban="豆瓣";
    var $s_store_shop="收藏店铺";
    var $s_send_mail="发站内信";
    var $s_goods_label="商品标签";
    var $s_enter_label="请在此输入自定义标签";
    var $s_add="添加";
    var $s_seller_commend="卖家推荐";
    var $s_mygoods_error="自己的商品不能放入收藏";
    var $s_myshop_error="自己的店铺不能收藏";
    var $s_store_mygoods_error="自己的商品不能放入购物车";
    var $s_store_info="此商铺已在您的收藏夹";
    var $s_shop_error1="非法操作,店铺不存在";
    var $s_buy_mygoods="自己不能购买自己的商品";
    var $s_less_stock="购买数量应小于库存数!";
    var $s_enter_goods_label="请输入商品标签";
    var $s_no_login="对不起,您还没有登录";
    var $s_close="关闭";
    
    var $s_group_buy="团购展示";
    var $s_no_group="没有此团购";
    var $s_shop_locked="商品不存在或商铺已锁定";
    var $s_shop_close="此商铺已关闭";
    var $s_no_notice="暂无公告";
    var $s_goods_commend="商品推荐";
    var $s_freight="运费";
    var $s_new_goods="最新上架";
    var $s_plugin="插件展示 ";
    var $s_work_count_error="输入字数超长";
    var $s_groupbuy_lock_error="错误，此团购被锁定";
    
    var $s_area = "选择地区";
    var $s_code_no = "请输入验证码";
}
?>
