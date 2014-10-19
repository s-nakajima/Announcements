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
       * Announcements plugin manage url
       *
       * @const
       */
      $scope.PLUGIN_EDIT_URL = '/announcements/announcement_edit/';

      /**
       * Announcements plugin manage url
       *
       * @const
       */
      $scope.PLUGIN_DISPALAY_CHANGE_URL = '/announcements/announcement_display_change/';

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
       * Initialize
       *
       * @return {void}
       */
      $scope.changeTab = function(tab) {
        var templateUrl = '';
        var controller = '';
        switch (tab) {
          case 'edit':
            templateUrl = $scope.PLUGIN_EDIT_URL + 'view/' + $scope.frameId;
            controller = 'Announcements.edit';
            break;
          case 'displayChange':
            templateUrl = $scope.PLUGIN_DISPALAY_CHANGE_URL + 'view/' + $scope.frameId;
            controller = 'Announcements.displayChange';
            break;
           default:
            return;
        }

        $modal.open({
          templateUrl: templateUrl,
          controller: controller,
          backdrop: 'static',
          scope: $scope
        }).result.then(
          function(result) {
            console.log($scope.announcement.Announcement.status);
          },
          function(reason) {}
        );
      };

      /**
       * Show manage dialog
       *
       * @return {void}
       */
      $scope.showManage = function() {
        $scope.changeTab('edit');
      };
    });


/**
 * Announcements.edit Javascript
 *
 * @param {string} Controller name
 * @param {function(scope, http, sce, modalInstance, dialogs)} Controller
 */
NetCommonsApp.controller('Announcements.displayChange',
                         function($scope, $http, $sce, $modalInstance) {

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
      $scope.save = function() {
        console.log('Announcements.displayChange.save');
        $modalInstance.close();
      };
    });


/**
 * Announcements.edit Javascript
 *
 * @param {string} Controller name
 * @param {function(scope, http, sce, modalInstance, dialogs)} Controller
 */
NetCommonsApp.controller('Announcements.edit',
                         function($scope, $http, $sce, $modalInstance) {

      ////todo: 後で消す
      //$scope.tinymceOptions = {
      //  //mode: 'exact',
      //  menubar: ' ',
      //  plugins: 'preview textcolor advlist autolink charmap code' +
      //            ' link fullscreen autoresize',
      //  toolbar: 'preview | fullscreen | undo redo  |' +
      //      ' forecolor |' +
      //      ' styleselect |' +
      //      ' bold italic |' +
      //      ' alignleft aligncenter alignright alignjustify |' +
      //      ' bullist numlist outdent indent |' +
      //      ' link |',
      //  autoresize_min_height: 300//,
      //  //autoresize_min_height: 300
      //};

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
        $http.get($scope.PLUGIN_EDIT_URL + 'form/' +
                  $scope.frameId + '/' + Math.random() + '.json')
            .success(function(data) {
              //フォームエレメント生成
              var form = $('<div>').html(data);

              //postフォームに値セット
              var findElement = 'select[name="data[Announcement][status]"]';
              $scope.announcement.Announcement.status = status;
              $(form).find(findElement).val(status);

              var findElement = 'textarea[name="data[Announcement][content]"]';
              var content = $scope.announcement.Announcement.content;
              $(form).find(findElement).val(content);

              //postパラメータ生成
              var formSerialize = $(form).find('form').serializeArray();
              console.log(formSerialize);

              //登録情報をPOST
              $scope.post(formSerialize);
            })
            .error(function(data, status, headers) {
              //keyの取得に失敗
              console.log(data);
              console.log(status);
              console.log(headers);
              if (! data) {
                data = {message: 'Bad Request', status: status};
              }
              //todo:後でメッセージ処理追加
            });
      };

      /**
       * send post
       *
       * @param {Object.<string>} postParams
       * @return {void}
       */
      $scope.post = function(postParams) {
        $http.post($scope.PLUGIN_POST_URL + 'post/' +
            $scope.frameId + '/' + Math.random() + '.json',
            $.param(postParams),
            {headers: {'Content-Type': 'application/x-www-form-urlencoded'}})
          .success(function(data) {
              //$scope.notepad = data.data;
              //$scope.showResult('success', data.message);

              //$modalInstance.close($scope);
              $modalInstance.close();
              console.log(data);
            })
          .error(function(data, status, headers) {
              //if (! data.message) {
              //  $scope.showResult('error', headers);
              //} else {
              //  $scope.showResult('error', data.message);
              //}
              console.log(data);
              console.log(status);
              console.log(headers);
            });
      };

    });
