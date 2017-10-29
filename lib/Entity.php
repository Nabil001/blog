<?php

namespace Library;

abstract class Entity {

    public function __construct() {
        $this->checkEntityConst();
    }

    public function checkEntityConst() {
        $primaryKeyAmount = 0;
        $fields = get_class($this)::FIELDS;
        if(is_array($fields)) {
            foreach ($fields as &$field) {
                if(isset($field['primaryKey']) && $field['primaryKey']) {
                    $primaryKeyAmount++;
                }
            }
        }
        if(!is_array($fields) || empty(get_class($this)::TABLE) || $primaryKeyAmount != 1) {
            throw new Exceptions\InvalidEntityConstantException();
        }
    }

    public function isValid() {
        foreach (get_class($this)::FIELDS as $field) {
            if(isset($field['required']) && $field['required'] && empty($this->{$field['fieldName']})) {
                return false;
            }
        }
        return true;
    }

    public function getPrimaryKey() {
        foreach (get_class($this)::FIELDS as $key => $field) {
            if(isset($field['primaryKey']) && $field['primaryKey']) {
                return [$key => $field];
            }
        }
        return [];
    }

    public function getForeignKeys() {
        $foreignKeys = [];
        foreach (get_class($this)::FIELDS as $key => $field) {
            if(isset($field['foreignKey']) && $field['foreignKey']) {
                $foreignKeys[$key] = $field;
            }
        }
        return $foreignKeys;
    }

    public abstract function prePersist();
    public abstract function postPersist($primaryKey);
    public abstract function preUpdate();
    public abstract function postUpdate();

}
