<?php

namespace Library;

class ErrorController extends \Library\Controller {

    public function show404Action() {
        header($this->application->getRequest()->getProtocol() . '404 Not Found', true);

        return $this->template->render();
    }

    public function show503Action() {
        header($this->application->getRequest()->getProtocol() . '503 Service Unavailable', true);

        return $this->template->render();
    }

}
