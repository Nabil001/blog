<?php

namespace Library;

class Request {

    public function getGetData($key) {
        return isset($_GET[$key]) ? $_GET[$key] : null;
    }

    public function getPostData($key) {
        return isset($_POST[$key]) ? $_POST[$key] : null;
    }

    public function getCookie($key) {
        return isset($_COOKIE[$key]) ? $_COOKIE[$key] : null;
    }

    public function getURI() {
        return $_SERVER['REQUEST_URI'];
    }

    public function getMethod() {
        return $_SERVER['REQUEST_METHOD'];
    }

    public function getProtocol() {
        return $_SERVER['SERVER_PROTOCOL'];
    }

}
