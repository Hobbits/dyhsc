app.controller("loginCtrl", function ($scope,$routeParams,textStatus,$rootScope,$window,myshopInfo,$timeout,$location,localStorageService,AJAX,$element,$pop) {



    var doneAndjump=function(returnedObj,timeout){
        var timeout=timeout || 0;
        if(returnedObj && returnedObj.userid>0){
            localStorageService.add("userInfo",returnedObj);

            myshopInfo.delete();

            $timeout(function(){
                $location.path('/');
            },timeout);

        }
    }

    if(angular.isDefined($routeParams.code)){
        if($routeParams.code==401){
            $scope.failedInfo=textStatus("error","帐号认证失败，请重新登录");
        }
        if($routeParams.code==403){
            $scope.failedInfo=textStatus("error","需要登陆");
        }
    }

    $scope.prefill = function () {

        var userLogininfo = localStorageService.get('userLogininfo');
        if (userLogininfo) {
            $scope.userprams = userLogininfo;
        }

    };

    $scope.submit = function () {
        var p = this.userprams;

        var btn=$($element).find('form :submit');
        var changeBtn=function(text,bol){
            $scope.subBtn={isOff:bol,submitText:text};
            btn.trigger('create');
        };

        if (p.name && p.psw) {
            AJAX({
                url: appConfig.loginURL,
                p: p,
                bCall:function(){changeBtn("正在提交...",false);},
                sCall: function (d) {

                    if(d && d.userid>0){
                        changeBtn("登录成功...",false);
                        doneAndjump(d,500);
                    }else{
                        $scope.$apply(function(){
                            $pop.open('帐号或密码错误!');
                            changeBtn("请修正后提交",false);
                        })
                    }
                },
                eCall: function () {
                    changeBtn("提交",false);
                }
            });


            if ($scope.remember == "on") {
                localStorageService.add('userLogininfo', p);
            } else {
                localStorageService.remove('userLogininfo');
            }
        } else {

            $pop.open('请填完!');
        }

    }

    var ableBtn=true;/*是否没禁止*/

    $scope.otherLogin={};




    $scope.otherLogin.loginAct=function(target){
        if(!ableBtn){
            return
        }else{
            ableBtn=false;
        }

        var makenewRandom=function(){
            var d=new Date();
            return d.valueOf()+Math.random();
        }
        var randomStr=makenewRandom();

        var removeEvent=function(){
            try{
                ref.removeEventListener('exit', exitCall);
                ref.removeEventListener('loadstart', jumpCall);
            }catch(e){}
        }

        $scope.otherLogin.loginSuccess=function(){
            ableBtn=true;
            $("#isLoginDone").popup("close");
            AJAX({
                url:appConfig.api.url.Logincallback,
                p:{random:randomStr},
                sCall:function(d){
                    if(d.status=="ok"){
                        doneAndjump(d.result,"0");
                    }else{
                        $pop.open(d.result);
                    }
                }
            })
            removeEvent();

        }

        $scope.otherLogin.loginFail=function(){
            ableBtn=true;
            $("#isLoginDone").popup("close");
            removeEvent()
        }




        var jumpCall=function(event){   /*被告诉可以关闭浏览器了*/
            if(event.url.indexOf(appConfig.api.url.closeInAppbroCall)>=0){
                ref.close();
            }
        }

        var exitCall=function(e){
            $scope.otherLogin.loginSuccess();
        }

        if(target=="tencent"){
            var openurl=appConfig.api.url.txLogin+randomStr;
        }else if(target=="sina"){
            var openurl=appConfig.api.url.sinaLogin+randomStr;
        }


        var ref = window.open(openurl, '_blank', 'location=yes');

        $("#isLoginDone").popup("open");
        ref.addEventListener('exit', exitCall);
        ref.addEventListener('loadstart', jumpCall);
    }



});