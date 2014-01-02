/* global angular:false
 */
angular.module('galatea.controllers.ambiance', ['ngRoute', 'idialog', 'resources']).config(function ($routeProvider) {
    'use strict';

    $routeProvider.when('/inspire-me', {'templateUrl' : 'views/ambiance/list.html', 'controller' : 'AmbianceListController', 'reloadOnSearch' : false});
    $routeProvider.when('/inspire-me/categorias/:categoryId', {'templateUrl' : 'views/ambiance/list.html', 'controller' : 'AmbianceListController', 'reloadOnSearch' : false});
}).run(function ($rootScope, $idialog) {
    'use strict';

    $rootScope.openAmbiance = function (ambiance) {
        $idialog('views/ambiance/details.html', {query : {'ambiente' : ambiance}});
    };
}).controller('AmbianceCreateController', function ($scope, $location, product, ambiance, category) {
    'use strict';

    $scope.ambiance = new ambiance({products : []});
    $scope.products = product.query();
    $scope.categories = category.query();

    $scope.addProduct = function (product) {
        $scope.ambiance.products.push(product);
        for (var i = 0; i < $scope.products.length; i += 1) {
            if ($scope.products[i] === product) {
                $scope.products.splice(i,1);
            }
        }
    };

    $scope.removeProduct = function (product) {
        $scope.products.push(product);
        for (var i = 0; i < $scope.ambiance.products.length; i += 1) {
            if ($scope.ambiance.products[i] === product) {
                $scope.ambiance.products.splice(i,1);
            }
        }
    };

    $scope.save = function () {
        $scope.ambiance.products = $scope.ambiance.products.map(function (product) {
            return product._id;
        });
        $scope.ambiance.$save(function () {
            $scope.success = 'Ambiente enviado com sucesso';
            $scope.hide();
            $location.path('/inspire-me');
        });
    };
}).controller('AmbianceListController', function ($scope, $routeParams, ambiance,category) {
    'use strict';

    $scope.categories = category.query();
    if ($routeParams.categoryId) {
        $scope.ambiances = ambiance.query({'category' : $routeParams.categoryId});
    } else {
        $scope.ambiances = ambiance.query();
    }
}).controller('AmbianceDetailsController', function ($scope, $location, ambiance) {
    'use strict';

    $scope.ambiance = ambiance.get({'ambianceId' : $location.search().ambiente});
});
