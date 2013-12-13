/* global angular:false
 */
angular.module('galatea.controllers.cart', ['ngRoute', 'resources']).config(function ($routeProvider) {
    'use strict';

    $routeProvider.when('/carrinho-de-compras', {'templateUrl' : 'views/order/cart.html', 'controller' : 'CartListController'});
}).controller('CartListController', function ($scope, user) {
    'use strict';

    user.get({userId : 'me'}, function (user) {
        $scope.cart = user.cart;
    });
});
