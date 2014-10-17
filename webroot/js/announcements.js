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
      $scope.PLUGIN_MANAGE_URL = '/announcements/announcements/manage/';

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
        ////管理ダイアログ取得のURL
        //var url = $scope.PLUGIN_MANAGE_URL + $scope.frameId;
        //
        ////管理ダイアログの取得
        //NetCommonsApp.run(function($templateCache) {
        //  $http.get(url)
        //    .success(function(data) {
        //        $templateCache.put(url, data);
        //      })
        //    .error(function() {
        //        return false;
        //      });
        //});

        //console.log($scope.announcement);

        $modal.open({
          templateUrl: $scope.PLUGIN_MANAGE_URL + $scope.frameId,
          controller: 'Announcements.edit',
          backdrop: 'static',
          scope: $scope
        });

        ////ダイアログの表示
        //dialogs.create(url, 'Announcements.edit',
        //    {frameId: $scope.frameId,
        //      announcement: $scope.announcement,
        //      tinymceOptions: $scope.tinymceOptions},
        //    {keyboard: false, backdrop: 'static'})
        //  .result.then(
        //        function(announcement) {
        //          $scope.announcement = announcement;
        //        },
        //        function() {
        //          $scope.name = 'You decided not to enter in your name.';
        //        }
        //    );
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

      /**
       * Announcements plugin edit form url
       *
       * @const
       */
      $scope.PLUGIN_FORM_URL = '/announcements/announcement_edit/form/';

      /**
       * Announcements plugin edit form url
       *
       * @const
       */
      $scope.PLUGIN_POST_URL = '/announcements/announcement_edit/post/';

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
        $http.get($scope.PLUGIN_FORM_URL +
                  $scope.frameId + '/' + Math.random())
            .success(function(data) {
              //フォームエレメント生成
              var form = $('<div>').html(data);

              //postフォームに値セット
              var findElement = 'select[name="data[Announcement][status]"]';
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
            .error(function(data, status) {
              //keyの取得に失敗
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
        $http.post($scope.PLUGIN_POST_URL +
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
            });
      };

    });
