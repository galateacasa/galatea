/* global angular:false
 */
angular.module('galatea.controllers.newsletter', ['resources', 'ngCookies']).config(function () {
    'use strict';

}).controller('NewsletterController', function ($scope, $rootScope, $cookieStore, newsletter) {
    'use strict';

    $scope.newsletter = new newsletter();

    $rootScope.popUp = !$cookieStore.get('newsletter');

    $scope.close = function () {
        $cookieStore.put('newsletter', true);
        $rootScope.popUp = false;
    };

    $scope.save = function () {
        $scope.newsletter.$save(function () {
            $scope.success = 'Obrigado por ser inscrever em nossa newsletter!!';
            $scope.newsletter = new newsletter();
        });
        $cookieStore.put('newsletter', true);
        $rootScope.popUp = false;
    };
});
