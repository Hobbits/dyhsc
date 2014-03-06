<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8" />
<title>登录入口</title>
<script type="text/javascript" src="jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="http://mat1.gtimg.com/app/openjs/openjs.js"></script>
<meta name="viewport" content="target-densitydpi=medium-dpi, width=device-width, initial-scale=1, user-scalable=no, minimum-scale=1, maximum-scale=1">
</head>
<body>

<a id="tip" onclick="login()">登录入口,请等待窗口打开</a>
<script>
var tip=$("#tip");
T.init({
    appkey: 801384522 //执行初始化,appkey为123456
});
function login() {
	T.login(function (loginStatus) { // 弹出登录窗口
	    // 本次登录成功
	    nick = loginStatus.nick;
	    openid = loginStatus.openid;
	    $.ajax({     	   
	    	url: "appdo.php?act=appregister&nick="+encodeURI(nick)+"&openid="+encodeURI(openid)+"&cat=open", 
	        success:function(data){
                tip.text("登录成功，您可以点击完成以返回...或等待跳转");
                setTimeout(function(){
                    window.location = "closewindow.html";
                },1000)

	        }       
	     });
	 
	},function (error) {
	    // 本次登录失败
        tip.text("登录失败...");
        setTimeout(function(){
            window.location = "closewindow.html";
        },1000)
	});
}
function loginout(){
	T.logout(function (loginStatus) { // 登出用户
	    // 登录成功
	    alert("登出成功");
	});
}

login();
</script>
</body>
</html>