/*global angular:false*/
angular.module('galatea', ['ngRoute', 'ngCookies', 'galatea.controllers.institutional', 'galatea.controllers.newsletter', 'galatea.controllers.user', 'galatea.controllers.ambiance', 'galatea.controllers.product', 'galatea.controllers.cart', 'resources', 'facebook']).config(function ($facebookProvider, $routeProvider) {
    'use strict';

    $facebookProvider.init({
        appId : '333099176831507',
        channelUrl : '//localhost:3000',
        status : true,
        cookie : true,
        xfbml : true
    });

    $routeProvider.when('/', {'templateUrl' : 'views/home/home.html', 'controller' : 'HomeController'});
}).run(function ($rootScope, user, category) {
    'use strict';

    $rootScope.categories = category.query();
    $rootScope.user = user.get({'userId' : 'me'});
}).controller('MiniCartController', function ($rootScope, $scope, $cookieStore) {
    'use strict';

    $scope.emptyCart = function () {
        $rootScope.cart = [];
        $cookieStore.put('cart', $rootScope.cart);
    };

    $rootScope.cart = $cookieStore.get('cart') || [];
}).controller('HomeController', function ($scope, ambiance) {
    'use strict';

    $scope.featured = ambiance.query({'featured' : true});
});
