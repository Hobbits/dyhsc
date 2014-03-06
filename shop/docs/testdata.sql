
--
-- 导出表中的数据 `imall_admin_group`
--

INSERT INTO `imall_admin_group` (`id`, `group_name`, `del_flg`, `rights`) VALUES
(1, '普通管理员', 0, NULL),
(2, '超级管理员', 0, 'site_set_browse,site_set_update,pay_browse,pay_oper,area_browse,area_add,area_edit,area_del,remind,remind_update,remind_oper,email_browse,email_update,database,data_backup,database_recover,data_recover,programme_browse,programme_edit,programme_exe,programme_del,crons_add');

--
-- 导出表中的数据 `imall_attribute`
--

INSERT INTO `imall_attribute` (`attr_id`, `cat_id`, `attr_name`, `input_type`, `attr_values`, `sort_order`) VALUES
(51, 5, '颜色', 2, '红\n黄\n绿\n蓝', 2),
(56, 402, '场合', 2, '室内适用\n室外适用\n室内室外', 0),
(49, 1, '大小', 2, 'M\nL\nXL\nXXL\nXXXL', 1),
(50, 5, '大小', 2, 'M\nL\nXL\nXXL\nXXXL', 1),
(52, 9, '颜色', 2, '红\n黄\n绿\n蓝', 2),
(53, 9, '大小', 2, 'M\nL\nXL\nXXL\nXXXL', 1),
(54, 7, '颜色', 2, '红\n黄\n绿\n蓝', 2),
(55, 7, '大小', 2, 'M\nL\nXL\nXXL\nXXXL', 1);


--
-- 导出表中的数据 `imall_complaint_type`
--

INSERT INTO `imall_complaint_type` (`type_id`, `type_content`) VALUES
(1, '收款不发货'),
(2, '成交不卖'),
(3, '商品与描述不符'),
(4, '评价纠纷');

--
-- 导出表中的数据 `imall_flink`
--

INSERT INTO `imall_flink` (`brand_id`, `brand_name`, `brand_logo`, `brand_desc`, `site_url`, `is_show`) VALUES
(2, '戴尔', './uploadfiles/brand/2010/07/20/2010072005164753.jpg', '戴尔', 'http://www.dell.com', 0),
(3, 'IBM', 'docs/images/brand/3.jpg', '', 'http://www.ibm.com/cn/zh/', 0),
(4, '联想', 'docs/images/brand/4.jpg', '', 'http://www.lenovo.com.cn/', 1),
(5, '三星', 'docs/images/brand/5.jpg', '', 'http://www.samsung.com/cn/', 1),
(6, '诺基亚', 'docs/images/brand/6.jpg', '', 'http://www.nokia.com.cn/', 1),
(7, '惠普', 'docs/images/brand/7.jpg', '', 'http://www.hp.com.cn', 1),
(8, '华硕', 'docs/images/brand/8.jpg', '', 'http://www.asus.com.cn/', 1),
(9, '苹果', 'docs/images/brand/9.jpg', '', 'http://www.apple.com/', 1),
(10, '大水牛', 'docs/images/brand/10.jpg', '', 'http://www.hedy.com.cn/', 1),
(11, '希捷', 'docs/images/brand/11.jpg', '', 'http://www.seagate.com/', 1),
(12, '金士顿', 'docs/images/brand/12.jpg', '', 'http://www.kingston.com/china/', 1);


--
-- 导出表中的数据 `imall_goods`
--

