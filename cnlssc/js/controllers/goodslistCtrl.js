app.controller("goodslistCtrl", function ($scope,AJAX,$location,userInfo,myshopInfo,$pop,$waitDialog) {
    $scope.logobaseURL=appConfig.logobaseURL;


    $scope.preget=function(){

        var shopid=myshopInfo.get("shop_id");
        if(shopid){
            AJAX({
                bCall:function(){
                    $waitDialog.show("正在同步列表...");
                },
                url: appConfig.goodListURL,
                p:{'shopid':shopid},
                sCall: function (d) {
                    if(d.status=="ok"){
                        var data= d.result.goodslist;
                        if(!data.goods_thumb){
                            $scope.default_thumb=myshopInfo.get("shop_logo");
                        }

                        $scope.goodList= data;
                    }else{
                        $pop.open(d.result);
                    }

                },
                cCall:function(){$waitDialog.hide();}
            })
        }else{
            $location.path("/shop412");
        }


    }

})
