app.controller("chatlistCtrl", function ($scope,AJAX,$waitDialog,userInfo,$pop,flashTip) {

$scope.logoURL = appConfig.logobaseURL;

$scope.getTalkedFriends = function(){
    AJAX({
        bCall : function(){
            $waitDialog.show("正在获取好友列表...");
        },
        url : appConfig.charlistURL,
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


$scope.deleteChatRecord=function(userid_chat){
    AJAX({
        url:appConfig.deleteChatRecordURL,
        p:{"friendid" : userid_chat},
        sCall:function(d){
            if(d.status=="ok"){
                flashTip.show("删除成功",1000,{
                    height:'5em',
                    width:'7em',
                    'max-width':'50%',
                    color:'white'
                });
                $scope.friendList= d.result;
            }else{
                $pop.open(d.result);
            }
        }
    })
}


$scope.hasNewMessage = function(newMessage_num){
    if(newMessage_num <= 0){
        return false;
    } else {
        return true;
    }
}

})
