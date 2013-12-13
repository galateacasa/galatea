/* global angular:false
 */
angular.module('galatea.controllers.product', ['ngRoute', 'angularFileUpload', 'resources']).config(function ($routeProvider) {
    'use strict';

    $routeProvider.when('/criar-projeto', {'templateUrl' : 'views/product/create.html', 'controller' : 'ProductCreateController'});
    $routeProvider.when('/categoria/:categoryId', {'templateUrl' : 'views/product/list.html', 'controller' : 'ProductListController'});
    $routeProvider.when('/projeto/:projectId', {'templateUrl' : 'views/product/details.html', 'controller' : 'ProductDetailsController'});
    $routeProvider.when('/produto/:productId', {'templateUrl' : 'views/product/details.html', 'controller' : 'ProductDetailsController'});
}).controller('ProductCreateController', function ($rootScope, $scope, $location, $fileUploader, product, category) {
    'use strict';

    $scope.product = new product({categories : [], measures : [], materials : []});
    category.query(function (categories) {
        var i, j;

        $scope.categories = [];
        for (i = 0; i < categories.length; i += 1) {
            for (j = 0; j < categories[i].subcategories.length; j += 1) {
                $scope.categories.push(categories[i].subcategories[j]);
            }
        }
    });
    $scope.uploader = $fileUploader.create({'method' : 'post'});
    $scope.uploader.bind('beforeupload', function (event, item) {
        item.url = 'products/' + $scope.product._id + '/images';
    });
    $scope.uploader.bind('completeall', function () {
        $scope.success = 'Produto enviado com sucesso';
        $location.path('/');
    });

    $scope.addCategory = function () {
        $scope.product.categories.push({});
    };

    $scope.addMeasure = function () {
        $scope.product.measures.push({});
    };

    $scope.addMaterial = function () {
        $scope.product.materials.push({});
    };

    $scope.save = function () {
        $scope.product.categories = $scope.product.categories.map(function (category) {
            return category._id;
        });
        $scope.product.$save(function () {
            $scope.uploader.uploadAll();
        });
    };
}).controller('ProductListController', function ($scope, $routeParams, product, category) {
    'use strict';

    $scope.category = category.get({'categoryId' : $routeParams.categoryId});
    $scope.products = product.query({'categoryId' : $routeParams.categoryId});
}).controller('ProductDetailsController', function ($rootScope, $scope, $routeParams, $location, product) {
    'use strict';

    $scope.cart = {};
    $scope.addToCart = function () {
        $rootScope.user.$addToCart({
            product : $scope.product._id,
            measure : $scope.cart.measure,
            material : $scope.cart.material,
            quantity : $scope.cart.quantity
        }, function () {
            $location.path('/carrinho-de-compras');
        });
    };

    $scope.product = product.get({'productId' : $routeParams.productId});
});
