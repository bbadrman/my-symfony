<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
require __DIR__ . '/vendor/autoload.php';

$request = Request::createFromGlobals();

$name = $request->query->get('name', 'hello');
// condition ternaire
//$name = isset($_GET['name']) ? $_GET['name'] : "J'ai pas trouvé le nom";

//  if(isset($_GET['name'])) {
//     $name = $_GET['name'];
//  } else {
//     $name = "J'ai pas trouvé le nom";
//  }
$response = new Response();
$response->headers->set('Content-Type', 'text/html; charset=utf-8');

$response->setContent(sprintf("hello %s", htmlspecialchars($name, ENT_QUOTES) ));
$response->send();
//header("Content-Type: text/html; charset=utf-8");

// printf("hello %s", $name); 