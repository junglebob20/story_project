<?php
//check is active route 
function isActiveRoute($route, $output = "active")
{
    if (Route::currentRouteName() == $route) return $output;
}
function isActiveTag($request, $currentTag, $output = "active")
{
    if ($currentTag == $request->tag_name) return $output;
}