app.controller("searchCtrl", function ($scope,$routeParams,$waitDialog,$location,AJAX,Obj2Arr,myshopInfo,localStorageService,$pop) {
    $scope.searchParameter={};
    $scope.logobaseURL=appConfig.logobaseURL;
    $scope.default_shopthumb=appConfig.default.shopthumb;
    var nofilter=[{'cat_id':0,'cat_name':"不筛选类别"}];
    var noprov=[{'provID':'0','provName':"不筛选省"}];
    $scope.gcat1List=nofilter;
    $scope.gcat1=$scope.gcat1List[0];
    $scope.scat1List=nofilter;
    $scope.scat1=$scope.scat1List[0];

    $scope.provList=noprov;
    $scope.prov=$scope.provList[0];



    var getObj=function(){
        var res=null;
        try{res=JSON.parse($routeParams.object)}catch(e){res={};};
        return res;
    };
    $scope.getKey=function(){
        return getObj().k;
    };

    /*搜索动作*/
    var searchAct=function(p){
        AJAX({
            url: appConfig.search,
            p:p||{k:$scope.getKey()},
            bCall:function(){
                $waitDialog.show("正在查询...");
            },
            sCall: function (d) {
                if(d && d.status=="ok"){
                    $scope.sresultList=null;
                    $scope.gresultList=null;
                    if(d.result.good && d.result.good.length>0 ){
                        $scope.gresultList=d.result.good;
                        $scope.noResult=false;
                    }else if(d.result.shop && d.result.shop.length>0){
                        $scope.sresultList=d.result.shop;
                        $scope.noResult=false;
                    }else{
                        $scope.noResult=true;
                    }

                }else{
                    $pop.open(d.result);
                }
            },
            cCall:function(){
                $waitDialog.hide();
            }
        })
    }

    $scope.pre=function(){
        $scope.searchParameter.key=$scope.getKey();
        searchAct(getObj());


        /*与获取省*/
        var prolist=localStorageService.get('shop_province');
        if (!prolist) {
            AJAX({
                url: appConfig.shop_area,
                sCall: function (d) {
                    var p=Obj2Arr(d,"provID","provName");
                    $scope.provList=noprov.concat(p);
                    localStorageService.add("shop_province", p);
                }
            })
        }else{
            $scope.provList=noprov.concat(prolist);
            $("#area").trigger("create");

        };


        /*获取商品一级分类*/
        AJAX({
            url: appConfig.goodCatURL,
            sCall: function (d) {
                if(typeof(d)=="object" || typeof(d)=="array"){
                    $scope.gcat1List=nofilter.concat(d);
                }
            },
            eCall:function(){
                alert("获取商品分类失败")
            }
        });

        /*获取店铺一级分类*/
        AJAX({
            url: appConfig.shop_ind,
            sCall: function (d) {
                if(typeof(d)=="object" || typeof(d)=="array"){
                    var truelist=Obj2Arr(d,'cat_id','cat_name');

                    $scope.scat1List=nofilter.concat(truelist);
                }
            },
            eCall:function(){
                alert("获取店铺分类失败")
            }
        })

    };
    /*pre结束*/

    /*获取商品二级分类*/
    $scope.getgcat2List=function(item){
        var cat1id=item.cat_id;
        $scope.gcat1=item;

        var choseFirst=function(){
            $scope.gcat2 = $scope.gcat2List[0];
        }

        if(!cat1id || cat1id==0){
            $scope.gcat2List=nofilter;
            choseFirst();
            return;
        }

        AJAX({
            url: appConfig.goodCatURL,
            p:{"cat_id":cat1id||null},
            sCall: function (d) {
                if(typeof(d)=="object" || typeof(d)=="array"){
                    var l=[{"cat_id":0,'cat_name':"不筛选二级分类"}].concat(d);
                    $scope.gcat2List=l;
                    choseFirst();
                }
            },
            eCall:function(){
                alert("获取商品列表失败")
            }
        })
    }


    /*获取店铺二级分类*/
    $scope.getscat2List=function(item){
        var cat1id=item.cat_id;
        $scope.scat1=item;

        var choseFirst=function(){
            $scope.scat2 = $scope.scat2List[0];
        }
        if(!cat1id || cat1id==0){
            $scope.scat2List=nofilter;
            choseFirst();
            return;
        }

        AJAX({
            url: appConfig.shop_ind,
            p:{"cat_id":cat1id||null},
            sCall: function (d) {
                if(typeof(d)=="object" || typeof(d)=="array"){
                    var trueArray=Obj2Arr(d,"cat_id",'cat_name');
                    var l=[{"cat_id":0,'cat_name':"不筛选二级分类"}].concat(trueArray);
                    $scope.scat2List=l;
                    choseFirst()
                }
            },
            eCall:function(){
                alert("获取店铺列表失败")
            }
        })
    }


    $scope.getCityList=function(){
        var provid=$scope.prov.provID;
        var choseFirst=function(){
            $scope.city=$scope.cityList[0];
        };

        var c=[{"cityID":0,"cityName":"不筛选城市"}];
        if(provid==0){
            $scope.cityList=c;
            choseFirst();
            return;
        }

        var cityL= localStorageService.get("shop_city_"+provid);



        if(!cityL){
            AJAX({
                url:appConfig.shop_area,
                p:{area_id:provid},
                sCall:function(d){
                    var truec=Obj2Arr(d,"cityID","cityName");
                    $scope.cityList= c.concat(truec);
                    localStorageService.add("shop_city_"+provid, truec);
                    choseFirst();
                },
                eCall:function(){
                    alert("获取城市列表失败")
                }
            })
        }else{
            $scope.cityList=c.concat(cityL);
            choseFirst();
        }
    };

    $scope.search=function(){
         var p={
             k:$scope.searchParameter.key,
             search_type:$scope.searchParameter.search_type,
             province:$scope.prov.provID
         };
        if(!angular.isUndefined($scope.city)){
            p.city=$scope.city.cityID;
        }

        if(p.search_type=="good"){
            if(!angular.isUndefined($scope.gcat1) && $scope.gcat1.cat_id!=0){

                p.categoryid=$scope.gcat1.cat_id;
            }
            if(!angular.isUndefined($scope.gcat2) && $scope.gcat2.cat_id!=0){

                p.categoryid=$scope.gcat2.cat_id;
            }

        }else{
            if(!angular.isUndefined($scope.scat1) && $scope.scat1.cat_id!=0){
                p.categoryid=$scope.scat1.cat_id;
            }
            if(!angular.isUndefined($scope.scat2) && $scope.scat2.cat_id!=0){
                p.categoryid=$scope.scat2.cat_id;
            }
        }

        $location.path("/search/"+JSON.stringify(p));

    }

    $scope.applyscat2=function(item){
         $scope.scat2=item;
    }
    $scope.applygcat2=function(item){
        $scope.gcat2=item;
    }


});