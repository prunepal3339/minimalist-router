<?php
namespace Framework\Utils;
class Redirect
{
  public static function to($url)
  {
    header("Location: {$url}", true, 302);
    exit;
  }
  public static function foreverTo($url)
  {
    header("Location: {$url}", true, 301);
    exit;
  }
}
