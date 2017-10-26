<?php

namespace Library;

class Router {

    protected $routes;
    protected $application;

    public function __construct(Application $application) {
        $this->application = $application;
    }

    public function addRoute(Route $route) {
        $this->routes[] = $route;
    }

    public function getController() {

        foreach ($this->routes as $route) {
            if(($actionParameters = $route->matches($this->application->getRequest()->getURI())) !== false) {
                $controller = '\Blog\\Controllers\\'.$route->getModule().'Controller';
                return new $controller($route, $this->application, $actionParameters);
            }
        }
        throw new Exceptions\NoSuchRouteException();
    }

}
