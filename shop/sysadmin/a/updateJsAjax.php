<?php
/**
 * 此文件是更新操作ajax的js文件，中间要进行php代码嵌套,因此放到php文件中进行编辑,并未形成js文件，并在相应的页面上进行引用
 */
?>
<script language="JavaScript" src="../servtools/ajax_client/ajax.js"></script>
<script type="text/javascript">
function ltrim(str){ //删除左边的空格   
	 return str.replace(/(^\s*)/g,"");   
}
//text
function edit(obj,id,inputname,url,param,size){
	var uright=document.getElementById("update_right");
	var div1=obj.nextSibling;
	if(div1.nodeType!=1){
      div1=div1.nextSibling;
	}
	if(uright!='0'){
	obj.style.display="none";
     var spanvalue=obj.innerHTML;
     var spaninput="<input type=text id='"+inputname+"' onblur=\"editpost(this,'"+id+"','"+url+"','"+param+"');\" size="+size+" maxlength='100' value='"+spanvalue+"' />";
     div1.innerHTML=spaninput;
     div1.style.display="block";
     
     document.getElementById(inputname).focus();
  }else{
	    ShowMessageBox("<?php echo $a_langpackage->a_privilege_mess;?>",'m.php?app=error');
		// location.href="m.php?app=error";
	}
}
function edit1(obj,id,inputname,url,param,size,name){
	var uright=document.getElementById("update_right");
	var div1=obj.nextSibling;
	if(div1.nodeType!=1){
      div1=div1.nextSibling;
	}
	if(uright!='0'){
	obj.style.display="none";
     var spanvalue=obj.innerHTML;
     var spaninput="<input type=text id='"+inputname+"' onblur=\"editpost1(this,'"+id+"','"+url+"','"+param+"','"+name+"');\" size="+size+" maxlength='100' value='"+spanvalue+"' />";
     div1.innerHTML=spaninput;
     div1.style.display="block";
     
     document.getElementById(inputname).focus();
  }else{
	    ShowMessageBox("<?php echo $a_langpackage->a_privilege_mess;?>",'m.php?app=error');
		// location.href="m.php?app=error";
	}
}
function editpost1(obj,id,url,param,name){
	var div1=obj.parentNode;
	var span1=div1.previousSibling;
	if(span1.nodeType!=1){
		span1=span1.previousSibling;
	}
	if(obj.value==span1.innerHTML){
      div1.style.display="none";
      span1.style.display="block";
	}else{
		if(obj.value!=""){
			ajax(url,"POST",param+obj.value,function(data){
		           if(data==1){
		          	 div1.style.display="none";
		          	 span1.innerHTML=obj.value;
		               span1.style.display="block";
		           }else{
		          	 ShowMessageBox("<?php echo $a_langpackage->a_update_fail;?>",'1');
		          	   div1.style.display="none";
		               span1.style.display="block";
		               }
		      });
		}
	}
	
}
function editpost(obj,id,url,param){
	var div1=obj.parentNode;
	var span1=div1.previousSibling;
	if(span1.nodeType!=1){
		span1=span1.previousSibling;
	}
	if(obj.value==span1.innerHTML){
      div1.style.display="none";
      span1.style.display="block";
	}else{
      ajax(url,"POST",param+obj.value,function(data){
           if(data==1){
          	 div1.style.display="none";
          	 span1.innerHTML=obj.value;
               span1.style.display="block";
           }else{
          	 ShowMessageBox("<?php echo $a_langpackage->a_update_fail;?>",'1');
          	   div1.style.display="none";
               span1.style.display="block";
               }
      });
	}
	
}

//带有数字验证
function editnum(obj,id,inputname,url,param,size){
	var uright=document.getElementById("update_right");
	var div1=obj.nextSibling;
	if(div1.nodeType!=1){
      div1=div1.nextSibling;
	}
	if(uright!='0'){
	obj.style.display="none";
     var spanvalue=obj.innerHTML;
     var spaninput="<input type=text id='"+inputname+"' onblur=\"editpost(this,'"+id+"','"+url+"','"+param+"');\" "+
                   "size="+size+" maxlength='100' value='"+spanvalue+"' onkeypress='return regInput(this,/^[0-9]*$/,String.fromCharCode(event.keyCode))'"+
                   " onpaste= \"return regInput(this,\/^[0-9]*$/,\window.clipboardData.getData('Text'))\" ondrop= \"return regInput(this,/^[0-9]*$/,event.dataTransfer.getData('Text'))\" "+
                   " style=\"ime-mode:Disabled\" />";
     div1.innerHTML=spaninput;
     div1.style.display="block";
     
     document.getElementById(inputname).focus();
  }else{
	    ShowMessageBox("<?php echo $a_langpackage->a_privilege_mess;?>",'m.php?app=error');
	}
}
//验证函数
function regInput(obj, reg, inputStr) {
    var docSel = document.selection.createRange()
    if (docSel.parentElement().tagName != "INPUT") return false
    oSel = docSel.duplicate()
    oSel.text = ""
    var srcRange = obj.createTextRange()
    oSel.setEndPoint("StartToStart", srcRange)
    var str = oSel.text + inputStr + srcRange.text.substr(oSel.text.length)
    return reg.test(str)
}



