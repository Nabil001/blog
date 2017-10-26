<?php

namespace Library\Exceptions;

class NoPrimaryKeyException extends \Exception {

    public function __construct($table, $code = 0, $previous = null) {
        parent::__construct('Table \''.$table.'\' has no primary key', $code, $previous);
    }

}
