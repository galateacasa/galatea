/* global angular:false
 */
angular.module('galatea.controllers.ambiance', ['ngRoute', 'angularFileUpload', 'resources']).config(function ($routeProvider) {
    'use strict';

    $routeProvider.when('/criar-ambiente', {'templateUrl' : 'views/ambiance/create.html', 'controller' : 'AmbianceCreateController'});
    $routeProvider.when('/inspire-me', {'templateUrl' : 'views/ambiance/list.html', 'controller' : 'AmbianceListController'});
    $routeProvider.when('/inspire-me/:ambianceId', {'templateUrl' : 'views/ambiance/details.html', 'controller' : 'AmbianceDetailsController'});
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

    $scope.ambiances = ambiance.query();
}).controller('AmbianceDetailsController', function ($scope, $routeParams, ambiance) {
    'use strict';

    $scope.ambiance = ambiance.get({'ambianceId' : $routeParams.ambianceId});
});
