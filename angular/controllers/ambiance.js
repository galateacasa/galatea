/* global angular:false
 */
angular.module('galatea.controllers.ambiance', ['ngRoute', 'angularFileUpload', 'resources']).config(function ($routeProvider) {
    'use strict';

    $routeProvider.when('/inspire-me/:ambianceId?', {'templateUrl' : 'views/ambiance/list.html', 'controller' : 'AmbianceListController'});
    $routeProvider.when('/inspire-me/categorias/:categoryId', {'templateUrl' : 'views/ambiance/list.html', 'controller' : 'AmbianceListController'});
}).controller('AmbianceCreateController', function ($rootScope, $scope, $location, $fileUploader, ambiance, category) {
    'use strict';

    $scope.newAmbiance = new ambiance({products : []});
    $scope.categories = category.query();
    $scope.uploader = $fileUploader.create({'method' : 'put'});
    $scope.uploader.bind('beforeupload', function (event, item) {
        item.url = 'ambiances/' + $scope.newAmbiance._id + '/images';
    });
    $scope.uploader.bind('completeall', function () {
        $scope.success = 'Ambiente enviado com sucesso';
        $location.path('/');
    });

    $scope.addProduct = function () {
        $scope.newAmbiance.products.push({});
    };

    $scope.save = function () {
        $scope.newAmbiance.$save(function () {
            $scope.uploader.uploadAll();
        });
    };
}).controller('AmbianceListController', function ($rootScope, $scope, $routeParams, ambiance) {
    'use strict';

    if ($routeParams.ambianceId) {
        $scope.ambiance = ambiance.get({'ambianceId' : $routeParams.ambianceId});
    }

    $scope.loadAmbiance = function (ambiance) {
        $scope.ambiance = ambiance;
    };

    if ($routeParams.categoryId) {
        $scope.ambiances = ambiance.query({'category' : $routeParams.categoryId});
    } else {
        $scope.ambiances = ambiance.query();
    }
});
