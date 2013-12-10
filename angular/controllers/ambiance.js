/* global angular:false
 */
angular.module('galatea.controllers.ambiance', ['ngRoute', 'ngCookies', 'angularFileUpload', 'resources']).config(function ($routeProvider) {
    'use strict';

    $routeProvider.when('/criar-ambiente', {'templateUrl' : 'views/ambiance/create.html', 'controller' : 'AmbianceCreateController'});
    $routeProvider.when('/inspire-me', {'templateUrl' : 'views/ambiance/list.html', 'controller' : 'AmbianceListController'});
    $routeProvider.when('/inspire-me/:ambianceId', {'templateUrl' : 'views/ambiance/details.html', 'controller' : 'AmbianceDetailsController'});
}).controller('AmbianceCreateController', function ($rootScope, $scope, $location, $cookieStore, $fileUploader, ambiances, categories) {
    'use strict';

    $scope.ambiance = new ambiances({products : []});
    $scope.categories = categories.query();
    $scope.uploader = $fileUploader.create({'method' : 'put', 'headers' : {'x-xsrf-token' : $cookieStore.get('XSRF-TOKEN')}});
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
}).controller('AmbianceListController', function ($scope, $routeParams, ambiances) {
    'use strict';

    $scope.ambiances = ambiances.query();
}).controller('AmbianceDetailsController', function ($scope, $routeParams, ambiances) {
    'use strict';

    $scope.ambiance = ambiances.get({'ambianceId' : $routeParams.ambianceId});
});
