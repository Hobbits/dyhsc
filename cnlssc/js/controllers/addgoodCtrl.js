app.controller("addgoodCtrl", function ($scope,$pop,userInfo,myshopInfo,AJAX,localStorageService,$location,$timeout,$waitDialog) {
   $scope.prefill=function(){
       $scope.goodPrams={};
       $scope.cat2={}
       localStorageService.remove("goodPic");
       myshopInfo.refresh(
           function(result){
               if(result){
               $scope.goodPrams.shopid=myshopInfo.get("shop_id");
               $scope.goodPrams.telphone=myshopInfo.get("telphone");
               $scope.goodPrams.address=myshopInfo.get("shop_address");
               $scope.goodPrams.email=myshopInfo.get("shop_email");
               }else{
                   alert("您需要先创建店铺");
                   $location.path("/shop");
               }

       });

       /*获取商品一级分类*/
       AJAX({
           url: appConfig.goodCatURL,
           sCall: function (d) {
               if(typeof(d)=="object" || typeof(d)=="array"){
                   $scope.cat1List=d;

               }
           },
           eCall:function(){
               alert("获取行业列表失败")
           }
       })


   }

    $scope.getcat2List=function(e){
        AJAX({
            url: appConfig.goodCatURL,
            p:{"cat_id":$scope.cat1.cat_id||null},
            sCall: function (d) {
                if(typeof(d)=="object" || typeof(d)=="array"){
                    $scope.cat2List=d;
                    $scope.cat2 = $scope.cat2List[0];
                }
            },
            eCall:function(){
                alert("获取行业列表失败")
            }
        })
    }


    $scope.changeGoodlogo=function(e){
        var target=$("#trueAddgoodpic")[0];
            getimageDataURL(target,function(o){
                localStorageService.add("goodPic",o);
                $("#fakeAddgoodpic img")[0].src= o.code;
                $(".goodpicList i").html(o.size/1000+"KB");

            })

    }


    $scope.goodSubmit=function(){
        var changeBtn=function(text,bol){
            $scope.subBtn={isOff:bol,submitText:text};
        };

        /*从本地存储获取图片*/
        var p=$scope.goodPrams;
        p.picture=localStorageService.get("goodPic");
        if(typeof($scope.cat2.cat_id) !="undefined"){
            p.category=$scope.cat2.cat_id;
        }else{
            p.category=null;
        }



        AJAX({
            url:appConfig.goodAddURL,
            p:p,
            method:"POST",
            bCall:function(){
                $waitDialog.show("正在提交...");
                changeBtn("提交中",true);

            },
            sCall:function(d){

                if(typeof(d)=="object" && d.status=="ok"){
                    $pop.open( '提交成功!');
                    $timeout(function(){
                        $pop.close();
                        $location.path('/goods');
                    },1000);

                }else{
                    $pop.open(d.result);
                    changeBtn("提交",false);

                }
            },
            eCall:function(){
                $pop.open( '<p>提交失败，</p><p>文件过大,</p><p>或服务器配置有问题</p>');
                changeBtn("提交",true);
            },
            cCall:function(){
                $waitDialog.hide();
            }
        })


    }



});

$(document).on("vclick","#fakeAddgoodpic",function(){
    $("#trueAddgoodpic").click();
})