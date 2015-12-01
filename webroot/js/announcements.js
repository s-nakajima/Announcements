/**
 * @fileoverview Announcements Javascript
 * @author nakajimashouhei@gmail.com (Shohei Nakajima)
 */


/**
 * Announcements Javascript
 *
 * @param {string} Controller name
 * @param {function($scope, NetCommonsWysiwyg)} Controller
 */
NetCommonsApp.controller('Announcements',
    function($scope, NetCommonsWysiwyg) {

      /**
       * tinymce
       *
       * @type {object}
       */
      $scope.tinymce = NetCommonsWysiwyg.new();

      /**
       * Initialize
       *
       * @return {void}
       */
      $scope.initialize = function(data) {
        $scope.announcement = angular.copy(data.announcement);
      };
    });

/**
 * Sample Javascript
 *
 * @param {string} Controller name
 * @param {function($scope, SelectUser)} Controller
 */
NetCommonsApp.controller('Sample',
    function($scope, SelectUser) {

      /**
       * 会員選択の結果を保持する配列
       *
       * @return {array}
       */
      $scope.users = [];

      /**
       * 会員選択ダイアログを表示する
       *
       * @param {number} users.id
       * @return {void}
       */
      $scope.showUserSelectionDialog = function(userId, roomId) {
        SelectUser($scope, userId, roomId).result.then(
            function(result) {
              /**
               * ここに選択後の処理を記述
               * とりあえず、サンプルコードとしてconsole.logと
               * 結果表示サンプルコード用の配列にセット
               */
              console.log(result);
              $scope.users = result;
            },
            function() {
              /**
               * ここにキャンセル処理
               */
            }
        );
      };
    });
