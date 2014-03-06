var $ = function (id) {
	return "string" == typeof id ? document.getElementById(id) : id;
}
function promote_change(obj) {
	var parent_node = obj.parentNode;
	var elements = parent_node.children;
	for(var i=0; i<elements.length; i++) {
		elements[i].className = '';
	}
	obj.className = "selected";
}
function nTabs(tabObj,obj){
	var tabList = $(tabObj).getElementsByTagName('li');
	for(i=0;i<tabList.length;i++){
	   if(tabList[i].id == obj.id)
	   {
		    $(tabObj+"_title"+i).className = "active"; 
		    $(tabObj+"_content"+i).style.display = "";
	   }else{
	   		$(tabObj+"_title"+i).className = ""; 
			$(tabObj+"_content"+i).style.display = "none";
	   }
	} 
}
function changeMenu(){
	var allElements = document.getElementsByTagName('ul');
	for(i=0;i<allElements.length;i++){
		if(allElements[i].className == 'mainnav'){
			var childElements = allElements[i].getElementsByTagName('li');
			for(var j=0;j<childElements.length;j++){
				childElements[0].style.left= -3 + 'px';
				childElements[j].onclick = changeStyle;
			}
		}
	}
}
function changeStyle(){
	var tagList = this.parentNode;
	var tagOptions = tagList.getElementsByTagName("li");
	for(i=0;i<tagOptions.length;i++){
		if(tagOptions[i].className.indexOf('active')>=0){
			tagOptions[i].className = '';
		}
	}
	this.className = 'active';
}
function changeStyle2(classname,obj){
	  var tagList = obj.parentNode;
	  var tagOptions = tagList.getElementsByTagName('a');
	  for(i=0;i<tagOptions.length;i++){
		//  if(tagOptions[i].className.indexOf('selected')>=0){
			  tagOptions[i].className = "";
		  //}
	  }
	  obj.className = 'selected';
	  var list = document.getElementById('listItems');
	  if(classname=='list'){
		  list.className = '';
			document.getElementById("listItems").style.display="block";
			document.getElementById("windowItems").style.display="none";
			document.cookie="goodsListClass=listItems";
	  }else{
			
			document.getElementById("listItems").style.display="none";
			document.getElementById("windowItems").style.display="block";
			document.cookie="goodsListClass=windowItems";
	  }
}



function hidden(){
	if($('category')){
		$('category').onmouseover = function (){
			$('category_box').style.display = "block";
		}
		$('category').onmouseout = function (){
			$('category_box').style.display = "none";
		}
	}
}
//显示容器内容
	function show_obj(obj){
		$(obj).style.display='';
	}

//隐藏容器内容
	function hidden_obj(obj){
		$(obj).style.display='none';
	}
//显示、隐藏样式
function show(obj){
	$(obj).style.display = ($(obj).style.display == 'none')?'block':'none'
}

function setHidden(obj){
	if($(obj+'_c').value=='') {
		$(obj).style.display='none'; 
	}
}
function setShow(obj){
	$(obj).style.display = ($(obj).style.display == 'none')?'block':'none'
	readyBlur(obj);
}
function readyBlur(obj){
	$(obj+'_c').focus();
}

var timeout;
function setOnShowPara(obj){
	$(obj+'_c').value='1';
	clearTimeout(timeout);
}
function setHiddenPara(obj){
	$(obj+'_c').value=''; 
}
	
function timerSetHidden(obj,t_time){
	setHiddenPara(obj);
	timeout = setTimeout("setHidden('"+obj+"')",t_time);
}
function inputTxt(obj,act){
	var str="请输入你要搜索的关键字";
	if(obj.value==''&&act=='set')
	{
		obj.value=str;
		obj.style.color="#cccccc"
	}
	if(obj.value==str&&act=='clean')
	{
		obj.value='';
		obj.style.color="#000000"
	}
}

window.onload = changeMenu;
window.onload = hidden;

function addLoadEvent(func){
	var oldonload=window.onload;
	if(typeof window.onload!="function"){window.onload=func;}else{window.onload=function(){oldonload();func();}};
}
addLoadEvent(changeMenu);
addLoadEvent(hidden);

