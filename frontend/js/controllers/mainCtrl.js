app.controller("mainCtrl", function ($scope,$location,localStorageService,userInfo) {
    $scope.islogged=true;
    $scope.pre=function(){
        if(userInfo.get()){
            $scope.islogged=true;
        }else{
            $scope.islogged=false;
        }

        try{
            if($.mobile.activePage.attr("id")=="pagemain" && window.template.mySwiper){
                setTimeout(function(){
                    $(window).trigger("resize");
                    window.template.mySwiper.resizeFix();
                },250);
            }
        }catch(e){}

    };

    $scope.mainsearch=function(){
        var key=$scope.mainSearch;
        if(key){
            var str=JSON.stringify({'k':key});
             $location.path("/search/"+str)
        }
    }

});