/* global angular:false
 */
angular.module('galatea.controllers.product', ['ngRoute', 'ngCookies', 'angularFileUpload', 'resources']).config(function ($routeProvider) {
    'use strict';

    $routeProvider.when('/criar-projeto', {'templateUrl' : 'views/product/create.html', 'controller' : 'ProductCreateController'});
    $routeProvider.when('/categoria/:categoryId/:subcategoryId?', {'templateUrl' : 'views/product/list.html', 'controller' : 'ProductListController'});
    $routeProvider.when('/projeto/:projectId', {'templateUrl' : 'views/product/details.html', 'controller' : 'ProductDetailsController'});
    $routeProvider.when('/produto/:productId', {'templateUrl' : 'views/product/details.html', 'controller' : 'ProductDetailsController'});
}).controller('ProductCreateController', function ($rootScope, $scope, $location, $cookieStore, $fileUploader, products, categories) {
    'use strict';

    $scope.product = new products({categories : [], measures : [], materials : []});
    $scope.categories = categories.query();
    $scope.uploader = $fileUploader.create({'method' : 'post', 'headers' : {'x-xsrf-token' : $cookieStore.get('XSRF-TOKEN')}});
    $scope.uploader.bind('beforeupload', function (event, item) {
        item.url = 'products/' + $scope.product.productId + '/images';
    });
    $scope.uploader.bind('completeall', function () {
        $scope.success = 'Produto enviado com sucesso';
        $location.path('/');
    });

    $scope.addCategory = function () {
        $scope.product.categories.push($scope.categories[0].categoryId);
    };

    $scope.addMeasure = function () {
        $scope.product.measures.push({});
    };

    $scope.addMaterial = function () {
        $scope.product.materials.push({});
    };

    $scope.save = function () {
        $scope.product.$save(function () {
            $scope.uploader.uploadAll();
        });
    };
}).controller('ProductListController', function ($scope, $routeParams, products) {
    'use strict';

    $scope.products = products.query({'categoryId' : $routeParams.categoryId});
}).controller('ProductDetailsController', function ($scope, $routeParams, products) {
    'use strict';

    $scope.product = products.get({'productId' : $routeParams.productId});
});
