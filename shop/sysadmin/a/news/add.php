<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}
require_once("../foundation/module_news.php");
require_once("../foundation/module_admin_logs.php");
//语言包引入
$a_langpackage=new adminlp;

//权限管理
$right=check_rights("news_add");
if(!$right){
	action_return(0,$a_langpackage->a_privilege_mess,'m.php?app=error');
}
$ctime = new time_class;
/* post 数据处理 */
$post['title'] = short_check(get_args('title'));
$post['cat_id'] = intval(get_args('cat_id'));
//$post['is_link'] = intval(get_args('is_link'));
$post['is_show'] = intval(get_args('is_show'));
//$post['link_url'] = short_check(get_args('link_url'));
$content = big_check(get_args('content'));

$replacearray = array("/<(script.*?)>(.*?)<(\/script.*?)>/","/<(i?frame.*?)>(.*?)<(\/i?frame.*?)>/","/<(\/?link.*?)>/","/<(\/?html.*?)>/");
$repalce = array("","","","");
$post['content'] = preg_replace($replacearray,$repalce,$content); //过滤html标签 

$post['short_order'] = intval(get_args('short_order'));
$post['is_blod'] = intval(get_args('is_blod'));
$post['tag_color'] = get_args('tilte_color');

$post['admin_id'] = $_SESSION['admin_id'];
$post['add_time'] = $ctime->long_time();

if(empty($post['title'])) {
	action_return(0,$a_langpackage->a_title_null,'-1');
	exit;
}

//数据表定义区
$t_article = $tablePreStr."article";
$t_admin_log = $tablePreStr."admin_log";
$t_article_cat = $tablePreStr."article_cat";
//定义写操作
dbtarget('w',$dbServs);
$dbo=new dbex;
$article_id = insert_news_info($dbo,$t_article,$post);
if ($article_id){
	$artid = $post['cat_id'];
	$asql = "select art_num from `$t_article_cat` where cat_id = $artid";
	$n = $dbo->getRow($asql);
	$update_items['art_num'] = $n['art_num']+1;
	update_news_cat($dbo,$t_article_cat,$update_items,$artid);
}
$news = get_news_info($dbo,$t_article,$article_id);
if (strpos($news['content'], 'img')){
$preg = '#<img src="(.*)" alt="" />#iUs';
preg_match_all($preg, $news['content'], $arr); 
if ($arr){
	$img = str_replace($baseUrl, $webRoot, $arr[1][0]);
//	$orimg = str_replace('../', $webRoot, $arr[1][0]);
	
	$picdir = dirname($img);
	$filename = basename($img);
//	echo $picdir.'<br>'.$filename;
	//生成缩略图
	list($width, $height, $itype, $attr) = getimagesize($img);
	$ni=imagecreatetruecolor('128','128');
	   
	   
		switch ($itype) {
			case 1: $im = imagecreatefromgif($img); break;
			case 2: $im = imagecreatefromjpeg($img); break;
			case 3: $im = imagecreatefrompng($img); break;
		}
		
		imagecopyresampled($ni,$im,0,0,0,0,'128','128',$width,$height);
		$dstFile =  $picdir.'/thumb'.$filename; 
	//	echo $dstFile;exit;
		ImageJpeg($ni,$dstFile);
		//更新
		$name = str_replace($webRoot, '', $dstFile);
		
		$update_items['thumb'] = $name;
		update_news_info($dbo,$t_article,$update_items,$article_id);
}
}
		//	print_r($arr);exit;
if($article_id) {
	admin_log($dbo,$t_admin_log,$a_langpackage->a_add_uml."：$article_id");
	action_return(1,$a_langpackage->a_add_suc);
} else {
	action_return(0,$a_langpackage->a_add_lose,'-1');
}
?>