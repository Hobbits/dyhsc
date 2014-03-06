appConfig.getPicString=function(jqObj){
    var list=jqObj.find("img");
    var arr=[];
    list.each(function(index) {
        arr.push($(this).attr('src'));
    });
    return arr;
}

