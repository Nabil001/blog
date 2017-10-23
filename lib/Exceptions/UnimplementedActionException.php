<?php

namespace Library\Exceptions;

class UnimplementedActionException extends \Exception {

    public function __construct($module, $action, $code = 0, $previous = null) {
        parent::__construct($module.'::'.$action.' is not implemented', $code, $previous);
    }

}
