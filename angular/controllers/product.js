/* global angular:false
 */
angular.module('galatea.controllers.product', ['ngRoute', 'ngCookies', 'resources']).config(function ($routeProvider) {
    'use strict';

    $routeProvider.when('/criar-projeto', {'templateUrl' : 'views/product/create.html', 'controller' : 'ProductCreateController'});
    $routeProvider.when('/categoria/:categoryId/:subCategoryId?', {'templateUrl' : 'views/product/list.html', 'controller' : 'ProductListController'});
    $routeProvider.when('/projeto/:projectId', {'templateUrl' : 'views/product/details.html', 'controller' : 'ProductDetailsController'});
    $routeProvider.when('/produto/:productId', {'templateUrl' : 'views/product/details.html', 'controller' : 'ProductDetailsController'});
    $routeProvider.when('/produtos', {'templateUrl' : 'views/product/list.html', 'controller' : 'ProductListController', 'reloadOnSearch' : false});
}).controller('ProductSearchController', function ($scope, $location, category) {
    'use strict';

    $scope.categories = category.query();
    $scope.query = $location.search().busca;

    $scope.search = function () {
        if ($location.path() !== '/produtos') {
            $location.path('/produtos');
        }
        $location.search('busca', $scope.query);
    };
}).controller('ProductListController', function ($rootScope, $scope, $routeParams, $location, product, category) {
    'use strict';

    $scope.query = $location.search().busca;

    if ($routeParams.subCategoryId) {
        $scope.category = category.get({'categoryId' : $routeParams.categoryId});
        $scope.subcategory = category.get({'categoryId' : $routeParams.subCategoryId});
        $scope.products = product.query({'categoryId' : $routeParams.subCategoryId});
    } else if ($routeParams.categoryId) {
        $scope.category = category.get({'categoryId' : $routeParams.categoryId});
        $scope.products = product.query({'categoryId' : $routeParams.categoryId});
    } else {
        $scope.products = product.query();
    }

    $scope.$on('$locationChangeSuccess', function () {
        $scope.query = $location.search().busca;
    });
}).controller('ProductCreateController', function ($rootScope, $scope, $location, product, subcategory) {
    'use strict';

    $scope.product = new product({categories : [], measures : [], materials : [], images : []});
    $scope.subcategories = subcategory.query();

    $scope.addImage = function () {
        $scope.product.images.push({});
    };

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
        $scope.product.images = $scope.product.images.map(function (image) {
            return image.url;
        });
        $scope.product.$save(function () {
            $scope.success = 'Produto enviado com sucesso';
            $location.path('/');
        });
    };
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

    $scope.changeImage = function (image) {
        $scope.selectedImage = image;
    };

    $scope.product = product.get({'productId' : $routeParams.productId}, function () {
        $scope.selectedImage = $scope.product.images[0];
    });
    $scope.cart = {quantity : 1, product : $scope.product};
});
