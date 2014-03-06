app.controller("shareCtrl", function ($scope,$pop) {
    $scope.share=function(target,o){
        if(!target || !o){return}


        var postToTxWb=function(o,callback){
            /*o:{sUrl:String,pics:Array,title:String,content:String}*/
            var _url = encodeURIComponent(o.sUrl || '');
            var _assname = encodeURI(appConfig.api.keys.txAccount);//你注册的帐号，不是昵称
            var _appkey = encodeURI(appConfig.api.keys.txappKey);//你从腾讯获得的appkey
            var _pic = encodeURI(o.pics.join('|'));//（例如：var _pic='图片url1|图片url2|图片url3....）
            var _t = ('“'+o.title+'”')||'';//标题和描述信息
            var metainfo = document.getElementsByTagName("meta");
            for(var metai = 0;metai < metainfo.length;metai++){
                if((new RegExp('description','gi')).test(metainfo[metai].getAttribute("name"))){
                    _t = metainfo[metai].attributes["content"].value;
                }
            }
            _t =  _t+ o.content;//请在这里添加你自定义的分享内容
            if(_t.length > 120){
                _t= _t.substr(0,117)+'...';
            }
            _t = encodeURI(_t);

            var _u = 'http://share.v.t.qq.com/index.php?c=share&a=index&url='+_url+'&appkey='+_appkey+'&pic='+_pic+'&assname='+_assname+'&title='+_t;
            callback(_u);
        }

        var postToSina=function(o,callback){
            /*o:{sUrl:String,pics:Array,title:String,content:String,ralateUid:number}*/
            var _w = 72 , _h = 16;
            var param = {
                url: o.sUrl||'',
                type:'3',
                count:'', /**是否显示分享数，1显示(可选)*/
                appkey:appConfig.api.keys.sinaKey, /**您申请的应用appkey,显示分享来源(可选)*/
                title: (o.title+' '+ o.content)||'', /**分享的文字内容(可选，默认为所在页面的title)*/
                pic: o.pics[0], /**分享图片的路径(可选)*/
                ralateUid: o.ralateUid||'', /**关联用户的UID，分享微博会@该用户(可选)*/
                language:'zh_cn', /**设置语言，zh_cn|zh_tw(可选)*/
                dpc:1
            }
            var temp = [];
            for( var p in param ){
                temp.push(p + '=' + encodeURIComponent( param[p] || '' ) )
            }
            var _u='http://service.weibo.com/share/share.php?' + temp.join('&');
            callback(_u);
        }

        if(target=="tx"){
            postToTxWb(o,function(url){
                var ref = window.open(url, '_blank', 'location=yes');
            })
        };
        if(target=="sina"){
            postToSina(o,function(url){
                var ref = window.open(url, '_blank', 'location=yes');
            })
        }
    }
})
