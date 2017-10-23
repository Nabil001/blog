<?php

namespace Blog\Controllers;

class PostController extends \Library\Controller {

    public function listAction($page, $limit = 5) {
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
