/*global angular:false*/
angular.module('galatea', ['ngRoute', 'idialog', 'fileUpload', 'galatea.controllers.campaing', 'galatea.controllers.institutional', 'galatea.controllers.newsletter', 'galatea.controllers.user', 'galatea.controllers.ambiance', 'galatea.controllers.product', 'galatea.controllers.cart', 'resources', 'facebook']).config(function ($facebookProvider, $routeProvider) {
    'use strict';

    $facebookProvider.init({
        appId : '333099176831507',
        channelUrl : '//localhost:3000',
        status : true,
        cookie : true,
        xfbml : true
    });

    $routeProvider.when('/', {'templateUrl' : 'views/home/home.html', 'controller' : 'HomeController', 'reloadOnSearch' : false});
}).run(function ($rootScope, $location, $window) {
    'use strict';

    $rootScope.$on('$routeChangeSuccess', function () {
        $window.scrollTo(0,0);
    });

    $rootScope.goToTop = function () {
        $window.scrollTo(0,0);
    };
}).controller('HomeController', function ($scope, ambiance) {
    'use strict';

    $scope.featured = ambiance.query({'featured' : true});
});
