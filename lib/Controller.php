<?php

namespace Library;

class Controller {

    protected $twigEnv;
    protected $route;
    protected $actionParameters;
    protected $application;
    protected $manager;

    public function __construct(Route $route, Application $application, array $actionParameters = []) {
        $this->route = $route;
        $this->application = $application;
        $this->actionParameters = $actionParameters;

        $loader = new \Twig_Loader_Filesystem(array('templates/'.$route->getModule(), 'templates/layout'));
        $this->twigEnv = new \Twig_Environment($loader);
    }

    public function render($view, array $data = []) {
        return $this->twigEnv->load($view.'.twig.html')->render($data);
    }

    public function action() {
        $action = $this->route->getAction().'Action';
        if(method_exists($this, $action)) {
            $class = new \ReflectionClass(get_class($this));
            $method = $class->getMethod($action);
            $parametersNames = array_map(
                                    function($parameter){return $parameter->getName();},
                                    $method->getParameters()
                                );
            $sortedParameters = [];
            foreach ($parametersNames as $parameterName) {
                if(isset($this->actionParameters[$parameterName])) {
                    $sortedParameters[] = $this->actionParameters[$parameterName];
                }
            }

            return new Response($method->invokeArgs($this, $sortedParameters));
        }
        else {
            throw new Exceptions\UnimplementedActionException($this->route->getModule(), $this->route->getAction());
        }
    }

}
