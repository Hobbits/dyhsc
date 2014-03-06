app.controller("myqrCtrl", function ($scope,textStatus,myshopInfo,AJAX,$location) {
    $scope.qrstatus=textStatus("wait","正在根据您的店铺信息生成二维码...");


    $scope.gen=function(){
        var shopid=myshopInfo.get("shop_id");
        AJAX({
            p:{shopid:shopid},
            url:appConfig.getqrCodeURL,
            sCall:function(d){
                if(d.status=="ok"){
                    var imgurl=appConfig.logobaseURL+d.result.codeurl;
                    $scope.imgsrc=imgurl;
                    $scope.downloadsrc=appConfig.logobaseURL+d.result.downloadurl;
                    $scope.qrstatus=textStatus("ok","<i class='icon-ok'></i>您可以另存为下面的二维码，用在您的产品或打印在名片上了");
                }else{
                    $scope.qrstatus=textStatus("error","<i class='icon-attention-alt'></i>错误:"+d.result);
                }
            },
            eCall:function(){
                $scope.qrstatus=textStatus("error","<i class='icon-attention-alt'></i>与服务器通信错误");
            }
        })
    }


    $scope.download=function(){
        window.open($scope.downloadsrc, '_system');
    }

    $scope.shopqrShare=function(){
//        $.mobile.activePage.find(".sharePop").popup("open");


        var targetObj=$.mobile.activePage.find('.qr');
        var picArr= appConfig.getPicString(targetObj);
         picArr.push(appConfig.logobaseURL+myshopInfo.get("shop_logo"));

        $scope.shareObj={
            sUrl:servURL+'shop.php?shopid='+myshopInfo.get("shop_id"),
            pics:picArr,
            title:myshopInfo.get("shop_name"),
            content:myshopInfo.get("shop_intro"),
            ralateUid:appConfig.api.sinaRalateUid||''
        }
        if($scope.shareObj.pics && $scope.shareObj.pics.length > 0) {
            //
        } else {
            $scope.shareObj.pics[0] = null;
        }
        window.plugins.socialsharing.share($scope.shareObj.title, null,  $scope.shareObj.pics[0],  $scope.shareObj.sUrl);

    }

})