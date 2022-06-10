<?php
error_reporting(E_ALL);
require_once __DIR__ . "/../vendor/autoload.php";
// use Framework\Exception\HttpException\MethodNotAllowedException;
// use Framework\Exception\HttpException\NotFoundException;
use Framework\Routing\Router;
use App\Routes;
use Dotenv\Dotenv as Dotenv;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;


/** Loading configuration data from .env files */
$dotenv = Dotenv::createImmutable(__DIR__ . "/..");
$dotenv->load();
// var_dump($_ENV);
$router = new Router();
$routes = new Routes($router);
// try{
//   /**
//    * We need to dispatch before using route because dispatching will resolve the parameters of the route.
//    */
//   print $router->dispatch();
//   // print("<br>");
//   // print $router->route('app_customer_index', ['id' => 1]);
// }catch(Exception $e)
// {
//   echo $e->getMessage();
//   // print_r($e);
//   exit;
// }
try{
    print $router->dispatch();
}catch(\Throwable $e) {
    if (isset($_ENV['APP_ENV']) && strcasecmp($_ENV['APP_ENV'], 'dev') === 0)
    {
      $whoops = new Run();
      $whoops->pushHandler(new PrettyPageHandler());
      $whoops->register();
      throw $e;  
    }
    return $this->dispatchError();
}