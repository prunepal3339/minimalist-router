<?php
namespace Framework\View\Engine;
use Override; //requires 8.3
class BasicEngine implements EngineInterface
{
    #[Override]
    public function render(string $path, array $data = []): string 
    {
        $contents = file_get_contents($path);
        foreach ($data as $key=>$value) {
            //{{}} must be escaped in case of string interpolation
            $contents = str_replace("{{$key}}", $value, $contents);
        }
        return $contents;
    }
}