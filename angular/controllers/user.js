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
}).controller('UserFacebookLoginController', function ($rootScope, $scope, $facebook, user) {
    'use strict';

    $scope.user = new user();

    $scope.save = function () {
        $facebook.login();
    };
}).controller('UserLoginController', function ($rootScope, $scope, $location, $http, user) {
    'use strict';

    $scope.user = new user();

    $scope.save = function () {
        $http.post('/sessions', $scope.user).success(function (user) {
            $rootScope.user = user;
            $location.path('/');
        }).error(function () {
            $scope.error = 'Senha inválida';
        });
    };
}).controller('UserSignupController', function ($scope, $location, $fileUploader, user, country, state, city, expertise) {
    'use strict';

    $scope.user = new user({type : 'designer'});
    $scope.uploader = $fileUploader.create({'method' : 'put'});
    $scope.uploader.bind('beforeupload', function (event, item) {
        item.url = 'users/' + $scope.user.userId + '/photo';
    });
    $scope.uploader.bind('completeall', function () {
        $scope.success = 'Obrigado! Para finalizar o cadastro, verifique o email de confirmação que enviamos para você.';
        $location.path('/');
    });

    $scope.countries = country.query();
    $scope.expertises = expertise.query();

    $scope.loadStates = function () {
        $scope.states = state.query({countryId : $scope.user.address.country});
    };

    $scope.loadCities = function () {
        $scope.cities = city.query({countryId : $scope.user.address.country, stateId : $scope.user.address.state});
    };

    $scope.save = function () {
        $scope.user.$save(function () {
            $scope.uploader.uploadAll();
        });
    };
});
