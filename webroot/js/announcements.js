/**
 * @fileoverview Announcements Javascript
 * @author nakajimashouhei@gmail.com (Shohei Nakajima)
 */


/**
 * Announcements Javascript
 *
 * @param {string} Controller name
 * @param {function(scope, http, sce, timeout)} Controller
 */
NetCommonsApp.controller('Announcements',
                         function($scope , $http, $sce, $timeout) {

      /**
       * Announcements plugin URL
       *
       * @const
       */
      $scope.PLUGIN_URL = '/announcements/announcements/';

});
