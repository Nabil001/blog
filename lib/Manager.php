<?php

namespace Library;

abstract class Manager {

    protected $pdo;

    public abstract function getEntity();

    public function __construct(\PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function insert($instance) {
        if($this->check($instance) && $instance->isValid()) {
            $fields = $this->getEntity()::FIELDS;
            $sql = 'INSERT INTO :table (';

            foreach ($fields as $key => &$field) {
                if(!((isset($field['primaryKey']) && $field['primaryKey'])
                    && (isset($field['autoIncrement']) && $field['autoIncrement']))) {
                    $sql .= $key.($field == end($fields) ? ') VALUES (' : ', ');
                }
            }
            foreach ($fields as $key => &$field) {
                if(!((isset($field['primaryKey']) && $field['primaryKey'])
                    && (isset($field['autoIncrement']) && $field['autoIncrement']))) {
                        $sql .= ':'.$key.($field == end($fields) ? ')' : ', ');
                    }
            }

            $insertQuery = $this->pdo->prepare($sql);

            $instance->prePersist();
            $reflection = new \ReflectionClass($instance);
            foreach ($fields as $key => &$field) {
                if(!((isset($field['primaryKey']) && $field['primaryKey'])
                    && (isset($field['autoIncrement']) && $field['autoIncrement']))) {
                        $property = $reflection->getProperty($field['fieldName']);
                        $property->setAccessible(true);
                        $insertQuery->bindValue($key, $property->getValue($instance));
                    }
            }
            $insertQuery->bindValue(':table', $this->getEntity()::TABLE);
            $insertQuery->execute();
            $instance->postPersist($this->pdo->lastInsertId());
        }
    }

    public function update($instance) {
        if($this->check($instance) && $instance->isValid()) {
            $fields = $this->getEntity()::FIELDS;
            $sql = 'UPDATE '.$this->getEntity()::TABLE. ' SET ';
            foreach ($fields as $key => &$field) {
                if(!isset($field['primaryKey']) || !$field['primaryKey']) {
                    $sql .= $key.' = :'.$key.($field == end($fields) ? ' WHERE ' : ', ');
                }
                else {
                    $primaryKey = $key;
                }
            }
            $sql .= $primaryKey.' = :'.$primaryKey;

            $updateQuery = $this->pdo->prepare($sql);

            $instance->preUpdate();
            $reflection = new \ReflectionClass($instance);
            foreach ($fields as $key => &$field) {
                $property = $reflection->getProperty($field['fieldName']);
                $property->setAccessible(true);
                $updateQuery->bindValue($key, $property->getValue($instance));
            }
            $updateQuery->execute();
            $instance->postUpdate();
        }
    }

    public function delete($instance) {
        $this->check($instance);
        $sql = 'DELETE FROM :table WHERE ';
        foreach ($this->getEntity()::FIELDS as $key => &$field) {
            if(isset($field['primaryKey']) && $field['primaryKey']) {
                $primaryKey = $key;
                $primaryKeyField = &$field;
                break;
            }
        }
        $sql .= $key.' = :'.$key;

        $deleteQuery = $this->pdo->prepare($sql);

        $reflection = new \ReflectionClass($instance);
        $property = $reflection->getProperty($primaryKeyField['fieldName']);
        $property->setAccessible(true);
        $deleteQuery->bindValue($primaryKey, $property->getValue($instance));
        $deleteQuery->bindValue('table', $this->getEntity()::TABLE);
        $deleteQuery->execute();
    }

    public function get($givenPrimaryKey) {
        $fields = $this->getEntity()::FIELDS;
        $sql = 'SELECT ';
        foreach ($fields as $key => &$field) {
                $sql .= $key.' AS '.$field['fieldName'].($field == end($fields) ? ' FROM ' : ', ');
            if(isset($field['primaryKey']) && $field['primaryKey']) {
                $primaryKey = $key;
            }
        }
        $sql .= $this->getEntity()::TABLE . ' WHERE '.$primaryKey. ' = :'.$primaryKey;

        $getQuery = $this->pdo->prepare($sql);

        $getQuery->bindValue($primaryKey, $givenPrimaryKey);
        $getQuery->execute();

        $getQuery->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, $this->getEntity());
        $object = $getQuery->fetch();
        $getQuery->closeCursor();

        return $object;
    }

    public function getList() {
        $fields = $this->getEntity()::FIELDS;

        $ordering = [];
        foreach ($fields as $key => &$field) {
            if(isset($field['order'])) {
                $ordering['orderingColumn'] = $field['fieldName'];
                $ordering['order'] = $field['order'];
            }
        }

        $sql = 'SELECT ';
        foreach ($fields as $key => &$field) {
            $sql .= $key.' AS '.$field['fieldName'].($field == end($fields) ? ' FROM ' : ', ');
        }
        $sql .= $this->getEntity()::TABLE;
        $sql .= !empty($ordering) ?
                    ' ORDER BY :orderingColumn :order';

        $getListQuery = $this->pdo->prepare($sql);
        $getListQuery->bindValue('orderingColumn', $ordering['orderingColumn']);
        $getListQuery->bindValue('order', $ordering['order']);
        $getListQuery->execute();
        $getListQuery->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, $this->getEntity());
        $objects = $getListQuery->fetchAll();
        $getListQuery->closeCursor();

        return $objects;
    }

    protected function check($instance) {
        if(!is_a($instance, $this->getEntity()) || !is_subclass_of($instance, '\Library\Entity')) {
            throw new \InvalidArgumentException('The given instance is not valid');
        }
        return true;
    }

}
