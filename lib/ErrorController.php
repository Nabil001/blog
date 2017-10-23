<?php

namespace Library;

class ErrorController extends \Library\Controller {

    public function show404Action() {
        return $this->template->render();
    }

}
