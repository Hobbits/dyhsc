app.factory('fetchShopInfo', function(AJAX,$waitDialog){
    return function(shopid,callback){
        AJAX(
            {
                url:appConfig.shop_get,
                p:{'shopid':shopid},
                bCall:function(){
//                    $waitDialog.show("正在获取店铺信息...");
                },
                sCall:function(d){
                        if(typeof(callback)=="function"){callback(d);}
                },
                cCall:function(){
//                    $waitDialog.hide();
                }
            }
        );
    }
})

app.factory('myshopInfo', function(localStorageService,fetchShopInfo,userInfo,$q){
    return {
        refresh:function(callback){
                /*获取已经存在服务器上的店铺信息*/
                fetchShopInfo(userInfo.get().userid,function(d){
                    if(d.status=="ok"){
                        localStorageService.add('shop_info', d.result);
                    }
                    if(typeof(callback)=="function"){callback(d);}
                })
            },
        set:function(o){
            localStorageService.add('shop_info',o);
        },
        get:function(str){

            var myshopInfo = localStorageService.get('shop_info');
            if(myshopInfo && myshopInfo['shop_id']>0){
                if(str){
                    return myshopInfo[str];
                }else{
                    return myshopInfo;
                }
            }else{
                this.refresh(function(data){
                    if(data.status=="ok"){
                        myshopInfo = localStorageService.get('shop_info');
                        if(str){
                            return myshopInfo[str];
                        }else{
                            return myshopInfo;
                        }
                    }

                });
                //return false;
            }
        },
        delete:function(){
            localStorageService.remove('shop_info');
        }
    }
});

app.factory('userInfo', function(localStorageService){
    return {
        get:function(){
            var userInfo = localStorageService.get('userInfo');
            if(userInfo && userInfo.userid>0){
                return userInfo;
            }else{
                return false;
            }
        },
        delete:function(){
            localStorageService.remove('userInfo');
        }
    }
});

app.factory('logout', function(userInfo,$http,localStorageService,$waitDialog){
    return function(path){
        try{
            var uinfo={"name":userInfo.get().username,"psw":""};
            localStorageService.add('userLogininfo',uinfo);
        }catch(e){}
        userInfo.delete();
        localStorageService.remove('shop_info');
        $http.jsonp(appConfig.logoutURL + '&callback=JSON_CALLBACK');
        if(angular.isDefined(path) && path.length>0){
            setTimeout(function(){
                window.location.replace("#!"+path);
            },200)
        }
        $waitDialog.hide();

    }


})

app.factory('dataChannel', function($rootScope){
    var sharedService={
        message:null,
        prepForBroadcast:function(msg){
            this.message=msg;
            this.broadcast();
        }
    };
    sharedService.broadcast=function(){

        $rootScope.$broadcast('appLive',this.message);

    }

    return sharedService
})



app.factory('AJAX', function($http,logout,dataChannel){
    /*url p bCall sCall eCall*/
      var send=function(o,timeout){
          var sendmethod=o.method || "JSONP";
          if(typeof(o.bCall)=="function"){o.bCall();}

          var httpPatams={}
          if(sendmethod=="JSONP"){
              httpPatams.url= o.url;
              httpPatams.method =sendmethod;
              httpPatams.params=o.p || {};
              httpPatams.params.callback='JSON_CALLBACK';
          }else{
              httpPatams.url= o.url;
              httpPatams.method =sendmethod;
              httpPatams.data=o.p || null;
          }
              httpPatams.timeout=timeout || 15000;
              $http(httpPatams).success(function(data, status, headers, config){

                      if(angular.isDefined(data) && angular.isDefined(data.status) && data.status=="401"){
                          logout('/login401');
                          return false;
                      }

                      if(typeof(o.sCall)=="function"){
                            o.sCall(data,status, headers, config);
                          };
                      if(typeof(o.cCall)=="function"){
                          o.cCall(data,status, headers, config);
                      };

                      /*处理附带信息*/
                      try{
                          if(angular.isDefined(data.status) && data.status=="ok"){
                              if(angular.isDefined(data.addon) && data.addon.records_num>0){
                                  dataChannel.prepForBroadcast({'newChatMsg':data.addon.records_num});
                              }
                          }
                      }catch(e){}




                  }).error(function(data,status, headers, config){
                      if(typeof(o.eCall)=="function"){
                        o.eCall(data,status, headers, config);
                      };
                      if(typeof(o.cCall)=="function"){
                          o.cCall(data,status, headers, config);
                      };
                  });

      };
        return send;
});


app.factory('Obj2Arr', function(){
    return function(o,name1,name2){
        if(typeof(o)=="object" && typeof(name1)=="string" && typeof(name2)=="string"){
             var arr=[];
            for(i in o){
                var thiso={};
                thiso[name1]=i;
                thiso[name2]=o[i];
                arr.push(thiso);
            }
            return arr;
        }
    };
});


app.factory('$pop', function($window){
    return {
         target:$("#popup"),
        targettext:$("#poptext"),
        open:function(str){

            this.targettext.html(str);
            this.target.show();
            this.target.popup();
            this.target.trigger("create");
            this.target.popup("open");
        },
        close:function(){
            this.target.popup("close");
            this.target.hide();
        }
    }


});


function getimageBinaryString(input,callback) {

    if (input.files && input.files[0]) {
        var f=input.files[0];
        if (!f.type.match('image.*')) {
            return null;
        }
        var reader = new FileReader();
        reader.onload = function (e) {
            //the only jQuery line.  All else is the File API.
            var imagecode=e.target.result;
            if(typeof(callback)=="function"){
                callback({
                    code:imagecode,
                    type: f.type,
                    name: f.name,
                    size: f.size
                });
            }
        }
        reader.readAsBinaryString(f);
    }
}

function getimageDataURL(input,callback) {
    if (input.files && input.files[0]) {
        var f=input.files[0];
        if (!f.type.match('image.*')) {
            return null;
        }
        var reader = new FileReader();
        reader.onload = function (e) {
            var imagecode=e.target.result;
            if(typeof(callback)=="function"){
                callback({
                    code:imagecode,
                    imageType: f.type,
                    name: f.name,
                    size: f.size
                });
            }
        }
        reader.readAsDataURL(f);
    }

}


app.factory('textStatus', function(){
    return function(s,text){
        if(s=="wait"){return {textboxClass:"textbox-warning",text:text}}
        if(s=="ok"){return {textboxClass:"textbox-info",text:text}}
        if(s=="error"){return {textboxClass:"textbox-error",text:text}}
    };
});

app.factory('flashTip',function(){
    var o={
        idName:'flashTip',
        targeto:null,
        resize:function(){
            var target=$('#'+this.idName);
            if(target.length<=0) return;
            target.css({
                'margin-top':target.height()/2*(-1)+"px",
                'margin-left':target.width()/2*(-1)+"px"
            });
            console.log("resize");
        },
        hide:function(){
            $("#"+this.idName).remove();
        },
        show:function(innerHTML,hideDelay,styleJqO){
                var that=this;
                var styleJqO=styleJqO || {};
                if(!document.getElementById(that.idName)){
                    that.targeto=$("<div/>").attr({'id':that.idName,'class':'flexbox-center'}).css(styleJqO).html(innerHTML);
                    that.targeto.appendTo(".my");
                }else{
                    that.targeto=$("#"+that.idName);
                    that.targeto.css(styleJqO).html(innerHTML);
                }
                that.resize();

            if(hideDelay){
                setTimeout(function(){
                    that.hide();
                },hideDelay);
            }

        }
    }
    return o;
})
