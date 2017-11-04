<?php

namespace Blog\Models;

class Post extends \Library\Entity {

    const TABLE = 'Post';
    const FIELDS = [
        'id' => [
            'fieldName' => 'id',
            'type' => 'integer',
            'nullable' => false,
            'primaryKey' => true,
            'foreignKey' => false,
            'autoIncrement' => true,
        ],
        'title' => [
            'fieldName' => 'title',
            'type' => 'varchar',
            'length' => 255,
            'nullable' => false,
            'required' => true
        ],
        'lead' => [
            'fieldName' => 'lead',
            'type' => 'text',
            'nullable' => false,
            'required' => true
        ],
        'content' => [
            'fieldName' => 'content',
            'type' => 'text',
            'nullable' => false,
            'required' => true
        ],
        'author' => [
            'fieldName' => 'author',
            'type' => 'varchar',
            'length' => 100,
            'nullable' => false,
            'required' => true
        ],
        'last_update' => [
            'fieldName' => 'lastUpdate',
            'type' => 'datetime',
            'nullable' => false,
            'required' => true,
        ]
    ];

    protected $id;
    protected $title;
    protected $lead;
    protected $content;
    protected $author;
    protected $lastUpdate;

    public function __construct() {
        parent::__construct();
        $this->lastUpdate = '0000-00-00 00:00:00';
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = (int) $id;
    }

    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
    }
    public function getLead() {
        return $this->lead;
    }

    public function setLead($lead) {
        $this->lead = $lead;
    }

    public function getContent() {
        return $this->content;
    }

    public function setContent($content) {
        $this->content = $content;
    }

    public function getAuthor() {
        return $this->author;
    }

    public function setAuthor($author) {
        $this->author = $author;
    }

    public function getLastUpdate() {
        return new \DateTime($this->lastUpdate);
    }

    public function setLastUpdate($lastUpdate) {
        $this->lastUpdate = $lastUpdate;
    }

    public function prePersist() {
        $this->title = ucfirst($this->title);
        $this->lead = ucfirst($this->lead);
        $this->content = ucfirst($this->content);
        $this->author = ucwords($this->author);
        $this->lastUpdate = date('Y-m-d H:i:s');
    }

    public function postPersist($primaryKey) {
        $this->id = $primaryKey;
    }

    public function preUpdate() {
        $this->title = ucfirst($this->title);
        $this->lead = ucfirst($this->lead);
        $this->content = ucfirst($this->content);
        $this->author = ucwords($this->author);
        $this->lastUpdate = date('Y-m-d H:i:s');
    }

    public function postUpdate() {}

}
