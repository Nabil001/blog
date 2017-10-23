<?php

namespace Blog\Controllers;

class DefaultController extends \Library\Controller {

    public function homeAction() {
        return $this->template->render();
    }

}
