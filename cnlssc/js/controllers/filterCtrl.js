app.controller("filterCtrl", function ($scope,$routeParams,$pop,$waitDialog,$location,AJAX) {

    var getObj=function(){
        var res=null;
        try{res=JSON.parse($routeParams.object);}catch(e){res={}}
        return res;
    };
    $scope.setShow=function(){
        if(getObj() && 'headerName' in getObj()){
            $scope.headerName=getObj().headerName;
        }

        if(getObj() && getObj().last){
            /*搜索动作*/
            var searchAct=function(p){
                AJAX({
                    url: appConfig.search,
                    p:p||null,
                    bCall:function(){
                        $waitDialog.show("正在查询...");
                    },
                    sCall: function (d) {
                        if(d && d.status=="ok"){
                            $scope.showList= d.result.good || d.result.shop ;
                        }else{
                            $pop.open(d.result);
                        }
                    },
                    cCall:function(){
                        $waitDialog.hide();
                    }
                })
            }

            searchAct(getObj());
        }

        if(getObj() && getObj().search_type=="good" && !getObj().last){
            /*获取商品一级分类*/
            AJAX({
                url: appConfig.goodCatURL,
                p:{"cat_id":getObj().categoryid||null},
                sCall: function (d) {
                    if(typeof(d)=="object" || typeof(d)=="array"){
                        $scope.lvList=d;
                    }
                },
                eCall:function(){
                    $pop.open("获取商品分类失败");
                }
            });
        }

    }

    $scope.go=function(lvID,lvName){
        var p=getObj();
        p.categoryid=lvID;
        p.lv=2;
        p.headerName=lvName;
        $location.path('/filterlv2/'+JSON.stringify(p))
    }
    $scope.golast=function(lvID,lvName){
        var p=getObj();
        p.categoryid=lvID;
        p.headerName=lvName;
        p.last=true;
        $location.path('/filterlast/'+JSON.stringify(p))
    }


})
