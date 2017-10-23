<?php

namespace Blog\Controllers;

class ErrorController extends \Library\Controller {

    public function show404Action() {
        return $this->template->render();
    }

}
