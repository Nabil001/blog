<?php

namespace Blog\Controllers;

class PostController extends \Library\Controller {

    public function __construct(\Library\Route $route, \Library\Application $application, array $actionParameters = []) {
        parent::__construct($route, $application, $actionParameters);
        $this->manager = new \Blog\Models\PostManager(\Library\PDOFactory::getInstance());
    }

    public function listAction($page, $limit = 5) {
        return $this->render($this->route->getAction());
    }

    public function showAction($id) {
        return $this->render($this->route->getAction());
    }

    public function updateAction($id) {
        return $this->render($this->route->getAction());
    }

    public function addAction() {
        return $this->render($this->route->getAction());
    }

}
