<?php
/*
 * 注意：此文件由itpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/modules/page.html
 * 如果您的模型要进行修改，请修改 models/modules/page.php
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
if(filemtime("templates/default/modules/page.html") > filemtime(__file__) || (file_exists("models/modules/page.php") && filemtime("models/modules/page.php") > filemtime(__file__)) ) {
	tpl_engine("default","modules/page.html",1);
	include(__file__);
} else {
/* debug模式运行生成代码 结束 */
?><?php
	$start_page	=	1;
	$end_page	=	10;
	$first_page	=	0;
	$last_page	=	0;
	
//引入语言包
if(!isset($m_langpackage)){
	$m_langpackage=new moduleslp;
	
}
	if($result['countpage']	>	10){
		if($result['page']	>	5){
			$start_page	=	$result['page']	-	4;
			$end_page	=	$result['page']	+	5;
		}
		if($end_page	>	$result['countpage'])
		{
			$start_page	=	$result['countpage']	-	9;
			$end_page	=	$result['countpage'];
		}
	}
	else{
		$end_page	=	$result['countpage'];
	}
	
	if($start_page	>	1)
		$first_page	=	1;
	if($end_page	<	$result['countpage'])
		$last_page	=	1;
if(isset($result['countpage'])){
	$pagecount=$result['countpage'];
}
?><?php if($result['countpage']>0){?>
	<a class="upPage"  href="<?php echo 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'].$result['preurl'];?>"><?php echo $m_langpackage->m_page_pre;?></a>
		<?php if($first_page==1){?>
			<a href="<?php echo 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'].$result['nopage'].'1' ;?>" ><?php echo '1';?></a><span>...</span>
		<?php }?>
		<?php for($i=$start_page;$i<=$end_page;$i++){?>
			<a <?php if($i==$result['page']){?> class="now" <?php }?> href="<?php echo 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'].$result['nopage'].$i ;?>" ><?php echo $i;?></a>
		<?php }?>
		<?php if($last_page==1){?>
			<span>...</span><a href="<?php echo 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'].$result['nopage'].$result['countpage'] ;?>" ><?php echo  $result['countpage'];?></a>
		<?php }?>
	<a class="nextPage" href="<?php echo 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'].$result['nexturl'];?>" ><?php echo $m_langpackage->m_page_next;?></a>
<?php }?>
<?php } ?>