<?php
/*
 * 注意：此文件由itpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/shop/index_header.html
 * 如果您的模型要进行修改，请修改 models/shop/index_header.php
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
if(filemtime("templates/default/shop/index_header.html") > filemtime(__file__) || (file_exists("models/shop/index_header.php") && filemtime("models/shop/index_header.php") > filemtime(__file__)) ) {
	tpl_engine("default","shop/index_header.html",1);
	include(__file__);
} else {
/* debug模式运行生成代码 结束 */
?><?php
if(!$IWEB_SHOP_IN) {
	trigger_error('Hacking attempt');
}

if($USER['shop_id']) {
	$url=shop_url($USER['shop_id']);
} else {
	$url='modules.php?app=shop_info';
}
$search_header_type = short_check(get_args("search_type"));
//引入语言包
if(!isset($i_langpackage)){
	$i_langpackage = new indexlp;
}
$ksearch=short_check(get_args("k"));
if($i_langpackage->i_search_keyword==$ksearch){
	$ksearch="";
}
?><div id="header" class="clearfix">
    <div class="site_nav clearfix">
      <p class="login_info"><span><?php echo  $i_langpackage->i_welcome;?><?php echo $SYSINFO['sys_name'];?>!</span><?php  if($USER['login']){?><?php echo  $i_langpackage->i_hi;?>! <?php echo  $USER['user_name'];?> <a href="do.php?act=logout"><?php echo  $i_langpackage->i_logout;?></a><?php } else {?><a href="login.php"><?php echo $i_langpackage->i_login;?></a>&nbsp;|&nbsp;<a href="modules.php?app=reg"><?php echo $i_langpackage->i_register_free;?></a><?php }?></p>
      <p class="quick_menu">
        <a href="index.php"><?php echo $i_langpackage->i_shop_index;?></a><a href="modules.php"><?php echo $i_langpackage->i_u_center;?></a>
        <a class="shop_cart" href="modules.php?app=user_cart"><?php echo $i_langpackage->i_cart;?></a>
        <a href="modules.php?app=user_favorite"><?php echo $i_langpackage->i_favorite;?></a>
      </p>
    </div>
    <div class="topMain clearfix">
      <h1 id="logo">
  		<?php  if($SYSINFO['sys_logo']){?>
			<a href="index.php">
				<img src="<?php echo $SYSINFO['sys_logo'];?>" title="<?php echo $SYSINFO['sys_name'];?>" style="float:left;width:209px; height:43px;" onerror="this.src='skin/default/images/nopic.gif'"/>
			</a>
  		<?php }else {?>
  			<a href="index.php"><img src="skin/<?php echo  $SYSINFO['templates'];?>/images/img_logo.gif" title="" alt="<?php echo $SYSINFO['sys_name'];?>" /></a>
  		<?php }?>
      </h1>
      <form action="search.php" method="POST" id="search_form" >
      <div class="search_panel clearfix">
    	<p class="search_sel" onclick="setShow('sel_content');setOnShowPara('sel_content');">
			<?php  if($search_header_type == $i_langpackage->i_s_company){?>
				<input class="sel_value" id="sel_value" value="<?php echo $i_langpackage->i_s_company;?>" name="search_type" type="text" />
  			<?php }else {?>
    			<input class="sel_value" id="sel_value" value="<?php echo $i_langpackage->i_goods_search;?>" name="search_type" type="text" />
			<?php }?>
    	</p>
    	<?php if(!$ksearch){?>
        <p class="search_txt"><input name="k" type="text" onblur="inputTxt(this,'set');" onfocus="inputTxt(this,'clean');" value="<?php echo $i_langpackage->i_search_keyword;?>" /></p>
       <?php }else{?>
       <p class="search_txt"><input name="k" type="text" onblur="inputTxt(this,'set');" onfocus="inputTxt(this,'clean');" style="color:#000000;"; value="<?php echo $ksearch;?>" /></p>
       <?php }?>
       
        <p class="search_btn"><input type="submit" value="" /></p>
        <div id="sel_content" class="sel_list" style="display:none">
        	<ul><li onclick="document.getElementById('sel_value').value = this.innerHTML" onmouseover="this.className = 'li_hover'" onmouseout="this.className = ''"><?php echo $i_langpackage->i_goods_search;?></li><li onclick="document.getElementById('sel_value').value = this.innerHTML" onmouseover="this.className = 'li_hover'" onmouseout="this.className = ''"><?php echo $i_langpackage->i_s_company;?></li></ul>
        </div>
      </div>
      </form>
    </div>
</div>

<input type="text" name="sel_content_c" id="sel_content_c" size="0" onblur="javascript:timerSetHidden('sel_content',200);" style="top:-100px;position:absolute;width:1px;height:1px;border:0px;background-color:transparent;" value="1">
<?php } ?>