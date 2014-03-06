function changeMenu(){
	var allElements = document.getElementsByTagName('div');
	for(i=0;i<allElements.length;i++){
		if(allElements[i].className == 'menu_title'){
			allElements[i].onclick = changeStyle;
		}
	}
}
function changeStyle(){
	if (window.navigator.userAgent.indexOf("MSIE")>=0 ){
		var element = this.nextSibling;
	}else{
		var element = this.nextSibling.nextSibling;
	}
	var childElements = this.getElementsByTagName('span');
	for(i=0;i<childElements.length;i++){
		childElements[i].className = (childElements[i].className == 'put')?'put2':'put';
	}
	element.style.display = (element.style.display == 'none')?'block':'none';
}
window.onload = changeMenu;