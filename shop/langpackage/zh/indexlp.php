<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

class indexlp{
	var $i_location = "所在位置";
	var $i_index = "首页";
	var $i_search = "搜索页";
	var $i_s_company = "搜商家";
	var $i_goods_category = "商品详细分类";
	var $i_want_buy = "我要买";
	var $i_want_sell = "我要卖";
	var $i_my_shop = "我的店铺";
	var $i_u_center = "用户中心";
	var $i_hi = "您好";
	var $i_welcome = "您好，欢迎来到";
	var $i_logout_safe = "安全退出";
	var $i_serach_ad = "高级搜索";
	var $i_keywords = "关键字";
	var $i_category = "分类";
	var $i_brand = "品牌";
	var $i_post = "提交";
	var $i_store_list = "商家列表";
	var $i_like_storelist = "相关店铺";
	var $i_searchs = "搜索";
	var $i_hot_tags = "热门Tags";
	var $i_category_toselect_goods = "按分类选择商品";
	var $i_user_register = "会员注册";
	var $i_s_com = "商家信息";
	var $i_loading_img = "正在加载清晰图片";
	var $i_getback_pw = "找回密码";
	var $i_shop_create = "创建店铺";

	/* index */
	var $i_seller = "卖家";
	var $i_fastsell = "活动促销";
	var $i_amsell = "我是卖家";
	var $i_ammall = "我是买家";
	var $i_notice_board = "公告栏";
	var $i_activities_board = "活动栏";
	var $i_u_register = "用户注册";
	var $i_u_login = "用户登陆";
	var $i_u_guide = "新手指南";
	var $i_u_loginnow = "现在登录";
	var $i_u_alipaylogin = "支付宝登录";
	var $i_g_category = "产品分类";
	var $i_g_torelease = "我要发布产品";
	var $i_g_hot = "热门产品";
	var $i_g_saleslist = "销售排行";
	var $i_g_bestcompany = "优秀企业";
	var $i_g_webhelp = "网站帮助";
	var $i_u_start = "新手上路";
	var $i_iam_buyer = "我是买家";
	var $i_shop_service = "商城服务";
	var $i_all_category = "所有分类";
	var $i_service_tel = "客服电话";
	var $i_service_something = "客服热线不受理商品咨询！如需购买咨询，请直接联系出售该商品的商家。";
	var $i_bbs_best = "社区精华";
	var $i_language_ch = "语言选择";
	var $i_group_buy_small_shops = "小商铺如何团购卖商品？";
	var $i_credit_evaluation_system = "店铺信用评价体系";

	/* search brand category */
	var $i_s_result = "搜索结果";
	var $i_s_kindseach = "全部商品分类导航";
	var $i_find_num = "共找到了{num}个匹配结果";
	var $i_c_logo = "店标";
	var $i_c_info = "商家信息/介绍";
	var $i_g_shop_info = "产品信息";
	var $i_s_goto = "进入店铺";
	var $i_c_hotgoods = "商家热卖产品";
	var $i_hotgoods_rec = "热门产品推荐";
	var $i_more_hotgoods = "更多热门产品";
	var $i_comapny_none = "没有商家！";
	var $i_low_height = "低->高";
	var $i_height_low = "高->低";
	var $i_search_pv = "人气";
	var $i_web_rrr = "已经过压缩机商城网的认证";
	var $i_price_discuss = "面议";
	var $i_loading_bigimage = "正在加载清晰图片";
	var $i_cate_result = "分类结果";
	var $i_cate_allgoods = "下的所有产品";
	var $i_cate_sub = "子分类";
	var $i_choice_sort = "按分类选择商品";
	var $i_choice_good = "您选择的所有商品";
	var $i_list = "列表";
	var $i_show_window = "橱窗";
	var $i_handle = "具体操作";
	var $i_particular = "详细";
	var $i_buy = "购买";
	var $i_no_goods = "没有产品";
	var $i_no_groupbuy = "没有团购活动";
	var $i_boutique = "精品推荐";
	var $i_hot = "热点排行";
	var $i_new = "最新浏览";
	var $i_approve_company = "认证商家";
	var $i_noapprove_company = "未认证商家";
	var $i_send_to = "发送至";
	var $i_askprice_title = "询价标题";
	var $i_select_products_by_brand ="按品牌选择商品";

