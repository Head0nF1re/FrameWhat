<?php

if (! function_exists('base_path')) {

    function base_path(string $path = ''): string
    {
        return dirname($_SERVER['DOCUMENT_ROOT']).DIRECTORY_SEPARATOR."$path";
    }
}

if (! function_exists('public_path')) {

    function public_path(string $path = ''): string
    {
        return $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR."$path";
    }
}
