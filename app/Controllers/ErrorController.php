<?php

namespace Blog\Controllers;

class ErrorController extends \Library\Controller {

    public function __construct(\Library\Route $route, \Blog\Application $application) {
        parent::__construct($route, $application);
    }

    public function show404Action() {
        return $this->template->render();
    }

}
