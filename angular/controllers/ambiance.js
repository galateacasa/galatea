/* global angular:false
 */
angular.module('galatea.controllers.ambiance', ['ngRoute', 'idialog', 'resources']).config(function ($routeProvider) {
    'use strict';

    $routeProvider.when('/inspire-me', {'templateUrl' : 'views/ambiance/list.html', 'controller' : 'AmbianceListController', 'reloadOnSearch' : false});
    $routeProvider.when('/inspire-me/categorias/:categoryId', {'templateUrl' : 'views/ambiance/list.html', 'controller' : 'AmbianceListController', 'reloadOnSearch' : false});
}).run(function ($rootScope, $idialog, $location) {
    'use strict';

    $rootScope.openAmbiance = function (ambiance) {
        $idialog('views/ambiance/details.html', {query : {'ambiente' : ambiance}});
    };

    if ($location.search().ambiente) {
        $rootScope.openAmbiance($location.search().ambiente);
    }
}).controller('AmbianceCreateController', function ($scope, ambiance, category) {
    'use strict';

    $scope.ambiance = new ambiance({products : []});
    $scope.categories = category.query();

    $scope.addProduct = function () {
        $scope.ambiance.products.push({});
    };

    $scope.save = function () {
        $scope.ambiance.$save(function () {
            $scope.success = 'Ambiente enviado com sucesso';
            $scope.hide();
        });
    };
}).controller('AmbianceListController', function ($scope, $routeParams, ambiance) {
    'use strict';

    if ($routeParams.categoryId) {
        $scope.ambiances = ambiance.query({'category' : $routeParams.categoryId});
    } else {
        $scope.ambiances = ambiance.query();
    }
}).controller('AmbianceDetailsController', function ($scope, $location, ambiance) {
    'use strict';

    $scope.ambiance = ambiance.get({'ambianceId' : $location.search().ambiente});
});
