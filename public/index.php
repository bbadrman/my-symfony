<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


require __DIR__ . '/../vendor/autoload.php';

// comment savoir la difference entre bye.php et hello.php

$request = Request::createFromGlobals();

// var_dump($request->getPathInfo());

$response = new Response();

$map = [
    
    '/hello' => 'hello.php',
    '/bye' => 'bye.php',
    '/about' => 'cms/about.php',
];

$pathInfo = $request->getPathInfo();

// die("Path Info est: ".$pathInfo);
if (isset($pathInfo)) {
    ob_start();
    include  __DIR__ . '/../src/pages/' . $map[$pathInfo];
    $response->setContent(ob_get_clean());

}else {
    $response->setContent("la page demande n'existe pas");
    $response->setStatusCode(404);
}  


$response->send();