<?php

namespace Library\Exceptions;

class NoSuchRouteException extends \Exception {
    public function __construct($code = 0, $previous = null) {
        parent::__construct('No route is matching with the URL', $code, $previous);
    }
}
