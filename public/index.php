<?php

namespace App;


use Exception;
use Framework\Simplex;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;


require __DIR__ . '/../vendor/autoload.php';


$request = Request::createFromGlobals();

$routes = require  __DIR__ . '/../src/routes.php';
// var_dump($routes);

$context = new RequestContext();

// var_dump($context);

$urlMatcher = new UrlMatcher($routes, $context);

$controllerResoulver = new ControllerResolver();
$argumentResolver = new ArgumentResolver();


$framework = new \Framework\Simplex($urlMatcher, $controllerResoulver, $argumentResolver);

$response = $framework->handle($request);

$response->send();
