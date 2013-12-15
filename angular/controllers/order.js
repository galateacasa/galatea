/* global angular:false
 */
angular.module('galatea.controllers.cart', ['ngRoute', 'ngCookies', 'resources']).config(function ($routeProvider) {
    'use strict';

    $routeProvider.when('/carrinho-de-compras', {'templateUrl' : 'views/order/cart.html', 'controller' : 'CartListController'});
}).controller('CartListController', function ($rootScope, $scope, $cookieStore, $location, product) {
    'use strict';

    var i;

    $scope.cart = [];
    $scope.total = 0;
    $scope.deliveryDate = new Date();

    $scope.changeQuantity = function (cartItem) {
        for (var i = 0; i < $rootScope.cart.length; i += 1) {
            if ($rootScope.cart[i].product === cartItem.product.slug) {
                $rootScope.cart[i].quantity = cartItem.quantity;
            }
        }
        $cookieStore.put('cart', $rootScope.cart);

        $scope.cart = [];
        $scope.total = 0;
        for (i = 0; i < $rootScope.cart.length; i += 1) {
            $scope.loadProduct($rootScope.cart[i]);
        }
    };

    $scope.removeItem = function (cartItem) {
        for (var i = 0; i < $rootScope.cart.length; i += 1) {
            if ($rootScope.cart[i].product === cartItem.product.slug) {
                $rootScope.cart.splice(i, 1);
            }
        }
        $cookieStore.put('cart', $rootScope.cart);

        $scope.cart = [];
        $scope.total = 0;
        for (i = 0; i < $rootScope.cart.length; i += 1) {
            $scope.loadProduct($rootScope.cart[i]);
        }
    };

    $scope.loadProduct = function (cartItem) {
        product.get({'productId' : cartItem.product}, function (product) {
            var price, date, i;

            price = product.price || 0;
            date  = new Date();

            date.setDate(date.getDate() + product.deadline);

            if (date > $scope.deliveryDate) {
                $scope.deliveryDate = date;
            }

            for (i = 0; i < product.measures.length; i += 1) {
                if (product.measures[i]._id === cartItem.measure && product.measures[i].priceIncrease) {
                    price += product.measures[i].priceIncrease;
                }
            }

            for (i = 0; i < product.materials.length; i += 1) {
                if (product.materials[i]._id === cartItem.material && product.materials[i].priceIncrease) {
                    price += product.materials[i].priceIncrease;
                }
            }

            $scope.cart.push({
                product : product,
                quantity : cartItem.quantity,
                material : cartItem.material,
                measure : cartItem.measure,
                price : price
            });
            $scope.total += price * cartItem.quantity;
        });
    };

    for (i = 0; i < $rootScope.cart.length; i += 1) {
        $scope.loadProduct($rootScope.cart[i]);
    }
});
