/* global angular:false
 */
angular.module('galatea.controllers.user', ['ngCookies', 'ngRoute', 'facebook', 'resources']).config(function ($routeProvider) {
    'use strict';

    $routeProvider.when('/entrar', {'templateUrl' : 'views/user/login.html'});
    $routeProvider.when('/sair', {'templateUrl' : 'views/user/logout.html', 'controller' : 'UserLogoutController'});
    $routeProvider.when('/confirmar-email', {'templateUrl' : 'views/user/account.html', 'controller' : 'UserEmailConfirmationController'});
    $routeProvider.when('/minha-conta', {'templateUrl' : 'views/user/account.html', 'controller' : 'UserAccountController'});
    $routeProvider.when('/meus-creditos', {'templateUrl' : 'views/user/credits.html'});
    $routeProvider.when('/perfil/:userId?', {'templateUrl' : 'views/user/profile.html', 'controller' : 'UserProfileController'});
}).run(function ($rootScope, user) {
    'use strict';

    $rootScope.user = user.get({'userId' : 'me'});
}).controller('UserProfileController', function ($scope, $routeParams, user) {
    'use strict';

    if ($routeParams.userId) {
        $scope.user = user.get({userId : $routeParams.userId});
    } else {
        $scope.user = user.get({userId : 'me'});
    }
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
}).controller('UserSignupController', function ($scope, $location, user, country, state, city, expertise) {
    'use strict';

    $scope.user = new user({type : 'designer', addresses : [{}]});

    $scope.countries = country.query();
    $scope.expertises = expertise.query();

    $scope.loadStates = function (address) {
        $scope.states = state.query({countryId : address.country});
    };

    $scope.loadCities = function (address) {
        $scope.cities = city.query({countryId : address.country, stateId : address.state});
    };

    $scope.save = function () {
        $scope.user.$save(function () {
            $scope.success = 'Obrigado! Para finalizar o cadastro, verifique o email de confirmação que enviamos para você.';
            $location.path('/');
        });
    };
}).controller('UserAccountController', function ($rootScope, $scope, $location, user, country, state, city) {
    'use strict';

    $scope.user = user.get({'userId' : 'me'}, function (user) {
        console.log(user);
    });
    $scope.countries = country.query();

    $scope.addAddress = function () {
        $scope.user.addresses.push({});
    };

    $scope.removeAddress = function (address) {
        for (var i = 0; i < $scope.user.addresses.length; i += 1) {
            if ($scope.user.addresses[i] === address) {
                $scope.user.addresses.splice(i,1);
            }
        }
    };

    $scope.loadStates = function (address) {
        $scope.states = state.query({countryId : address.country});
    };

    $scope.loadCities = function (address) {
        $scope.cities = city.query({countryId : address.country, stateId : address.state});
    };

    $scope.save = function (goToCart) {
        $scope.user.$save();
        $rootScope.user = $scope.user;
        if (goToCart) {
            $location.path('/carrinho-de-compras');
        } else {
            $location.path('/');
        }
    };
});
