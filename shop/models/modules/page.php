<?php
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
?>