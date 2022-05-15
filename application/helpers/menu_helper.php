<?php 
if(!defined('BASEPATH')) exit('No direct script access allowed');

if(!function_exists('active_link')) {
  function activate_menu($controller) {
    // Getting the class instance.
    $ci = get_instance();
    // Getting the router class to actived it.
    $class = $ci->router->fetch_class();
    return ($class == $controller) ? 'active' : '';
  }
}

if(!function_exists('active_link')) {
  function activate_side_menu($controller) {
    $controller_array = explode("/",$controller);
    // Getting the class instance.
    $ci = get_instance();
    // Getting the router class to actived it.
    $class = $ci->router->fetch_class();
    $method = $ci->router->fetch_method();


    if($class == "Index" && $controller == "/"){
      return 'active';
    }
    else if($class == $controller_array[0] && $method == $controller_array[1]){
      return 'active';
    } else {
      return '';
    }

        // return ($class == $controller) ? $class.''.$controller : $class.''.$controller;

  }
}