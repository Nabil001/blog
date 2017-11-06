<?php

namespace Blog\Controllers;

class PostController extends \Library\Controller {

    public function __construct(\Library\Route $route, \Library\Application $application, array $actionParameters = []) {
        parent::__construct($route, $application, $actionParameters);
        $this->manager = new \Library\PostManager(\Library\PDOFactory::getInstance());
    }

    public function listAction($page, $limit = 5) {
        if($page <= 0 || $limit != 5 && $limit != 10) {
            $errorController = $this->application->get503ErrorController();
            return $errorController->show503Action();
        }
        try{
            $posts = $this->manager->getList();
        } catch(\PDOException $e) {
            $errorController = $this->application->get503ErrorController();
            return $errorController->show503Action();
        }
        $pagesAmount = ceil(count($posts) / $limit);
        $posts = array_slice($posts, ($page - 1) * $limit, $limit);

        return $this->render('list', ['posts' => $posts, 'page' => $page, 'limit' => $limit, 'pagesAmount' => $pagesAmount]);
    }

    public function showAction($id) {
        try {
            $post = $this->manager->get($id);
        } catch(\PDOException $e) {
            $errorController = $this->application->get503ErrorController();
            return $errorController->show503Action();
        }
        if(empty($post)) {
            $errorController = $this->application->get404ErrorController();
            return $errorController->show404Action();
        }

        return $this->render('show', ['post' => $post]);
    }

    public function updateAction($id) {
        $request = $this->application->getRequest();
        $notifArray = [];
        if($request->getMethod() == 'POST') {
            $post = new \Blog\Models\Post();
            $post->setId($id);
            $request->hydrate($post);

            if(empty($post->getAuthor())) {
                $notifArray['authorNotif'] = 'The author field is empty';
            }
            else if(strlen($post->getAuthor()) < 2) {
                $notifArray['authorNotif'] = 'The author field is too short';
            }

            if(empty($post->getTitle())) {
                $notifArray['titleNotif'] = 'The title field is empty';
            }
            else if(strlen($post->getTitle()) < 5) {
                $notifArray['titleNotif'] = 'The title field is too short';
            }

            if(empty($post->getLead())) {
                $notifArray['leadNotif'] = 'The lead field is empty';
            }
            else if(strlen($post->getLead()) < 15) {
                $notifArray['leadNotif'] = 'The lead field is too short';
            }

            if(empty($post->getContent())) {
                $notifArray['contentNotif'] = 'The content field is empty';
            }
            else if(strlen($post->getContent()) < 30) {
                $notifArray['contentNotif'] = 'The content field is too short';
            }

            if(empty($notifArray)) {
                try {
                    $this->manager->update($post);
                    header('Location: /show-'.$id);
                } catch(\PDOException $e) {
                    $errorController = $this->application->get503ErrorController();
                    return $errorController->show503Action();
                }
            }
        }

        else {
            try {
                $post = $this->manager->get($id);
            } catch(\PDOException $e) {
                $errorController = $this->application->get503ErrorController();
                return $errorController->show503Action();
            }
            if(empty($post)) {
                $errorController = $this->application->get404ErrorController();
                return $errorController->show404Action();
            }
        }

        return $this->render('update', array_merge($notifArray, ['post' => $post]));
    }

    public function addAction() {
        $request = $this->application->getRequest();
        $notifArray = [];
        $post = new \Blog\Models\Post();
        if($request->getMethod() == 'POST') {
            $request->hydrate($post);

            if(empty($post->getAuthor())) {
                $notifArray['authorNotif'] = 'The author field is empty';
            }
            else if(strlen($post->getAuthor()) < 2) {
                $notifArray['authorNotif'] = 'The author field is too short';
            }

            if(empty($post->getTitle())) {
                $notifArray['titleNotif'] = 'The title field is empty';
            }
            else if(strlen($post->getTitle()) < 5) {
                $notifArray['titleNotif'] = 'The title field is too short';
            }

            if(empty($post->getLead())) {
                $notifArray['leadNotif'] = 'The lead field is empty';
            }
            else if(strlen($post->getLead()) < 15) {
                $notifArray['leadNotif'] = 'The lead field is too short';
            }

            if(empty($post->getContent())) {
                $notifArray['contentNotif'] = 'The content field is empty';
            }
            else if(strlen($post->getContent()) < 30) {
                $notifArray['contentNotif'] = 'The content field is too short';
            }

            if(empty($notifArray)) {
                try {
                    $this->manager->insert($post);
                    header('Location: /list-1');
                } catch(\PDOException $e) {
                    $errorController = $this->application->get503ErrorController();
                    return $errorController->show503Action();
                }
            }
        }

        return $this->render('add', array_merge($notifArray, ['post' => $post]));
    }

}
