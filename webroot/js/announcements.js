/**
 * Announcements js
 *
 * @author   Ryuji Masukawa <masukawa@nii.ac.jp>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */
var announcements = NetCommonsApp;
var frames = NetCommonsApp;

/**
 * ブロック設定リンク
 */
frames.controller('blockEditController', ['$scope', '$modal', '$http', '$templateCache', function($scope, $modal, $http, $templateCache) {
    $http.defaults.headers.common = { 'X-Requested-With' : 'XMLHttpRequest' }
    $scope.show = function(event) {
        var modalInstance = $modal.open({
            templateUrl: event.target.href,
            controller: 'announcementsBlockController'
        });
        event.preventDefault();
        $templateCache.remove(event.target.href);   // 再登録時Token Errorになるため
    }
}]);

/**
 * ブロック設定画面
 */
frames.controller('announcementsBlockController', ['$scope', '$modalInstance', function($scope, $modalInstance) {
    $scope.submit = function(event){
        var form = $(event.target);
        var top = form.parent();
        $.post(
            form.attr('action'),
            form.serialize(),
            function(res){
                if(res == '1') {
                    $modalInstance.close();
                } else {
                    top.replaceWith(res);
                }
            }
        );
        event.preventDefault();
    };

    $scope.cancel = function () {
        $modalInstance.dismiss('cancel');
    };

    $scope.toggleSendMailDetail = true;
    $scope.toggleSendMail = function() {
        $scope.toggleSendMailDetail = $scope.toggleSendMailDetail === false ? true: false;
    };
}]);

/**
 * 一般画面
 */
announcements.controller('announcementsController', ['$scope', '$location', '$http', '$element', function($scope, $location, $http, $element) {
    // 編集リンク
    $http.defaults.headers.common = { 'X-Requested-With' : 'XMLHttpRequest' };
    $scope.show = function(event) {
        var path = event.target.href;

        $http.get(path).success(function(res) {
            // URL変換：あるブロックで編集画面に遷移後、異なるブロックで操作した場合、javascriptエラーになる＆Backキーで画面遷移もできないためコメント
            //      (Error: [$rootScope:infdig] 10 $digest() iterations reached. Aborting! Watchers fired in the last 5 iterations)
            //var baseLen = $location.absUrl().length - $location.url().length;
            //$location.path(event.target.href.substring(baseLen));
            $($element).replaceWith(res);
        });
        event.preventDefault();
    }
}]);

/**
 * 編集画面
 */
announcements.controller('announcementsEditController', ['$scope', '$http', '$element', function($scope, $http, $element) {
    $http.defaults.headers.common = { 'X-Requested-With' : 'XMLHttpRequest' };
    $scope.submit = function(event, editorId){
        var form = $(event.target);
        if (tinyMCE) {
            tinyMCE.triggerSave();
        }
        $.post(
            form.attr('action'),
            form.serialize(),
            function(res){
                $($element).replaceWith(res);
            }
        );
        event.preventDefault();
    };

    $scope.cancel = function (event) {
        var path = event.target.href;
        $http.get(path).success(function(res) {
            $($element).replaceWith(res);
        });
        event.preventDefault();
    };
}]);