INSERT INTO `imall_goods` (`goods_id`, `shop_id`, `goods_name`, `cat_id`, `ucat_id`, `brand_id`, `type_id`, `goods_intro`, `goods_wholesale`, `goods_number`, `goods_price`, `transport_price`, `keyword`, `is_delete`, `is_best`, `is_new`, `is_hot`, `is_promote`, `is_admin_promote`, `is_on_sale`, `is_set_image`, `goods_thumb`, `pv`, `favpv`, `sort_order`, `add_time`, `last_update_time`, `lock_flg`, `is_transport_template`, `transport_template_id`, `transport_template_price`) VALUES
(1, 2, '2010年全新新款海信213TDA/A冰箱', 421, 70, 0, 1, '<li title="产品名称">产品名称：海信 BCD-258TDEK </li>\r\n<li>冰箱冰柜品牌: Hisense/海信</li>\r\n<li>海信型号: BCD-258TDEK</li>\r\n<li>制冷方式: 直冷</li>\r\n<li>箱门结构: 三门式</li>\r\n<li>面板类型: 不锈钢</li>\r\n<li>冰箱总容积: 251-300升</li>\r\n<li>冷冻室容积: 60升以下</li>\r\n<li>冰箱能耗等级: 1级</li>\r\n<li>冰箱上市时间: 2007年</li>\r\n<li>耗电量(Kwh/24h): 0.6-0.7</li>\r\n<li>售后服务: 全国联保</li>\r\n<li>同城特色服务: 同城卖家送货上门</li>\r\n<li>冰箱价格区间: 3000-4000元 </li>', '', 99, 3860.00, 50.00, '', 1, 0, 0, 0, 0, 0, 1, 1, 'uploadfiles/goods/2010/11/29/thumb_2010112902244298.jpg', 1, 0, 0, '2010-11-29 10:24:42', '0000-00-00 00:00:00', 0, 0, 0, 50),
(2, 2, '海信 BC-46S', 423, 70, 0, 1, '<li title="产品名称">产品名称：海信 BC-46S </li>\r\n<li>冰箱冰柜品牌: Hisense/海信</li>\r\n<li>海信型号: BC-46S</li>\r\n<li>冰箱冷柜机型: 冷藏冷冻冰箱</li>\r\n<li>制冷方式: 直冷</li>\r\n<li>箱门结构: 单门式</li>\r\n<li>冰箱总容积: 60升以下</li>\r\n<li>冷冻室容积: 60升以下</li>\r\n<li>冰箱能耗等级: 1级</li>\r\n<li>冰箱上市时间: 2008年</li>\r\n<li>耗电量(Kwh/24h): 0.4以下</li>\r\n<li>售后服务: 全国联保</li>\r\n<li>同城特色服务: 同城卖家送货上门</li>\r\n<li>冰箱价格区间: 1500元以下</li>\r\n<li>制冷控制系统: 机械温控 </li>', '', 99, 499.00, 20.00, '', 1, 0, 0, 0, 0, 0, 1, 1, 'uploadfiles/goods/2010/11/29/thumb_2010112902264274.jpg', 0, 0, 0, '2010-11-29 10:26:42', '0000-00-00 00:00:00', 0, 0, 0, 20),
(3, 2, '海信官方旗舰 40寸 液晶 Hisense/海信 TLM40V78PK', 416, 71, 0, 1, '<li title="产品名称">产品名称：海信 TLM40V78PK </li>\r\n<li>品牌: Hisense/海信</li>\r\n<li>海信液晶型号: TLM40V78PK</li>\r\n<li>屏幕尺寸: 40英寸</li>\r\n<li>同城特色服务: 同城上门安装</li>\r\n<li>屏幕比例: 宽屏16:9</li>\r\n<li>清晰度: 1080p(全高清)</li>\r\n<li>屏幕分辨率: 1920×1080</li>\r\n<li>平板/液晶电视类型: LCD液晶电视</li>\r\n<li>屏幕响应速度: 3-6毫秒(含3毫秒)</li>\r\n<li>售后服务: 全国联保</li>\r\n<li>液晶价格区间: 4000-6000元</li>\r\n<li>最佳观看距离: 2.7米(40英寸)</li>\r\n<li>颜色分类: 带底座&nbsp;单机...</li>\r\n<li>套餐: 官方标配 </li>', '', 99, 3840.00, 50.00, '', 1, 0, 0, 0, 0, 0, 1, 1, 'uploadfiles/goods/2010/11/29/thumb_2010112902345215.jpg', 0, 0, 0, '2010-11-29 10:34:52', '0000-00-00 00:00:00', 0, 0, 0, 50),
(4, 1, '苹果电脑MacBook Air 2代11寸13寸 64/128/256G 现货联保', 55, 72, 3, 1, '&nbsp;&nbsp;&nbsp; *&nbsp; 品牌: Apple/苹果<br />&nbsp;&nbsp;&nbsp; * 系列: MacBook Air<br />&nbsp;&nbsp;&nbsp; * MacBook Air 系列配置: 其它MacBook Air 系列...<br />&nbsp;&nbsp;&nbsp; * 成色: 全新<br />&nbsp;&nbsp;&nbsp; * CPU平台: 酷睿2双核<br />&nbsp;&nbsp;&nbsp; * 酷睿2双核: 其它酷睿二代<br />&nbsp;&nbsp;&nbsp; * CPU频率量级: 1.4GHz<br />&nbsp;&nbsp;&nbsp; * CPU电压规格: 标准版电压<br />&nbsp;&nbsp;&nbsp; * 内存容量: 2G<br />&nbsp;&nbsp;&nbsp; * 硬盘容量: 64G固态硬盘<br />&nbsp;&nbsp;&nbsp; * 显卡类型: 独立<br />&nbsp;&nbsp;&nbsp; * 独显: 其它独立显卡型号<br />&nbsp;&nbsp;&nbsp; * 显存容量: 256M<br />&nbsp;&nbsp;&nbsp; * 光驱类型: 无<br />&nbsp;&nbsp;&nbsp; * 屏幕比例: 宽屏16：10<br />&nbsp;&nbsp;&nbsp; * 屏幕尺寸: 11寸<br />&nbsp;&nbsp;&nbsp; * 重量: 1-1.5公斤<br />&nbsp;&nbsp;&nbsp; * 电池类型: 9芯锂电池<br />&nbsp;&nbsp;&nbsp; * 指纹功能: 有<br />&nbsp;&nbsp;&nbsp; * 蓝牙功能: 有<br />&nbsp;&nbsp;&nbsp; * 摄像头功能: 有<br />&nbsp;&nbsp;&nbsp; * 上市时间: 2010年<br />&nbsp;&nbsp;&nbsp; * 笔记本价格区间: 5001-7000元<br />&nbsp;&nbsp;&nbsp; * 颜色分类: 13吋-128G联保(现货......<br />&nbsp;&nbsp;&nbsp; * 笔记本套餐: 标准套餐<br />&nbsp;&nbsp;&nbsp; * 笔记本定位: 商务定位', '', 99, 6650.00, 100.00, '苹果 笔记本', 1, 0, 0, 0, 0, 0, 1, 1, 'uploadfiles/goods/2010/11/29/thumb_2010112902493251.jpg', 0, 0, 0, '2010-11-29 10:49:32', '0000-00-00 00:00:00', 0, 0, 0, 100),
(5, 1, '11寸 Macbook Air mc506 128GB', 55, 72, 3, 1, '&nbsp;&nbsp;&nbsp; *&nbsp; 品牌: Apple/苹果<br />&nbsp;&nbsp;&nbsp; * 系列: MacBook Air<br />&nbsp;&nbsp;&nbsp; * MacBook Air 系列配置: 其它MacBook Air 系列...<br />&nbsp;&nbsp;&nbsp; * 成色: 全新<br />&nbsp;&nbsp;&nbsp; * CPU平台: 其它CPU型号<br />&nbsp;&nbsp;&nbsp; * CPU频率量级: 1.4GHz<br />&nbsp;&nbsp;&nbsp; * CPU电压规格: 标准版电压<br />&nbsp;&nbsp;&nbsp; * 内存容量: 2G<br />&nbsp;&nbsp;&nbsp; * 硬盘容量: 128G固态硬盘<br />&nbsp;&nbsp;&nbsp; * 显卡类型: 集成<br />&nbsp;&nbsp;&nbsp; * 集成显卡型号: NVIDIA Geforce 320M<br />&nbsp;&nbsp;&nbsp; * 显存容量: 共享内存容量<br />&nbsp;&nbsp;&nbsp; * 光驱类型: 无<br />&nbsp;&nbsp;&nbsp; * 屏幕比例: 宽屏16：9<br />&nbsp;&nbsp;&nbsp; * 屏幕尺寸: 11寸<br />&nbsp;&nbsp;&nbsp; * 重量: 1-1.5公斤<br />&nbsp;&nbsp;&nbsp; * 指纹功能: 无<br />&nbsp;&nbsp;&nbsp; * 蓝牙功能: 有<br />&nbsp;&nbsp;&nbsp; * 摄像头功能: 有<br />&nbsp;&nbsp;&nbsp; * 上市时间: 2010年<br />&nbsp;&nbsp;&nbsp; * 平板电脑: 否<br />&nbsp;&nbsp;&nbsp; * 笔记本定位: 便携定位<br /><p>&nbsp;&nbsp;&nbsp; * 笔记本价格区间: 7001-9000元</p><p><span style="font-size:x-large;color:#ff0000;">全新原装未拆封 </span></p><p><span style="font-size:x-large;color:#ff0000;">2010新款11寸 Macbook Air</span> </p><p><img src="http://img04.taobaocdn.com/imgextra/i4/57514701/T2ClprXipXXXXXXXXX_%21%2157514701.jpg" align="absMiddle" alt="" /></p><p><img src="http://img01.taobaocdn.com/imgextra/i1/57514701/T2Y8lrXkBXXXXXXXXX_%21%2157514701.jpg" align="absMiddle" alt="" /></p>', '', 99, 8400.00, 40.00, '笔记本 苹果', 1, 0, 0, 0, 0, 0, 1, 1, 'uploadfiles/goods/2010/11/29/thumb_2010112902522139.jpg', 0, 0, 0, '2010-11-29 10:52:21', '0000-00-00 00:00:00', 0, 0, 0, 40),
(6, 1, '苹果 APPLE MACBOOK 516 港行', 55, 72, 3, 1, '<ul class="attributes-list"><li>品牌: Apple/苹果</li><li>系列: Macbook</li><li>Macbook 系列配置: 其它Macbook 系列配置</li><li>成色: 全新</li><li>CPU平台: 酷睿2双核</li><li>酷睿2双核: P8800</li><li>CPU频率量级: 2.4GHz</li><li>CPU电压规格: 标准版电压</li><li>内存容量: 2G</li><li>硬盘容量: 250G</li><li>显卡类型: 集成</li><li>集成显卡型号: 其它集成显卡型号</li><li>显存容量: 256M</li><li>光驱类型: DVD刻录</li><li>屏幕比例: 宽屏16：10</li><li>屏幕尺寸: 13寸</li><li>重量: 2-2.5公斤</li><li>电池类型: 其它类型</li><li>摄像头功能: 有</li><li>售后服务: 全国联保</li><li>上市时间: 2010年</li><li>笔记本定位: 便携定位</li><li>笔记本价格区间: 5001-7000元</li></ul>', '', 99, 6900.00, 40.00, '', 1, 0, 0, 0, 0, 0, 1, 1, 'uploadfiles/goods/2010/11/29/thumb_2010112902540584.jpg', 0, 0, 0, '2010-11-29 10:54:05', '0000-00-00 00:00:00', 0, 0, 0, 40),
(7, 1, '苹果平板电脑 Apple iPad现货 苹果 wifi版ipad(16G)非3G版', 55, 0, 3, 1, '<div id="attributes" class="attributes">				<ul class="attributes-list"><li title="产品名称">产品名称：苹果 iPad WIFI版(16G)</li><li>品牌: Apple/苹果</li><li>型号: iPad WIFI版(16G)</li><li>操作系统: iOS</li><li>屏幕尺寸: 9.7英寸</li><li>硬盘容量: 16GB</li><li>处理器型号: Apple A4</li><li>处理器主频: 1GHz</li><li>WIFI网络: 支持</li><li>3G网络: 不支持</li><li>蓝牙: 支持</li><li>内存容量: 256MB</li><li>触摸屏类型: 电容式</li><li>存储类型: 固态硬盘</li><li>支持接口类型: USB&nbsp;电脑锁</li><li>产品类型: 平板电脑</li><li>上市时间: 2010年</li><li>颜色分类: 银色</li><li>售后服务: 全国联保</li><li>套餐类型: 套餐一&nbsp;套餐二...</li><li>摄像头: 无摄像头</li></ul>\r\n    </div>', '', 99, 3988.00, 40.00, '', 1, 0, 0, 0, 0, 0, 1, 1, 'uploadfiles/goods/2010/11/29/thumb_2010112902560858.jpg', 1, 0, 0, '2010-11-29 10:56:08', '0000-00-00 00:00:00', 0, 0, 0, 40),
(8, 3, '泡沫之夏小猫卫衣+显瘦镶钻牛仔裤 2件套装价 立省32元', 12, 3, 0, 1, '<span style="font-size:medium;"><span style="color:#ff0000;">【推荐理由】</span><span style="color:#666666;">秋天是属于卫衣的季节。当然了卫衣还可以穿到冬天哈！</span></span><span style="font-size:medium;"><span style="color:#666666;">配马甲，棉衣，羽绒服都很潇洒有型。超好品质的，<span style="color:#ff0000;">手感厚实而细腻</span>，内抓绒足够保暖又有安全感<br /></span><span style="color:#ff0000;">【关于面料】</span></span><span style="color:#666666;"><span style="font-size:medium;"><span style="color:#ff0000;">韩国进口优质卫衣棉</span>，手感超级柔软舒适，穿着无束缚感<br />有一定的厚度，<span style="color:#ff0000;">抗皱，不会磨毛起球变形，透气性好，</span><span style="color:#ff0000;">亲肤感</span>非常出色，整体面料很有高级感<br /><span style="color:#ff0000;">【优惠价格】</span>很有明星范儿的一款卫衣，凸显休闲风格，强烈推荐！<span style="color:#ff0000;">超韩剧的感觉</span>哦！</span><span style="color:#ff0000;"><br /></span></span><span style="font-size:medium;color:#ff0000;">【朴泽的话】</span><span style="color:#666666;"><span style="font-size:medium;">小黑猫的印花，连口袋本身也是小黑猫的造型哦，</span><span style="font-size:medium;color:#ff0000;">是不是让你想起泡沫之夏里面洛溪唱的“小黑猫是一只流浪的猫”，希望亲爱的你，穿上这件衣服，从此懂得了爱......<br />关于KK------------------<br /></span></span>', '', 99, 100.00, 80.00, '', 1, 0, 0, 0, 0, 0, 1, 1, 'uploadfiles/goods/2010/11/29/thumb_2010112903050942.jpg', 0, 0, 0, '2010-11-29 11:05:09', '0000-00-00 00:00:00', 0, 0, 0, 80),
(9, 4, '苹果手机Apple iPhone4代 16G正品行货WIFI版 iPhone 4 16G', 44, 73, 5, 1, '&nbsp;&nbsp;&nbsp; *&nbsp; 产品名称：iphone 4代 (16G)<br />&nbsp;&nbsp;&nbsp; * 品牌: iPhone<br />&nbsp;&nbsp;&nbsp; * Apple型号: iPhone 4(16G)<br />&nbsp;&nbsp;&nbsp; * 上市时间: 2010年<br />&nbsp;&nbsp;&nbsp; * 10年上市月份: 6月<br />&nbsp;&nbsp;&nbsp; * 网络类型: GSM/WCDMA(3G)<br />&nbsp;&nbsp;&nbsp; * 外观样式: 直板<br />&nbsp;&nbsp;&nbsp; * 主屏尺寸: 3.5英寸<br />&nbsp;&nbsp;&nbsp; * 屏幕颜色: 1600万<br />&nbsp;&nbsp;&nbsp; * 机身颜色: 黑色<br />&nbsp;&nbsp;&nbsp; * 手机套餐: 套餐三 套餐一...<br />&nbsp;&nbsp;&nbsp; * 铃声: MP3铃声<br />&nbsp;&nbsp;&nbsp; * 摄像头: 500万<br />&nbsp;&nbsp;&nbsp; * 是否智能手机: 智能手机<br />&nbsp;&nbsp;&nbsp; * 操作系统: iPhone<br />&nbsp;&nbsp;&nbsp; * 储存功能: 不支持存储卡<br />&nbsp;&nbsp;&nbsp; * 适合送给谁: 中年男性 女青年<br />&nbsp;&nbsp;&nbsp; * 高级功能: WIFI上网...<br />&nbsp;&nbsp;&nbsp; * 适合的送礼场景: 商务送礼 礼仪拜访<br />&nbsp;&nbsp;&nbsp; * 适合的送礼人物类型: 探索创新型...<br />&nbsp;&nbsp;&nbsp; * 宝贝成色: 全新<br />&nbsp;&nbsp;&nbsp; * 售后服务: 全国联保', '', 99, 6099.00, 10.00, '', 1, 0, 0, 0, 0, 0, 1, 1, 'uploadfiles/goods/2010/11/29/thumb_2010112903144378.jpg', 0, 0, 0, '2010-11-29 11:14:43', '0000-00-00 00:00:00', 0, 0, 0, 10),
(10, 3, '2010秋冬装新女装细节 韩版肩章双排扣羊绒大衣毛呢外套', 103, 3, 0, 1, '<li>品牌: JORESHOW</li>\r\n<li>板型: 修身型</li>\r\n<li>衣长: 中长款(65cm&lt;衣长≤...</li>\r\n<li>袖型: 常规袖</li>\r\n<li>袖长: 长袖</li>\r\n<li>衣门襟: 双排扣</li>\r\n<li>款式细节: 腰带装饰</li>\r\n<li>图案: 纯色</li>\r\n<li>风格: 韩版</li>\r\n<li>面料分类: 粗花呢</li>\r\n<li>材质: 羊绒混纺</li>\r\n<li>里料材质: 涤纶</li>\r\n<li>里料图案: 纯色</li>\r\n<li>适合人群: 淑女</li>\r\n<li>颜色分类: 卡其&nbsp;黑灰</li>\r\n<li>尺码: M&nbsp;L&nbsp;XL</li>\r\n<li>季节: 冬季&nbsp;秋季</li>\r\n<li>实拍方式: 模特实拍&nbsp;搭配实拍...</li>\r\n<li>细节图: 有细节图</li>\r\n<li>货号: 107364 </li>', '', 99, 330.00, 30.00, '', 1, 0, 0, 0, 0, 0, 1, 1, 'uploadfiles/goods/2010/11/29/thumb_2010112903160287.jpg', 0, 0, 0, '2010-11-29 11:16:02', '0000-00-00 00:00:00', 0, 0, 0, 30),
(11, 4, '【诺基亚官方旗舰店】诺基亚N8精锐乐动限量版 旗舰店限量首发', 44, 73, 5, 1, '&nbsp;&nbsp;&nbsp; *&nbsp; 产品名称：诺基亚 N8<br />&nbsp;&nbsp;&nbsp; * 品牌: Nokia/诺基亚<br />&nbsp;&nbsp;&nbsp; * 诺基亚型号: N8<br />&nbsp;&nbsp;&nbsp; * 手机价格区间: 3001-5000元<br />&nbsp;&nbsp;&nbsp; * 上市时间: 2010年<br />&nbsp;&nbsp;&nbsp; * 10年上市月份: 8月<br />&nbsp;&nbsp;&nbsp; * 网络类型: GSM/WCDMA(3G)<br />&nbsp;&nbsp;&nbsp; * 外观样式: 直板<br />&nbsp;&nbsp;&nbsp; * 主屏尺寸: 3.5英寸<br />&nbsp;&nbsp;&nbsp; * 屏幕颜色: 1600万<br />&nbsp;&nbsp;&nbsp; * 机身颜色: 柠檬绿精锐超值...<br />&nbsp;&nbsp;&nbsp; * 手机套餐: 官方标配<br />&nbsp;&nbsp;&nbsp; * 铃声: MP3铃声<br />&nbsp;&nbsp;&nbsp; * 摄像头: 1200万<br />&nbsp;&nbsp;&nbsp; * 是否智能手机: 智能手机<br />&nbsp;&nbsp;&nbsp; * 操作系统: Symbian<br />&nbsp;&nbsp;&nbsp; * 储存功能: microSD/microSDHC<br />&nbsp;&nbsp;&nbsp; * 适合送给谁: 女青年<br />&nbsp;&nbsp;&nbsp; * 高级功能: WIFI上网...<br />&nbsp;&nbsp;&nbsp; * 适合的送礼场景: 商务送礼 学业有成...<br />&nbsp;&nbsp;&nbsp; * 适合的送礼人物类型: 时尚爱美型 小资型...<br />&nbsp;&nbsp;&nbsp; * 宝贝成色: 全新<br />&nbsp;&nbsp;&nbsp; * 售后服务: 全国联保<br />&nbsp;&nbsp;&nbsp; * 触摸屏: 电容式触摸屏', '', 99, 4389.00, 10.00, '', 1, 0, 0, 0, 0, 0, 1, 1, 'uploadfiles/goods/2010/11/29/thumb_2010112903171741.jpg', 0, 0, 0, '2010-11-29 11:17:17', '0000-00-00 00:00:00', 0, 0, 0, 10),
(12, 3, '复古金扣子修身仿呢中长外套[WT00036]细节', 12, 2, 0, 1, '<li class="selected"><a hidefocus="" href="http://item.taobao.com/item.htm?id=7920960422#description" data-index="0">宝贝详情</a></li>\r\n<li><a hidefocus="" href="http://item.taobao.com/item.htm?id=7920960422#reviews" data-index="1"><span style="color:#000000;">评价详情(</span><strong><span style="color:#2853b4;">0</span></strong><span style="color:#000000;">)</span></a></li>\r\n<li><a hidefocus="" href="http://item.taobao.com/item.htm?id=7920960422#deal-record" data-index="2"><span style="color:#000000;">成交记录(</span><strong><span style="color:#2853b4;">226</span></strong><span style="color:#000000;">件)</span></a></li>\r\n<li><a hidefocus="" href="http://item.taobao.com/item.htm?id=7920960422#other-info" data-index="3"><span style="color:#000000;"><img style="RIGHT: 3px; POSITION: relative; TOP: 3px" src="http://img03.taobaocdn.com/tps/i3/T1DAxKXo8XXXXXXXXX.png" alt="" />保障须知</span></a></li>\r\n<li><a hidefocus="" href="http://item.taobao.com/item.htm?id=7920960422#recommendation" data-index="4"><span style="color:#000000;">掌柜推荐</span></a></li>\r\n<li><a hidefocus="" href="http://item.taobao.com/item.htm?id=7920960422#payway-info" data-index="5"><span style="color:#000000;">付款方式</span></a></li>\r\n<li><a hidefocus="" href="http://item.taobao.com/item.htm?id=7920960422#guestbook" data-index="6"><span style="color:#000000;">留言簿</span></a></li>\r\n<div class="attributes" id="attributes">\r\n<ul class="attributes-list">\r\n<li>板型: 修身型</li>\r\n<li>衣长: 中长款(65cm&lt;衣长≤...</li>\r\n<li>袖长: 长袖</li>\r\n<li>衣门襟: 双排扣</li>\r\n<li>图案: 格子</li>\r\n<li>风格: 欧美</li>\r\n<li>面料分类: 仿呢料</li>\r\n<li>里料材质: 涤纶</li>\r\n<li>里料图案: 纯色</li>\r\n<li>适合人群: 少女</li>\r\n<li>颜色分类: 米黄&nbsp;黑色</li>\r\n<li>尺码: M&nbsp;L</li>\r\n<li>季节: 冬季&nbsp;秋季</li>\r\n<li>实拍方式: 悬挂实拍&nbsp;模特实拍...</li>\r\n<li>细节图: 有细节图 </li></ul></div>', '', 99, 145.00, 30.00, '', 1, 0, 0, 0, 0, 0, 1, 1, 'uploadfiles/goods/2010/11/29/thumb_2010112903173062.jpg', 0, 0, 0, '2010-11-29 11:17:30', '0000-00-00 00:00:00', 0, 0, 0, 30),
(13, 4, '全新诺基亚E71 大陆行货手机 全国联保 商务智能机 包邮送礼品', 44, 73, 5, 1, '&nbsp;&nbsp;&nbsp; *&nbsp; 产品名称：诺基亚 E71<br />&nbsp;&nbsp;&nbsp; * 品牌: Nokia/诺基亚<br />&nbsp;&nbsp;&nbsp; * 诺基亚型号: E71<br />&nbsp;&nbsp;&nbsp; * 上市时间: 2008年<br />&nbsp;&nbsp;&nbsp; * 08年上市月份: 7月<br />&nbsp;&nbsp;&nbsp; * 网络类型: GSM<br />&nbsp;&nbsp;&nbsp; * 外观样式: 直板<br />&nbsp;&nbsp;&nbsp; * 主屏尺寸: 2.4英寸<br />&nbsp;&nbsp;&nbsp; * 屏幕颜色: 1600万<br />&nbsp;&nbsp;&nbsp; * 机身颜色: 白色 灰色 黑色<br />&nbsp;&nbsp;&nbsp; * 手机套餐: 套餐三 套餐一...<br />&nbsp;&nbsp;&nbsp; * 铃声: MP3铃声<br />&nbsp;&nbsp;&nbsp; * 摄像头: 320万<br />&nbsp;&nbsp;&nbsp; * 是否智能手机: 智能手机<br />&nbsp;&nbsp;&nbsp; * 操作系统: Symbian<br />&nbsp;&nbsp;&nbsp; * 储存功能: microSD/microSDHC<br />&nbsp;&nbsp;&nbsp; * 适合送给谁: 中年男性 中年女性...<br />&nbsp;&nbsp;&nbsp; * 高级功能: GPS导航 收音机...<br />&nbsp;&nbsp;&nbsp; * 适合的送礼场景: 商务送礼<br />&nbsp;&nbsp;&nbsp; * 适合的送礼人物类型: 宅型<br />&nbsp;&nbsp;&nbsp; * 宝贝成色: 全新<br />&nbsp;&nbsp;&nbsp; * 售后服务: 全国联保', '', 99, 1530.00, 10.00, '', 1, 0, 0, 0, 0, 0, 1, 1, 'uploadfiles/goods/2010/11/29/thumb_2010112903220571.jpg', 0, 0, 0, '2010-11-29 11:22:05', '0000-00-00 00:00:00', 0, 0, 0, 10),
(14, 4, '美域高★全新HTC Legend/A6363/G6台湾版新到货', 44, 73, 5, 1, '&nbsp;&nbsp;&nbsp; *&nbsp; 产品名称：HTC Legend<br />&nbsp;&nbsp;&nbsp; * 品牌: HTC<br />&nbsp;&nbsp;&nbsp; * HTC型号: Legend<br />&nbsp;&nbsp;&nbsp; * 上市时间: 2010年<br />&nbsp;&nbsp;&nbsp; * 10年上市月份: 3月<br />&nbsp;&nbsp;&nbsp; * 网络类型: GSM/WCDMA(3G)<br />&nbsp;&nbsp;&nbsp; * 外观样式: 直板<br />&nbsp;&nbsp;&nbsp; * 主屏尺寸: 3.2英寸<br />&nbsp;&nbsp;&nbsp; * 屏幕颜色: 其它颜色<br />&nbsp;&nbsp;&nbsp; * 机身颜色: 银黑色<br />&nbsp;&nbsp;&nbsp; * 手机套餐: 套餐二 官方标配<br />&nbsp;&nbsp;&nbsp; * 铃声: MP3铃声<br />&nbsp;&nbsp;&nbsp; * 摄像头: 500万<br />&nbsp;&nbsp;&nbsp; * 是否智能手机: 智能手机<br />&nbsp;&nbsp;&nbsp; * 操作系统: Android<br />&nbsp;&nbsp;&nbsp; * 储存功能: TF(microSD)卡<br />&nbsp;&nbsp;&nbsp; * 高级功能: WIFI上网...<br />&nbsp;&nbsp;&nbsp; * 宝贝成色: 全新<br />&nbsp;&nbsp;&nbsp; * 售后服务: 店铺三包<br />&nbsp;&nbsp;&nbsp; * 触摸屏: 电容式触摸屏', '', 99, 2420.00, 10.00, '', 1, 0, 0, 0, 0, 1, 1, 1, 'uploadfiles/goods/2010/11/29/thumb_2010112903255296.jpg', 0, 0, 0, '2010-11-29 11:25:52', '0000-00-00 00:00:00', 0, 0, 0, 10),
(15, 4, 'HTC HD MINI 宽域迷你版宜昌现货', 44, 73, 5, 1, '<p style="text-indent: 21pt; margin: 0cm 0cm 0pt;"><span style="font-size: 10pt;"><span style="font-family:Calibri;"><img title="" alt="" src="http://img02.taobaocdn.com/tps/i2/T1AHpGXcltXXXXXXXX-169-300.jpg" /><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;HD mini</span></span><span style="font-family: 宋体; font-size: 10pt;">可以说是</span><span style="font-size: 10pt;"><span style="font-family:Calibri;">HD2</span></span><span style="font-family: 宋体; font-size: 10pt;">的简易缩小版，它的体积为</span><span style="font-size: 10pt;"><span style="font-family:Calibri;">103.8 x 57.7 x 11.7 mm</span></span><span style="font-family: 宋体; font-size: 10pt;">，不论是长宽都比之前的</span><span style="font-size: 10pt;"><span style="font-family:Calibri;">HD2</span></span><span style="font-family: 宋体; font-size: 10pt;">要小得多；这也是为什麼</span><span style="font-size: 10pt;"><span style="font-family:Calibri;">HTC</span></span><span style="font-family: 宋体; font-size: 10pt;">要开发出这样的机种；</span><span style="font-size: 10pt;"><span style="font-family:Calibri;">HD2</span></span><span style="font-family: 宋体; font-size: 10pt;">虽然萤幕大、规格强，不过</span><span style="font-size: 10pt;"><span style="font-family:Calibri;">HD2</span></span><span style="font-family: 宋体; font-size: 10pt;">的优点即是缺点，</span><span style="font-size: 10pt;"><span style="font-family:Calibri;">4.3</span></span><span style="font-family: 宋体; font-size: 10pt;">吋的大萤幕，让它在携带性上面总是比较低一点，因此</span><span style="font-size: 10pt;"><span style="font-family:Calibri;">HD mini</span></span><span style="font-family: 宋体; font-size: 10pt;">就是要给这些想要手机小一点，却又喜欢</span><span style="font-size: 10pt;"><span style="font-family:Calibri;">HD2</span></span><span style="font-family: 宋体; font-size: 10pt;">软体介面的消费者使用。</span><span style="font-size: 10pt;"></span></p><span style="font-family: calibri sans-serif; font-size: 10.5pt;"><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;HD mini</span><span style="font-family: 宋体; font-size: 10.5pt;">手机正面是整片的拋光玻璃，萤幕边框为黑色，比较容易留下指纹；为了要节省体积，这次</span><span style="font-family: calibri sans-serif; font-size: 10.5pt;">HD mini</span><span style="font-family: 宋体; font-size: 10.5pt;">当然不能装上与</span><span style="font-family: calibri sans-serif; font-size: 10.5pt;">HD2</span><span style="font-family: 宋体; font-size: 10.5pt;">同级的</span><span style="font-family: calibri sans-serif; font-size: 10.5pt;">4.3</span><span style="font-family: 宋体; font-size: 10.5pt;">吋</span><span style="font-family: calibri sans-serif; font-size: 10.5pt;">WVGA</span><span style="font-family: 宋体; font-size: 10.5pt;">萤幕，而是搭载</span><span style="font-family: calibri sans-serif; font-size: 10.5pt;">3.2</span><span style="font-family: 宋体; font-size: 10.5pt;">吋规格</span><span style="font-family: calibri sans-serif; font-size: 10.5pt;">TFT</span><span style="font-family: 宋体; font-size: 10.5pt;">萤幕，解析度也降为</span><span style="font-family: calibri sans-serif; font-size: 10.5pt;">320 x 480</span><span style="font-family: 宋体; font-size: 10.5pt;">（</span><span style="font-family: calibri sans-serif; font-size: 10.5pt;">HVGA</span><span style="font-family: 宋体; font-size: 10.5pt;">），不过还是保留了电容触控的能力，而且也支援多点触控，因此手机不需要触控笔，只要用手指触控即可。</span><span style="font-family: calibri sans-serif; font-size: 10pt;"><br /></span><span style="font-family: 宋体; font-size: 10.5pt;"><br />&nbsp;&nbsp;&nbsp; 在背面，</span><span style="font-family: calibri sans-serif; font-size: 10.5pt;">HD mini</span><span style="font-family: 宋体; font-size: 10.5pt;">做了一些特殊的设计。首先，背盖四角有四个螺丝，</span><span style="font-family: calibri sans-serif; font-size: 10.5pt;">HTC</span><span style="font-family: 宋体; font-size: 10.5pt;">表示这个地方是参考了跑车的轮胎设计，中央的螺丝看起来就像轮框一样；再来，在打开背盖之后，使用者会发现手机内部全部都是黄色，包含电池、机板、还有下方的半透明黄色保护板都是，</span><span style="font-family: calibri sans-serif; font-size: 10.5pt;">HTC</span><span style="font-family: 宋体; font-size: 10.5pt;">说这是要给使用者一个惊喜，毕竟目前还没有厂商愿意在这个地方做点不一样的设计。</span>', '', 99, 2400.00, 10.00, '', 1, 0, 0, 0, 0, 1, 1, 1, 'uploadfiles/goods/2010/11/29/thumb_2010112903273763.jpg', 0, 0, 0, '2010-11-29 11:27:37', '0000-00-00 00:00:00', 0, 0, 0, 10),
(16, 5, '玉友人气商品热销2000件圆润饱满和田玉平安扣吊坠挂件玉器平安扣', 425, 75, 0, 1, '<li>和田玉分类: 白玉</li>\r\n<li>和田玉产地: 山料</li>\r\n<li>玉器形式: 挂件/佩件</li>\r\n<li>收藏品售后/服务: 收货后7日鉴赏期</li>\r\n<li>收藏品价格: 101--200元</li>\r\n<li>品牌: 玉友</li>\r\n<li>货号: 888184977 </li>', '', 99, 196.00, 10.00, '', 1, 0, 0, 0, 0, 1, 1, 1, 'uploadfiles/goods/2010/11/29/thumb_2010112903274638.jpg', 0, 0, 0, '2010-11-29 11:27:46', '0000-00-00 00:00:00', 0, 0, 0, 10),
(17, 5, '老坑A货油青种翡翠手链 饱满圆润 DFZ039', 424, 75, 0, 1, '<li>翡翠种地: 油青</li>\r\n<li>款式: 手链</li>\r\n<li>图案: 路路通</li>\r\n<li>售后: 收货后鉴赏3日</li>\r\n<li>证书: 不带证书</li>\r\n<li>是否镶嵌: 未镶嵌</li>\r\n<li>品牌: 鼎铛翡翠</li>\r\n<li>货号: DFZ039 </li>', '', 99, 110.00, 10.00, '', 1, 0, 0, 0, 0, 1, 1, 1, 'uploadfiles/goods/2010/11/29/thumb_2010112903292648.jpg', 0, 0, 0, '2010-11-29 11:29:26', '0000-00-00 00:00:00', 0, 0, 0, 10),
(18, 5, '正品 金箔玫瑰 黄金玫瑰 24K金玫瑰（大号）', 424, 76, 0, 1, '<li>贵金属成色: 999千足金</li>\r\n<li>款式: 摆件</li>\r\n<li>品牌: 其它品牌</li>\r\n<li>售后: 收货后鉴赏7日</li>\r\n<li>是否镶嵌: 未镶嵌</li>\r\n<li>适合送给谁: 少女&nbsp;中年女性...</li>\r\n<li>适合的送礼场景: 结婚送礼&nbsp;生日送礼...</li>\r\n<li>适合的送礼人物类型: 运动型&nbsp;小资型... </li>', '', 99, 55.00, 10.00, '', 1, 0, 0, 0, 0, 1, 1, 1, 'uploadfiles/goods/2010/11/29/thumb_2010112903312523.jpg', 0, 0, 0, '2010-11-29 11:31:25', '0000-00-00 00:00:00', 0, 0, 0, 10),
(19, 5, '细腻润泽〗羊脂级天然白玉手镯 （扁条）【包邮】', 424, 75, 0, 1, '<li>款式: 手镯</li>\r\n<li>玉石分类: 其它玉石</li>\r\n<li>售后: 7日内无条件退货...</li>\r\n<li>宝石证书: 不带证书</li>\r\n<li>新奇特: 新鲜出炉</li>\r\n<li>适合送给谁: 中年女性&nbsp;女童...</li>\r\n<li>适合的送礼场景: 生日送礼&nbsp;结婚送礼...</li>\r\n<li>适合的送礼人物类型: 精明理财型&nbsp;运动型... </li>', '', 99, 88.00, 0.00, '', 1, 0, 0, 0, 0, 1, 1, 1, 'uploadfiles/goods/2010/11/29/thumb_2010112903323860.jpg', 0, 0, 0, '2010-11-29 11:32:38', '0000-00-00 00:00:00', 0, 0, 0, 0),
(20, 7, '新款百达翡丽(Patek)复古系列多功能自动机械背透手表', 424, 0, 0, 1, '<span style="font-size:small;">百达翡丽数次被香港、台湾等地专家评为世界十大古董表排名的第一名。&nbsp;<br />&nbsp;&nbsp;&nbsp;作为全球爱表人士心目中最高地位的百达翡丽，已为许多富贵的中国人所拥有，百达翡丽坚持在日内瓦"一条龙"生产，而全然不顾高昂的成本，绝对值得尊 敬，日内瓦印记的获得，需要将机芯的每一部件按守则仔细修饰，现时有五个品牌的手表得到日内瓦印记，但其实每年得到该项殊荣的表中，大部分还是百达翡丽， 百达翡丽的机械表每年只生产两万只，每只都能刻上日内瓦印记的也只有百达翡丽。</span>\r\n<div><span style="FONT-SIZE: medium"></span>&nbsp;</div>\r\n<div>\r\n<div>\r\n<div>\r\n<div><span style="FONT-SIZE: medium"><span style="font-size:small;">&nbsp;&nbsp;&nbsp;手表在每个人的点缀物中占据着非常重要的位置，它几乎是唯一能公开显示主人显贵身份的物品。不动产、游艇、飞机通常都远离人们的视线，手表则经常戴在手上，几乎随时随地都可看到</span></span></div>\r\n<div><span style="FONT-SIZE: medium"><span style="font-size:small;">&nbsp;&nbsp;</span></span></div>\r\n<div><span style="FONT-SIZE: medium"><span style="font-size:small;">&nbsp;&nbsp; 谁会陪你过24小时，贵族，钟表爱好者贵族的标志是拥有一块百达翡丽表，高贵的艺术境界与昂贵的制作材料塑造百达翡丽经久不衰的品牌效应。作为世界十大名表之首,百达翡丽表每个款式推出都是一场革命,也是收藏家以及腕表爱好者狂热追逐并且不可企及!</span></span></div>\r\n<div><span style="FONT-SIZE: medium"></span>&nbsp;</div>\r\n<div><span style="FONT-SIZE: medium"><span style="font-size:small;">&nbsp;&nbsp; 如果要问全世界最厉害的制表师与最好的顶级复杂表是哪一家表商的？那么百达翡丽绝对当之无愧！目前堪称当今世界上最贵的表就是出自于百达翡丽之手，当然敢 推出如此惊人价格的表款也是大有来头的，有些顶级复杂功能表款具时、分、秒显示，1分钟陀飞轮装置、三问报时功能、万年历显示、几乎集所有功能于一身，是 瑞士传统制表工艺的完美表现,百达一向以独特设计以及复杂设计而闻名世界.</span></span></div></div></div></div>', '', 99, 588.00, 30.00, '', 1, 0, 0, 0, 0, 1, 1, 1, 'uploadfiles/goods/2010/11/29/thumb_2010112903395765.jpg', 1, 0, 0, '2010-11-29 11:39:57', '0000-00-00 00:00:00', 0, 0, 0, 30),
(21, 7, '韩国冰封时间 炫酷版 男士手表 72灯 led灯手表 时尚手表', 424, 78, 0, 1, '<li>品牌: 其它品牌手表</li>\r\n<li>型号: intercrew</li>\r\n<li>手表种类: 男表</li>\r\n<li>保修: 店铺保修</li>\r\n<li>成色: 全新</li>\r\n<li>推出时间: 2010年</li>\r\n<li>机芯类型: 电子表</li>\r\n<li>表带材质: 钛合金</li>\r\n<li>表盘形状: 其他</li>\r\n<li>显示类型: 数字</li>\r\n<li>颜色分类: 黑色&nbsp;银色</li>\r\n<li>适合送给谁: 少男&nbsp;中年男性...</li>\r\n<li>适合的送礼场景: 生日送礼&nbsp;学业有成...</li>\r\n<li>适合的送礼人物类型: 时尚爱美型...</li>\r\n<li>特殊功能: 夜光&nbsp;日历...</li>\r\n<li>手表价格区间: 300元以下 </li>', '', 99, 880.00, 80.00, '', 1, 0, 0, 0, 0, 1, 1, 1, 'uploadfiles/goods/2010/11/29/thumb_2010112903411338.jpg', 0, 0, 0, '2010-11-29 11:41:13', '0000-00-00 00:00:00', 0, 0, 0, 80),
(22, 6, '【恒盈户外】最新款专柜正品美国骆驼cantorp男款抓绒冲锋衣', 74, 77, 17, 1, '&nbsp; * 市场价: 1168<br />&nbsp;&nbsp;&nbsp; * 是否现货: 现货<br />&nbsp;&nbsp;&nbsp; * 适用人群: 男士<br />&nbsp;&nbsp;&nbsp; * 货号: F-3026<br />&nbsp;&nbsp;&nbsp; * 主流品牌: Cantorp/骆驼<br />&nbsp;&nbsp;&nbsp; * 工艺技术: 无缝对接 激光切割...<br />&nbsp;&nbsp;&nbsp; * 产地: 中国<br />&nbsp;&nbsp;&nbsp; * 颜色分类: F-3026兰色...<br />&nbsp;&nbsp;&nbsp; * 主要功能: 保暖 防水 防虫...<br />&nbsp;&nbsp;&nbsp; * 适应项目: 徒步 登山 野营...<br />&nbsp;&nbsp;&nbsp; * 面料科技: 其他<br />&nbsp;&nbsp;&nbsp; * 尺码: S M L XL...', '', 99, 498.00, 10.00, '', 1, 0, 0, 0, 0, 1, 1, 1, 'uploadfiles/goods/2010/11/29/thumb_2010112903414078.jpg', 0, 0, 0, '2010-11-29 11:41:40', '0000-00-00 00:00:00', 0, 0, 0, 10),
(23, 6, '美国骆驼cantorp女子高档户外登山鞋 LT-2670', 75, 80, 17, 1, '&nbsp;&nbsp; * 市场价: 638<br />&nbsp;&nbsp;&nbsp; * 货号: LT--2670<br />&nbsp;&nbsp;&nbsp; * 品牌: Cantorp/骆驼<br />&nbsp;&nbsp;&nbsp; * 颜色分类: 2670 卡其...<br />&nbsp;&nbsp;&nbsp; * 分类: 登山鞋<br />&nbsp;&nbsp;&nbsp; * 适用人群: 女士<br />&nbsp;&nbsp;&nbsp; * 户外鞋功能: 支撑 减震 平衡...<br />&nbsp;&nbsp;&nbsp; * 产地: 中国<br />&nbsp;&nbsp;&nbsp; * 是否现货: 现货<br />&nbsp;&nbsp;&nbsp; * 尺码: 35 36 37...', '', 99, 248.00, 10.00, '', 1, 0, 0, 0, 0, 1, 1, 1, 'uploadfiles/goods/2010/11/29/thumb_2010112903435815.jpg', 1, 0, 0, '2010-11-29 11:43:58', '2010-11-29 11:48:55', 0, 0, 0, 10),
(24, 6, 'aotu 户外35L运动背包 旅行包徒步包登山包 双肩包 配防雨罩', 77, 79, 17, 1, '&nbsp;&nbsp;&nbsp; * 品牌: aotu<br />&nbsp;&nbsp;&nbsp; * 市场价: 245<br />&nbsp;&nbsp;&nbsp; * 货号: aotu506<br />&nbsp;&nbsp;&nbsp; * 户外包容量: 20-35升<br />&nbsp;&nbsp;&nbsp; * 产地: 中国<br />&nbsp;&nbsp;&nbsp; * 是否现货: 现货<br />&nbsp;&nbsp;&nbsp; * 颜色分类: 红色 金黄色 橘色..', '', 99, 135.00, 10.00, '', 1, 0, 0, 0, 0, 1, 1, 1, 'uploadfiles/goods/2010/11/29/thumb_2010112903473267.jpg', 0, 0, 0, '2010-11-29 11:47:32', '0000-00-00 00:00:00', 0, 0, 0, 10);


