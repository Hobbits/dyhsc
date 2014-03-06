
var app = angular.module("app", ['btford.phonegap.geolocation']);


app.config(function($locationProvider,$httpProvider,$compileProvider) {
    $locationProvider.html5Mode(false);
    $httpProvider.defaults.useXDomain = true;
    $compileProvider.urlSanitizationWhitelist(/^\s*(https?|ftp|mailto|file|tel):/);

    delete $httpProvider.defaults.headers.common['X-Requested-With'];
    $httpProvider.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded; charset=UTF-8';
});

var transOrganizer=function(trans){
    if(isAndroid){
        trans="none";
    }
    return trans;
}

app.config(function($routeProvider) {
    $routeProvider.
		when('/news/:cat_id', {		
            templateUrl: 'newsCategory2.html',
            jqmOptions: {transition: transOrganizer('slide')}
        }).
		when('/news', {		
            templateUrl: 'newsCategory1.html',
            jqmOptions: {transition: transOrganizer('slide')}
        }).
        when('/article/:articleid', {
            templateUrl: 'newsDetail.html',
            jqmOptions: {transition: transOrganizer('slide')}
        }).
        when('/searchFriend', {
            templateUrl: 'searchFriend.html',
            jqmOptions: {transition: transOrganizer('slide')},
            resolve:validateLogon
        }).
		when('/buddyChat', {
            footerPointer:'nav4',
            templateUrl: 'buddyChat.html',
            jqmOptions: {transition: transOrganizer('slide')},
            resolve:validateLogon
        }).
		when('/orderDetail/:payid',{
			templateUrl: 'orderDetail.html',
            jqmOptions: {transition: transOrganizer('slide')},
			resolve:validateLogon
		}).
		when('/buyRev', {
            footerPointer:'nav3',
			templateUrl: 'orderlist.html',
            jqmOptions: {transition: transOrganizer('slide'),reverse:true},
			resolve:validateLogon
		}).
		when('/buy', {
            footerPointer:'nav3',
			templateUrl: 'orderlist.html',
            jqmOptions: {transition: transOrganizer('slide')},
			resolve:validateLogon
		}).
		when('/sell', {
            footerPointer:'nav3',
			templateUrl: 'orderlistSell.html',
            jqmOptions: {transition: transOrganizer('slide')},
			resolve:validateLogon
		}).
        when('/order/:payid/2', {
            templateUrl: 'order2.html',
            jqmOptions: {transition: transOrganizer('slide')},
            resolve:validateLogon
        }).
        when('/order/:goodid/1', {
            templateUrl: 'order1.html',
            jqmOptions: {transition: transOrganizer('slide')},
            resolve:validateLogon
        }).
        when('/fav/:type', {
            templateUrl: 'fav.html',
            jqmOptions: {transition: transOrganizer('slide')},
            resolve:validateLogon
        }).
        when('/myqrcode', {
            templateUrl: 'myqrcode.html',
            jqmOptions: {transition: transOrganizer('slide')},
            resolve:hasShop
        }).
        when('/near', {
            templateUrl: 'nearShop.html',
            jqmOptions: {transition: transOrganizer('slide')}
        }).
        when('/filterlast/:object', {
            footerPointer:'nav2',
            templateUrl: 'filterlastShow.html',
            jqmOptions: {transition: transOrganizer('slide')}
        }).
        when('/filterlv2/:object', {
            footerPointer:'nav2',
            templateUrl: 'filterlv2.html',
            jqmOptions: {transition: transOrganizer('slide')}
        }).
        when('/filterlv1/:object', {
            footerPointer:'nav2',
            templateUrl: 'filterlv1.html',
            jqmOptions: {transition: transOrganizer('slide')}
        }).
        when('/search/:object', {
            footerPointer:'nav2',
            templateUrl: 'search.html',
            jqmOptions: {allowSamePageTransition: true,transition: transOrganizer('flip')}
        }).
        when('/uploadmore/:goodid', {
            templateUrl: 'uploadmore.html',
            jqmOptions: {transition: transOrganizer('slide')}
        }).
        when('/gooddetail/:goodid/gallery', {
            templateUrl: 'goodgallery.html',
            jqmOptions: {transition: transOrganizer('slide')}
        }).
        when('/gooddetail/:goodid/detailRev', { /*翻转动画反向*/
            templateUrl: 'gooddetail.html',
            jqmOptions: {transition: transOrganizer('slide'),reverse:true}
        }).
        when('/gooddetail/:goodid/detail', {
            templateUrl: 'gooddetail.html',
            jqmOptions: {transition: transOrganizer('slide')}
        }).
        when('/addgood', {
            templateUrl: 'addgood.html',
            jqmOptions: {transition: transOrganizer('slide')},
            resolve:validateLogon
        }).
        when('/goods', {
            templateUrl: 'goodslist.html',
            jqmOptions: {transition: transOrganizer('slide')},
            resolve:hasShop
        }).
        when('/dialogue:targetName/:targetid/', {
            templateUrl: 'dialogue.html',
            jqmOptions: {transition: transOrganizer('slide')},
            resolve:validateLogon
        }).
        when('/chatlist', {
            templateUrl: 'chatlist.html',
            jqmOptions: {transition: transOrganizer('slide')},
            resolve:validateLogon
        }).
        when('/account', {
            footerPointer:'nav4',
            templateUrl: 'account.html',
            jqmOptions: {transition: transOrganizer('slide')},
            resolve:validateLogon
        }).
        when('/shopGuest/:shopid/goods', {
            templateUrl: 'shopGuestviewgoods.html',
            jqmOptions: {transition: transOrganizer('slide')}
        }).
        when('/shopGuest/:shopid/infoRev', {/*动画反向*/
            templateUrl: 'shopGusetviewinfo.html',
            jqmOptions: {transition: transOrganizer('slide'),reverse:true}
        }).
        when('/shopGuest/:shopid/info', {
            templateUrl: 'shopGusetviewinfo.html',
            jqmOptions: {transition: transOrganizer('slide')}
        }).
        when('/shop:code', {
            templateUrl: 'shop.html',
            jqmOptions: {transition: transOrganizer('none')},
            resolve:validateLogon
        }).
        when('/reg', {
            templateUrl: 'reg.html',
            jqmOptions: {transition: transOrganizer('slide')}
        }).
        when('/login:code', {
        templateUrl: 'login.html',
        jqmOptions: {transition: transOrganizer('slide')}
    }).
        when('/', {
            footerPointer:'nav1',
            templateUrl: '#pagemain',
            jqmOptions: {transition: transOrganizer('none')}
        }).
        otherwise({redirectTo:"/"});

});


var validateLogon = {
    storge: function($q,$rootScope,userInfo) {
        var deferred = $q.defer();
        if(userInfo.get()){
            deferred.resolve();
        }else{
            deferred.reject("notlogin");
        };
        return deferred.promise;
    }
};


var hasShop = {
    get: function($q,userInfo,myshopInfo,$location) {
        var deferred = $q.defer();
        myshopInfo.refresh(
            function(d){
                if(d.status=="ok"){
                    deferred.resolve();
                }else{
                    deferred.reject("needaShop");
                }

            });
        return deferred.promise;
    }
};
