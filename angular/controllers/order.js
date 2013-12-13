/* global angular:false
 */
angular.module('galatea.controllers.cart', ['ngRoute', 'resources']).config(function ($routeProvider) {
    'use strict';

    $routeProvider.when('/carrinho-de-compras', {'templateUrl' : 'views/product/create.html', 'controller' : 'CartListController'});
}).controller('CartListController', function () {

});
