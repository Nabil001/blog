<?php

namespace Library;

class Route {

    protected $module;
    protected $action;
    protected $urlPattern;
    protected $slugs;

    public function __construct($module, $action, $urlPattern, array $slugs = []) {
        if(!empty($urlPattern) && strcmp($urlPattern[0], substr($urlPattern, -1)) != 0) {
            throw new \InvalidArgumentException('The given URL pattern,'.$urlPattern.' is invalid' . "\n");
        }
        $this->module = $module;
        $this->action = $action;
        $this->urlPattern = $urlPattern;
        $this->slugs = $slugs;
    }

    public function matches($url) {
        $actionParameters = [];
        if(!empty($this->urlPattern) && preg_match($this->urlPattern, $url, $matches)) {
            //if there's a match, we go through the slugs array
            for($i = 0 ; $i < count($this->slugs) ; $i++) {
                if(!empty($matches[$i + 1])) {
                    //we have to trim the first character in case of an optional parameter in URL
                    //the URL is of a (-[1-9][0-9]{0,}) form in such a case
                    $matches[$i + 1] = preg_replace('#^[-_\\/?!:;%\.](.+)#', '$1' , $matches[$i + 1]);
                    //if a slug has been attributed a value in the URL, the couple is added in a key-value array
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
