<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

function shop_url($shop_id,$app='index',$domain='',$page=''){
	global $url_rewrite;
	global $SYSINFO;
	global $dbServs;
	global $tablePreStr;
	$domain_url = '';
	$url='';
	if ($SYSINFO['sys_domain']){
		$t_shop_info = $tablePreStr."shop_info";
		$t_users = $tablePreStr."users";
		$t_user_rank = $tablePreStr."user_rank";
		dbtarget('r',$dbServs);
		$dbo = new dbex;
		$sql = "select ur.privilege from $t_shop_info as si join  $t_users as u  on si.user_id=u.user_id join $t_user_rank as ur on u.rank_id = ur.rank_id where si.shop_id = '$shop_id'";
		$user_rank = $dbo->getRow($sql);
		$privilege = unserialize($user_rank['privilege']);
		$flag ='0';
		foreach ($privilege as $key =>$vlaue){
			if ($key =='10'){
				$flag ='1';
			}
		}
		if($flag=='1'){
			if(isset($domain))
				$domain_url= 'http://'.$domain.$SYSINFO['site_domain']."/";
		}
	}
	if($url_rewrite) {
		$url_rewrite=='1' ? $url = "shop/$shop_id" : $url = "shop.php/$shop_id";
		if($app) {
			$url .= "/$app";
		}
		if($page) {
			$url .= "/$page";
		}
		$url .= '.html';
	} else {
		 if($domain_url){
			if($app!='index'){
				$url = "shop.php";
				if($app) {
					$url .= "?app=$app";
				}
				if($page) {
					$url .= "&page=$page";
				}
			}
		} else {
			$url = "shop.php?shopid=$shop_id";
			if($app) {
				$url .= "&app=$app";
			}
			if($page) {
				$url .= "&page=$page";
			}
		}
	}
	if($domain_url)
		$url = $domain_url.$url;
	return $url;
	
}

function goods_url($goods_id){
	global $url_rewrite;
	if($url_rewrite) {
		$url_rewrite=='1' ? $url = "goods/$goods_id" : $url = "goods.php/$goods_id";
		$url .= '.html';
	} else {
		$url = "goods.php?id=$goods_id";
	}
	return $url;
}

function article_url($article_id){
	global $url_rewrite;
	if($url_rewrite) {
		$url_rewrite=='1' ? $url = "article/$article_id" : $url = "article.php/$article_id";
		$url .= '.html';
	} else {
		$url = "article.php?id=$article_id";
	}
	return $url;
}

function article_list_url($id,$page=''){
	global $url_rewrite;
	if($url_rewrite) {
		$url_rewrite=='1' ? $url = "article_list/$id" : $url = "article_list.php/$id";
		if($page) {
			$url .= "/$page";
		}
		$url .= '.html';
	} else {
		$url = "article_list.php?id=$id";
		if($page) {
			$url .= "&page=$page";
		}
	}
	return $url;
}


function ucategory_url($id,$page=''){
	global $url_rewrite;
	if($url_rewrite) {
		$url_rewrite=='1' ? $url = "ucategory/$id" : $url = "ucategory.php/$id";
		if($page) {
			$url .= "/$page";
		}
		$url .= '.html';
	} else {
		$url = "ucategory.php?id=$id";
		if($page) {
			$url .= "&page=$page";
		}
	}
	return $url;
}

function category_url($id,$page=''){
	global $url_rewrite;
	if($url_rewrite) {
		$url_rewrite=='1' ? $url = "category/$id" : $url = "category.php/$id";
		if($page) {
			$url .= "/$page";
		}
		$url .= '.html';
	} else {
		$url = "category.php?id=$id";
		if($page) {
			$url .= "&page=$page";
		}
	}
	return $url;
}

function urlRewrite(){
	$script_name = basename($_SERVER['SCRIPT_NAME']);
	$request_str = strstr($_SERVER['REQUEST_URI'],'.php');
	$request_str=preg_replace("/\.(html|htm|php)$/",'',$request_str);
	$request_arr=explode('/',$request_str);
	array_shift($request_arr);
	if($script_name == 'goods.php' || $script_name == 'article.php') {
		isset($request_arr[0]) && $_GET['id'] = $request_arr[0];
	} elseif ($script_name == 'shop.php') {
		isset($request_arr[0]) && $_GET['shopid'] = $request_arr[0];
		isset($request_arr[1]) && $_GET['app'] = $request_arr[1];
		isset($request_arr[2]) && $_GET['page'] = $request_arr[2];
	} elseif ($script_name == 'category.php' || $script_name == 'ucategory.php' || $script_name == 'article_list.php') {
		isset($request_arr[0]) && $_GET['id'] = $request_arr[0];
		isset($request_arr[1]) && $_GET['page'] = $request_arr[1];
	}
}

if($url_rewrite && $url_rewrite=='2') {
	urlRewrite();
}
?>