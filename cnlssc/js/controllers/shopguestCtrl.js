app.controller("shopGuestview", function ($scope,$routeParams,AJAX,fetchShopInfo,$pop,myshopInfo,$waitDialog) {

    var setshopid=function(){
        $scope.thisShopid=$routeParams.shopid;
    }

    $scope.getshopInfo=function(){
        setshopid();
        fetchShopInfo($scope.thisShopid,function(d){
            if(d.status=="ok"){
                $scope.thisShopinfo=d.result;
            }else{
                $pop.open(d.result);
            }
        });

    }

    $scope.getshopGoods=function(){
        setshopid();
//        $scope.thisShopname=$routeParams.shopname;
            AJAX({
                bCall:function(){
                    $waitDialog.show("正在同步列表...");
                },
                url: appConfig.goodListURL,
                p:{'shopid':$scope.thisShopid},
                sCall: function (d) {
                    if(d.status=="ok"){
                        var data= d.result;
                        $scope.goodList= data.goodslist;
                        $scope.thisShopname=data.shopname;
                    }else{
                        $pop.open(d.result);
                    }

                },
                cCall:function(){$waitDialog.hide();}
            })


    };



})