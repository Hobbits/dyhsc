app.filter('htmlToPlaintext', function() {
        return function(text) {
            var newStr=String(text).replace(/\&nbsp;/g, " ").replace(/<(?:.|\n)*?>/gm, '');

            return newStr;
        }
    }
);