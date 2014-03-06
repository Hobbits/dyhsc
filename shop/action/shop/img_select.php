<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

//引入模块公共方法文件
/* post 数据处理 */
$ii = 2;
$page = intval(get_args('page'));
//数据表定义区
$t_img_size = $tablePreStr."img_size";

//定义写操作
dbtarget('r',$dbServs);
$dbo=new dbex;

$sql="select * from $t_img_size where uid=$shop_id ";

$result= $dbo->ajax_page($sql,10,$page);
$str= "<ul>";
$i=1;
$vala="";

foreach($result['result'] as $val){
	if($ii==2){
		$str.= "<li><p class='photo'><img src='".$val['img_url']."' width='100' height='100' /></p>";
		$str.="<p><a href='javascript:;'  onclick='change_style(\"style1\");return addIntroImg(this);' >插入</a><a href='javascript:;' name='".$val["id"]."' onclick='return delIntroImg(this)'>删除</a></p></li>";
	}else
	if($ii==1){
		$str.= "<td><img ondblclick=\"showimg('".$val['img_url']."')\" src='".$val['img_url']."' height='100' width='100'/></td>";
	}
	$vala.=$val["id"].",";
	if($i%6==0){
		$str.="<li></li>";
	}
	$i++;
}
$str.="</ul>";
if($vala){
	$vala=substr($vala,0,strlen($vala)-1);
}
$str="<span style='display:none'>$vala</span>".$str;

	$start_page	=	1;
	$end_page	=	10;
	$first_page	=	0;
	$last_page	=	0;
	
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
	$test="";
	if($result['countpage']>0){
		$test.="<a class='upPage' onclick='get_img_list(\"img_select3\",\"2\",\"img_list3\",".$result['prepage'].")' href='javascript:;'>上一页</a>";
		if($first_page==1){
			$test.="<a onclick='get_img_list(\"img_select3\",\"2\",\"img_list3\",1)' href='javascript:;' >1</a><span>...</span>";
		}
		for($i=$start_page;$i<=$end_page;$i++){
			if($i==$result['page']){
				$test.="<a class='num now' onclick='get_img_list(\"img_select3\",\"2\",\"img_list3\",".$i.")' href='javascript:;' >".$i."</a>";
			}else{
				$test.="<a class='num' onclick='get_img_list(\"img_select3\",\"2\",\"img_list3\",".$i.")' href='javascript:;' >".$i."</a>";
			}
		}
		if($last_page==1){
			$test.="<span>...</span><a onclick='get_img_list(\"img_select3\",\"2\",\"img_list3\",".$result['page'].")' href='javascript:;' >{echo:". $result['countpage'].";/}</a>";
		}
		$test.="<a class='nextPage' onclick='get_img_list(\"img_select3\",\"2\",\"img_list3\",".$result['nextpage'].")' href='javascript:;' >下一页</a>";
	}
$str.="<div class='clear'></div><div class='pagenav clearfix' style='margin:10px 0'>".$test."</div>";
echo $str;

?>