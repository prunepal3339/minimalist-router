<?php

namespace Framework\Routing;
use Framework\Exception\HttpException\MethodNotAllowedException;
use Framework\Exception\HttpException\NotFoundException;
class Router
{
  protected array $routes = [];
  protected array $errorHandlers = array();
  protected ?Route $currentRoute = null;
  public function add(
      string $method,
      string $path,
      callable $handler
    ): Route
    {
      $this->currentRoute = $this->routes[] = new Route($method, $path, $handler);
      return $this->currentRoute;
    }
    public function route(string $routeName, ?array $params = null)
    {
      $routePath = "";
      foreach($this->routes as $route)
      {
        if ($route->name() === $routeName)
        {
          $routePath = $route->path();
          foreach($route->routeParams() as $key => $value)
          {
            $routePath = preg_replace("#\{$key\}#",$value, $routePath);
          }
        }
      }
      return $routePath;
    }
    public function currentRoute(): ?Route
    {
      return $this->currentRoute;
    }
    public function redirect(string $url)
    {
      return \Framework\Utils\Redirect::to($url);
    }

    public function errorHandler(int $statusCode, callable $fn){
      $this->errorHandlers[$statusCode] = $fn;
    }
    public function dispatch()
    {
      $requestMethod = $_SERVER['REQUEST_METHOD'] ?? 'GET';
      $requestPath = $_SERVER['REQUEST_URI'] ?? '/';
      if (($matching = $this->match($requestMethod, $requestPath)))
      {
        try {
          return $matching->dispatch();
        }catch(\Throwable $e) {
          return $this->dispatchError();
        }
      }
      if (in_array($requestPath, $this->paths()))
      {
        return $this->dispatchNotAllowed();
      }
      return $this->dispatchNotFound();
    }
    private function paths()
    {
      $paths = array();
      foreach($this->routes as $route){
        $paths[] = $route->path();
      }
      return $paths;
    }
    private function match(string $method, string $path): ?Route
    {
      foreach($this->routes as $route)
      {
        if ($route->match($method, $path))
        {
          return $route;
        }
      }
      return null;
    }
    /**
    * @throws Exception
    */
    private function dispatchNotAllowed()
    {
      if (array_key_exists(405, $this->errorHandlers) && $this->errorHandlers[405]){
        return $this->errorHandlers[405]();
      }
      throw new MethodNotAllowedException("Dispatch not allowed!");
    }
    /**
    * @throws Exception
    */
    private function dispatchError()
    {
      if (array_key_exists(500, $this->errorHandlers) && $this->errorHandlers[500])
      {
        return $this->errorHandlers[500]();
      }
      throw new \ErrorException();
    }
    /**
    * @throws Exception
    */
    private function dispatchNotFound()
    {
      if (array_key_exists(404, $this->errorHandlers) && $this->errorHandlers[404])
      {
        return $this->errorHandlers[404]();
      }
      throw new NotFoundException("Dispatch not found!");
    }

}
// $router = new Router();
// $router->add('get', '/', get_route_handler(MainController::class, 'indexAction'));
// $router->add('get', '/login', get_route_handler(MainController::class, 'loginAction'));
//
// // function get_route_handler(string $class, string $method): callable
// // {
// //   return fn() => (new $class)($method($request, $response));
// // }
