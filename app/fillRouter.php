<?php

namespace Blog;

function fillRouter(\Library\Router $router) {
    $router->addRoute(new \Library\Route('Default', 'home', '#^/(home)?/?$#'));
    $router->addRoute(new \Library\Route('Post', 'add', '#^/add/?$#'));
    $router->addRoute(new \Library\Route('Post', 'list', '#^/list-([1-9][0-9]{0,})(-5|-10)?/?$#', array('page', 'limit')));
    $router->addRoute(new \Library\Route('Post', 'show', '#^/show-([1-9][0-9]{0,})/?$#', array('id')));
    $router->addRoute(new \Library\Route('Post', 'update', '#^/update-([1-9][0-9]{0,})/?$#', array('id')));
}
