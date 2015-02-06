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
// NetCommonsApp.controller('Announcements',
//     function($scope, $sce, NetCommonsBase, NetCommonsWorkflow) {

//       /**
//        * plugin
//        *
//        * @type {object}
//        */
//       $scope.plugin = NetCommonsBase.initUrl('announcements', 'announcements');

//       /**
//        * workflow
//        *
//        * @type {object}
//        */
//       $scope.workflow = NetCommonsWorkflow.new($scope);

//       /**
//        * Announcement
//        *
//        * @type {Object.<string>}
//        */
//       $scope.announcement = {};

//       /**
//        * post object
//        *
//        * @type {Object.<string>}
//        */
//       $scope.edit = {
//         _method: 'POST',
//         data: {
//           _Token: {
//             key: '',
//             fields: '',
//             unlocked: ''
//           }
//         }
//       };

//       /**
//        * Initialize
//        *
//        * @return {void}
//        */
//       $scope.initialize = function(frameId, data) {
//         console.debug(data);
//         $scope.frameId = frameId;
//         $scope.announcement = data.announcement;
//       };

//       /**
//        * Show manage dialog
//        *
//        * @return {void}
//        */
//       $scope.showSetting = function() {
//         NetCommonsBase.showSetting(
//             $scope.plugin.getUrl('view', $scope.frameId + '.json'),
//             $scope.setEditData,
//             {templateUrl: $scope.plugin.getUrl('setting', $scope.frameId),
//               scope: $scope,
//               controller: 'Announcements.edit'}
//         );
//       };

//       /**
//        * dialog initialize
//        *
//        * @return {void}
//        */
//       $scope.setEditData = function(data) {
//         //workflow初期化
//         $scope.workflow.clear();

//         //最新データセット
//         if (data) {
//           $scope.announcement = data.announcement;
//           $scope.workflow.init('announcements',
//                                $scope.announcement.key,
//                                data['comments']);
//         }

//         //編集データセット
//         // $scope.announcement = {
//         //   content: $scope.announcement.content,
//         //   status: $scope.announcement.status,
//         //   block_id: $scope.announcement.block_id,
//         //   key: $scope.announcement.key,
//         //   id: $scope.announcement.id
//         // };
//         // $scope.comment = {
//         //   comment: $scope.announcement.Comment.comment
//         // };
//         // $scope.frame = {
//         //   id: $scope.announcement.Frame.id
//         // };

//         $scope.workflow.currentStatus = $scope.announcement.status;
//         $scope.workflow.editStatus = $scope.announcement.status;
//         $scope.workflow.input.comment = $scope.comment.comment;
//       };

//       /**
//        * htmlContent method
//        *
//        * @return {string}
//        */
//       $scope.htmlContent = function() {
//         //ng-bind-html では、style属性まで消えてしまうため
//         return $sce.trustAsHtml($scope.announcement.content);
//       };

//       /**
//        * published method
//        *
//        * @return {void}
//        */
//       $scope.publish = function() {
//         $scope.setEditData();
//         $scope.announcement.status = NetCommonsBase.STATUS_PUBLISHED;

//         NetCommonsBase.save(
//             $scope,
//             null,
//             $scope.plugin.getUrl('token', $scope.frameId + '.json'),
//             $scope.plugin.getUrl('edit', $scope.frameId + '.json'),
//             $scope.edit,
//             function(data) {
//               angular.copy(data.results.announcement, $scope.announcement);
//             });
//       };
//     });


/**
 * Announcements.edit Javascript
 *
 * @param {string} Controller name
 * @param {function($scope, $modalStack)} Controller
 */
NetCommonsApp.controller('Announcements',
  function($scope, NetCommonsBase, NetCommonsWysiwyg,
           NetCommonsTab, NetCommonsUser, NetCommonsWorkflow) {

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
       * workflow
       *
       * @type {object}
       */
      $scope.workflow = NetCommonsWorkflow.new($scope);

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
      // $scope.form = {};

      /**
       * master
       *
       * @type {object}
       */
      // $scope.master = {};

      /**
       * Initialize
       *
       * @return {void}
       */
      $scope.initialize = function(data) {
        // $scope.form = form;
        $scope.announcements = angular.copy(data.announcements);
        // console.debug(typeof data.announcements.id == 'undefined');
        // console.debug($scope.announcements.id);
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
        console.debug(2);
        // $scope.master = angular.copy($scope.announcement);
        // $scope.announcement.status = status;
        // $scope.workflow.editStatus = status;
        // $scope.comment = $scope.workflow.input.comment;
        // console.debug($scope.announcement.status);

        // NetCommonsBase.save(
        //     $scope,
        //     $scope.form,
        //     $scope.plugin.getUrl('token', $scope.frameId + '.json'),
        //     $scope.plugin.getUrl('edit', $scope.frameId + '.json'),
        //     $scope.edit,
        //     function(data) {
        //       angular.copy(data.results.announcement, $scope.announcement);
        //     });
        // NetCommonsBase.post(
        //   $scope.plugin.getUrl('edit', $scope.frameId + '.json'),
        //   $scope.edit
        // );
      };

      // $scope.reset = function() {
      //   $scope.user = angular.copy($scope.master);
      // };

      // $scope.reset();
    });
