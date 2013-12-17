/* global angular:false
 */
angular.module('galatea.controllers.ambiance', ['ngRoute', 'angularFileUpload', 'resources']).config(function ($routeProvider) {
    'use strict';

    $routeProvider.when('/criar-ambiente', {'templateUrl' : 'views/ambiance/create.html', 'controller' : 'AmbianceCreateController'});
    $routeProvider.when('/inspire-me/:ambianceId?', {'templateUrl' : 'views/ambiance/list.html', 'controller' : 'AmbianceListController'});
}).controller('AmbianceCreateController', function ($rootScope, $scope, $location, $fileUploader, ambiance, category) {
    'use strict';

    $scope.ambiance = new ambiance({products : []});
    $scope.categories = category.query();
    $scope.uploader = $fileUploader.create({'method' : 'put'});
    $scope.uploader.bind('beforeupload', function (event, item) {
        item.url = 'ambiances/' + $scope.ambiance.ambianceId + '/images';
    });
    $scope.uploader.bind('completeall', function () {
        $scope.success = 'Ambiente enviado com sucesso';
        $location.path('/');
    });

    $scope.addProduct = function () {
        $scope.ambiance.products.push({});
    };

    $scope.save = function () {
        $scope.ambiance.$save(function () {
            $scope.uploader.uploadAll();
        });
    };
}).controller('AmbianceListController', function ($scope, $routeParams, ambiance) {
    'use strict';

    if ($routeParams.ambianceId) {
        $scope.ambiance = ambiance.get({'ambianceId' : $routeParams.ambianceId});
    }

    $scope.loadAmbiance = function (ambiance) {
        $scope.ambiance = ambiance;
    }

    $scope.ambiances = ambiance.query();
});
