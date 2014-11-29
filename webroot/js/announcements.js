/**
 * @fileoverview Announcements Javascript
 * @author nakajimashouhei@gmail.com (Shohei Nakajima)
 */


/**
 * Announcements Javascript
 *
 * @param {string} Controller name
 * @param {function($scope, $sce)} Controller
 */
NetCommonsApp.controller('Announcements',
     function($scope, $sce, NetCommonsBase, NetCommonsFlush, NetCommonsWorkflow) {

      /**
       * Announcements plugin view url
       *
       * @const
       */
      $scope.PLUGIN_INDEX_URL = '/announcements/announcements/';

      /**
       * workflow
       *
       * @type {object}
       */
      $scope.workflow = NetCommonsWorkflow.new($scope);
      $scope.workflow.comments.plugin_key = 'announcements';

      /**
       * Announcement
       *
       * @type {Object.<string>}
       */
      $scope.announcement = {};

      /**
       * post object
       *
       * @type {Object.<string>}
       */
      $scope.edit = {
        _method: 'POST',
        data: {
          _Token: {
            key: '',
            fields: '',
            unlocked: ''
          }
        }
      };

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
      $scope.showSetting = function() {
        NetCommonsBase.get(
            $scope.PLUGIN_INDEX_URL + 'edit/' + $scope.frameId + '.json')
            .success(function(data) {
               //最新データセット
              $scope.setEditData(data.results);

              NetCommonsBase.showDialog(
                  $scope.$id,
                  $scope.PLUGIN_INDEX_URL + 'setting/' + $scope.frameId,
                  'Announcements.edit');
            })
            .error(function(data) {
              NetCommonsFlush.danger(data.name);
            });
      };

      /**
       * dialog initialize
       *
       * @return {void}
       */
      $scope.setEditData = function(data) {
        $scope.workflow.clear();

        //最新データセット
        if (data) {
          $scope.announcement = data.announcement;
          $scope.workflow.init(data['comments']);
        }

        //編集データセット
        $scope.edit.data.Announcement = {
          content: $scope.announcement.Announcement.content,
          status: $scope.announcement.Announcement.status,
          block_id: $scope.announcement.Announcement.block_id,
          key: $scope.announcement.Announcement.key,
          id: $scope.announcement.Announcement.id
        };
        $scope.edit.data.Comment = {
          comment: $scope.announcement.Comment.comment
        };
        $scope.edit.data.Frame = {
          id: $scope.announcement.Frame.id
        };

        $scope.workflow.currentStatus = $scope.announcement.Announcement.status;
        $scope.workflow.editStatus = $scope.edit.data.Announcement.status;
        $scope.workflow.comments.content_key =
                                $scope.announcement.Announcement.key;
        $scope.workflow.input.comment = $scope.edit.data.Comment.comment;
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
 * @param {function($scope, $modalStack)} Controller
 */
NetCommonsApp.controller('Announcements.edit',
    function($scope, $modalStack,
             NetCommonsBase, NetCommonsWysiwyg, NetCommonsFlush,
             NetCommonsTab, NetCommonsUser) {

      /**
       * tab
       *
       * @type {object}
       */
      $scope.tab = NetCommonsTab.new();

      /**
       * show user information method
       *
       * @param {number} users.id
       * @return {string}
       */
      $scope.user = NetCommonsUser.new();

      /**
       * tinymce
       *
       * @type {object}
       */
      $scope.tinymce = NetCommonsWysiwyg.new();

      /**
       * sending
       *
       * @type {bool}
       */
      $scope.sending = false;

      /**
       * dialog cancel
       *
       * @return {void}
       */
      $scope.cancel = function() {
        $modalStack.dismissAll('canceled');
      };

      /**
       * validate
       *
       * @return {bool}
       */
      $scope.validate = function() {
        //コメントチェック
        if ($scope.workflow.input.hasErrorTarget() &&
                                    $scope.workflow.input.invalid()) {
          return false;
        }
        //本文チェック
        if ($scope.edit.data.Announcement.content === '') {
          return false;
        }
        return true;
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
        $scope.edit.data.Announcement.status = status;
        $scope.edit.data.Comment.comment = $scope.workflow.input.comment;
        $scope.workflow.editStatus = $scope.edit.data.Announcement.status;

        if (! $scope.validate()) {
          return;
        }

        $scope.sending = true;
        NetCommonsBase.get(
            $scope.PLUGIN_INDEX_URL + 'token/' + $scope.frameId + '.json')
            .success(function(data) {
              $scope.edit.data._Token = data._Token;

              //登録情報をPOST
              NetCommonsBase.post(
                  $scope.PLUGIN_INDEX_URL + 'edit/' + $scope.frameId + '.json',
                  $scope.edit)
              .success(function(data) {
                    angular.copy(data.results.announcement,
                                 $scope.announcement);
                    NetCommonsFlush.success(data.name);
                    $modalStack.dismissAll('saved');
                  })
              .error(function(data) {
                    NetCommonsFlush.danger(data.name);
                  })
              .finally (function() {
                    $scope.sending = false;
                  });
            })
            .error(function(data) {
              //keyの取得に失敗
              NetCommonsFlush.danger(data.name);
              $scope.sending = false;
            });
      };

    });
