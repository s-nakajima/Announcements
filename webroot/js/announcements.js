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
    function($scope, $sce,
             NetCommonsBase, NetCommonsWorkflow, NetCommonsFlash) {

      /**
       * plugin
       *
       * @type {object}
       */
      $scope.plugin = NetCommonsBase.initUrl('announcements', 'announcements');

      /**
       * workflow
       *
       * @type {object}
       */
      $scope.workflow = NetCommonsWorkflow.new($scope);

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
        NetCommonsBase.showSetting(
            $scope.plugin.getUrl('edit', $scope.frameId + '.json'),
            $scope.setEditData,
            {templateUrl: $scope.plugin.getUrl('setting', $scope.frameId),
              scope: $scope,
              controller: 'Announcements.edit'}
        );
      };

      /**
       * dialog initialize
       *
       * @return {void}
       */
      $scope.setEditData = function(data) {
        //workflow初期化
        $scope.workflow.clear();

        //最新データセット
        if (data) {
          $scope.announcement = data.announcement;
          $scope.workflow.init('announcements',
                               $scope.announcement.Announcement.key,
                               data['comments']);
        }

        //編集データセット
        $scope.edit.data = $scope.announcement;

        $scope.workflow.currentStatus = $scope.announcement.Announcement.status;
        $scope.workflow.editStatus = $scope.edit.data.Announcement.status;
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

      /**
       * published method
       *
       * @return {void}
       */
      $scope.publish = function() {
        $scope.setEditData();
        $scope.edit.data.Announcement.status = NetCommonsBase.STATUS_PUBLISHED;

        NetCommonsBase.save(
            null,
            $scope.plugin.getUrl('edit', $scope.frameId + '.json'),
            $scope.edit,
            function(data) {
              angular.copy(data.results.announcement, $scope.announcement);
              NetCommonsFlash.success(data.name);
            });
      };
    });


/**
 * Announcements.edit Javascript
 *
 * @param {string} Controller name
 * @param {function($scope, $modalStack)} Controller
 */
NetCommonsApp.controller('Announcements.edit',
    function($scope, $modalStack, NetCommonsBase, NetCommonsWysiwyg,
             NetCommonsTab, NetCommonsUser, NetCommonsFlash) {

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
       * serverValidationClear method
       *
       * @param {number} users.id
       * @return {string}
       */
      $scope.serverValidationClear = NetCommonsBase.serverValidationClear;

      /**
       * form
       *
       * @type {form}
       */
      $scope.form = {};

      /**
       * Initialize
       *
       * @return {void}
       */
      $scope.initialize = function(form) {
        $scope.form = form;
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
        $scope.workflow.editStatus = status;
        $scope.edit.data.Comment.comment = $scope.workflow.input.comment;

        NetCommonsBase.save(
            $scope.form,
            $scope.plugin.getUrl('edit', $scope.frameId + '.json'),
            $scope.edit,
            function(data) {
              angular.copy(data.results.announcement, $scope.announcement);
              NetCommonsFlash.success(data.name);
              $modalStack.dismissAll('saved');
            });
      };
    });
