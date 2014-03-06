app.controller("rootC", function (dataChannel,$scope,flashTip,userInfo,$history,$location,$pop,AJAX,$rootScope,notification) {

//    $rootScope.linkTo=function(str){
//        $location.url(str);
//    }
    $rootScope.$on("$routeChangeError",function(event,current,previous,rejection){

        if(rejection=="notlogin"){
            setTimeout(function(){window.location.replace('#!/login403');},500)
        }
        if(rejection=="needaShop"){
            setTimeout(function(){window.location.replace('#!/shop412');},500)
        }
    })

    $scope.closepop=function(){
        $pop.close();
    }


    $rootScope.openPanel=function(){
        $.mobile.activePage.find(".myPanel").panel("toggle");
    }

    $rootScope.fav=function(target,idnum){
        var pram={};
        if(target=="s"){
            pram.shopid=idnum;
        }else{
            pram.goodid=idnum;
        }


        AJAX({
            url:appConfig.addFav,
            p:pram,
            sCall:function(d){
                if(d.status=="ok"){
                    flashTip.show(d.result,1000,{
                        width:'50%',
                        height:'8em',
                        color:'white'
                    });
                }
            }
        })
    }

    $rootScope.logobaseURL=appConfig.logobaseURL;


    $scope.$on("appLive", function(event, message){
        try{
            if(message && message.newChatMsg){
                $('.newMsg .ui-li-count').text(message.newChatMsg).addClass("blueSurroundShadow");
                if(message.newChatMsg>0){
                    $.mobile.activePage.addClass("panelShadow");

                    /*震动*/
                    notification.vibrate(500);
                }else{
                    $.mobile.activePage.removeClass("panelShadow");
                }

            }
        }catch(e){}


    });



});
