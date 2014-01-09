/* global angular:false
 */
angular.module('galatea.controllers.cart', ['ngRoute', 'ngCookies', 'resources']).config(function ($routeProvider) {
    'use strict';

    $routeProvider.when('/carrinho-de-compras', {'templateUrl' : 'views/order/cart.html', 'controller' : 'CartListController'});
}).controller('MiniCartController', function ($rootScope, $scope, $cookieStore) {
    'use strict';

    $scope.emptyCart = function () {
        $rootScope.cart = [];
        $cookieStore.put('cart', $rootScope.cart);
    };

    $rootScope.cart = $cookieStore.get('cart') || [];
}).controller('CartListController', function ($rootScope, $scope, $window, $cookieStore, order) {
    'use strict';

    $scope.changeQuantity = function () {
        $cookieStore.put('cart', $rootScope.cart);
        $scope.calculateTotal();
        $scope.calculateDeliveryDate();
    };

    $scope.removeItem = function (cartItem) {
        for (var i = 0; i < $rootScope.cart.length; i += 1) {
            if ($rootScope.cart[i] === cartItem) {
                $rootScope.cart.splice(i, 1);
            }
        }
        $cookieStore.put('cart', $rootScope.cart);
        $scope.calculateTotal();
        $scope.calculateDeliveryDate();
    };

    $scope.calculateTotal = function () {
        $scope.total = 0;
        for (var i = 0; i < $rootScope.cart.length; i += 1) {
            $scope.total += (($rootScope.cart[i].product.price || 0) + ($rootScope.cart[i].measure.priceIncrease || 0) + ($rootScope.cart[i].material.priceIncrease || 0)) * $rootScope.cart[i].quantity;
        }
    };

    $scope.calculateDeliveryDate = function () {
        var deadline = 0;
        for (var i = 0; i < $rootScope.cart.length; i += 1) {
            if ($rootScope.cart[i].product.deadline > deadline) {
                deadline = $rootScope.cart[i].product.deadline;
            }
        }
        $scope.deliveryDate = new Date();
        $scope.deliveryDate.setDate($scope.deliveryDate.getDate() + deadline);
    };

    $scope.buy = function () {
        $scope.order.user = $rootScope.user._id;
        $scope.order.items = $rootScope.cart.map(function (item) {
            return {product : item.product._id, measure : item.measure._id, material : item.material._id, quantity : item.quantity};
        });
        $scope.order.$save(function (order) {
            console.log(order);
            $window.location.href = 'http://pagseguro.uol.com.br/v2/checkout/payment.html?code=' + order.code;
        });
    };

    $scope.order = new order({});
    $scope.calculateTotal();
    $scope.calculateDeliveryDate();
});
