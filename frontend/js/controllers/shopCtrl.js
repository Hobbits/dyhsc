app.controller("shopCtrl",function($q,$scope,AJAX,$routeParams,textStatus,$location,Obj2Arr,localStorageService,userInfo,myshopInfo,$waitDialog,$pop,$timeout,geo){
    $scope.provList={};$scope.ind1list={};
    $scope.shopPrams={};
    localStorageService.remove("shopPic");

    var getListIndex=function(arr,idname,id){
        for(index in arr){
            if(arr[index][idname]==id){
                return index;
            }
        }
        return -1;
    };

    if(angular.isDefined($routeParams.code)){
        if($routeParams.code==412){
            $scope.failedInfo=textStatus("error","请先创建店铺：");
        }
    }

    $scope.preGet=function(){

        var aftergetShopinfo=function(d){
            if(d.status!="ok"){return}/*没店铺*/


            /*TODO 预先给表单赋值*/

            myshopInfo.set(d.result);

            if(angular.isDefined(d.result.coords)){
                $scope.shopPrams.coords=d.result.coords;
                $scope.geovalid="geovalid";
            }

            $scope.shopPrams['shopname']= d.result.shop_name;
            $scope.introduction= d.result.shop_intro;
            $scope.shopPrams['management']= d.result.shop_management;
            $scope.shopPrams['address']= d.result.shop_address;
            $scope.shopPrams['contact']= d.result.shop_contact;
            $scope.shopPrams['email']= d.result.shop_email;
            $scope.shopPrams['tel']= d.result.telphone;
            if(d.result.shop_logo && d.result.shop_logo.length>2){
                $("#s_shoppic img").prop({"src": appConfig.logobaseURL+d.result.shop_logo})
            }

            var provIndex=getListIndex($scope.provList,"provID",d.result.shop_province);

            if(provIndex>0){
                $scope.shopPrams.prov = $scope.provList[provIndex];
                $scope.getCityList(d.result.shop_city);
            }

            var mcatIndex=getListIndex($scope.ind1List,"ind1ID",d.result.shop_maincategories);
            if(mcatIndex>=0){
                $scope.shopPrams.ind1 = $scope.ind1List[mcatIndex];
                $scope.getin2List(d.result.shop_categories);
            }

            $scope.bindalipay=d.result.alipay;
            //$scope.bindalipay.alipayOn=true;
            //$("input[type='checkbox']").checkboxradio("refresh");

        };


        var getProvandInd=function(){
             var provDef=$q.defer();
            var indDef=$q.defer();

            /*与获取省*/
            var prolist=localStorageService.get('shop_province');
            if (!prolist) {
                AJAX({
                    url: appConfig.shop_area,
                    sCall: function (d) {
                        $scope.provList=Obj2Arr(d,"provID","provName");
                        localStorageService.add("shop_province", $scope.provList);
                    },
                    cCall:function(){provDef.resolve();}
                })
            }else{
                $scope.provList=prolist;
                //$("#area").trigger("create");
                provDef.resolve();
            };

            /*与获取行业*/
            AJAX({
                url: appConfig.shop_ind,
                sCall: function (d) {
                    $scope.ind1List=Obj2Arr(d,"ind1ID","ind1Name");
                    //$scope.shopPrams.ind1 = $scope.ind1List[0];
                },
                eCall:function(){
                    alert("获取行业列表失败");
                },
                cCall:function(){indDef.resolve();}
            })


            return $q.all([provDef.promise,indDef.promise]);

        }

        getProvandInd().then(function(){
            myshopInfo.refresh(aftergetShopinfo);
        })
    };



    $scope.getCityList=function(cityID){
        var cityID=cityID||0;
        var aid=$scope.shopPrams.prov.provID;
        var cityL= localStorageService.get("shop_city_"+aid);

        var changeCity=function(){
            var index=getListIndex($scope.cityList,"cityID",cityID);
            if(index>0){
            $scope.shopPrams.city = $scope.cityList[index];
            }else{
                $scope.shopPrams.city = $scope.cityList[0];
            }
        };

        if(!cityL){
            AJAX({
                url:appConfig.shop_area,
                p:{area_id:aid},
                sCall:function(d){
                    $scope.cityList=Obj2Arr(d,"cityID","cityName");
                    localStorageService.add("shop_city_"+aid, $scope.cityList);
                    changeCity();

                },
                eCall:function(){
                    alert("获取城市列表失败")
                }
            })
        }else{
            $scope.cityList=cityL;
            changeCity();
        }
    };

    $scope.getin2List=function(lv2ID){
        var lv2ID=lv2ID||0;

        var catid=$scope.shopPrams.ind1.ind1ID;
        var changeCat=function(){
            var index=getListIndex($scope.shopPrams.ind2,"ind2ID",lv2ID);
            $scope.shopPrams.ind2 = $scope.ind2List[0];
        };

        AJAX({
            url:appConfig.shop_ind,
            p:{cat_id:catid},
            sCall:function(d){
                $scope.ind2List=Obj2Arr(d,"ind2ID","ind2Name");
                changeCat();

            },
            eCall:function(){
                alert("获取行业列表失败")
            }
        });
    }


    $scope.changeShoplogo=function(){
        var target=$("#s_shoppic_false")[0];
        getimageDataURL(target,function(o){
            localStorageService.add("shopPic",o);
            $("#s_shoppic img")[0].src= o.code;
            $(".shoppic i").html(o.size/1000+"KB");
        })
    }


    $scope.shopSubmit=function(){
        var logoImg=document.getElementById("logoImg");

        var  shopPrams=$scope.shopPrams;
        var picPrams=localStorageService.get("shopPic");
        if(!picPrams){
            picPrams={};
            picPrams.code=null;
            picPrams.imageType=null;
        }



        var p = {
            userid:userInfo.get().userid,
            shopname: shopPrams.shopname,
            email: shopPrams.email,
            contact: shopPrams.contact,
            province: ('prov' in shopPrams)?shopPrams.prov.provID:null,
            city: ('city' in shopPrams)?shopPrams.city.cityID:null,
            categories: ('ind2' in shopPrams)?shopPrams.ind2.ind2ID:null,
            management: shopPrams.management,
            introduction: $scope.introduction,
            tel: shopPrams.tel,
            logo: picPrams.code,
            imageType:picPrams.imageType,
            address: shopPrams.address,
            coords:shopPrams.coords,
            alipay:$scope.bindalipay
        };

//        $http
//            .post(appConfig.shop_newShop, {})
//            .success(function(data) {console.log(data)})
//            .error(function(data) { console.log(data); });
        var btn=$("#shopSub");
        var changeBtn=function(text,bol){
            $scope.subBtn={isOff:bol,submitText:text};
            btn.trigger('create');
        };


        var sendAct=function(){
            AJAX({
                url:appConfig.shop_newShop,
                p:p,
                method:"POST",
                bCall:function(){
                    $waitDialog.show("正在提交...");
                    changeBtn("提交中",true);

                },
                sCall:function(d){
                    if(typeof(d)=="object" && angular.isDefined(d.shop_name)){
                        $pop.open( '提交成功!');
                        myshopInfo.set(d);
                        $timeout(function(){
                            $pop.close();
                            $location.path('/account');
                        },1000);
                    }else if(d==2){
                        $pop.open( '店铺重名!');
                        changeBtn("提交",false);

                    }else if(d==-1){
                        $pop.open( '添加失败!');
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
        };



        if($scope.geovalid=="geoStandby" || $scope.geovalid=="geoinvalid"){
            var cityname=('city' in shopPrams)?shopPrams.city.cityName:null;
            geo.getGeodecode(p.address, cityname,function(r){
                try{
                    if(r && angular.isDefined(r.location)){
                        p.coords= {
                            latitude:r.location.lat,
                            longitude: r.location.lng
                        }
                    }
                }catch(e){}

             },sendAct);
        }else{
            sendAct();
        }





    }

    $scope.geovalid="geoStandby";
    $scope.getGeo=function(e){
        var ongeoSuccess=function(data){
            var coords=data.coords;
            $scope.shopPrams.coords=coords;
            $scope.geovalid="geovalid";
            geo.getGeocoding(coords,function(result){
                if(angular.isDefined(result.formatted_address)){
                    $scope.shopPrams.address=result.formatted_address
                }

            })
        }

        var ongeoError=function(data){
            var em=data.message || "GEO定位服务权限不足"
            $pop.open(em);
            $scope.geovalid="geoinvalid";
        }

        if($scope.geovalid=="geoStandby" || $scope.geovalid=="geoinvalid"){
            geo.get(ongeoSuccess,ongeoError)
        }else if($scope.geovalid=="geovalid"){
            $scope.shopPrams.coords=null;
            $scope.geovalid="geoStandby";
        }

    }


});

$(document).on("vclick","#s_shoppic",function(){
    $("#s_shoppic_false").click();
})

