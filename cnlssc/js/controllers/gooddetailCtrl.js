app.controller("gooddetailCtrl", function ($scope,$routeParams,$window,AJAX,userInfo,$location,myshopInfo,$pop,$waitDialog) {
    $scope.isGoodowner=false;

    $scope.logobaseURL=appConfig.logobaseURL;
    $scope.goodInfo={};
    $scope.getgoodid=function(){
          return $routeParams.goodid;
    };

    var selectObj={};
    var menuAct="";
    var reset=function(){
        selectObj={};
        menuAct="";
    };

    $scope.getitemInfo=function(){
        reset();
        $scope.isGoodowner=false;
        var getInfo=function(itemID){


            /*区分店铺是不是自己的*/
            var distinguishOwner=function(data){
                var thisshopID=data.shopid;
                var thisusersShop=myshopInfo.get('shop_id');
                $scope.$apply(function(){

                    if(thisshopID == thisusersShop){
                        $scope.isGoodowner=true
                    }else{
                        $scope.isGoodowner=false
                    }
                })
            }


            AJAX({
                bCall:function(){
                    $waitDialog.show("获取商品信息...");
                },
                url: appConfig.goodInfoURL,
                p:{'goodsid':itemID},
                sCall: function (d) {
                    if(d.status=="ok"){
                        if(d.result.imgs && d.result.imgs.length>0){
                            d.result.imgs[0].img_thumb=d.result.imgs[0].img_thumb || myshopInfo.get("shop_logo");
                        }
                        $scope.goodInfo= d.result;
                        distinguishOwner(d.result);

                        if(d.result.imgs && d.result.imgs.length>0){
                              $scope.galleryList=d.result.imgs;
                        }

                    }else{
                        $pop.open(d.result);
                    }

                },
                cCall:function(){$waitDialog.hide();}
            })
        }



            if($routeParams.goodid){
                getInfo($scope.getgoodid());
            }else{
                $window.history.back();
            }

    }

    var popupIMG=$("#popupIMG");
    var menuIMG=$("#imgmenu");





    $scope.showMenu=function(index,$event){
        $event.preventDefault();
        selectObj=$scope.galleryList[index];
        menuIMG.popup("open",{
                history: false,
                overlayTheme: "a",
                positionTo:"origin",
                transition:"slideup"
            });

        setTimeout(function(){
            $("#galleryTip").fadeOut();
        },500)

    }

    /*关闭菜单后的动作*/
    var afterMenu=function(){
        var targetObj=angular.copy(selectObj);


        /*完毕后重刷相册*/
        var refreshGallery=function(d){
            if(d.result.imgs && d.result.imgs.length>=0){
                $scope.$apply(function(){
                    $scope.galleryList=d.result.imgs;
                })

            }
            reset();

        };


        /*查看原图*/
        if(menuAct==1 && targetObj.img_url){
            var trueurl=appConfig.logobaseURL+targetObj.img_url;

            var targetimg=popupIMG.find(".popphoto");
            targetimg.prop({src:"libs/images/ajax-loader.gif"});
            try{
                targetimg.css({
                    "width":targetObj.orwidth+"px"
                });
            }catch(e){}
            targetimg.prop({src:trueurl});


            popupIMG.popup("open",{
                history: false,
                overlayTheme: "a",
                positionTo:"window",
                transition:"flow"
            });
            reset();
            return;
        }

        /*设为主图*/
        if(menuAct==2 && targetObj.imgid>0){
            var imgid=targetObj.imgid;

            AJAX({
                url:appConfig.makeMainimgURL,
                p:{
                    'imgid':imgid,
                    'goodsid':$scope.getgoodid()
                },
                bCall:function(){
                    $waitDialog.show("正在设置...");
                },
                sCall:function(d){
                    if(d.status=="ok"){
                        $pop.open("成功设置!");
                        refreshGallery(d);
                    }else{
                        $pop.open(d.result);
                    }
                },
                cCall:function(){
                    $waitDialog.hide();
                }
            })

            reset();
            return;
        }


        /*删除图片*/
        if(menuAct==3){
            var imgid=targetObj.imgid;

            AJAX({
                url:appConfig.deleteImgURL,
                p:{
                    'imgid':imgid,
                    'goodsid':$scope.getgoodid()
                },
                bCall:function(){
                    $waitDialog.show("正在删除...");
                },
                sCall:function(d){
                   if(d.status=="ok"){
                       $pop.open("成功删除!");
                       refreshGallery(d);
                   }else{
                       $pop.open(d.result);
                   }
                },
                cCall:function(){
                    $waitDialog.hide();
                    reset();
                }
            })


            reset();
            return;
        }


    };
    menuIMG.bind("popupafterclose",afterMenu);


    $scope.menuAct=function(act){
        if(act){
            menuAct=act;
            menuIMG.popup("close");
            return;
        }


    }

    $scope.closepop=function(){
        $("#popupIMG").popup("close");
        reset();
    }

    $scope.goodShare=function(){
//        $.mobile.activePage.find(".sharePop").popup("open");


        var targetObj=$.mobile.activePage.find('.goodth');

        $scope.shareObj={
            sUrl:servURL+'shop.php?app=product&productid='+$scope.getgoodid(),
            pics:appConfig.getPicString(targetObj),
            title:$scope.goodInfo.name,
            content:$scope.goodInfo.introduction,
            ralateUid:appConfig.api.sinaRalateUid||''
        }
        if($scope.shareObj.pics && $scope.shareObj.pics.length > 0) {
            //
        } else {
            $scope.shareObj.pics[0] = null;
        }
        window.plugins.socialsharing.share($scope.shareObj.content,$scope.shareObj.title,$scope.shareObj.pics[0],  $scope.shareObj.sUrl);
    }

});




