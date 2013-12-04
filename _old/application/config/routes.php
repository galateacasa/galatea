<?php

if (!defined('BASEPATH'))
  exit('No direct script access allowed');
/*
  | -------------------------------------------------------------------------
  | URI ROUTING
  | -------------------------------------------------------------------------
  | This file lets you re-map URI requests to specific controller functions.
  |
  | Typically there is a one-to-one relationship between a URL string
  | and its corresponding controller class/method. The segments in a
  | URL normally follow this pattern:
  |
  |  example.com/class/method/id/
  |
  | In some instances, however, you may want to remap this relationship
  | so that a different class/function is called than the one
  | corresponding to the URL.
  |
  | Please see the user guide for complete details:
  |
  |  http://codeigniter.com/user_guide/general/routing.html
  |
  | -------------------------------------------------------------------------
  | RESERVED ROUTES
  | -------------------------------------------------------------------------
  |
  | There area two reserved routes:
  |
  |  $route['default_controller'] = 'welcome';
  |
  | This route indicates which controller class should be loaded if the
  | URI contains no data. In the above example, the "welcome" class
  | would be loaded.
  |
  |  $route['404_override'] = 'errors/page_missing';
  |
  | This route will tell the Router what URI segments to use if those provided
  | in the URL cannot be matched to a valid route.
  |
 */
$route['validate_email/(:any)']    = "site/users/validate_email/$1";
$route['default_controller']       = "site/home";
$route['404_override']             = 'galatea_404';
$route['admin']                    = "admin/admin";
$route['retorno-pagseguro']        = "site/pagseguro/notify";
$route['retorno-pagseguro/(:num)'] = "site/pagseguro/notify/$1";
$route['teste']                    = "site/test";

// Institutional
$route['institucional/sobre']                   = "site/about/index/about_galatea";
$route['institucional/cliente']                 = "site/about/index/client";
$route['institucional/decorador']               = "site/about/index/decorator";
$route['institucional/designer']                = "site/about/index/designer";
$route['institucional/fornecedor']              = "site/about/index/supplier";
$route['institucional/manual-de-boas-praticas'] = "site/about/index/be_galatea";
$route['atendimento']                           = "site/about/index/contact";
$route['institucional/duvidas-frequentes']      = "site/about/index/faq";
$route['institucional/cuidados-com-a-mobilia']  = "site/about/index/tips";
$route['institucional/trocas-e-devolucoes']     = "site/about/index/returns";
$route['institucional/garantia']                = "site/about/index/warranty";
$route['institucional/formas-de-pagamento']     = "site/about/index/payments";
$route['institucional/ganhe-creditos']          = "site/about/index/credits";
$route['institucional/politica-de-entrega']     = "site/about/index/delivery-policy";
$route['institucional/termos-e-condicoes']      = "site/about/index/terms";
$route['institucional/condicoes-de-upload']     = "site/about/index/upload_projects";
$route['mapa-do-site']                          = "site/about/index/sitemap";

// Concurso cultural abril
//$route['institucional/concurso-cultural-abril'] = "site/about/index/concurso_cultural_abril";
//$route['concurso-cultural-abril']               = "site/abril/index";

// Users
$route['perfil/(:any)']  = "site/users/profile/$1";
$route['minha-conta']    = "site/users/edit";
$route['meus-creditos']  = "site/user_balances";
$route['meus-pedidos']   = "site/orders";
$route['sair']           = "login/logout";
$route['quero-produzir'] = "site/items/produce";

// Ambiances
$route['inspire-me'] =        "site/ambiances";
$route['inspire-me/(:num)'] = "site/ambiances/index/$1";

// Login/sign up
$route['esqueci-minha-senha'] = "site/users/change_password";

// Project
$route['criar-projeto']  = "site/items/create";
$route['projeto/(:any)'] = "site/disponibilities/show_project/$1";

// Products
$route['produto/(:any)'] = "site/disponibilities/show/$1";

// Cart
$route['confirmacao-do-pedido'] = 'site/pagseguro/callback';
$route['carrinho-de-compras']   = 'site/cart';

// Categories
$route['categoria/(:any)']        = 'site/categories/show/$1'; // Main category
$route['categoria/(:any)/(:any)'] = 'site/categories/show/$1/$2'; // Sub category
$route['categoria/vote']          = 'site/categories/show_projects'; // Projects to be voted
$route['categoria/novidades']     = 'site/categories/show_news'; // New products
