<?php

namespace Blog\Controllers;

class PostController extends \Library\Controller {

    public function __construct(\Library\Route $route, \Blog\Application $application) {
        parent::__construct($route, $application);
    }

    public function listAction($page) {
        return $this->template->render();
    }

    public function showAction($id) {
        return $this->template->render();
    }

    public function updateAction($id) {
        return $this->template->render();
    }

    public function addAction() {
        return $this->template->render();
    }
}
