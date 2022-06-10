<?php
namespace App;

use App\Controller\CustomerController;
use App\Controller\HomeController;
use App\Controller\ProductController;
use Framework\Routing\Router;
class Routes
{
  public function __construct(Router $router)
  {
    $router
      ->add('get', '/home',[HomeController::class, 'indexAction'])
      ->name("app_index")    
      ;
    $router
      ->add('get', '/home2', HomeController::class);
    
    $router->add('get', '/', fn() => $router->redirect('/home'));
    $router->add('get', '/login', fn() => 'Login Page');
    $router->add('post', '/login',fn() => 'Login Post Page');
    $router->add('get', '/internal-server-error', fn() => throw new \Exception("Internal Server Error"));
    // $router
    //     ->add('get', '/customers/{id}',
    //        function() use ($router) {
    //          $params = $router->currentRoute()->routeParams();
    //          var_dump($params);
    //          return "Customer {$params['id']}"; 
    //       })
    //       ->name('app_customer_index');
    // ;
    $router->add('get', '/customers/{id}', [CustomerController::class, 'showCustomerAction']);
    $router->add('get', '/products/{id}', [ProductController::class, 'showProductAction']);
    $router->errorHandler(404, fn() => "Page Not found!");
    $router->errorHandler(500, fn() => "Internal Server Error!");
    $router->errorHandler(405, fn() => "Method not allowed!");
  }
}
