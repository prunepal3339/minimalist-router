<?php
namespace App\Controller;

use Framework\Routing\Router;

class AbstractController
{
    protected $router;
    public function __construct(Router $router)
    {
        $this->router = $router;
    }
}