/* Start angularLocalStorage */



// You should set a prefix to avoid overwriting any local storage variables from the rest of your app
// e.g. angularLocalStorage.constant('prefix', 'youAppName');
app.constant('prefix', 'app');
// Cookie options (usually in case of fallback)
// expiry = Number of days before cookies expire // 0 = Does not expire
// path = The web path the cookie represents
app.constant('cookie', { expiry:30, path: '/'});

app.service('localStorageService', [
    '$rootScope',
    'prefix',
    'cookie',
    function($rootScope, prefix, cookie) {

        // If there is a prefix set in the config lets use that with an appended period for readability
        //var prefix = angularLocalStorage.constant;
        if (prefix.substr(-1)!=='.') {
            prefix = !!prefix ? prefix + '.' : '';
        }

        // Checks the browser to see if local storage is supported
        var browserSupportsLocalStorage = function () {
            try {
                return ('localStorage' in window && window['localStorage'] !== null);
            } catch (e) {
                $rootScope.$broadcast('LocalStorageModule.notification.error',e.message);
                return false;
            }
        };

        // Directly adds a value to local storage
        // If local storage is not available in the browser use cookies
        // Example use: localStorageService.add('library','angular');
        var addToLocalStorage = function (key, value) {

            // If this browser does not support local storage use cookies
            if (!browserSupportsLocalStorage()) {
                $rootScope.$broadcast('LocalStorageModule.notification.warning','LOCAL_STORAGE_NOT_SUPPORTED');
                return false;
            }

            // 0 and "" is allowed as a value but let's limit other falsey values like "undefined"
            if (!value && value!==0 && value!=="") return false;

            try {
                if(typeof(value)=="object"){
                    value=JSON.stringify(value);
                }
                localStorage.setItem(prefix+key, value);
            } catch (e) {
                $rootScope.$broadcast('LocalStorageModule.notification.error',e.message);
                return false;
            }
            return true;
        };

        // Directly get a value from local storage
        // Example use: localStorageService.get('library'); // returns 'angular'
        var getFromLocalStorage = function (key) {
            if (!browserSupportsLocalStorage()) {
                $rootScope.$broadcast('LocalStorageModule.notification.warning','LOCAL_STORAGE_NOT_SUPPORTED');
                return getFromCookies(key);
            }

            var item = localStorage.getItem(prefix+key);

            /*TODO 判断是否为JSON*/
            function IsJsonString(str) {
                try {
                    JSON.parse(str);
                } catch (e) {
                    return false;
                }
                return true;
            }
            if(IsJsonString(item)){
                item=JSON.parse(item);
            }


            if (!item) return null;
            return item;
        };

        // Remove an item from local storage
        // Example use: localStorageService.remove('library'); // removes the key/value pair of library='angular'
        var removeFromLocalStorage = function (key) {
            if (!browserSupportsLocalStorage()) {
                $rootScope.$broadcast('LocalStorageModule.notification.warning','LOCAL_STORAGE_NOT_SUPPORTED');
                return false;
            }

            try {
                localStorage.removeItem(prefix+key);
            } catch (e) {
                $rootScope.$broadcast('LocalStorageModule.notification.error',e.message);
                return false;
            }
            return true;
        };

        // Remove all data for this app from local storage
        // Example use: localStorageService.clearAll();
        // Should be used mostly for development purposes
        var clearAllFromLocalStorage = function () {

            if (!browserSupportsLocalStorage()) {
                $rootScope.$broadcast('LocalStorageModule.notification.warning','LOCAL_STORAGE_NOT_SUPPORTED');
                return false;
            }

            var prefixLength = prefix.length;

            for (var key in localStorage) {
                // Only remove items that are for this app
                if (key.substr(0,prefixLength) === prefix) {
                    try {
                        removeFromLocalStorage(key.substr(prefixLength));
                    } catch (e) {
                        $rootScope.$broadcast('LocalStorageModule.notification.error',e.message);
                        return false;
                    }
                }
            }
            return true;
        };

        return {
            isSupported: browserSupportsLocalStorage,
            add: addToLocalStorage,
            get: getFromLocalStorage,
            remove: removeFromLocalStorage,
            clearAll: clearAllFromLocalStorage
        };

    }]);
