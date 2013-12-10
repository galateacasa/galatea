/* global angular:false
 */
angular.module('galatea.controllers.newsletter', ['resources']).config(function () {
    'use strict';

}).controller('NewsletterController', function ($scope, newsletters) {
    'use strict';

    $scope.newsletter = new newsletters();

    $scope.save = function () {
        $scope.newsletter.$save(function () {
            $scope.success = 'Obrigado por ser inscrever em nossa newsletter!!';
            $scope.newsletter = new newsletters();
        });
    };
});
