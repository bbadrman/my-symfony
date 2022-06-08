<?php


use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;


require __DIR__ . '/../vendor/autoload.php';

// comment savoir la difference entre bye.php et hello.php

$request = Request::createFromGlobals();


$routes = require  __DIR__ . '/../src/routes.php';
// var_dump($routes);

$context = new RequestContext();

$context->fromRequest($request);

// var_dump($context);

$urlMatcher = new UrlMatcher($routes, $context);


try {
    
    $resultat = ($urlMatcher->match($request->getPathInfo()));
// var_dump($resultat);

    $request->attributes->add($resultat);
    
    $response  = call_user_func($resultat['_controller'], $request);
// var_dump($response);
    // ob_start();
    // include __DIR__ . '/../src/pages/' . $_route . '.php';
    // $response = new Response(ob_get_clean());

} catch(ResourceNotFoundException $e) {
    $response = new Response("la page demandée n'existe pas", 404);
    
} catch(Exception $e) {
    $response = new Response("Erreur arrivée sur le serveur", 500);

}

$response->send();
