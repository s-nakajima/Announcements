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
                         function($scope, $http, $sce, dialogs) {

//    //$scope.tinymceModel = null;
//  $scope.tinymceOptions = {
//    mode: 'exact',
//    menubar: ' ',
//    plugins: 'textcolor advlist autolink autoresize charmap code link ',
//    toolbar: 'undo redo  |' +
//        ' forecolor |' +
//        ' styleselect |' +
//        ' bold italic |' +
//        ' alignleft aligncenter alignright alignjustify |' +
//        ' bullist numlist outdent indent |' +
//        ' link |'
//  };

      /**
       * Announcements plugin url
       *
       * @const
       */
      $scope.PLUGIN_URL = '/announcements/';

      /**
       * Announcements plugin view url
       *
       * @const
       */
      $scope.PLUGIN_FRAME_URL = $scope.PLUGIN_URL + 'announcements/';

      /**
       * Announcements plugin edit manage url
       *
       * @const
       */
      $scope.PLUGIN_MANAGE_URL = $scope.PLUGIN_FRAME_URL + 'manage/';

//      /**
//       * Announcements plugin edit manage url
//       *
//       * @const
//       */
//      $scope.PLUGIN_EDIT_URL = $scope.PLUGIN_URL + 'announcement_edit/';
//
//      /**
//       * Announcements plugin edit view url
//       *
//       * @const
//       */
//      $scope.PLUGIN_EDIT_POST_URL =
//                      $scope.PLUGIN_URL + 'announcement_edit/post';

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
        //管理ダイアログ取得のURL
        var url = $scope.PLUGIN_MANAGE_URL + $scope.frameId

        //管理ダイアログの取得
        NetCommonsApp.run(function($templateCache) {
            $http({method: 'GET', url: url})
              .success(function(data) {
                 $templateCache.put(url, data);
                })
              .error(function() {
                  return false;
                });
          });

//console.log($scope.tinymceOptions);
console.log($scope.announcement);

        //ダイアログの表示
        dialogs.create(url, 'Announcements.edit',
                      {tinymceOptions: $scope.tinymceOptions,
                        announcement: $scope.announcement},
                      {keyboard: false, backdrop: 'static'})
          .result.then(
                function(status) {
                    $scope.status = status;
                  },
                function() {
                    $scope.name = 'You decided not to enter in your name, that makes me sad.';
                  }
            );
      };
});

/**
 * Announcements.edit Javascript
 *
 * @param {string} Controller name
 * @param {function(scope, http, modalInstance, dialogs)} Controller
 */
NetCommonsApp.controller('Announcements.edit',
                         function($scope, $http, $modalInstance, data, dialogs) {

    $scope.tinymceModel = null;
    $scope.tinymceOptions = data.tinymceOptions;

//    //todo: 後で消す
//    $scope.tinymceOptions = {
//      //mode: 'exact',
//      menubar: ' ',
//      plugins: 'preview textcolor advlist autolink charmap code link fullscreen autoresize',
//      toolbar: 'preview | fullscreen | undo redo  |' +
//          ' forecolor |' +
//          ' styleselect |' +
//          ' bold italic |' +
//          ' alignleft aligncenter alignright alignjustify |' +
//          ' bullist numlist outdent indent |' +
//          ' link |',
//      autoresize_min_height: 300//,
//      //autoresize_min_height: 300
//    };

    /**
     * dialog cancel
     *
     * @return {void}
     */
	  $scope.cancel = function(){
	    $modalInstance.dismiss('canceled');
	  };

    /**
     * dialog save
     *
     * @return {void}
     */
	  $scope.save = function(status){



      $modalInstance.close(status);
	  };

	});

//
///**
// * Announcements.edit Javascript
// *
// * @param {string} Controller name
// * @param {function(scope, http, modalInstance, dialogs)} Controller
// */
//NetCommonsApp.controller('Announcements.edit',
//                         function($scope, $http, $modalInstance, dialogs) {
//
//    $scope.modalTitle = 'aaaaa';
//
//	  $scope.user = {name : ''};
//
//	  $scope.cancel = function(){
//	    $modalInstance.dismiss('canceled');
//	  }; // end cancel
//
//	  $scope.save = function(){
//
//      console.log($scope.PLUGIN_URL);
//
//        var message = 'FAQを削除してもよろしいですか？';
//
//        dialogs.confirm('', message, {size: 'sm'})
//          .result.then(
//            function(yes) {
//              //alert('yes');
//              $modalInstance.close($scope.user.name);
////              $http.delete('/frames/frames/' + frameId.toString())
////                .success(function(data, status, headers, config) {
////                    $scope.deleted = true;
////                  })
////                .error(function(data, status, headers, config) {
////                    alert(status);  // It should be error code
////                    return false;
////                  });
//            },
//            function(no) {
//              //alert('no');
//              //$modalInstance.close($scope.user.name);
//            });
//
//      //$modalInstance.close($scope.user.name);
//
//	  }; // end save
//
//	  $scope.hitEnter = function(evt){
//	    if(angular.equals(evt.keyCode,13) && !(angular.equals($scope.name,null) || angular.equals($scope.name,'')))
//					$scope.save();
//	  }; // end hitEnter
//	}); // end whatsYourNameCtrl
//
////NetCommonsApp.run(['$templateCache', function($templateCache) {
////    $templateCache.put('/dialogs/whatsyourname.html',
////      'sssssss');
////
////
//////    $templateCache.put('/announcements/' + 'announcements/' + 'manage/1',
//////      '<div class="modal"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><h4 class="modal-title"><span class="glyphicon glyphicon-star"></span> User\'s Name</h4></div><div class="modal-body"><ng-form name="nameDialog" novalidate role="form"><div class="form-group input-group-lg" ng-class="{true: \'has-error\'}[nameDialog.username.$dirty && nameDialog.username.$invalid]"><label class="control-label" for="username">Name:</label><input type="text" class="form-control" name="username" id="username" ng-model="user.name" ng-keyup="hitEnter($event)" required><span class="help-block">Enter your full name, first &amp; last.</span></div></ng-form></div><div class="modal-footer"><button type="button" class="btn btn-default" ng-click="cancel()">Cancel</button><button type="button" class="btn btn-primary" ng-click="save()" ng-disabled="(nameDialog.$dirty && nameDialog.$invalid) || nameDialog.$pristine">Save</button></div></div></div></div>');
////	}]); // end run / module
//

