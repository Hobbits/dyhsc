app.factory('Socket', function($rootScope) {
    var socket = io.connect('http://localhost:3000');

    //Override socket.on to $apply the changes to angular
    return {
        on: function(eventName, fn) {
            socket.on(eventName, function(data) {
                $rootScope.$apply(function() {
                    fn(data);
                });
            });
        },
        emit: socket.emit
    };
})
   /*用法
function MyCtrl($scope, Socket) {
    Socket.on('content:changed', function(data) {
        $scope.data = data;
    });
    $scope.submitContent = function() {
        socket.emit('content:changed', $scope.data);
    };
}
       */