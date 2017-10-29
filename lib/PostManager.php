<?php

namespace Library;

class PostManager extends Manager {

    public function getEntity() {
        return '\\Blog\\Models\\Post';
    }

}
