<?php
//check is active route 
function isActiveRoute($route, $output = "active")
{
    if (Route::currentRouteName() == $route) return $output;
}