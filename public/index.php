<?php

require __DIR__.'/../vendor/autoload.php';

$uri = str_replace('?'.$_SERVER['QUERY_STRING'], '', $_SERVER['REQUEST_URI']);

$router = require '../routes/web.php';
$router->resolve($_SERVER['REQUEST_METHOD'], $uri);
