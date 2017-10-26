<?php

namespace Library\Exceptions;

class NoSuchTableException extends \Exception {

    public function __construct($table, $code = 0, $previous = null) {
        parent::__construct('Table \''.$table.'\' hasn\'t been found', $code, $previous);
    }

}
