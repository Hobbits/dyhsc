app.directive("templarlink",['$window','$location', function($window){
    return {
        restrict: 'A',
        link: function (scope,element,attrs) {
            element.bind("vclick",function(){
                var href=attrs.templarlink;
                    $window.location.replace(href);

            })
        }
    }
}]);

app.directive("appfooter", function($route) {
    return {
        restrict: "E",
        replace: true,
        template: '<div data-id="appfooter" data-role="footer" data-position="fixed" data-tap-toggle="false">'+
            '<div data-role="navbar" data-iconpos="bottom">'+
            '<ul class="footerul">'+
            '<li><a href="#!/" data-icon="home" data-theme="a" class="nav nav1">首页</a></li>'+
            '<li><a href="#!/filterlv1/%7B%22search_type%22:%22good%22,%22lv%22:%221%22%7D" data-icon="grid" data-theme="a" class="nav nav2">分类浏览</a></li>'+
            '<li><a href="#!/buy" data-icon="shopping-cart" data-theme="a" class="nav nav3">购物车</a></li>'+
            '<li><a href="#!/account" data-icon="gear" data-theme="a" class="nav nav4">会员中心</a></li>'+
            '</ul>'+
            '</div>'+
            '</div>',
        link: function(scope,element,attrs) {
            var navName = 'nav1';
            scope.$on("$routeChangeSuccess", function (event, current, previous) {
                $('.nav').removeClass("ui-btn-active");
                if(current.$$route && ('footerPointer' in current.$$route)){
                    navName=current.$$route.footerPointer;
                    setTimeout(function(){
                        $('.'+navName).addClass("ui-btn-active");
                    },300);
//                    scope.navNames[navName]="ui-btn-active";
                }
            });
        }
    }
});


