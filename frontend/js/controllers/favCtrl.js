app.controller("favCtrl", function ($scope,AJAX,$pop,userInfo,flashTip,$routeParams) {


    $scope.favList=[];
    $scope.isShop=function(){
        if($scope.favType=="shop"){
            return true
        }else{
            return false
        }
    }

    $scope.preGet=function(){
        $scope.favType=$routeParams.type;
        AJAX({
            url:appConfig.favList,
            p:{favorite_type:$scope.favType},
            sCall:function(d){
                if(d.status=="ok"){
                    $scope.favList= d.result;
                }else{
                    $pop.open(d.result);
                }

            }
        })
    }

    $scope.delFav=function(favID){
        AJAX({
            url:appConfig.favDel,
            p:{
                favorite_type:$scope.favType,
                favorite_id:favID
            },
            sCall:function(d){
                if(d.status=="ok"){
                    flashTip.show("删除完成",1000,{
                        height:'5em',
                        width:'7em',
                        'max-width':'50%',
                        color:'white'
                    });
                    $scope.favList= d.result;
                }else{
                    $pop.open(d.result);
                }
            }
        })
    }
})