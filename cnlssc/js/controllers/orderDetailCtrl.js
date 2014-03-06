app.controller("orderDetailCtrl", function ($scope,AJAX,$routeParams,$location,$waitDialog,userInfo,$pop) {
    
    $scope.orderDetails = {};
    $scope.picURL = appConfig.logobaseURL;  

    $scope.getpayid = function(){
        return $routeParams.payid;
    }
    
    $scope.prefill = function(){
        AJAX({
            bCall:function(){
                $waitDialog.show("正在获取订单信息...");
            },
            url : appConfig.orderDetailURL,
            p : {"payid" : $scope.getpayid()},
            sCall : function(d){
                if(d.status == "ok"){
                    var r = d.result;
                    $scope.orderDetails = r;
                    $scope.buyerid = r.buyerid;
                } else {
                    $pop.open(d.result);
                }

            },
            cCall : function(){
                $waitDialog.hide();
            }
        })
    }
    
    $scope.isSelf = function(){
        if(userInfo.get().userid == $scope.buyerid){
            return false;
        } else {
            return true;
        }
    }


})