--
-- 导出表中的数据 `imall_goods_gallery`
--

INSERT INTO `imall_goods_gallery` (`img_id`, `goods_id`, `img_url`, `img_desc`, `thumb_url`, `img_original`, `is_set`, `img_size_id`) VALUES
(1, 1, 'uploadfiles/goods/2010/11/29/m_2010112902244298.jpg', '', 'uploadfiles/goods/2010/11/29/thumb_2010112902244298.jpg', 'uploadfiles/goods/2010/11/29/2010112902244298.jpg', 1, 1),
(2, 2, 'uploadfiles/goods/2010/11/29/m_2010112902264274.jpg', '', 'uploadfiles/goods/2010/11/29/thumb_2010112902264274.jpg', 'uploadfiles/goods/2010/11/29/2010112902264274.jpg', 1, 2),
(3, 3, 'uploadfiles/goods/2010/11/29/m_2010112902345215.jpg', '', 'uploadfiles/goods/2010/11/29/thumb_2010112902345215.jpg', 'uploadfiles/goods/2010/11/29/2010112902345215.jpg', 1, 3),
(4, 4, 'uploadfiles/goods/2010/11/29/m_2010112902493251.jpg', '', 'uploadfiles/goods/2010/11/29/thumb_2010112902493251.jpg', 'uploadfiles/goods/2010/11/29/2010112902493251.jpg', 1, 4),
(5, 5, 'uploadfiles/goods/2010/11/29/m_2010112902522139.jpg', '', 'uploadfiles/goods/2010/11/29/thumb_2010112902522139.jpg', 'uploadfiles/goods/2010/11/29/2010112902522139.jpg', 1, 5),
(6, 6, 'uploadfiles/goods/2010/11/29/m_2010112902540584.jpg', '', 'uploadfiles/goods/2010/11/29/thumb_2010112902540584.jpg', 'uploadfiles/goods/2010/11/29/2010112902540584.jpg', 1, 6),
(7, 7, 'uploadfiles/goods/2010/11/29/m_2010112902560858.jpg', '', 'uploadfiles/goods/2010/11/29/thumb_2010112902560858.jpg', 'uploadfiles/goods/2010/11/29/2010112902560858.jpg', 1, 7),
(8, 7, 'uploadfiles/goods/2010/11/29/m_2010112902562452.jpg', '', 'uploadfiles/goods/2010/11/29/thumb_2010112902562452.jpg', 'uploadfiles/goods/2010/11/29/2010112902562452.jpg', 0, 8),
(9, 8, 'uploadfiles/goods/2010/11/29/m_2010112903050942.jpg', '', 'uploadfiles/goods/2010/11/29/thumb_2010112903050942.jpg', 'uploadfiles/goods/2010/11/29/2010112903050942.jpg', 1, 9),
(10, 9, 'uploadfiles/goods/2010/11/29/m_2010112903144378.jpg', '', 'uploadfiles/goods/2010/11/29/thumb_2010112903144378.jpg', 'uploadfiles/goods/2010/11/29/2010112903144378.jpg', 1, 10),
(11, 9, 'uploadfiles/goods/2010/11/29/m_2010112903145831.jpg', '', 'uploadfiles/goods/2010/11/29/thumb_2010112903145831.jpg', 'uploadfiles/goods/2010/11/29/2010112903145831.jpg', 0, 11),
(12, 10, 'uploadfiles/goods/2010/11/29/m_2010112903160287.jpg', '', 'uploadfiles/goods/2010/11/29/thumb_2010112903160287.jpg', 'uploadfiles/goods/2010/11/29/2010112903160287.jpg', 1, 12),
(13, 11, 'uploadfiles/goods/2010/11/29/m_2010112903171741.jpg', '', 'uploadfiles/goods/2010/11/29/thumb_2010112903171741.jpg', 'uploadfiles/goods/2010/11/29/2010112903171741.jpg', 1, 13),
(14, 12, 'uploadfiles/goods/2010/11/29/m_2010112903173062.jpg', '', 'uploadfiles/goods/2010/11/29/thumb_2010112903173062.jpg', 'uploadfiles/goods/2010/11/29/2010112903173062.jpg', 1, 14),
(15, 11, 'uploadfiles/goods/2010/11/29/m_2010112903173743.jpg', '', 'uploadfiles/goods/2010/11/29/thumb_2010112903173743.jpg', 'uploadfiles/goods/2010/11/29/2010112903173743.jpg', 0, 15),
(16, 11, 'uploadfiles/goods/2010/11/29/m_2010112903173758.jpg', '', 'uploadfiles/goods/2010/11/29/thumb_2010112903173758.jpg', 'uploadfiles/goods/2010/11/29/2010112903173758.jpg', 0, 16),
(17, 13, 'uploadfiles/goods/2010/11/29/m_2010112903220571.jpg', '', 'uploadfiles/goods/2010/11/29/thumb_2010112903220571.jpg', 'uploadfiles/goods/2010/11/29/2010112903220571.jpg', 1, 17),
(18, 13, 'uploadfiles/goods/2010/11/29/m_2010112903223472.jpg', '', 'uploadfiles/goods/2010/11/29/thumb_2010112903223472.jpg', 'uploadfiles/goods/2010/11/29/2010112903223472.jpg', 0, 18),
(19, 13, 'uploadfiles/goods/2010/11/29/m_2010112903223441.jpg', '', 'uploadfiles/goods/2010/11/29/thumb_2010112903223441.jpg', 'uploadfiles/goods/2010/11/29/2010112903223441.jpg', 0, 19),
(20, 13, 'uploadfiles/goods/2010/11/29/m_2010112903223473.jpg', '', 'uploadfiles/goods/2010/11/29/thumb_2010112903223473.jpg', 'uploadfiles/goods/2010/11/29/2010112903223473.jpg', 0, 20),
(21, 13, 'uploadfiles/goods/2010/11/29/m_2010112903223464.jpg', '', 'uploadfiles/goods/2010/11/29/thumb_2010112903223464.jpg', 'uploadfiles/goods/2010/11/29/2010112903223464.jpg', 0, 21),
(22, 14, 'uploadfiles/goods/2010/11/29/m_2010112903255296.jpg', '', 'uploadfiles/goods/2010/11/29/thumb_2010112903255296.jpg', 'uploadfiles/goods/2010/11/29/2010112903255296.jpg', 1, 22),
(23, 15, 'uploadfiles/goods/2010/11/29/m_2010112903273763.jpg', '', 'uploadfiles/goods/2010/11/29/thumb_2010112903273763.jpg', 'uploadfiles/goods/2010/11/29/2010112903273763.jpg', 1, 23),
(24, 16, 'uploadfiles/goods/2010/11/29/m_2010112903274638.jpg', '', 'uploadfiles/goods/2010/11/29/thumb_2010112903274638.jpg', 'uploadfiles/goods/2010/11/29/2010112903274638.jpg', 1, 24),
(25, 17, 'uploadfiles/goods/2010/11/29/m_2010112903292648.jpg', '', 'uploadfiles/goods/2010/11/29/thumb_2010112903292648.jpg', 'uploadfiles/goods/2010/11/29/2010112903292648.jpg', 1, 25),
(26, 18, 'uploadfiles/goods/2010/11/29/m_2010112903312523.jpg', '', 'uploadfiles/goods/2010/11/29/thumb_2010112903312523.jpg', 'uploadfiles/goods/2010/11/29/2010112903312523.jpg', 1, 26),
(27, 19, 'uploadfiles/goods/2010/11/29/m_2010112903323860.jpg', '', 'uploadfiles/goods/2010/11/29/thumb_2010112903323860.jpg', 'uploadfiles/goods/2010/11/29/2010112903323860.jpg', 1, 27),
(28, 20, 'uploadfiles/goods/2010/11/29/m_2010112903395765.jpg', '', 'uploadfiles/goods/2010/11/29/thumb_2010112903395765.jpg', 'uploadfiles/goods/2010/11/29/2010112903395765.jpg', 1, 28),
(29, 21, 'uploadfiles/goods/2010/11/29/m_2010112903411338.jpg', '', 'uploadfiles/goods/2010/11/29/thumb_2010112903411338.jpg', 'uploadfiles/goods/2010/11/29/2010112903411338.jpg', 1, 29),
(30, 22, 'uploadfiles/goods/2010/11/29/m_2010112903414078.jpg', '', 'uploadfiles/goods/2010/11/29/thumb_2010112903414078.jpg', 'uploadfiles/goods/2010/11/29/2010112903414078.jpg', 1, 30),
(31, 22, 'uploadfiles/goods/2010/11/29/m_2010112903415884.jpg', '', 'uploadfiles/goods/2010/11/29/thumb_2010112903415884.jpg', 'uploadfiles/goods/2010/11/29/2010112903415884.jpg', 0, 31),
(32, 22, 'uploadfiles/goods/2010/11/29/m_2010112903415866.jpg', '', 'uploadfiles/goods/2010/11/29/thumb_2010112903415866.jpg', 'uploadfiles/goods/2010/11/29/2010112903415866.jpg', 0, 32),
(33, 23, 'uploadfiles/goods/2010/11/29/m_2010112903435815.jpg', '', 'uploadfiles/goods/2010/11/29/thumb_2010112903435815.jpg', 'uploadfiles/goods/2010/11/29/2010112903435815.jpg', 1, 33),
(34, 23, 'uploadfiles/goods/2010/11/29/m_2010112903442360.jpg', '', 'uploadfiles/goods/2010/11/29/thumb_2010112903442360.jpg', 'uploadfiles/goods/2010/11/29/2010112903442360.jpg', 0, 34),
(35, 23, 'uploadfiles/goods/2010/11/29/m_2010112903442391.jpg', '', 'uploadfiles/goods/2010/11/29/thumb_2010112903442391.jpg', 'uploadfiles/goods/2010/11/29/2010112903442391.jpg', 0, 35),
(36, 23, 'uploadfiles/goods/2010/11/29/m_2010112903442348.jpg', '', 'uploadfiles/goods/2010/11/29/thumb_2010112903442348.jpg', 'uploadfiles/goods/2010/11/29/2010112903442348.jpg', 0, 36),
(37, 24, 'uploadfiles/goods/2010/11/29/m_2010112903473267.jpg', '', 'uploadfiles/goods/2010/11/29/thumb_2010112903473267.jpg', 'uploadfiles/goods/2010/11/29/2010112903473267.jpg', 1, 37),
(38, 24, 'uploadfiles/goods/2010/11/29/m_2010112903480091.jpg', '', 'uploadfiles/goods/2010/11/29/thumb_2010112903480091.jpg', 'uploadfiles/goods/2010/11/29/2010112903480091.jpg', 0, 38),
(39, 24, 'uploadfiles/goods/2010/11/29/m_2010112903480041.jpg', '', 'uploadfiles/goods/2010/11/29/thumb_2010112903480041.jpg', 'uploadfiles/goods/2010/11/29/2010112903480041.jpg', 0, 39),
(40, 24, 'uploadfiles/goods/2010/11/29/m_2010112903480063.jpg', '', 'uploadfiles/goods/2010/11/29/thumb_2010112903480063.jpg', 'uploadfiles/goods/2010/11/29/2010112903480063.jpg', 0, 40);



