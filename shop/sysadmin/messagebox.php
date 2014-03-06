<style>
#bg_div { background-color:#333; position:absolute; width:100%; left:0; top:0; opacity:0.4; filter:alpha(opacity=40); height:1313px; z-index:960}
#messagebox_div { width:370px; z-index:961; margin:0 auto; position:absolute;filter:alpha(opacity=95); left:25%; top:15%; background-color:#fff; height:180px;
text-align:center;padding:20px;}
.messagebox_title { margin-bottom:15px;background:#FFE1C2; color:#F67A06; padding-left:10px; line-height:25px; font-weight:bold; font-size:14px;}
.messagebox_title span {float:right; padding-right:5px; cursor:pointer;}
.btn {
background:url("../sysadmin/skin/images/buttonbg.gif") repeat-x 0 0 #F60 ;
border:none;
color:#FFFFFF;
cursor:pointer;
font-weight:bold;
margin-top:10px;
padding:6px ;
}
</style>
<div id="bg_div" style="display:none;"></div>
	<div id="messagebox_div" style="display:none;">
		<div class="messagebox_title">提示</div>
		<div id='msg_content'></div>
		<input id='return_url' type='hidden' value='0' />
		<input id='button_ok' class="btn"  type="button" value='确定' onclick="ClossMessageBox('-1')" />
	</div>
<script>
function ShowMessageBox(content,return_url) {
	var bg_div = document.getElementById("bg_div");
	var messagebox_div = document.getElementById("messagebox_div");
	var msg_content = document.getElementById("msg_content");
	document.getElementById("return_url").value=return_url;
	bg_div.style.display = '';
	messagebox_div.style.display = '';
	msg_content.innerHTML=content;
}

function ClossMessageBox(url) {
	var bg_div = document.getElementById("bg_div");
	var messagebox_div = document.getElementById("messagebox_div");
	var return_url = document.getElementById("return_url");
	bg_div.style.display = 'none';
	messagebox_div.style.display = 'none';
	var url=return_url.value;
	if(url=='-1'){
		history.go(-1);
	} else if(url=='0') {
		window.close();
	} else if(url=='1') {
		location.reload();
	} else {
		location.href=url;
	}
}
</script>