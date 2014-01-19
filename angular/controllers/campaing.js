/* global angular:false
 */
angular.module('galatea.controllers.campaing', ['ngRoute', 'resources']).config(function ($routeProvider) {
    'use strict';

    $routeProvider.when('/abril', {'templateUrl' : 'views/campaing/abril.html', 'controller' : 'CampaingAbrilController'});
}).controller('CampaingAbrilController', function ($scope, $location, campaign) {
    'use strict';

    $scope.campaign = new campaign();
    $scope.save = function () {
        $scope.campaign.$save(function () {
            $location.path('/');
        });
    };
});
