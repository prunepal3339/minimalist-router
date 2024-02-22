<?php
namespace Framework\View;
class Manager {
    private $engines = [];
    private $paths = [];
    public function addPath($path) {
        $this->paths[] = $path;
        return $this; // method-chains
    }
    public function addEngine($extension, $engine) {
        $this->engines[$extension] = $engine;
        return $this; // method-chains
    }
    public function render(string $template, array $data):string {
        foreach ($this->engines as $extension => $engine) {
            foreach ($this->paths as $path) {
                $file = "{$path}/{$template}.{$extension}";
                
                if(is_file($file)) {
                    return $engine->render($file, $data);
                }
            }
        }
    } // this is slow in performance, TODO: optimize
}
