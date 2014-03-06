app.controller("accCtrl", function ($scope,$pop,userInfo,myshopInfo,$location,logout) {
    $scope.preRun=function(){
        $scope.uInfo=userInfo.get();

        var logobaseURL = appConfig.logobaseURL;
        var getUserLogo = function(){
            return userInfo.get().user_Logo;
        }
        var getShopLogo = function(){
            return myshopInfo.get('shop_logo');
        }
        var otherLogo = appConfig.default.headerThumb;
        
        $scope.logo = getUserLogo() ? logobaseURL+getUserLogo() : 
                      getShopLogo() ? logobaseURL+getShopLogo() :
                      otherLogo;
    }
    
   


    $scope.logout=function(){
        logout('/');
    }
});
