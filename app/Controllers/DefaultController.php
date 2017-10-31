<?php

namespace Blog\Controllers;

class DefaultController extends \Library\Controller {

    public function homeAction() {
        $notifArray = [];
        $request = $this->application->getRequest();
        if($request->getMethod() == 'POST') {
            $name = strip_tags(trim($request->getPostData('name')));
            $email = strtolower(strip_tags(trim($request->getPostData('email'))));
            $message = strip_tags(trim($request->getPostData('message')));

            if(empty($name)) {
                $notifArray['nameNotif'] = 'The name field is empty';
            }
            if(empty($email)) {
                $notifArray['emailNotif'] = 'The email field is empty';
            }
            else if(!preg_match('#^[a-z][a-z0-9.-_]+@[a-z0-9.-_]+\.[a-z0-9]{1,4}#', $email)){
                $notifArray['emailNotif'] = 'This is not an email';
            }
            if(empty($message)) {
                $notifArray['messageNotif'] = 'The message field is empty';
            }

            if(!isset($notifArray['nameNotif']) &&
                !isset($notifArray['emailNotif']) &&
                !isset($notifArray['messageNotif'])) {
                //As this project is to be used locally, the mail() function won't run correctly
                //mail('nabil.lemenuel@gmx.fr', 'Email coming from the Blog',
                //                    $message, 'From: '.$name.' <'.$email.'>');
            }
        }

        return $this->render('home', $notifArray);
    }

}
