/**
 * @fileoverview Announcements Javascript
 * @author nakajimashouhei@gmail.com (Shohei Nakajima)
 */


/**
 * Announcements Javascript
 *
 * @param {string} Controller name
 * @param {function($scope, $http, $sce)} Controller
 */
NetCommonsApp.controller('Announcements',
                         function($scope, $http, $sce) {

      /**
       * Announcements plugin view url
       *
       * @const
       */
      $scope.PLUGIN_INDEX_URL = '/announcements/announcements/';

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
        $http.get($scope.PLUGIN_INDEX_URL + 'edit/' +
                  $scope.frameId + '.json', {cache: false})
            .success(function(data) {
              //最新データセット
              $scope.setEditData(data.results);

              var templateUrl = $scope.PLUGIN_INDEX_URL +
                                'setting/' + $scope.frameId;
              $scope.showDialog($scope, templateUrl, 'Announcements.edit');
            })
            .error(function(data) {
              $scope.flash.danger(data.name);
            });
      };

      /**
       * dialog initialize
       *
       * @return {void}
       */
      $scope.setEditData = function(data) {
        if (data) {
          //最新データセット
          $scope.announcement = data.announcement;
          $scope.comments.init(
              data.comments,
              'announcements',
              $scope.announcement.Announcement.key
          );
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
          plugin_key: 'announcements',
          content_key: $scope.announcement.Announcement.key,
          comment: ''
        };
        $scope.edit.data.Frame = {
          id: $scope.frameId
        };
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
      $scope.validate = function(form) {
        //コメントチェック
        var editStatus = $scope.edit.data.Announcement.status;
        var status = $scope.announcement.Announcement.status;
        if ($scope.comments.input.hasErrorTarget(status, editStatus) &&
                $scope.comments.input.invalid(form)) {
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
      $scope.save = function(form, status) {
        $scope.edit.data.Announcement.status = status;
        if (! $scope.validate(form)) {
          return;
        }

        $scope.sending = true;
        $http.get($scope.PLUGIN_INDEX_URL + 'token/' +
                  $scope.frameId + '.json', {cache: false})
            .success(function(data) {
              $scope.edit.data._Token = data._Token;

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
        $http.post(
            $scope.PLUGIN_INDEX_URL + 'edit/' + $scope.frameId + '.json',
            $.param(postParams),
            {cache: false,
              headers: {'Content-Type': 'application/x-www-form-urlencoded'}})
          .success(function(data) {
              angular.copy(data.results.announcement, $scope.announcement);
              $scope.flash.success(data.name);
              $modalStack.dismissAll('saved');
            })
          .error(function(data) {
              $scope.flash.danger(data.name);
            })
          .finally (function() {
              $scope.sending = false;
            });
      };

    });
