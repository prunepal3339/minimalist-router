<?php
namespace App\Controller;
class HomeController extends AbstractController
{
    public function indexAction()
    {
        return "I am a response!";   
    }
    public function __invoke()
    {
        return "I am a direct controller response";
    }
    public function __toString()
    {
        return "I expected __invoke to be called!";
    }
}