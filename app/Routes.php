<?php
namespace App;
use Framework\Routing\Router;
class Routes
{
  public function __construct(Router $router)
  {
    $router
      ->add('get', '/home', fn() => 'Index Page')
      ->name("app_index")    
      ;
    $router->add('get', '/', fn() => $router->redirect('/home'));
    $router->add('get', '/login', fn() => 'Login Page');
    $router->add('post', '/login',fn() => 'Login Post Page');
    $router->add('get', '/internal-server-error', fn() => '500 Internal Server Error');
    $router
        ->add('get', '/customers/{id}', function() use ($router) {$params = $router->currentRoute()->routeParams(); return "Customer {$params['id']}"; })
        ->name('app_customer_index');
    ;
    $router->errorHandler(404, fn() => "Page Not found!");
    $router->errorHandler(500, fn() => "Internal Server Error!");
    $router->errorHandler(405, fn() => "Method not allowed!");
  }
}
