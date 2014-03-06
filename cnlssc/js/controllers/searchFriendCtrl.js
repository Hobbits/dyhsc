app.controller("searchFriendCtrl", function ($scope,AJAX,$waitDialog,$pop,flashTip,$location) {

$scope.logoURL = appConfig.logobaseURL;

$scope.prepareSearchFriend = function(){
    
}


var searchFriendAct = function(){
    $scope.actKeyword=angular.copy($scope.searchValue);
    AJAX({
        url : appConfig.searchFriendURL,
        p : {"searchname" :$scope.actKeyword},
        bCall : function(){
            $waitDialog.show("正在搜索...");
        },
        sCall : function(d){
            if(d.status == "ok"){
                $scope.searchResult = d.result;
            } else {
                $pop.open(d.result);
            }
        },
        cCall : function(){
            $waitDialog.hide();
        }
    })
}


$scope.searchFriend = function(){
    if(!$scope.searchValue){
        return;
    } else {
        searchFriendAct();
    }
}


var logMessage=null;
$scope.openMenu=function(id){
    logMessage=id;
    $("#moreActions2").popup('open',{
        //positionTo : "origin", /*貌似不管用*/
        transition :'pop'
    });
   
}


//添加好友
$scope.addFriend = function(){
    if(logMessage){
        AJAX({
            url : appConfig.addFriendURL,
            p : {'friendid' :logMessage},
            sCall:function(d){
                $("#moreActions2").popup('close');
                if(d.status == "ok"){
                    setTimeout(function(){
                        flashTip.show(d.result,1000,{
                            width:'50%',
                            height:'8em',
                            color:'white'
                        });
                    }, 1000);
                } else {
                    $pop.open(d.result);
                }
            }
        });
        logMessage=null;
    }
    
}

//查看店铺
$scope.getBuddyShop = function(){
    $location.path("/shopGuest/" + logMessage + "/info");
}

})







