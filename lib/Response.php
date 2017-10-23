<?php

namespace Library;

class Response {

    protected $view;

    public function __construct($view) {
        $this->view = $view;
    }

    public function send() {
        echo $this->view;
    }

}
