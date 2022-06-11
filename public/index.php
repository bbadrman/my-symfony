<?php

namespace App;


use Exception;
use Framework\Simplex;
use Framework\Event\RequestEvent;
use Symfony\Contracts\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\EventDispatcher\EventDispatcher;
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
$dispatcher = new EventDispatcher;
$dispatcher->addListener('kernel.request', function(RequestEvent $e) {
    dump('salut');
});
$dispatcher->addListener('kernel.controller', function(){
    dump('nous avous trouve le controller');
});

$framework = new \Framework\Simplex($dispatcher, $urlMatcher, $controllerResoulver, $argumentResolver);



$response = $framework->handle($request);

$response->send();