--
-- 导出表中的数据 `imall_goods_types`
--

INSERT INTO `imall_goods_types` (`type_id`, `type_name`, `is_show`) VALUES
(1, '全新', 1),
(2, '二手', 1),
(3, '闲置', 1);


--
-- 导出表中的数据 `imall_img_size`
--

INSERT INTO `imall_img_size` (`id`, `uid`, `img_url`, `img_size`, `upl_time`, `is_intro_img`, `goods_id`) VALUES
(1, 2, 'uploadfiles/goods/2010/11/29/2010112902244298.jpg', '4562', '2010-11-29 10:24:42', NULL, NULL),
(2, 2, 'uploadfiles/goods/2010/11/29/2010112902264274.jpg', '4477', '2010-11-29 10:26:43', NULL, NULL),
(3, 2, 'uploadfiles/goods/2010/11/29/2010112902345215.jpg', '36694', '2010-11-29 10:34:52', NULL, NULL),
(4, 1, 'uploadfiles/goods/2010/11/29/2010112902493251.jpg', '27185', '2010-11-29 10:49:32', NULL, NULL),
(5, 1, 'uploadfiles/goods/2010/11/29/2010112902522139.jpg', '9339', '2010-11-29 10:52:22', NULL, NULL),
(6, 1, 'uploadfiles/goods/2010/11/29/2010112902540584.jpg', '12090', '2010-11-29 10:54:05', NULL, NULL),
(7, 1, 'uploadfiles/goods/2010/11/29/2010112902560858.jpg', '32174', '2010-11-29 10:56:09', NULL, NULL),
(8, 1, 'uploadfiles/goods/2010/11/29/2010112902562452.jpg', '22861', '2010-11-29 10:56:24', NULL, NULL),
(9, 3, 'uploadfiles/goods/2010/11/29/2010112903050942.jpg', '19740', '2010-11-29 11:05:09', NULL, NULL),
(10, 4, 'uploadfiles/goods/2010/11/29/2010112903144378.jpg', '20561', '2010-11-29 11:14:43', NULL, NULL),
(11, 4, 'uploadfiles/goods/2010/11/29/2010112903145831.jpg', '28049', '2010-11-29 11:14:59', NULL, NULL),
(12, 3, 'uploadfiles/goods/2010/11/29/2010112903160287.jpg', '37339', '2010-11-29 11:16:02', NULL, NULL),
(13, 4, 'uploadfiles/goods/2010/11/29/2010112903171741.jpg', '44646', '2010-11-29 11:17:17', NULL, NULL),
(14, 3, 'uploadfiles/goods/2010/11/29/2010112903173062.jpg', '22299', '2010-11-29 11:17:31', NULL, NULL),
(15, 4, 'uploadfiles/goods/2010/11/29/2010112903173743.jpg', '54309', '2010-11-29 11:17:38', NULL, NULL),
(16, 4, 'uploadfiles/goods/2010/11/29/2010112903173758.jpg', '36536', '2010-11-29 11:17:38', NULL, NULL),
(17, 4, 'uploadfiles/goods/2010/11/29/2010112903220571.jpg', '18826', '2010-11-29 11:22:05', NULL, NULL),
(18, 4, 'uploadfiles/goods/2010/11/29/2010112903223472.jpg', '5483', '2010-11-29 11:22:37', NULL, NULL),
(19, 4, 'uploadfiles/goods/2010/11/29/2010112903223441.jpg', '18006', '2010-11-29 11:22:37', NULL, NULL),
(20, 4, 'uploadfiles/goods/2010/11/29/2010112903223473.jpg', '21427', '2010-11-29 11:22:37', NULL, NULL),
(21, 4, 'uploadfiles/goods/2010/11/29/2010112903223464.jpg', '45109', '2010-11-29 11:22:37', NULL, NULL),
(22, 4, 'uploadfiles/goods/2010/11/29/2010112903255296.jpg', '37527', '2010-11-29 11:25:52', NULL, NULL),
(23, 4, 'uploadfiles/goods/2010/11/29/2010112903273763.jpg', '17342', '2010-11-29 11:27:37', NULL, NULL),
(24, 5, 'uploadfiles/goods/2010/11/29/2010112903274638.jpg', '18017', '2010-11-29 11:27:46', NULL, NULL),
(25, 5, 'uploadfiles/goods/2010/11/29/2010112903292648.jpg', '39276', '2010-11-29 11:29:27', NULL, NULL),
(26, 5, 'uploadfiles/goods/2010/11/29/2010112903312523.jpg', '14150', '2010-11-29 11:31:25', NULL, NULL),
(27, 5, 'uploadfiles/goods/2010/11/29/2010112903323860.jpg', '14216', '2010-11-29 11:32:39', NULL, NULL),
(28, 7, 'uploadfiles/goods/2010/11/29/2010112903395765.jpg', '31075', '2010-11-29 11:39:58', NULL, NULL),
(29, 7, 'uploadfiles/goods/2010/11/29/2010112903411338.jpg', '28294', '2010-11-29 11:41:13', NULL, NULL),
(30, 6, 'uploadfiles/goods/2010/11/29/2010112903414078.jpg', '21272', '2010-11-29 11:41:41', NULL, NULL),
(31, 6, 'uploadfiles/goods/2010/11/29/2010112903415884.jpg', '15509', '2010-11-29 11:41:59', NULL, NULL),
(32, 6, 'uploadfiles/goods/2010/11/29/2010112903415866.jpg', '14417', '2010-11-29 11:41:59', NULL, NULL),
(33, 6, 'uploadfiles/goods/2010/11/29/2010112903435815.jpg', '18170', '2010-11-29 11:43:59', NULL, NULL),
(34, 6, 'uploadfiles/goods/2010/11/29/2010112903442360.jpg', '36012', '2010-11-29 11:44:26', NULL, NULL),
(35, 6, 'uploadfiles/goods/2010/11/29/2010112903442391.jpg', '35920', '2010-11-29 11:44:26', NULL, NULL),
(36, 6, 'uploadfiles/goods/2010/11/29/2010112903442348.jpg', '29983', '2010-11-29 11:44:26', NULL, NULL),
(37, 6, 'uploadfiles/goods/2010/11/29/2010112903473267.jpg', '24884', '2010-11-29 11:47:32', NULL, NULL),
(38, 6, 'uploadfiles/goods/2010/11/29/2010112903480091.jpg', '23514', '2010-11-29 11:48:02', NULL, NULL),
(39, 6, 'uploadfiles/goods/2010/11/29/2010112903480041.jpg', '30469', '2010-11-29 11:48:02', NULL, NULL),
(40, 6, 'uploadfiles/goods/2010/11/29/2010112903480063.jpg', '22636', '2010-11-29 11:48:02', NULL, NULL);