//下拉框
function editselect(obj,id,inputname,url,param,size){
	var uright=document.getElementById("update_right");
	var sid=document.getElementById("selectid"+id);
	var div1=obj.nextSibling;
	if(div1.nodeType!=1){
  div1=div1.nextSibling;
	}
	if(uright!='0'){
	obj.style.display="none";
 var spanvalue=obj.innerHTML;
 var spaninput="<select id='"+inputname+"' name='"+inputname+"' onblur=\"editselectpost(this,'"+id+"','"+url+"','"+param+"');\"><?php if(isset($selecttype)){ foreach ($selecttype as $key=>$val){ ?><option value='<?php echo $key;?>'><?php echo $val?></option><?php }} ?></select>";
 div1.innerHTML=spaninput;
 div1.style.display="block";
 
 document.getElementById(inputname).value=sid.value;
 document.getElementById(inputname).focus();
}else{
	    alert("<?php echo $a_langpackage->a_privilege_mess;?>");
		location.href="m.php?app=error";
	}
}
function editselectpost(obj,id,url,param){
	var div1=obj.parentNode;
	var span1=div1.previousSibling;
	if(span1.nodeType!=1){
		span1=span1.previousSibling;
	}
	if(obj.value==span1.innerHTML){
  div1.style.display="none";
  span1.style.display="block";
	}else{
  ajax(url,"POST",param+obj.value,function(data){
       if(data==1){
      	 div1.style.display="none";
      	 span1.innerHTML=obj.options[obj.selectedIndex].text;
       	document.getElementById("selectid"+id).value=obj.value;
         span1.style.display="block";
          // alert(data);
       }else{
      	 alert("<?php echo $a_langpackage->a_update_fail;?>");
      	   div1.style.display="none";
           span1.style.display="block";
          // alert(data);
           }
  });
	}
	
}

//下拉框2 sysadmin/m/asd/list.php文件中用此函数
function editselect2(obj,id,inputname,url,param,size){
	var uright=document.getElementById("update_right");
	var sid=document.getElementById("selectid2"+id);
	var div1=obj.nextSibling;
	if(div1.nodeType!=1){
  div1=div1.nextSibling;
	}
	if(uright!='0'){
	obj.style.display="none";
 var spanvalue=obj.innerHTML;
 var spaninput="<select id='"+inputname+"' name='"+inputname+"' onblur=\"editselectpost2(this,'"+id+"','"+url+"','"+param+"');\"><?php if(isset($type)){ foreach ($type as $key=>$val){ ?><option value='<?php echo $key;?>'><?php echo $val?></option><?php } }?></select>";
 div1.innerHTML=spaninput;
 div1.style.display="block";
 
 document.getElementById(inputname).value=sid.value;
 document.getElementById(inputname).focus();
}else{
	    alert("<?php echo $a_langpackage->a_privilege_mess;?>");
		location.href="m.php?app=error";
	}
}
////下拉框2回调函数
function editselectpost2(obj,id,url,param){
	var div1=obj.parentNode;
	var span1=div1.previousSibling;
	if(span1.nodeType!=1){
		span1=span1.previousSibling;
	}
	if(obj.value==span1.innerHTML){
  div1.style.display="none";
  span1.style.display="block";
	}else{
  ajax(url,"POST",param+obj.value,function(data){
       if(data==1){
      	 div1.style.display="none";
      	 span1.innerHTML=obj.options[obj.selectedIndex].text;
       	document.getElementById("selectid2"+id).value=obj.value;
         span1.style.display="block";
          // alert(data);
       }else{
      	 alert("<?php echo $a_langpackage->a_update_fail;?>");
      	   div1.style.display="none";
           span1.style.display="block";
          // alert(data);
           }
  });
	}
	
}

</script>