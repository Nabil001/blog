<?php

namespace Blog\Controllers;

class DefaultController extends \Library\Controller {

    public function __construct(\Library\Route $route, \Blog\Application $application) {
        parent::__construct($route, $application);
    }

    public function homeAction() {
        return $this->template->render();
    }

}
