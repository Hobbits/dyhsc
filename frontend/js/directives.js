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