	/* login */
	var $i_au_register = "你还没有注册用户？";
	var $i_register_now = "马上注册";
	var $i_registeru_loginnow = "注册用户请直接登录";
	var $i_login_email = "邮箱/用户名";
	var $i_login_password = "密码";
	var $i_login_in = "登 录";
	var $i_login_forgot = "忘记密码了？";
	var $i_verifycode = "验证码";
	var $i_email_notnone = "邮箱不能为空！";
	var $i_password_notnone = "密码不能为空！";
	var $i_verifycode_notnone = "请输入验证码！";
	var $i_admin ="后台管理系统";
	var $i_enter_username_email = "请输入您的邮箱 / 用户名";


	/* reg */
	var $i_reg_repasswd1 = "重复上面的密码。";
	var $i_reginfo_1 = "1、填写会员信息";
	var $i_reginfo_2 = "2、通过邮件激活";
	var $i_reginfo_3 = "3、注册成功";
	var $i_reg_info = "填写你的注册资料";
	var $i_reg_username = "会员用户名";
	var $i_reg_unameinfo = "由4-16位数字、英文字母或中文组成(一个中文2位)";
	var $i_reg_email = "Email帐号";
	var $i_reg_emailinfo = "如：shop@jooyea.com";
	var $i_reg_passwd = "设置密码";
	var $i_reg_passwdinfo = "数字或英文，6-16位";
	var $i_reg_repasswd = "确认密码";
	var $i_reg_nameandcontact = "姓名和联系方式";
	var $i_reg_truename = "真实姓名";
	var $i_reg_truenameinfo = "请填写2-4个汉字";
	var $i_reg_tel = "固定电话";
	var $i_reg_telinfo = "如：053188888888";
	var $i_reg_mobile = "手机";
	var $i_reg_mobileinfo = "如：13688888888";
	var $i_reg_inputvf = "请输入上图中的文字";
	var $i_reg_postreg = "同意以下条款，并提交注册信息";
	var $i_rmsg_inputuname = "请填写会员用户名！";
	var $i_rmsg_formatname = "会员用户名格式不正确！";
	var $i_rmsgname_checknow = "正在检测您的用户名是否可用！";
	var $i_rmsgname_isok = "恭喜，您的用户名可用！";
	var $i_rmsgname_used = "此用户名已被使用！";
	var $i_rmsgmail_input = "请填写Email帐号！";
	var $i_rmsgmail_format = "Email帐号格式不正确！";
	var $i_rmsgmail_checknow = "正在检测您的Email帐号是否可用！";
	var $i_rmsgmail_isok = "恭喜，您的Email帐号可用！";
	var $i_rmsgmail_used = "此Email帐号已被使用！";
	var $i_rmsgpwd_input = "请填写密码！";
	var $i_rmsgpwd_format = "填写的密码格式不正确！";
	var $i_rmsgpwd_right = "密码格式正确！";
	var $i_rmsgrepwd_format = "确认密码格式正确！";
	var $i_rmsgrepwd_input = "请填写确认密码！";
	var $i_rmsgpwd_notfaf = "两次填写的密码不一致！";
	var $i_rmsgtn_input = "请填写真实姓名！";
	var $i_rmsgtn_notright = "填写的真实姓名格式不正确,请填写2-4个汉字！";
	var $i_rmsgtn_right = "真实姓名格式正确！";
	var $i_rmsgtel_input = "请填写联系电话！";
	var $i_rmsgtel_notright = "填写的联系电话格式不正确！";
	var $i_rmsgtel_right = "联系电话格式正确！";
	var $i_rmsgmob_input = "请填写联系手机！";
	var $i_rmsgmob_notright = "填写的联系手机格式不正确！";
	var $i_rmsgmob_right = "联系手机格式正确！";
	var $i_rmsgvf_input = "请填写验证码！";
	var $i_reg2_checkmail = "就差最后一步了，登录您注册时填写的邮箱完成注册吧！";
	var $i_reg2_loginmail = "登录邮箱激活";
	var $i_reg2_nomail = "没有收到邮件？";
	var $i_reg3_regsucess = "恭喜您，注册成功！";
	var $i_goto_manage = "进入管理";
	var $i_find_goods = "查找商品";
	var $i_member_login = "会员登录";
	var $i_welcome_iwebshop = "欢迎您登录{iweb_mall}多用户商城系统";
	var $i_remembe_me = "记住我（请不要在公共计算机上使用此项）";
	var $i_login_info_first = "便宜有好货！超过1000万件商品任您选。";
	var $i_noshop_account_clickhere = "如果你已拥有{iweb_mall}账户<br />请点击";
	var $i_pls_info_safe_msg = "请认真、仔细地填写下以信息，严肃的商业信息有助于您获得别人的信任。";
	var $i_login_info_sec = "买卖更安心！支付宝交易超安全。";
	var $i_login_info_the = "轻松赚钱交商友。";
	var $i_login_info_foru = "超人气社区！精彩活动每一天。";
	var $i_iwantget_price = "我要询价";
	var $i_article_list = "文章分类";
	var $i_up_article = "上一篇";
	var $i_down_article = "下一篇";
	var $i_none_article = "没有了";
	var $i_none_articles = "没有文章";