--
-- 导出表中的数据 `imall_nav`
--

INSERT INTO `imall_nav` (`id`, `nav_name`, `url`, `postion`, `type`, `short_order`) VALUES
(4, '团购', 'groupbuy.php', 1, 4, 1),
(5, '商品', 'search.php', 1, 4, 0),
(6, '商家', 'search.php?search_type=搜商家', 1, 4, 3),
(7, '资讯', 'article_list.php?id=1', 1, 4, 51);


--
-- 导出表中的数据 `imall_shop_categories`
--

INSERT INTO `imall_shop_categories` (`cat_id`, `cat_name`, `parent_id`, `sort_order`, `shops_num`) VALUES
(11, '数码', 0, 0, 0),
(12, '手机', 11, 0, 0),
(13, '笔记本', 11, 0, 0),
(15, '文体', 0, 0, 0),
(16, '户外', 15, 0, 0),
(17, '家居', 0, 0, 0),
(18, '家具', 17, 0, 0),
(19, '运动', 15, 0, 0);


--
-- 导出表中的数据 `imall_shop_category`
--

INSERT INTO `imall_shop_category` (`shop_cat_id`, `shop_id`, `shop_cat_name`, `shop_cat_unit`, `parent_id`, `sort_order`) VALUES
(1, 2, '狗粮', '', 0, 0),
(2, 3, '童装、帽子', '套', 0, 0),
(3, 3, '连身衣/哈衣, 内衣, 睡衣', '套', 2, 0),
(72, 1, '苹果笔记本', '', 0, 0),
(6, 3, '笔记本', '', 0, 0),
(7, 3, '相机', '', 0, 0),
(8, 2, '手表', '', 0, 0),
(9, 2, '手机', '', 0, 0),
(10, 2, '男包', '', 0, 0),
(37, 8, '手机', '', 0, 0),
(38, 23, '男装', '', 0, 0),
(39, 23, 'T恤', '', 38, 0),
(45, 26, '笔记本', '', 0, 0),
(41, 26, '电脑', '', 0, 1),
(47, 37, '服饰', '', 0, 0),
(46, 26, '联想', '', 0, 0),
(48, 37, '女装', '', 47, 0),
(49, 36, '商品类别测试111', '', 0, 0),
(50, 31, 'f', '', 0, 0),
(51, 45, '1111', '', 0, 0),
(52, 45, 'rrrr', '', 0, 0),
(53, 44, 'IBM', '', 0, 0),
(54, 50, 'java', '', 0, 0),
(55, 53, '苹果', '', 0, 0),
(56, 52, 'Nokia', '', 0, 0),
(57, 52, '苹果', '', 0, 0),
(58, 52, '摩托罗拉', '', 0, 0),
(59, 53, '戴尔', '', 0, 0),
(60, 54, '户外鞋', '', 0, 0),
(61, 54, '户外服装', '', 0, 0),
(62, 54, '户外包', '', 0, 0),
(63, 55, '电脑桌', '', 0, 0),
(64, 55, '躺椅', '', 0, 0),
(65, 56, '苹果手机', '', 0, 0),
(66, 56, 'iPhone4', '', 65, 0),
(67, 58, '山地车', '', 0, 0),
(68, 58, '女式车', '', 0, 0),
(69, 2, '家电', '', 0, 0),
(70, 2, '冰箱', '', 69, 0),
(71, 2, '液晶电视', '', 69, 0),
(73, 4, '手机', '', 0, 0),
(74, 5, '2343', '', 0, 0),
(75, 5, '玉器', '', 0, 0),
(76, 5, '黄金', '', 0, 0),
(77, 6, '冲锋衣', '', 0, 0),
(78, 7, '手表', '', 0, 0),
(79, 6, '背包', '', 0, 0),
(80, 6, '登山鞋', '', 0, 0);


