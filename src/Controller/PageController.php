<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;

class PageController
{
    public function about()
    {
        ob_start();
        include __DIR__ . '/../pages/cms/about.php';

        //renvoyer la response
        
        return new Response(ob_get_clean());

    }
}