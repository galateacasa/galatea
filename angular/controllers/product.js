/* global angular:false
 */
angular.module('galatea.controllers.product', ['ngRoute', 'ngCookies', 'angularFileUpload', 'resources']).config(function ($routeProvider) {
    'use strict';

    $routeProvider.when('/criar-projeto', {'templateUrl' : 'views/product/create.html', 'controller' : 'ProductCreateController'});
    $routeProvider.when('/categoria/:categoryId/:subCategoryId?', {'templateUrl' : 'views/product/list.html', 'controller' : 'ProductListController'});
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
    $scope.subcategory = category.get({'categoryId' : $routeParams.subCategoryId});

    if ($routeParams.subCategoryId) {
        $scope.products = product.query({'categoryId' : $routeParams.subCategoryId});
    } else {
        $scope.products = product.query({'categoryId' : $routeParams.categoryId});
    }
}).controller('ProductDetailsController', function ($rootScope, $scope, $routeParams, $location, $cookieStore, product) {
    'use strict';

    $scope.addToCart = function () {
        $rootScope.cart.push({
            product : {
                '_id' : $scope.cart.product._id,
                'name' : $scope.cart.product.name,
                'slug' : $scope.cart.product.slug,
                'price' : $scope.cart.product.price,
                'deadline' : $scope.cart.product.deadline,
                'images' : $scope.cart.product.images
            },
            material : {
                '_id' : $scope.cart.material._id,
                'material' : $scope.cart.material.material,
                'priceIncrease' : $scope.cart.material.priceIncrease
            },
            measure : {
                '_id' : $scope.cart.measure._id,
                'width' : $scope.cart.measure.width,
                'height' : $scope.cart.measure.height,
                'depth' : $scope.cart.measure.depth,
                'priceIncrease' : $scope.cart.measure.priceIncrease
            },
            quantity : $scope.cart.quantity
        });
        $cookieStore.put('cart', $rootScope.cart);
        $location.path('/carrinho-de-compras');
    };

    $scope.product = product.get({'productId' : $routeParams.productId});
    $scope.cart = {quantity : 1, product : $scope.product};
});
