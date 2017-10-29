<?php

namespace Library\Exceptions;

class InvalidEntityConstantException extends \Exception {

    public function __construct() {
        parent::__construct('The constants seems to be invalid', 0, null);
    }

}
