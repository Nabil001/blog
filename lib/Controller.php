<?php

namespace Library;

class Controller {

    protected $template;
    protected $route;
    protected $application;

    public function __construct(\Library\Route $route, \Blog\Application $application) {
        $this->route = $route;
        $this->application = $application;

        $loader = new \Twig_Loader_Filesystem(array('templates/'.$route->getModule(), 'templates/layout'));
        $twig = new \Twig_Environment($loader);
        $this->template = $twig->load($this->route->getAction().'.twig.html');
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
            $parametersValues = $this->route->matches($this->application->getRequest()->getURI());
            $parameters = [];
            foreach ($parametersNames as $parameterName) {
                if(isset($parametersValues[$parameterName])) {
                    $parameters[] = $parametersValues[$parameterName];
                }
            }

            return new Response($method->invokeArgs($this, $parameters));
        }
        else {
            throw new Exceptions\UnimplementedActionException();
        }
    }

}
