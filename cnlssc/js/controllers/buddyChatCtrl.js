app.controller("buddyChatCtrl", function ($scope,AJAX,$waitDialog,userInfo,$pop,$location,flashTip) {

$scope.logoURL = appConfig.logobaseURL;


$scope.getFriends = function(){
    AJAX({
        bCall : function(){
            $waitDialog.show("正在获取好友列表...");
        },
        url : appConfig.friendslistURL,
        sCall : function(d){
            if(d.status == "ok"){
                var r = d.result;
                $scope.friendList = r;
            } else {
                $pop.open(d.result);
            }
        },
        cCall : function(){
            $waitDialog.hide();
        }
        
    })


}


  
$scope.hasNewsInformation = function(num){
    if(num <= 0) {
        return false;
    } else {
        return true;
    }
}


var logMessage = null;
$scope.openMenu=function(userid){
    logMessage=userid;
    $("#moreActions").popup('open',{
        positionTo : "origin",
        transition :'pop'
    });
}



//删除好友
$scope.deleteFriend = function(){
    if(logMessage){
        AJAX({
            url : appConfig.deleteFriendURL,
            p : {'friendid' :logMessage},
            sCall:function(d){
                $("#moreActions").popup('close');
                if(d.status == "ok"){
                    $scope.friendList = d.result;
                    setTimeout(function(){
                        flashTip.show("删除成功",1000,{
                            width:'50%',
                            height:'8em',
                            color:'white'
                        });
                    }, 1000);
                } else {
                    setTimeout(function(){
                        flashTip.show(d.result ,1000,{
                                width:'50%',
                                height:'8em',
                                color:'white'
                        });
                    }, 1000);
                }
            }
        });
        logMessage=null;
    }
}






//好友店铺
$scope.watchFriendShop = function(){
    $location.path("/shopGuest/" + logMessage + "/info");
    
}

//聊天记录
$scope.getDialogue = function(){
    $location.path("/dialogue/"+ logMessage);
}


})







