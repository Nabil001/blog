<?php

namespace Library;

class ErrorController extends \Library\Controller {

    public function show404Action() {
        header($this->application->getRequest()->getProtocol() . '404 Not Found', true);

        return $this->render($this->route->getAction());
    }

    public function show503Action() {
        header($this->application->getRequest()->getProtocol() . '503 Service Unavailable', true);

        return $this->render($this->route->getAction());
    }

}
