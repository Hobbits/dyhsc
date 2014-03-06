app.controller("dialogueCtrl", function ($scope,AJAX,$routeParams,$pop,userInfo,$window,$waitDialog) {
    $scope.cansendClass=function(){
        if($scope.chatTexting){
            return "canSend";
        }else{
            return "";
        }
    };
    $scope.Loadmore={
        show:false,
        last:1,
        loading:false
    }



    var senderID=userInfo.get().userid;
    var opposite_userid=$routeParams.targetid;
    $scope.opposite_name=$routeParams.targetName;

    $scope.dialogueList=[];
    $scope.cssInner=null;



    var fetchHistory=function(lastnum,okfunction){
        AJAX({
            url:appConfig.dialog_prefetch,
            p:{toid:opposite_userid,last:lastnum},
            sCall:function(d){
                if(d.status=="ok"){
                    if(angular.isDefined(d.addon)){
                        if(!$scope.cssInner){
                            var oppositeImg=appConfig.logobaseURL+d.addon.toidicon;
                            var meImg=appConfig.logobaseURL+d.addon.fromidicon;
                            $scope.cssInner='.opposite .gavInner{background-image: url('+oppositeImg+')}'
                                +'.me .gavInner{background-image: url('+meImg+')}';
                        }
                    }
                    if(angular.isArray(d.result)){
                        okfunction(d.result);
                    }
                }else{
                    $pop.open("与服务器的通讯错误");
                }
            }
        });
    }

    $scope.prefetch=function(){
        fetchHistory(1,function(result){
            handleSendcallback(result);
            if(result.length>=9){
                $scope.Loadmore.show=true;
            }
            $scope.Loadmore.last++;
        });
        $scope.periodicityGetunread=$window.setInterval(dialog_fetchUnread,appConfig.default.chatPollingcycle);
    }

    $scope.out=function(){
        if(angular.isDefined($scope.periodicityGetunread)){
            $window.clearInterval($scope.periodicityGetunread);
        }
    }

    $scope.loadHistoryAct=function(){
        $scope.Loadmore.loading=true;

        fetchHistory($scope.Loadmore.last,function(result){
            handleSendcallback(result,"top");

                $scope.Loadmore.last++;
                $scope.Loadmore.show=true;
                $scope.Loadmore.loading=false;

            $scope.Loadmore.loading=false;
        });
    }


    var resetDialog=function(dir){
        if(dir=="top"){
            window.scrollTo(0,0);
        }else{
            try{
                setTimeout(function(){
                    $.mobile.scrollBottom();
                },200);
            }catch(e){}
        }

    };

    var handleSendcallback=function(arr,dir){
        var distinguish=function(data){
            var o=null;
            if(data.fromid==senderID && data.toid==opposite_userid){/*来自我*/
                o=data;
                o.senderName="我";
                o.targetClassname="me";

            }else if(data.fromid==opposite_userid && data.toid==senderID){/*来自对方*/
                o=data;
                o.senderName= $scope.opposite_name || o.fromidname;
                o.targetClassname="opposite";

            }
            return o;
        }

        var newArr=[];
        angular.forEach(arr, function(value, key){
            var thiso=distinguish(value);
            if(thiso){
                newArr.push(thiso);
            }

        });
        if(dir=="top"){  /*此仅为增加效率*/
            $scope.dialogueList=newArr.concat($scope.dialogueList);
        }else{
            $scope.dialogueList=$scope.dialogueList.concat(newArr);
        }
        resetDialog(dir);
    }

    var dialog_fetchUnread=function(){
        AJAX({
            url:appConfig.dialog_fetchUnreadURL,
            p:{
                opposite_userid:opposite_userid,
                selfID:senderID
            },
            sCall:function(d){
                if(d.status=="ok"){
                    if(angular.isArray(d.result)){
                        handleSendcallback(d.result);
                    }

                }
            }

        })
    }

    $scope.send=function(){
        var message=$scope.chatTexting;
        if(!message){return;}

        AJAX({
            url:appConfig.dialogueURL,
            p:{
                toid:opposite_userid,
                message:message
            },
            sCall:function(d){
                if(d.status=="ok"){
                    dialog_fetchUnread();
                    handleSendcallback([d.result]);
                    $scope.chatTexting=null;
                }else{
                   $pop.open(d.result);
                }
            }

        })

    }

    $scope.clearScreen=function(){
        $scope.dialogueList=[];
        $scope.Loadmore={
            show:true,
            last:1,
            loading:false
        }
    }

})
