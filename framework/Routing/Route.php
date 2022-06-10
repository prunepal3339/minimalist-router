<?php
namespace Framework\Routing;

use Framework\Exception\RouteException\ParameterMismatchException;
class Route
{
  protected ?string $name = null;
  protected string $method;
  protected string $path;
  protected array $parameters;
  protected $handler;
  public function __construct(string $method, string $path, callable | array | string $handler)
  {
    $this->method = $method;
    $this->handler = $handler;
    $this->parameters = array();
    $matches = array();
    $this->path = $this->normalizePath($path);
    preg_match_all('#\{([^/]*)\}#', $path, $matches);
    if (isset($matches[1]) && !empty($matches[1]))
    {
      // var_dump($matches[1]);
      $this->parameters = $matches[1];
    }
  }
  private function normalizePath(string $path): string
  {
    $path =  '/' . trim($path, '/') . '/';
    return preg_replace('#\/{2,}#', '/', $path);
  }
  public function match(string $method, string $path): bool
  {

    $pathExpr = "#" . preg_replace('#\{[^/]*\}#', '([^/]*)', $this->path) . "#";
    if ($this->path == $this->normalizePath($path) && (strcasecmp($this->method, $method) === 0))
    {
      return true;
    }
    if (!str_contains($pathExpr, '+') && !str_contains($pathExpr, '*'))
    {
      return false;
    }
    $matches = array();
    /**
     * Checks for whether pathExpr matches the path
     */
    if (preg_match_all($pathExpr, $this->normalizePath($path), $matches)){
      if (isset($matches[1]) && !empty($matches[1]) && count($this->parameters) === count($matches[1]))
      {
        $this->parameters = array_combine($this->parameters, $matches[1]);
      }else{
        throw new ParameterMismatchException("Expected " . count($this->parameters). " parameters, got " . isset($matches[1]) ? count($matches[1]) : 0);
      }
    }else{
      return false;
    }
    return strcasecmp($this->method, $method) === 0;
  }
  public function path(){return $this->path;}
  public function method(){return $this->method;}
  public function dispatch(Router& $router)
  {
    if (is_array($this->handler))
    {
      [$class, $method] = $this->handler;
      return (new $class($router))->{$method}();
    }else if (is_string($this->handler)){
      $class = $this->handler;
      return new (new $class($router))();
    }
    return ($this->handler)($router);
    //➔ Multiple ways of calling a callable $fn($args), call_user_func($fn, $args), eval ( I have no idea about this)
  }
  public function routeParams(): array
  {
    return $this->parameters;
  }
  public function name(?string $name = null)
  {
    if ($name){
      $this->name =$name;
      return $this;
    }
    return $this->name;
  }
}
