/* global angular:false
 */
angular.module('galatea.controllers.institutional', ['ngRoute', 'ngResource', 'resources']).config(function ($routeProvider) {
    'use strict';

    $routeProvider.when('/institucional/sobre', {'templateUrl' : 'views/institutional/about.html'});
    $routeProvider.when('/institucional/cliente', {'templateUrl' : 'views/institutional/client.html'});
    $routeProvider.when('/institucional/decorador', {'templateUrl' : 'views/institutional/decorator.html'});
    $routeProvider.when('/institucional/designer', {'templateUrl' : 'views/institutional/desginer.html'});
    $routeProvider.when('/institucional/fornecedor', {'templateUrl' : 'views/institutional/supplier.html'});
    $routeProvider.when('/institucional/manual-de-boas-praticas', {'templateUrl' : 'views/institutional/manual.html'});
    $routeProvider.when('/atendimento', {'templateUrl' : 'views/institutional/contact.html', 'controller' : 'InstitutionalContactController'});
    $routeProvider.when('/institucional/duvidas-frequentes', {'templateUrl' : 'views/institutional/faq.html'});
    $routeProvider.when('/institucional/cuidados-com-a-mobilia', {'templateUrl' : 'views/institutional/cares.html'});
    $routeProvider.when('/institucional/trocas-e-devolucoes', {'templateUrl' : 'views/institutional/changes.html'});
    $routeProvider.when('/institucional/garantia', {'templateUrl' : 'views/institutional/warranty.html'});
    $routeProvider.when('/institucional/formas-de-pagamento', {'templateUrl' : 'views/institutional/payment.html'});
    $routeProvider.when('/institucional/ganhe-creditos', {'templateUrl' : 'views/institutional/credits.html'});
    $routeProvider.when('/institucional/politica-de-entrega', {'templateUrl' : 'views/institutional/delivery.html'});
    $routeProvider.when('/institucional/termos-e-condicoes', {'templateUrl' : 'views/institutional/terms.html'});
    $routeProvider.when('/institucional/condicoes-de-upload', {'templateUrl' : 'views/institutional/upload.html'});
    $routeProvider.when('/mapa-do-site', {'templateUrl' : 'views/institutional/sitemap.html'});
}).controller('InstitutionalContactController', function ($scope, contact) {
    'use strict';

    $scope.contact = new contact();

    $scope.save = function () {
        $scope.contact.$save(function () {
            $scope.success = 'Sua mensagem foi enviada com sucesso. Nossa equipe entrará em contato por email ou telefone em breve.';
            $scope.contact = new contact();
        });
    };
});
