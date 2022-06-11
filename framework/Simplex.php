<?php

namespace Framework;

use Exception;
use Framework\Event\RequestEvent;
use Framework\Event\ArgumentEvent;
use Framework\Event\ResponseEvent;
use Framework\Event\ControllerEvent;
use Symfony\Contracts\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\Matcher\UrlMatcherInterface;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\HttpKernel\Controller\ArgumentResolverInterface;
use Symfony\Component\HttpKernel\Controller\ControllerResolverInterface;

class Simplex

{
    protected UrlMatcherInterface $urlMatcher;
    protected ControllerResolverInterface $controllerResolver;
    protected ArgumentResolverInterface $argumentResolver;
    protected EventDispatcherInterface $dispatcher;

    public function __construct(
        UrlMatcherInterface $urlMatcher,
        ControllerResolverInterface $controllerResolver,
        ArgumentResolverInterface $argumentResolver,
        EventDispatcherInterface $dispatcher
    ) {
        $this->urlMatcher = $urlMatcher;
        $this->controllerResolver = $controllerResolver;
        $this->argumentResolver = $argumentResolver;
        $this->eventDispatcher = $dispatcher;
    }

    public function handle(Request $request)
    {

        $this->urlMatcher->getContext()->fromRequest($request);
        
        try {
            
            $request->attributes->add($this->urlMatcher->match($request->getPathInfo()));
            
            $this->dispatcher->dispatch(new RequestEvent($request), 'kernel.request');

            $controller = $this->controllerResoulver->getController($request);

            $this->dispatcher->dispatch(new ControllerEvent($request, $controller), 'kernel.controller');

            $arguments = $this->argumentResolver->getArguments($request, $controller);

            $this->dispatcher->dispatch(new ArgumentEvent($request, $controller, $arguments), 'kernel.arguments');

            $response  = call_user_func_array($controller, $arguments);

            $this->dispatcher->dispatch(new ResponseEvent($response), 'kernel.response');
            // var_dump($response);
            // ob_start();
            // include __DIR__ . '/../src/pages/' . $_route . '.php';
            // $response = new Response(ob_get_clean());

        } catch (ResourceNotFoundException $e) {
            $response = new Response("la page demandée n'existe pas", 404);
        } catch (Exception $e) {
            $response = new Response("Erreur arrivée sur le serveur", 500);
        }

        return $response;
    }
}
