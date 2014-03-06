app.controller('uploadmoreCtrl', function($scope,$pop,$element,AJAX,$waitDialog,$timeout,localStorageService,$window,$routeParams) {
    $scope.moreimgChange=function(){
        var target=$("#moreimgInput")[0];
        getimageDataURL(target,function(o){
            localStorageService.add("moregoodPic",o);
            $(".imgContainer img")[0].src= o.code;

            if(o.size>=300000){
                $scope.$apply(function(){
                    $scope.dataUsageWarning= Math.ceil(o.size/1000);
                })
            }

        })
    }

    $scope.upload=function(){
        var goodid=$routeParams.goodid;
        var imgObj=localStorageService.get("moregoodPic");

        var btn=$($element).find('form :submit');
        var changeBtn=function(text,bol){
            $scope.subBtn={isOff:bol,submitText:text};
            btn.trigger('create');
        };

        if(goodid && goodid>=0 && typeof(imgObj)=="object" && typeof(imgObj.code)!="undefined"){
            AJAX({
                url: appConfig.goodmorePicURL,
                method:"POST",
                p: {
                    goodsid:goodid,
                    img:imgObj
                },
                bCall:function(){
                    $waitDialog.show("正在上传...");
                    changeBtn("正在上传",false);
                },
                sCall: function (d) {
                    if(d && d.status=="ok"){
                        $pop.open('提交成功');
                        $timeout(function(){
                            localStorageService.remove("moregoodPic");
                            $window.history.back();
                        },500);
                    }else{
                        $pop.open(d.result);
                    }
                },
                eCall: function () {
                    $pop.open("长传失败，网络问题");
                    changeBtn("上传",true);
                },
                cCall:function(){
                    $waitDialog.hide();
                    changeBtn("上传",true);
                }
            });
        }
    }

});