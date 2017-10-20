<?php

namespace Library\Exceptions;

class NoSuchRouteException extends \Exception {
    public function __construct() {
        parent::__construct('No route is matching with the URL' . "\n");
    }
}
