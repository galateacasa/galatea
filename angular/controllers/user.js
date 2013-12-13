/* global angular:false
 */
angular.module('galatea.controllers.user', ['ngCookies', 'ngRoute', 'angularFileUpload', 'facebook', 'resources']).config(function ($routeProvider) {
    'use strict';

    $routeProvider.when('/entrar', {'templateUrl' : 'views/user/login.html'});
    $routeProvider.when('/sair', {'templateUrl' : 'views/user/logout.html', 'controller' : 'UserLogoutController'});
    $routeProvider.when('/confirmar-email', {'templateUrl' : 'views/user/account.html', 'controller' : 'UserEmailConfirmationController'});
    $routeProvider.when('/minha-conta', {'templateUrl' : 'views/user/account.html', 'controller' : 'UserAccountController'});
}).controller('UserEmailConfirmationController', function ($rootScope, $scope, $cookies, $location, user) {
    'use strict';

    if ($location.search().token) {
        $cookies['XSRF-TOKEN'] = $location.search().token;
    }

    setTimeout(function () {
        $rootScope.user = user.get({'userId' : 'me'}, function () {
            $rootScope.user.$emailConfirmation(function () {
                $scope.success = 'Email confirmado com sucesso!';
                $location.path('/');
            });
        });
    }, 1000);
}).controller('UserLogoutController', function ($rootScope, $cookieStore) {
    'use strict';

    $cookieStore.remove('XSRF-TOKEN');
    delete $rootScope.user;
}).controller('UserFacebookLoginController', function ($rootScope, $scope, $facebook, user) {
    'use strict';

    $scope.user = new user();

    $scope.save = function () {
        $facebook.login();
    };
}).controller('UserLoginController', function ($rootScope, $scope, $location, user) {
    'use strict';

    $scope.user = new user();

    $scope.save = function () {
        $scope.user.$login(function (user) {
            $rootScope.user = user;
            $location.path('/');
        });
    };
}).controller('UserSignupController', function ($scope, $location, $fileUploader, user, country, state, city, expertise) {
    'use strict';

    $scope.user = new user({type : 'designer', addresses : [{}]});
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
}).controller('UserAccountController', function ($rootScope, $scope, user) {
    'use strict';

    $scope.user = user.get({'userId' : 'me'});

    $scope.addAddress = function () {
        $scope.user.addresses.push({});
    };

    $scope.save = function () {
        $scope.user.$save();
    };
});
