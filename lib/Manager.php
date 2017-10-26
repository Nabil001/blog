<?php

namespace Library;

abstract class Manager {

    protected $pdo;
    protected $managedClass;
    protected $table;
    protected $primaryKey;

    public function __construct(\PDO $pdo, $table = '') {
        $this->pdo = $pdo;
        preg_match('#([a-zA-Z0-9]+)Manager$#', get_class($this), $matches);
        $this->managedClass = '\\'.__NAMESPACE__.'\\'.$matches[1];
        if(empty($table)) {
            $this->table = $matches[1];
        }
        else {
            $this->table = $table;
        }
        $checkExistenceQuery = $this->pdo->query('SELECT Table_Name
                                            FROM INFORMATION_SCHEMA.Tables
                                            WHERE Table_Name = \''.$this->table.'\''
                                        );
        if($checkExistenceQuery->rowCount() == 0) {
            throw new Exceptions\NoSuchTableException($this->table);
        }
        $checkExistenceQuery->closeCursor();

        $pkQuery = $this->pdo->query('SELECT DISTINCT Column_Name
                                        FROM INFORMATION_SCHEMA.Key_Column_Usage
                                        WHERE Constraint_Name = \'PRIMARY\'
                                        AND Table_Name = \''.$this->table.'\''
                                    );
        if($checkExistenceQuery->rowCount() == 0) {
            throw new Exceptions\NoPrimaryKeyException($this->table);
        }
        $this->primaryKey = $pkQuery->fetchColumn();
        $pkQuery->closeCursor();
    }

    public function save($instance) {
        if($this->check($instance) && $instance->isValid()) {
            if($instance->isIdentified()) {
                $this->update($instance);
            }
            else {
                $this->insert($instance);
            }
        }
    }

    protected function insert($instance) {
        if($this->check($instance) && $instance->isValid()) {
            $fields = $instance->getFields();
            $sql = 'INSERT INTO '.$this->table.' (';
            for($i = 0 ; $i < count($fields) ; $i++) {
                if($fields[$i] != $this->primaryKey) {
                    $sql .= $fields[$i].($i != count($fields) - 1 ? ', ' : ')');
                }
            }
            $sql .= ' VALUES (';
            for($i = 0 ; $i < count($fields) ; $i++) {
                if($fields[$i] != $this->primaryKey) {
                    $sql .= ':'.$fields[$i].($i != count($fields) - 1 ? ', ' : ')');
                }
            }
            $valuesToSave = $instance->getValuesToSave();
            unset($valuesToSave[$this->primaryKey]);
            $insertQuery = $this->pdo->prepare($sql);
            $insertQuery->execute($valuesToSave);
        }
    }

    protected function update($instance) {
        if($this->check($instance) && $instance->isValid()) {
            $fields = $instance->getFields();
            $sql = 'UPDATE '.$this->table.' SET ';
            for($i = 0 ; $i < count($fields) ; $i++) {
                if($fields[$i] != $this->primaryKey) {
                    $sql .= $fields[$i].' = :'.$fields[$i].($i != count($fields) - 1 ? ', ' : '');
                }
            }
            $sql .= ' WHERE '.$this->primaryKey.' = :'.$this->primaryKey;
            $updateQuery = $this->pdo->prepare($sql);
            $updateQuery->execute($instance->getValuesToSave());
        }
    }

    public function delete($instance) {
        $this->check($instance);
        $sql = 'DELETE FROM '.$this->table.' WHERE '.$this->primaryKey.' = :'.$this->primaryKey;
        $deleteQuery = $this->pdo->prepare($sql);
        $deleteQuery->execute([$this->primaryKey => $instance[$this->primaryKey]]);
    }

    public function get($pkValue) {
        $getQuery = $this->pdo->query('SELECT * FROM '.$this->table.' WHERE '.$this->primaryKey.' = '.intval($pkValue));
        $getQuery->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, $this->managedClass);
        $post = $getQuery->fetch();
        $getQuery->closeCursor();
        return $post;
    }

    public function getList() {
        $getListQuery = $this->pdo->query('SELECT * FROM '.$this->table);
        $getListQuery->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, $this->managedClass);
        $posts = $getListQuery->fetchAll();
        $getListQuery->closeCursor();
        return $posts;
    }

    protected function check($instance) {
        if(!is_a($instance, $this->managedClass) || !is_subclass_of($instance, '\Library\TableRow')) {
            throw new \InvalidArgumentException('The parameter isn\'t an instance of '.$this->managedClass);
        }
        return true;
    }

}
