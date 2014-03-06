<?php

/**
 *    二级域名解析
 **/
/* 二级域名功能未开启，不解析 */
$custom_domain='';
if ($SYSINFO['sys_domain']){
	
    /* 获取当前域名 */
	$current_domain = get_domain();
	/* 获取二级域名 */
	$custom_domain = get_custom_domain($current_domain);

	/* 没有二级域名，不解析 */
	if ($custom_domain != false)
	{
		/* 解析对应的二级域名到对应的店铺 */
		$shop_id = get_custom_domain_shop_id($custom_domain);
		if ($shop_id != false)
		{
			$_GET['shopid'] = $_REQUEST['shopid'] = $shop_id;
			if($_SERVER['PHP_SELF']!='/shop.php')
			header("Location:/shop.php");
		}
	}
}


/**
 *    获取二级域名对应的店铺ID
 *
 *    @author    Garbin
 *    @param     string $custom_domain
 *    @return    int    成功
 *               false  失败
 */
function get_custom_domain_shop_id($custom_domain)
{
    #TODO 获取对应的店铺ID
	global $dbServs;
	global $tablePreStr;
	$t_shop_info = $tablePreStr."shop_info";
	$t_users = $tablePreStr."users";
	$t_user_rank = $tablePreStr."user_rank";
	
	dbtarget('r',$dbServs);
	$dbo=new dbex;
	$sql = "select ur.privilege,si.shop_id from $t_shop_info as si join  $t_users as u  on si.user_id=u.user_id join $t_user_rank as ur on u.rank_id = ur.rank_id where si.shop_domain='$custom_domain'";
	$shop_info = $dbo->getRow($sql);
	if (empty($shop_info))
    {
         return false;
    }
	
	$privilege = unserialize($shop_info['privilege']);
	$flag ='0';
	foreach ($privilege as $key =>$vlaue){
		if ($key =='10'){
			$flag ='1';
		}
	}
	if($flag == '0'){
		return false;
	}
    return $shop_info['shop_id'];
}

/**
 *    获取自定义二级域名
 *
 *    @author    Garbin
 *    @return    string     成功
 *               false      失败
 */
function get_custom_domain($current_domain)
{
	global $baseUrl;
    $curr_url_info = parse_url($current_domain);
    $main_url_info = parse_url($baseUrl);
    $curr_domain = strtolower($curr_url_info['host']);
    $main_domain = strtolower($main_url_info['host']);
	/* 当前域名不是二级域名 */
	
    if ($curr_domain == $main_domain)
    {
        return false;
    }
    $tmp = explode('.', $curr_domain);

    return $tmp[0];
}

/**
 * 获得当前的域名
 *
 * @return  string
 */
function get_domain()
{
    /* 协议 */
    $protocol = (isset($_SERVER['HTTPS']) && (strtolower($_SERVER['HTTPS']) != 'off')) ? 'https://' : 'http://';

    /* 域名或IP地址 */
    if (isset($_SERVER['HTTP_X_FORWARDED_HOST']))
    {
        $host = $_SERVER['HTTP_X_FORWARDED_HOST'];
    }
    elseif (isset($_SERVER['HTTP_HOST']))
    {
        $host = $_SERVER['HTTP_HOST'];
    }
    else
    {
        /* 端口 */
        if (isset($_SERVER['SERVER_PORT']))
        {
            $port = ':' . $_SERVER['SERVER_PORT'];

            if ((':80' == $port && 'http://' == $protocol) || (':443' == $port && 'https://' == $protocol))
            {
                $port = '';
            }
        }
        else
        {
            $port = '';
        }

        if (isset($_SERVER['SERVER_NAME']))
        {
            $host = $_SERVER['SERVER_NAME'] . $port;
        }
        elseif (isset($_SERVER['SERVER_ADDR']))
        {
            $host = $_SERVER['SERVER_ADDR'] . $port;
        }
    }

    return $protocol . $host;
}

?>
