<?php

namespace Library;

interface TableRow extends \ArrayAccess {

    public function isValid();
    public function isIdentified();
    public function getFields();
    public function getValuesToSave();

}
