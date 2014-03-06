<?php
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>微博登录按钮</title>
		
		<script src="http://tjs.sjs.sinajs.cn/open/api/js/wb.js?appkey=793276180" type="text/javascript" charset="utf-8"></script>
		<script type="text/javascript" src="jquery-1.3.2.min.js"></script>
		<meta name="viewport" content="target-densitydpi=medium-dpi, width=device-width, initial-scale=1, user-scalable=no, minimum-scale=1, maximum-scale=1">
	</head>
	<body>
	<header>
		<h1 class="headerTitle yahei">登录按钮使用范例</h1>
	</header>
	
		<div id="wb_connect_btn" style="width:50em;height:180px;border:1px solid #bbb;background:#eee; padding:5px 2px;">登录按钮容器</div>
		<script>

		WB2.anyWhere(function(W){
			W.widget.connectButton({
				id: "wb_connect_btn",	
				type:'3,2',
				callback : {
					login:function(o){
						name = o.screen_name;
						uid = o.id;
						
						profile = o.profile_image_url;
						$.ajax({     	   
					    	url: "appdo.php?act=appregister&name="+encodeURI(name)+"&uid="+encodeURI(uid)+"&cat=open&profile="+encodeURI(profile), 
					        complete:function(data){
				                setTimeout(function(){
				                    window.location = "closewindow.html";
				                },1000)

					        }       
					     });
					},
					logout:function(){
						alert('logout');
					}
				}
			});
		});
		</script>
	
	</body>
</html>