--
-- 导出表中的数据 `imall_shop_info`
--

INSERT INTO `imall_shop_info` (`shop_commend`, `shop_id`, `user_id`, `shop_name`, `shop_country`, `shop_province`, `shop_city`, `shop_district`, `shop_address`, `shop_images`, `shop_logo`, `shop_template_img`, `shop_template`, `shop_management`, `shop_intro`, `shop_notice`, `shop_creat_time`, `goods_num`, `open_flg`, `lock_flg`, `map_x`, `map_y`, `map_zoom`, `count_imgsize`, `shop_categories`, `shop_domain`) VALUES
(1, 2, 2, '海信专卖店', 1, 22, 283, 2334, '历下区山大路248号', NULL, 'uploadfiles/shop/2010/11/29/2010112905171663.jpg', 'uploadfiles/shop/2010/11/29/2010112905171691.jpg', 'green', '家电、冰箱、洗衣机、空调等家用电器', '本店为海信挂名的特许经营专卖店', NULL, '2010-11-29 10:09:40', 3, 0, 0, '0', '0', '11', 45733, 18, NULL),
(1, 1, 1, '苹果旗舰店', 1, 22, 283, 2332, '山东省济南市历下区金泉大厦', NULL, 'uploadfiles/shop/2010/11/29/2010112903574176.jpg', '', 'default', '笔记本 ipad', '笔记本 ipad<br />', NULL, '2010-11-29 10:09:47', 4, 0, 0, '0', '0', '11', 103649, 13, NULL),
(1, 3, 3, '花朵儿', 1, 22, 283, 2334, '111111111111', NULL, 'uploadfiles/shop/2010/11/29/2010112905331398.jpg', 'uploadfiles/shop/2010/11/29/2010112905331362.jpg', 'default', '1111111111111111111', '1111111111111111', NULL, '2010-11-29 10:53:09', 3, 0, 0, '0', '0', '11', 79378, 18, NULL),
(1, 4, 4, '手机专卖', 1, 22, 283, 2333, '山东省济南市历下区金泉大厦', NULL, 'uploadfiles/shop/2010/11/29/2010112904032887.jpg', NULL, 'blue', '手机', '手机专卖<br />', NULL, '2010-11-29 11:03:48', 5, 0, 0, '0', '0', '11', 248596, 12, NULL),
(1, 5, 5, '玉友珠宝', 1, 22, 283, 2336, '234234324324', NULL, 'uploadfiles/shop/2010/11/29/2010112905222426.jpg', 'uploadfiles/shop/2010/11/29/2010112905222415.jpg', 'default', '2342343243242', '234234234324324', NULL, '2010-11-29 11:24:23', 4, 0, 0, '0', '0', '11', 85659, 18, NULL),
(1, 6, 6, '户外运动专卖', 1, 22, 283, 2333, '山东省济南市历下区金泉大厦', NULL, 'uploadfiles/shop/2010/11/29/2010112903531896.jpg', NULL, 'default', '户外 运动', '户外 运动 <br />', NULL, '2010-11-29 11:32:36', 3, 0, 0, '0', '0', '11', 131362, 16, NULL),
(1, 7, 7, '名表行', 1, 22, 283, 2332, '21132', NULL, 'uploadfiles/shop/2010/11/29/2010112904005398.jpg', 'uploadfiles/shop/2010/11/29/2010112904013325.jpg', 'default', '123123123123', '12312312312312', NULL, '2010-11-29 11:35:54', 2, 0, 0, '0', '0', '11', 59369, 18, NULL);


