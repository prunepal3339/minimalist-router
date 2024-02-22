<?php
use Framework\View;
if (!function_exists('view')) {
    function view(string $template, array $data = []): string
    {
        static $manager;
        if (!$manager) {
            $manager = new View\Manager();
            $manager->addPath(__DIR__. '/../templates/');
            $manager->addEngine('basic.php', new View\Engine\BasicEngine());
        }
        return $manager->render($template, $data);
    }
}