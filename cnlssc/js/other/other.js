$(document).on("vclick",".fakeSubmit",function(){
    $.mobile.activePage.find(".trueSubmit").click();
});

/*Panel 目前只留给安卓*/
$(document).on('pagebeforeshow', '[data-role="page"]', function(event){
    var tempHTML=$("#panelTemp").html();
    $(".inject").remove();
    $(this).append(tempHTML);
    var pn=$.mobile.activePage.find('.myPanel');

    pn.panel();
    pn.find(".panelul").listview();

});
//$(document).on("swiperight","div:jqmData(role='page')",function(evt){
//    $.mobile.activePage.find(".myPanel").panel("open");
//});

$(document).on("vclick",".gallery li",function(e){
    var choseLi=$(this);
    if(!choseLi.hasClass("cur")){
        $.mobile.activePage.find("div:jqmData(role='popup')").popup("close");

    $(".gallery li").removeClass("cur");
    choseLi.addClass("cur");
    }
});


$.mobile.scrollBottom=function(){
    var footerHeight=$.mobile.activePage.find('footer').height();
    var distance=$.mobile.activePage.find('.ui-content').height()+footerHeight+900;
    window.scrollTo(0,distance);
}

$(document).ready(function(){
     var prepareData=function(){
         var df=$.Deferred();
         $.getJSON(appConfig.bannerURL+"&callback=?")
             .done(function(data){
                 if(data.status == "ok"){
                     var strHTML = '';
                     $.each(data.result, function(InfoIndex, Info) {
                         var imgurl=servURL+Info["images_url"];
                         strHTML += "<div class='swiper-slide' style='background:url("+imgurl+") no-repeat;'>" + "<a href='" +Info["images_link"] + "'></a></div>";
                     });
                     $(".swiper-wrapper").empty().html(strHTML);
                     df.resolve();
                 }else{
                     df.reject();
                 }
             })
             .fail(function(){df.reject();});
         return df;
    }

    $.when(
            $.getScript("libs/swiper/idangerous.swiper-2.0.min.js"),
            $.getScript("libs/swiper/idangerous.swiper.3dflow-2.0.js"),
            prepareData()
        ).done(function(){
            var initSwiper=function(){
                var container=$(".swiper-container");
                var init=function(){

                    var resetContainer=function(){
                        container.width($("#mainContent").width());
                    }

                    resetContainer();
                    var threeDObj={
                        rotate : 50,
                        stretch :40,
                        depth: 300,
                        modifier : 1,
                        shadows : true
                    };
                    var options={
                        mode:'horizontal',
                        speed:750,
                        autoplay:5000,
                        loop: true,
                        tdFlow:threeDObj
                    }

                    window.template.mySwiper = container.swiper(options);



                    var resetContainer=function(){
                        container.width($("#mainContent").width());
                    }

                    resetContainer();

                    window.onresize=function(){
                        resetContainer();
                        window.template.mySwiper.resizeFix();
                    }

                };
                setTimeout(init,0);

                container.on("swiperight",function(evt){
                    evt.stopPropagation();
                });
            }

            initSwiper();
        }
    );

//    $( "#pagemain" ).on( "pageshow", function( event, ui ) {
//        try{
//            if(window.template.mySwiper){
//                window.template.mySwiper.reInit();
//            }
//        }catch(e){}
//    });



})

document.addEventListener("deviceready", function(){
//    document.addEventListener("backbutton", function(e){
//        e.preventDefault();
//        return false;
//    }, false);

    document.addEventListener("menubutton", function(e){
//        e.preventDefault();
        try{
            $.mobile.activePage.find(".myPanel").panel("toggle");
        }catch(e){}
    }, false);
    document.addEventListener("searchbutton", function(){
        window.location.href="#!/search/";
    }, false);
}, false);

document.addEventListener("deviceready", function(){
    setTimeout(function(){navigator.splashscreen.hide();},3000);
}, false);


$('body').on('click',"[href]",function(event){
    event.preventDefault();
    var url=$(this).attr('href');
    if(url.indexOf("http") >= 0){
        window.open(url, '_blank', 'location=yes');
    }
});

//$(document).on("touchmove",function(evt){
//    evt.preventDefault();
//});
//$(document).on("touchmove",".scrollable",function(evt){
//    evt.stopPropagation();
//});
//var scrollableHeightchange=function(){
//    try{
//    var target=$(".scrollable");
//    var maxHeight=$(window).height();
//    var headerHeight=$("header").height();
//    target.height(maxHeight-headerHeight-80);
//    }catch (e){}
//
//};
//
//$(window).on('orientationchange resize',scrollableHeightchange);
//$(document).on("pageshow","div:jqmData(role='page')",scrollableHeightchange);