--
-- 导出表中的数据 `imall_shop_payment`
--

INSERT INTO `imall_shop_payment` (`shop_payment_id`, `shop_id`, `pay_id`, `pay_desc`, `pay_config`, `enabled`) VALUES
(1, 1, 1, '支付宝(接口网站：www.alipay.com) 是国内先进的网上支付平台，无预付/年费，单笔费率1.5%，无流量限制。 立即在线申请', 'a:3:{s:7:"partner";s:6:"111111";s:13:"security_code";s:10:"1111111111";s:12:"seller_email";s:10:"1111111111";}', 1),
(2, 1, 5, '收款人信息：银行 ***； 帐号 ***； 姓名 ***；', 'a:0:{}', 1),
(3, 1, 4, '收款人信息: 姓名 ***; 地址:***; 邮编 ***', 'a:0:{}', 1),
(4, 2, 4, '收款人信息: 姓名 ***; 地址:***; 邮编 ***', 'a:0:{}', 1),
(5, 3, 4, '收款人信息: 姓名 ***; 地址:***; 邮编 ***', 'a:0:{}', 1),
(6, 4, 1, '支付宝(接口网站：www.alipay.com) 是国内先进的网上支付平台，无预付/年费，单笔费率1.5%，无流量限制。 立即在线申请', 'a:3:{s:7:"partner";s:11:"11111111111";s:13:"security_code";s:8:"11111111";s:12:"seller_email";s:9:"111111111";}', 1),
(7, 4, 5, '收款人信息：银行 ***； 帐号 ***； 姓名 ***；', 'a:0:{}', 1),
(8, 4, 4, '收款人信息: 姓名 ***; 地址:***; 邮编 ***', 'a:0:{}', 1),
(9, 5, 4, '收款人信息: 姓名 ***; 地址:***; 邮编 ***', 'a:0:{}', 1),
(10, 7, 4, '收款人信息: 姓名 ***; 地址:***; 邮编 ***', 'a:0:{}', 1),
(11, 6, 1, '支付宝(接口网站：www.alipay.com) 是国内先进的网上支付平台，无预付/年费，单笔费率1.5%，无流量限制。 立即在线申请', 'a:3:{s:7:"partner";s:12:"111111111111";s:13:"security_code";s:12:"111111111111";s:12:"seller_email";s:12:"111111111111";}', 1),
(12, 6, 5, '收款人信息：银行 ***； 帐号 ***； 姓名 ***；', 'a:0:{}', 1),
(13, 6, 4, '收款人信息: 姓名 ***; 地址:***; 邮编 ***', 'a:0:{}', 1);


