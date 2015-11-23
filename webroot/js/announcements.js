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
 * Announcements Javascript
 *
 * @param {string} Controller name
 * @param {function($scope, NetCommonsWysiwyg)} Controller
 */
NetCommonsApp.controller('AnnouncementsDummy',
    function($scope, UserSearchByUserSelected) {

      /**
       * Show user search method(e.g)
       *
       * @param {number} users.id
       * @return {void}
       */
      $scope.showUserSearch = function(id) {
        return UserSearchByUserSelected($scope, id).result.then(
            function(result) {
              console.log(result);
            },
            function(reason) {}
        );
      };
    });
