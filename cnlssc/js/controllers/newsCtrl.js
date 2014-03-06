app.controller("newsCategoryCtrl", function ($scope,$routeParams,$pop,$waitDialog,$location,AJAX) {
 

//获取新闻分类
$scope.showNewsCategory = function(){
    AJAX({
        url : appConfig.newsCategoryURL,
        sCall : function(d){
            if(d.status == 'ok'){
                $scope.newsCategory = d.result;
            } else{
                $pop.open(d.result);
            }
        }
    })
}


var getcatid = function(){
    return $routeParams.cat_id;
}

//获取新闻列表
$scope.showNewslist = function(){
    AJAX({
        url : appConfig.newslistURL,
        p : {'cat_id' : getcatid()},
        sCall : function(d){
            if(d.status == 'ok'){
                $scope.newslist = d.result;
                $scope.headerName = d["addon"]["categoryname"];
            } else{
                $pop.open(d.result);
            }
        }
    })
    
}

 $scope.getNewsDetial=function(){
      var a_id=$routeParams.articleid;
     AJAX({
         url:appConfig.newsInfoURL,
         p:{article_id:a_id},
         bCall:function(){$waitDialog.show("加载新闻...")},
         sCall:function(d){
             if(d && d.status=="ok"){
                 $scope.arti={
                     title: d.result.title ||"无内容",
                     content:d.result.content ||"无内容",
                     add_time:d.result.add_time,
                     author:d.result.admin_name,
                     sUrl:(servURL+'article.php?id='+a_id)||''
                 }
             }
         },
         cCall:function(){$waitDialog.hide();}
     })
 }


    $scope.newsShare=function(){
//        $.mobile.activePage.find(".sharePop").popup("open");


        var targetObj=$.mobile.activePage.find('article');

        $scope.shareObj={
            sUrl:$scope.arti.sUrl,
            pics:appConfig.getPicString(targetObj),
            title:$scope.arti.title,
            content:targetObj.find('.articleText').text(),
            ralateUid:appConfig.api.sinaRalateUid||''
        }

        if($scope.shareObj.pics && $scope.shareObj.pics.length > 0) {
            //
        } else {
            $scope.shareObj.pics[0] = null;
        }
        window.plugins.socialsharing.share($scope.shareObj.content, $scope.shareObj.title, $scope.shareObj.pics[0], $scope.shareObj.sUrl);
    }







})