	var $i_question_see = "常见问题";
	var $i_safe_compp = "安全交易";
	var $i_process_of_purchase = "购买流程";
	var $i_howto_pay = "如何付款";
	var $i_contact_us = "联系我们";
	var $i_make_a_proposal = "合作提案";
	var $i_site_map = "网站地图";
	var $i_email_complete_registration ="请登陆邮箱进行邮箱验证完成注册！";
	var $i_resend_verification ="重新发送验证码";
	var $i_email_reminded_end ="如果您已经填写了注册信息，请到您注册的邮箱点击验证。<br />如验证失败，可使用本方式重新发送验证连接。<br />请填写注册时的邮箱，否则将无法发送邮件到您的邮箱内。";
	var $i_re_your_password ="请输入您的常用邮箱，方便日后找回密码。";
	/* forgot */
	var $i_find_password = "找回密码";
	var $i_forgot_1 = "1、请输入会员名";
	var $i_forgot_2 = "2、请输入您的注册电子邮箱";
	var $i_forgot_3 = "3、密码成功找回";
	var $i_fgot_inputname = "请输入会员名";
	var $i_next_step = "下一步";
	var $i_fgot_namenotnone = "会员名称不能为空！";
	var $i_fgot2_info = "请填写下面信息，系统将通过邮箱找回密码";
	var $i_fgot2_email = "注册邮箱";
	var $i_fgot2_emailnotnone = "注册邮箱不能为空！";
	var $i_complete = "完成";

	/* inquiry */
	var $i_inquiry = "询价";
	var $i_inquiry_info1 = "1、向供应商发送询价";
	var $i_inquiry_info2 = "2、询价完成";
	var $i_inquiry_sucess = "恭喜您，询价完成！";
	var $i_back_goodspage = "返回当前商品页";
	var $i_inq_resave = "接收方";
	var $i_inq_comname = "公司名称";
	var $i_inq_address = "联系地址";
	var $i_inq_askinfo = "填写询价内容";
	var $i_inq_title = "标题";
	var $i_inq_msat = "咨询{name}相关信息";
	var $i_inq_content = "内容";
	var $i_inq_namelink = "填写姓名和联系方式";
	var $i_inq_truename = "真实姓名";
	var $i_inq_email = "E-mail地址";
	var $i_inq_tel = "固定电话";
	var $i_inq_mob = "手机";
	var $i_inq_telandmobile = "固定电话和手机号码至少填写一项";
	var $i_inq_sendmsg = "发送询价";

	var $i_allgoodsheader_category = "查看所有商品类目";
	var $i_goodsheader_category = "商品分类";
	var $i_new_goods = "新品速递";
	var $i_promote_goods = "精品促销";
	var $i_brand_sort = "品牌专区";
	var $i_links_list = "友情链接";
	var $i_hotgoods_sort = "人气排行";
	var $i_new_goodsb = "最新上架";
	var $i_index_nocite = "公告栏";
	var $i_new_user_help = "新手上路";
	var $i_register_free = "免费注册";
	var $i_best_store = "推荐店铺";
	var $i_goods_num = "商品数量";
	var $i_shop_info = "商品数量";
	var $i_shop_logo = "店标";
	var $i_iwant_mkstore = "我要开店";
	var $i_shop_help = "商城帮助";
	var $i_about_shop = "关于商城";
	var $i_goods_search = "搜商品";
	var $i_goods_infos = "商品信息";



