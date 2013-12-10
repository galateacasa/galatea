/* global angular:false
 */
angular.module('galatea.controllers.user', ['ngCookies', 'ngRoute', 'angularFileUpload', 'facebook', 'resources']).config(function ($routeProvider) {
    'use strict';

    $routeProvider.when('/entrar', {'templateUrl' : 'views/user/login.html'});
    $routeProvider.when('/sair', {'templateUrl' : 'views/user/logout.html', 'controller' : 'UserLogoutController'});
    $routeProvider.when('/confirmar-email', {'templateUrl' : 'views/home/home.html', 'controller' : 'UserEmailConfirmationController'});
}).controller('UserEmailConfirmationController', function ($rootScope, $scope, $location, $http) {
    'use strict';

    $http.put('/users/' + $location.search().userId + '/email-confirmation').success(function (user) {
        $rootScope.user = user;
        $scope.success = 'Email confirmado com sucesso!';
    });
}).controller('UserLogoutController', function ($rootScope, $cookieStore) {
    'use strict';

    $cookieStore.remove('XSRF-TOKEN');
    $cookieStore.remove('userId');
    delete $rootScope.user;
}).controller('UserFacebookLoginController', function ($rootScope, $scope, $facebook, users) {
    'use strict';

    $scope.user = new users();

    $scope.save = function () {
        $facebook.login();
    };
}).controller('UserLoginController', function ($rootScope, $scope, $location, $http, users) {
    'use strict';

    $scope.user = new users();

    $scope.save = function () {
        $http.post('/sessions', $scope.user).success(function (user) {
            $rootScope.user = user;
            $location.path('/');
        }).error(function () {
            $scope.error = 'Senha inválida';
        });
    };
}).controller('UserSignupController', function ($scope, $location, $fileUploader, users, countries, states, cities, expertises) {
    'use strict';

    $scope.user = new users({type : 'designer'});
    $scope.uploader = $fileUploader.create({'method' : 'put'});
    $scope.uploader.bind('beforeupload', function (event, item) {
        item.url = 'users/' + $scope.user.userId + '/photo';
    });
    $scope.uploader.bind('completeall', function () {
        $scope.success = 'Obrigado! Para finalizar o cadastro, verifique o email de confirmação que enviamos para você.';
        $location.path('/');
    });

    $scope.countries = countries.query();
    $scope.expertises = expertises.query();

    $scope.loadStates = function () {
        $scope.states = states.query({countryId : $scope.user.address.country});
    };

    $scope.loadCities = function () {
        $scope.cities = cities.query({countryId : $scope.user.address.country, stateId : $scope.user.address.state});
    };

    $scope.save = function () {
        $scope.user.$save(function () {
            $scope.uploader.uploadAll();
        });
    };
});
