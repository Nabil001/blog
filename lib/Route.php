<?php

namespace Library;

class Route {

    protected $module;
    protected $action;
    protected $urlPattern;
    protected $slugs;

    public function __construct($module, $action, $urlPattern, array $slugs = []) {
        $firstChar = $urlPattern[0];
        $lastChar = substr($urlPattern, -1);
        if(strcmp($firstChar, $lastChar) != 0) {
            throw new \InvalidArgumentException('The given URL pattern,'.$urlPattern.' is invalid' . "\n");
        }
        $this->module = strval($module);
        $this->action = strval($action);
        $this->urlPattern = strval($urlPattern);
        $this->slugs = $slugs;
    }

    public function matches($url) {
        $actionParameters = [];
        if(preg_match($this->urlPattern, $url, $matches)) {
            //si il y a correspondance, on parcourt le tableau des slugs
            for($i = 0 ; $i < count($this->slugs) ; $i++) {
                if(isset($matches[$i + 1])) {
                    //Si un slug a sa valeur dans l'URL, on la lui attribut sous format clé-valeur
                    $actionParameters[$this->slugs[$i]] = $matches[$i + 1];
                }
            }
        }
        else {
            return false;
        }

        return $actionParameters;
    }

    public function getModule() {
        return $this->module;
    }

    public function getAction() {
        return $this->action;
    }

    public function getUrlPattern() {
        return $this->urlPattern;
    }

}
