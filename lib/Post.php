<?php

namespace Library;

class Post implements TableRow {

    protected $columns;

    public function __construct(array $columns = []) {
        $this->columns = ['id' => 0, 'title' => '', 'lead' => '', 'content' => '', 'author' => '', 'lastUpdate' => null];
        foreach ($columns as $column => $value) {
            if(!array_key_exists($column, $this->columns)) {
                throw new \InvalidArgumentException('The given columns contain an invalid field');
            }
            $this->columns[$column] = $value;
        }
    }

    public function isValid() {
        return (is_string($this['title']) && !empty($this['title'])
                && is_string($this['lead']) && !empty($this['lead'])
                && is_string($this['content']) && !empty($this['content'])
                && is_string($this['author']) && !empty($this['author'])
                );
    }

    public function isIdentified() {
        return int($this['id']) > 0;
    }

    public function getFields() {
        return array_keys($this->columns);
    }

    public function getValuesToSave() {
        return ['id' => $this['id'], 'title' => $this['title'],
                    'lead' => $this['lead'], 'content' => $this['content'],
                    'author' => $this['author'], 'lastUpdate' => date('Y:m:d H:i:s')
                ];
    }

    public function __set($attr, $value) {
        if(array_key_exists($attr, $this->columns)) {
            if($attr == 'lastUpdate') {
                $this->columns[$attr] = new \DateTime($value);
            }
            else {
                $this->columns[$attr] = $value;
            }
        }
    }

    public function offsetSet($offset, $value) {
        if(array_key_exists($offset, $this->columns)) {
            $this->columns[$offset] = $value;
        }
    }

    public function offsetGet($offset) {
        return isset($this->columns[$offset]) ? $this->columns[$offset] : null;
    }

    public function offsetExists($offset) {
        return array_key_exists($offset, $this->columns);
    }

    public function offsetUnset($offset) {}

}
