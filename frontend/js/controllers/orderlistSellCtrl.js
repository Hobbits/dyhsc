app.controller("orderlistSellCtrl", function ($scope,AJAX,userInfo,$waitDialog,$routeParams,$pop) {
    $scope.picURL = appConfig.logobaseURL;  
  

    $scope.prefill = function(){
        AJAX({
            url : appConfig.orderlistSell,
            p : {"userid" : userInfo.get().userid},
            bCall : function(){
                $waitDialog.show("正在获取订单列表...");
            },
            sCall : function(d){
                if(d.status == "ok"){
                    var r = d.result.sell;
                    $scope.orderlist = r;
                } else {
                    $pop.open(d.result);
                }
            },
            cCall : function(){
                $waitDialog.hide();
            }
        })
     
        
    }
    



})
