app.controller("regCtrl", function ($scope,$element,$window,AJAX,$location,localStorageService,$pop) {
    $scope.comparePsw=function(a,b){
        if(a && b && a!=b){
            return "两次输入的密码不一致，请核对"
        }else{
            return null;
        }
    };

    $scope.regSubmit=function(){
        var regp=$scope.regprams;

        var btn=$($element).find('form :submit');
        var changeBtn=function(text,bol){
            $scope.subBtn={isOff:bol,submitText:text};
            btn.trigger('create');
        };


        AJAX({
            url: appConfig.regURL,
            p: regp,
            bCall:function(){changeBtn("正在提交...",false);},
            sCall: function (d) {
                if(typeof(d)=="object" && d.userid>0){
                    localStorageService.add("userLogininfo",regp);
                    changeBtn("注册成功...",false);
                    setTimeout(function(){
                        $window.location.href="#!/login";
                    },500);
                }else{
                    var t= '注册失败!';
                    if(d==2){t = '用户名已经被其他人使用';}
                    $scope.$apply(function(){
                        $pop.open(t);
                        changeBtn("请修正后提交",false);
                    })
                }
            },
            eCall: function () {
                changeBtn("提交",false);
            }
        });


    }


});