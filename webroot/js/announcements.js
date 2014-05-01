
var nc = angular.module('nc', ['ui.bootstrap']);
nc.controller('blockEditController', ['$scope', '$modal', '$http', function($scope, $modal, $http) {
    $http.defaults.headers.common = { 'X-Requested-With' : 'XMLHttpRequest' }
    $scope.show = function(event) {
        /*$http.get(event.target.href).success(function(data) {
         console.log(data);

         });*/
        var modalInstance = $modal.open({
            templateUrl: event.target.href,
            controller: 'announcementBlockController'
        });
        event.preventDefault();
    }
}]);
nc.controller('announcementBlockController', ['$scope', '$modalInstance', '$modalInstance', function($scope, $modalInstance) {
    $scope.submit = function(event){
        var form = $(event.target);
        $.post(
            form.attr('action'),
            form.serialize(),
            function(data){
                if(data == '1') {
                    // TODO: 再編集時にTokenエラーとなる。
                    $modalInstance.close();
                }
            }
        );
        event.preventDefault();
    };

    $scope.cancel = function () {
        $modalInstance.dismiss('cancel');
    };
}]);
