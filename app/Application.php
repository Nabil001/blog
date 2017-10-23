<?php

namespace Blog;

class Application {

    protected $request;

    public function __construct() {
        $this->request = new \Library\Request();
    }

    public function run() {
        $router = new \Library\Router($this);
        $router->addRoute(new \Library\Route('Default', 'home', '#^/(home)?/?$#'));
        $router->addRoute(new \Library\Route('Post', 'add', '#^/add/?$#'));
        $router->addRoute(new \Library\Route('Post', 'list', '#^/list-([1-9]{1,})/?$#', array('page')));
        $router->addRoute(new \Library\Route('Post', 'show', '#^/show-([1-9][0-9]{0,})/?$#', array('id')));
        $router->addRoute(new \Library\Route('Post', 'update', '#^/update-([1-9][0-9]{0,})/?$#', array('id')));

        try {
            $controller = $router->getController();
        } catch (\Library\Exceptions\NoSuchRouteException $e) {
            $controller = $this->get404ErrorController();
        }

        $response = $controller->action();
        $response->send();
    }

    public function get404ErrorController() {
        //header($this->request->getProtocol() . '404 Not Found', true);
        return new Controllers\ErrorController(
                                                new \Library\Route('Error', 'show404', ''),
                                                $this
                                                );
    }

    public function get503ErrorController() {
        //header($this->request->getProtocol() . '503 Service Unavailable', true);
        return new Controllers\ErrorController(
                                                new \Library\Route('Error', 'show503', ''),
                                                $this
                                                );
    }

    public function getRequest() {
        return $this->request;
    }

}
