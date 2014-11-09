/**
 * @fileoverview Announcements Javascript
 * @author nakajimashouhei@gmail.com (Shohei Nakajima)
 */


/**
 * Announcements Javascript
 *
 * @param {string} Controller name
 * @param {function($scope, $http, $sce, $modalStack)} Controller
 */
NetCommonsApp.controller('Announcements',
                         function($scope, $http, $sce, $modalStack) {

      /**
       * Announcements plugin view url
       *
       * @const
       */
      $scope.PLUGIN_INDEX_URL = '/announcements/announcements/';

      /**
       * Announcements edit url
       *
       * @const
       */
      $scope.PLUGIN_EDIT_URL = '/announcements/announcement_edit/';

      /**
       * Announcement
       *
       * @type {Object.<string>}
       */
      $scope.announcement = {};

      /**
       * comments
       *
       * @type {Object.<string>}
       */
      $scope.comments = {};

      /**
       * Initialize
       *
       * @return {void}
       */
      $scope.initialize = function(frameId, announcement) {
        $scope.frameId = frameId;
        $scope.announcement = announcement;
      };

      /**
       * Show manage dialog
       *
       * @return {void}
       */
      $scope.showManage = function() {
        $modalStack.dismissAll('canceled');

        $http.get($scope.PLUGIN_EDIT_URL + 'view_latest/' +
                  $scope.frameId + '/' + Math.random() + '.json')
            .success(function(data) {
              //最新データセット
              $scope.announcement = data.announcement;
              $scope.comments.current = data.comments.current;
              $scope.comments.hasPrev = data.comments.hasPrev;
              $scope.comments.hasNext = data.comments.hasNext;
              $scope.comments.data = data.comments.data;
              $scope.comments.disabled =
                              data.comments.data.length === 0 ? true : false;
              $scope.comments.visibility =
                              data.comments.data.length === 0 ? false : true;

              var templateUrl = $scope.PLUGIN_EDIT_URL +
                              'view/' + $scope.frameId + '.json';
              $scope.showDialog($scope, templateUrl, 'Announcements.edit');
            })
            .error(function(data) {
              $scope.flash.danger(data.name);
            });
      };

      /**
       * htmlContent method
       *
       * @return {string}
       */
      $scope.htmlContent = function() {
        //ng-bind-html では、style属性まで消えてしまうため
        return $sce.trustAsHtml($scope.announcement.Announcement.content);
      };

    });


/**
 * Announcements.edit Javascript
 *
 * @param {string} Controller name
 * @param {function($scope, $http, $modalStack)} Controller
 */
NetCommonsApp.controller('Announcements.edit',
                         function($scope, $http, $modalStack) {
      /**
       * errors
       *
       * @type {bool}
       */
      $scope.errors = {};

      /**
       * placeholders
       *
       * @type {Object.<string>}
       */
      $scope.placeholders = {};

      /**
       * sending
       *
       * @type {bool}
       */
      $scope.sending = false;

      /**
       * edit object
       *
       * @type {Object.<string>}
       */
      $scope.edit = {
        _method: 'POST',
        data: {}
      };

      /**
       * dialog initialize
       *
       * @return {void}
       */
      $scope.initialize = function() {
        $scope.edit.data = {
          Announcement: {
            content: $scope.announcement.Announcement.content,
            comment: '',
            status: $scope.announcement.Announcement.status,
            block_id: $scope.announcement.Announcement.block_id,
            key: $scope.announcement.Announcement.key,
            id: $scope.announcement.Announcement.id
          },
          Frame: {
            id: $scope.frameId
          },
          _Token: {
            key: '',
            fields: '',
            unlocked: ''
          }
        };
      };

      /**
       * dialog cancel
       *
       * @return {void}
       */
      $scope.cancel = function() {
        $modalStack.dismissAll('canceled');
      };

      /**
       * dialog save
       *
       * @param {number} status
       * - 1: Publish
       * - 2: Approve
       * - 3: Draft
       * - 4: Disapprove
       * @return {void}
       */
      $scope.save = function(status) {
        $scope.sending = true;

        $http.get($scope.PLUGIN_EDIT_URL + 'form/' +
                  $scope.frameId + '/' + Math.random() + '.json')
            .success(function(data) {
              //フォームエレメント生成
              var form = $('<div>').html(data);

              //セキュリティキーセット
              $scope.edit.data._Token.key =
                  $(form).find('input[name="data[_Token][key]"]').val();
              $scope.edit.data._Token.fields =
                  $(form).find('input[name="data[_Token][fields]"]').val();
              $scope.edit.data._Token.unlocked =
                  $(form).find('input[name="data[_Token][unlocked]"]').val();

              //ステータスセット
              $scope.edit.data.Announcement.status = status;

              //登録情報をPOST
              $scope.sendPost($scope.edit);
            })
            .error(function(data) {
              //keyの取得に失敗
              $scope.flash.danger(data.name);
              $scope.sending = false;
            });
      };

      /**
       * send post
       *
       * @param {Object.<string>} postParams
       * @return {void}
       */
      $scope.sendPost = function(postParams) {
        $http.post($scope.PLUGIN_EDIT_URL + 'edit/' +
                $scope.frameId + '/' + Math.random() + '.json',
            $.param(postParams),
            {headers: {'Content-Type': 'application/x-www-form-urlencoded'}})
          .success(function(data) {
              angular.copy(data.announcement, $scope.announcement);
              $scope.flash.success(data.name);
              $modalStack.dismissAll('saved');
            })
          .error(function(data) {
              if (typeof data.errors === 'object') {
                $scope.errors = data.errors;
              } else {
                $scope.flash.danger(data.name);
              }
            })
          .finally (function() {
              $scope.sending = false;
            });
      };

      /**
       * Comment list of prev page
       *
       * @return {void}
       */
      $scope.prevComments = function() {
        if (! $scope.comments.hasPrev) {
          return;
        }
        $scope.getComments($scope.comments.current - 1);
      };

      /**
       * Comment list of next page
       *
       * @return {void}
       */
      $scope.nextComments = function() {
        if (! $scope.comments.hasNext) {
          return;
        }
        $scope.getComments($scope.comments.current + 1);
      };

      /**
       * get comments
       *
       * @return {void}
       */
      $scope.getComments = function(page) {
        $http.get($scope.PLUGIN_EDIT_URL + 'comment/' +
                  $scope.frameId + '/page:' + page + '.json')
            .success(function(data) {
              $scope.comments.current = data.comments.current;
              $scope.comments.hasPrev = data.comments.hasPrev;
              $scope.comments.hasNext = data.comments.hasNext;
              $scope.comments.data = data.comments.data;
            })
            .error(function(data) {
              //keyの取得に失敗
              $scope.flash.danger(data.name);
            });
      };
    });
