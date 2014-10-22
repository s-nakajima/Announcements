/**
 * @fileoverview Announcements Javascript
 * @author nakajimashouhei@gmail.com (Shohei Nakajima)
 */


/**
 * Announcements Javascript
 *
 * @param {string} Controller name
 * @param {function(scope, http, sce, dialogs)} Controller
 */
//NetCommonsApp.requires.push('dialogs.main');
NetCommonsApp.controller('Announcements',
                         function($scope, $http, $sce, dialogs, $modal) {

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
        var templateUrl = $scope.PLUGIN_EDIT_URL +
                              'view/' + $scope.frameId + '.json';
        var controller = 'Announcements.edit';

        $modal.open({
          templateUrl: templateUrl,
          controller: controller,
          backdrop: 'static',
          scope: $scope
        }).result.then(
            function(result) {},
            function(reason) {
              if (typeof reason.data === 'object') {
                //openによるエラー
                $scope.flash.danger(reason.status + ' ' + reason.data.name);
              } else {
                //キャンセル
                $scope.flash.close();
              }
            }
        );
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
 * @param {function(scope, http, modalInstance)} Controller
 */
NetCommonsApp.controller('Announcements.edit',
                         function($scope, $http, $modalInstance) {

      /**
       * sending
       *
       * @type {string}
       */
      $scope.sending = false;

      /**
       * edit _method
       *
       * @type {Object.<string>}
       */
      $scope.edit = {
        _method: 'POST'
      };

      /**
       * edit data
       *
       * @type {Object.<string>}
       */
      $scope.edit.data = {
        Announcement: {
          content: $scope.announcement.Announcement.content,
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

      /**
       * dialog cancel
       *
       * @return {void}
       */
      $scope.cancel = function() {
        $modalInstance.dismiss('canceled');
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
            .error(function(data, status) {
              //keyの取得に失敗
              $scope.flash.danger(status + ' ' + data.name);
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
        $http.post($scope.PLUGIN_EDIT_URL + 'edit/' + Math.random() + '.json',
            $.param(postParams),
            {headers: {'Content-Type': 'application/x-www-form-urlencoded'}})
          .success(function(data) {
              angular.copy(data.announcement, $scope.announcement);
              $scope.flash.success(data.name);
              $modalInstance.close();
            })
          .error(function(data, status) {
              $scope.flash.danger(status + ' ' + data.name);
              $scope.sending = false;
            });
      };

    });


/**
 * Announcements.publish Javascript
 *
 * @param {string} Controller name
 * @param {function(scope, http)} Controller
 */
NetCommonsApp.controller('Announcements.publish',
                         function($scope, $http) {

      /**
       * sending
       *
       * @type {string}
       */
      $scope.sending = false;

      /**
       * edit _method
       *
       * @type {Object.<string>}
       */
      $scope.edit = {
        _method: 'POST'
      };

      /**
       * edit data
       *
       * @type {Object.<string>}
       */
      $scope.edit.data = {
        Announcement: {
          content: $scope.announcement.Announcement.content,
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

      /**
       * publish
       *
       * @param {number} status
       * - 1: Publish
       * @return {void}
       */
      $scope.save = function(status) {
        if (status !== $scope.STATUS_PUBLISHED) {
          return false;
        }
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
            .error(function(data, status) {
              //keyの取得に失敗
              $scope.flash.danger(status + ' ' + data.name);
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
        $http.post($scope.PLUGIN_EDIT_URL + 'edit/' + Math.random() + '.json',
            $.param(postParams),
            {headers: {'Content-Type': 'application/x-www-form-urlencoded'}})
          .success(function(data) {
              angular.copy(data.announcement, $scope.announcement);
              $scope.flash.success(data.name);
              $scope.sending = false;
            })
          .error(function(data, status) {
              $scope.flash.danger(status + ' ' + data.name);
              $scope.sending = false;
            });
      };

    });