	/* page */
	var $i_page_num = "共{num}条记录";
	var $i_page_first = "首页";
	var $i_page_pre = "上一页";
	var $i_page_next = "下一页";
	var $i_page_last = "尾页";
	var $i_page_now = "当前";
	var $i_page_count = "共{num}页";


	var $i_more_search = "更多搜索";
	var $i_creat_time = "创建时间";
	var $i_in_area = "所在地区";
	var $i_specialarea = "专区";
	var $i_info = "摘要";
	var $i_shop = "店铺";
	var $i_news = "资讯";
	var $i_price = "价格";
	var $i_company = "商家";
	var $i_goods = "产品";
	var $i_more = "更多";
	var $i_moregoods = "更多推荐商品";
	var $i_moreshop = "更多店铺";
	var $i_recommend = "推荐";
	var $i_best = "精品";
	var $i_promote = "促销";
	var $i_logout = "退出";
	var $i_login = "登录";
	var $i_register = "注册";
	var $i_cart = "购物车";
	var $i_favorite = "收藏夹";
	var $i_back_index = "返回首页";
	var $i_yan = "元";
	var $i_is_vis = "认证";
	var $i_shopour = "店主";

	var $i_select_goods = "选择商品";
	var $i_select = "按";
	var $i_choice_attr = "按{num}选择商品";
	
	var $i_email_check="您已通过验证，请勿重复验证。";
	var $i_pass_check="恭喜您已通过验证。";
	var $i_again_send="邮箱验证码错误，请重新发送。";
	var $i_check_url_error="url不完整，请确认。";
	var $i_goods_error="没有此商品";
	
	var $i_shop_index="商城首页";
	var $i_websit_navigation="网站导航";
	var $i_search_keyword="请输入你要搜索的关键字";
	var $i_brand_list="品牌列表";
	var $i_no_product="没有商品";
	var $i_no_shop_1="没有店铺";
	var $i_locus="所在地";
	var $i_search_category="请选择分类";
	var $i_search_brand="请选择品牌";
	var $i_login_info="登录社区，你将得到以下服务";
	var $i_no_shop="您访问的店铺不存在!";
	var $i_href="系统将在<span id=\"skip\">3</span>秒钟返回...";
	var $i_hand_index="如果浏览器没有自动调整，点击这里返回";
	var $i_brand_detail="品牌详细页";
	var $i_company_website="公司网站";
	var $i_category_filter="筛选分类";
	var $i_all="全部";
	var $i_description="描述";
	var $i_money_sign="￥";
	var $i_freight="运费";
	var $i_collection="收藏";
	var $i_contrast="对比";
	var $i_hot_label="热门标签集";
	var $i_start_compare="开始比较";
	var $i_illegal="非法请求";
	var $i_shop_filter="商品筛选";
	var $i_goods_commend="人气商品推荐";
	var $i_brower_register="浏览记录";
	var $i_compare_error1="只能比较同类商品";
	var $i_compare_error2="已经选择了此商品";
	var $i_compare_error3="只能同时对比5个商品";
	var $i_all_category2="全部分类";
	var $i_groupbuy_list="团购列表";
	var $i_groupbuy_say="团购说明";
	var $i_lay_out="团购展示";
	var $i_brand_navigation="名优品牌导航";
	var $i_better_shop="优秀店铺推荐";
	var $i_groupbuy="团购";
	var $i_integral="积分";
	var $i_shop_infomation="店铺信息";
	var $i_jian="件";
	var $i_contract_goods="商品对比";
	var $i_close="关闭";
	var $i_remove="移除";
	var $i_free_open="免费开店";
	
	var $i_page_error="你请求的页面不存在或有错误！";
	var $i_work_count_error="输入字数超长";
	
	var $i_g_addedfavorite = "已成功添加到您的收藏夹！";
	var $i_g_stayfavorite = "此商品已在您的收藏夹里！";
	var $i_g_addfailed = "添加失败，请确认您是否已登陆！";
	var $i_mygoods_error="自己的商品不能放入收藏";
	var $i_change_img="看不清,换一张";
	var $i_checkcode_error="验证码错误";
	
	var $i_one_num="每人限购";
	var $i_all_num="团购总数";
	var $i_groupbuy_lock="团购被管理员锁定";
	var $i_num_format_error ="购买数量格式不正确!";
}

// g 商品
// u 用户
// s 搜索
// c 商家
?>