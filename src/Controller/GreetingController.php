<?php
 
namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

Class GreetingController
{

    public function hello(Request $request){

        $name = $request->attributes->get('name');
      
        //Integrer HTML
        ob_start();
        include __DIR__ . '/../pages/hello.html';

        //Renvoyer la response
        return new Response(ob_get_clean());
    }

    public function bye(){

        ob_start();
        include __DIR__ . '/../pages/bye.html';

        //Renvoyer la response
        return new Response(ob_get_clean());

    }



}