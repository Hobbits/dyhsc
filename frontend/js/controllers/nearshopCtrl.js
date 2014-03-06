app.controller("nearshopCtrl", function ($scope,geo,$waitDialog,textStatus,AJAX,userInfo) {
    $scope.noResult=false;
    $scope.searchRange=5;

    $scope.userpos=textStatus("wait","geo服务待命中");
    $scope.logobaseURL=appConfig.logobaseURL;


    var refreshGeo=function(){
        $scope.userpos=textStatus("wait","geo启动中...");

        var refreshList=function(coords){
            AJAX({
                url:appConfig.nearShop,
                p:{
                    userid:userInfo.get().userid,
                    longitude:coords.longitude,
                    latitude:coords.latitude,
                    distance:$scope.searchRange
                },
                bCall:function(){

                },
                sCall:function(data){
                    if(data.status="ok"){
                        if(data.result.length>0){
                            $scope.nearList=data.result;
                        }else{
                            $scope.noResult=true;
                        }
                    }

                }
            })
        }


        var ongeoSuccess=function(data){
            var coords=data.coords;

            refreshList(coords);

            geo.getGeocoding(coords,function(result){
                if(angular.isDefined(result.formatted_address)){
                    $scope.userpos=textStatus("ok",result.formatted_address);
                }else{
                    $scope.userpos=textStatus("error",'未知地点');
                }
            })
        };
        var ongeoError=function(err){
            var msg=err.message || '获取座标失败';
            $scope.userpos=textStatus("error",msg);
        };

        geo.get(ongeoSuccess,ongeoError);
    }

    $scope.preget=function(){
        refreshGeo();
    }

})