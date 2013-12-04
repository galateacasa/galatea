/* global angular:false
 */
angular.module('galatea.user', ['ngRoute', 'ngResource']).config(function ($routeProvider) {
    'use strict';

    $routeProvider.when('/login', {'templateUrl' : 'views/user/login.html'});
});
