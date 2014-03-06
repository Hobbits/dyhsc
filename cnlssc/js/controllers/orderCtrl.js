app.controller("orderCtrl", function ($scope,AJAX,$routeParams,$location,$waitDialog,$pop) {

    $scope.orderInfo = {};
    $scope.unChange = {};
    $scope.orderDetail = {};

    $scope.getGoodid=function(){
        return $routeParams.goodid;
    }
    $scope.getStep=function(){
        return $routeParams.step;
    }

    $scope.step2get=function(){
        $scope.getPayid=function(){
            return $routeParams.payid;
        }
        AJAX({
            url : appConfig.orderDetailURL, 
            p : {'payid' : $scope.getPayid()},
            bCall : function(){
                $waitDialog.show("正在获取订单信息...");
            },
            sCall : function(d){
                if(d.status == "ok"){
                    var r = d.result;
                    $scope.orderDetail.goods_name = r.goods_name;
                    $scope.orderDetail.order_num = r.order_num;
                    $scope.orderDetail.goods_price = r.goods_price;
                    $scope.orderDetail.transport_price = r.transport_price;
                    $scope.orderDetail.order_amount = r.order_amount;
                    $scope.orderDetail.consignee = r.consignee;
                    $scope.orderDetail.mobile = r.mobile;
                    $scope.orderDetail.address = r.address;
                    $scope.orderDetail.goodaddress = r.goodaddress;
                    $scope.orderDetail.payid = $scope.getPayid();
                    $scope.orderDetail.alipayOn = r.alipayOn;


                } else {
                    $pop.open(d.result);
                }
            },
            cCall : function(){
                $waitDialog.hide();
            }
        });


    }


    $scope.goNextstep=function(o){
        var oi=$scope.orderInfo;
        AJAX({
            url:appConfig.orderInfoURL,
            p: {
                "order_num" : oi.order_num,
                "goods_id":$scope.getGoodid(),
                "consignee" : oi.consignee,
                "mobile" : oi.mobile,
                "address" : oi.address,
                "message":oi.usernote
            },
            sCall:function(d){
                if(d.status=="ok"){
                    var payid=d.result;
                    $location.path("/order/"+payid+"/2");
                }else {
                    $pop.open(d.result);
                }
            }
        })


   
    }

    $scope.prefill=function(){
        AJAX({
            url : appConfig.goodInfoURL,
            p : {'goodsid': $scope.getGoodid()},
            bCall : function(){
                $waitDialog.show("正在获取信息...");
            },
            sCall : function(d){
                if(d.status == "ok"){
                    var r = d.result;
                    $scope.unChange.goods_name = r.name;
                    $scope.unChange.goods_price = r.price;
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