--
-- 导出表中的数据 `imall_shop_request`
--

INSERT INTO `imall_shop_request` (`request_id`, `user_id`, `company_name`, `person_name`, `credit_type`, `credit_num`, `credit_commercial`, `company_area`, `company_address`, `zipcode`, `mobile`, `telphone`, `add_time`, `status`) VALUES
(1, 2, '海信', '海信', '身份证', '111111111111111111', 'uploadfiles/shop/request/2/2010112902081315.jpg', '11111111111', '1111111111111111111', 111111, '1111111111111111111', '111111111111111', '2010-11-29 10:08:13', 1),
(2, 1, 'zhangsan', 'zhangsan', '身份证', '111111111111111111', 'uploadfiles/shop/request/1/2010112902081672.jpg', '济南市历城区', '济南市历城区金泉大厦', 111111, '13815215064', '13815215064', '2010-11-29 10:08:16', 1),
(3, 3, '花朵儿', '花朵儿', '军官证', '1111111111111111111111111', 'uploadfiles/shop/request/3/2010112902510770.jpg', '', '111111111111111', 1111111, '11111111111111111', '11111111111111111111', '2010-11-29 10:51:07', 1),
(4, 4, 'lisi', 'lisi', '身份证', '11111111111111111', 'uploadfiles/shop/request/4/2010112903025488.jpg', '济南市历城区', '济南市历城区金泉大厦', 111111, '13815215064', '13815215064', '2010-11-29 11:02:54', 1),
(5, 5, 'asdfasd', 'asdf', '身份证', '234234234234', 'uploadfiles/shop/request/5/2010112903235969.jpg', '', '23423423423', 23432432, '234234234234324234', '23423423423423', '2010-11-29 11:23:59', 1),
(6, 6, 'wangwu', 'wangwu', '身份证', '1111111111111111111', 'uploadfiles/shop/request/6/2010112903313171.jpg', '济南市历城区', '济南市历城区金泉大厦', 111111, '13815215064', '13815215064', '2010-11-29 11:31:31', 1),
(7, 7, '131', '123123', '身份证', '123123123123123', 'uploadfiles/shop/request/7/2010112903353121.jpg', '', '123123123', 123123, '12312321312312323', '123123213123123', '2010-11-29 11:35:31', 1);


--
-- 导出表中的数据 `imall_transport`
--

INSERT INTO `imall_transport` (`tranid`, `tran_name`, `ifopen`, `content`, `tran_type`) VALUES
(1, 'EMS', 1, '这是EMS的内容', 'ems'),
(2, '平邮', 1, '通过邮局来进行传递', 'pst'),
(3, '快递', 0, '通过快递公司\r\n', 'ex');

--
-- 导出表中的数据 `imall_users`
--

INSERT INTO `imall_users` (`user_id`, `user_email`, `user_name`, `user_passwd`, `user_question`, `user_answer`, `user_ico`, `reg_time`, `last_login_time`, `last_ip`, `email_check`, `email_check_code`, `forgot_check_code`, `rank_id`, `locked`) VALUES
(1, 'zhangsan@jooyea.com', 'zhangsan', '613e14fd8459bd696ed30940e90d7647', NULL, NULL, '', '2010-11-29 10:06:15', '2010-11-29 11:57:25', '192.168.1.65', 1, '428bbf7e94758e40cf49c197f2965e44', NULL, 2, 0),
(2, '111@22.com', '海信专卖店', '96e79218965eb72c92a549dd5a330112', NULL, NULL, '', '2010-11-29 10:07:45', '2010-11-29 13:13:20', '192.168.2.99', 1, '78465c6166afa56193ba68c763fb812e', NULL, 2, 0),
(3, '222@22.com', '花朵儿', '96e79218965eb72c92a549dd5a330112', NULL, NULL, '', '2010-11-29 10:50:19', '2010-11-29 13:31:15', '192.168.2.99', 1, '23cfee668799af648ec6ca8892b50a96', NULL, 2, 0),
(4, 'lisi@jooyea.com', 'lisi', '613e14fd8459bd696ed30940e90d7647', NULL, NULL, '', '2010-11-29 11:01:10', '2010-11-29 12:03:07', '192.168.2.65', 1, '56ae3768e14189331d143d8f46f2442a', NULL, 2, 0),
(5, '333@as2.fg', '玉友珠宝', '96e79218965eb72c92a549dd5a330112', NULL, NULL, '', '2010-11-29 11:22:59', '2010-11-29 13:22:03', '192.168.2.99', 1, 'eba8d161615b3af95afe426ec5a2e930', NULL, 2, 0),
(6, 'wangwu@jooyea.com', 'wangwu', '613e14fd8459bd696ed30940e90d7647', NULL, NULL, '', '2010-11-29 11:29:12', NULL, NULL, 1, '24ec15f9902b887d59b476bbb72bf9ba', NULL, 2, 0),
(7, '454@sdf.dfg', '名表行', '96e79218965eb72c92a549dd5a330112', NULL, NULL, '', '2010-11-29 11:33:57', NULL, NULL, 1, 'f58c01dd61006ecf208e02b40c3699ae', NULL, 2, 0);


--
-- 导出表中的数据 `imall_user_info`
--

INSERT INTO `imall_user_info` (`id`, `user_id`, `user_truename`, `user_ico`, `user_marry`, `user_gender`, `user_mobile`, `user_telphone`, `user_country`, `user_province`, `user_city`, `user_district`, `user_zipcode`, `user_address`, `user_birthday`, `user_qq`, `user_msn`, `user_skype`) VALUES
(1, 1, '', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 2, '', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 3, '', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 4, '', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 5, '', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 6, '', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 7, '', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
