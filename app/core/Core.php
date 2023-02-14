<?php

namespace app\core;

class Core {

    private $controller;
    private $method;
    private $param;
    private $url;

    function __construct() {
        $this->baseUri();
    }

    public function run() {
        $class = $this->getController();
        if(strpos(strtolower($class), 'api') !== false){
            $controller = new $class($this->getParam());
        } else {
            $controller = new $class;
        }
        
        
        call_user_func_array(array($controller, $this->getMethod()), $this->getParam());
    }

    protected function baseUri() {
        $this->url = explode(CONF_FILE_DEFAULT, $_SERVER['PHP_SELF']);

        $this->url = end($this->url);

        if ($this->url) {
            $this->url = explode("/", $this->url);
            array_shift($this->url);

            $this->controller = ucfirst(strtolower($this->url[0])) . CONF_NAME_CONTROLLER_DEFAULT;
            array_shift($this->url);

            if (isset($this->url[0])) {
                $this->method = $this->url[0];
                array_shift($this->url);
            }

            if (isset($this->url[0])) {
                $this->param = array_filter($this->url);
            }
        } else {
            $this->controller = ucfirst(strtolower(CONF_CONTROLLER_DEFAULT)) . CONF_NAME_CONTROLLER_DEFAULT;
        }
    }

    function getController() {
        if (class_exists(CONF_NAMESPACE_DEFAULT . $this->controller)) {
            return CONF_NAMESPACE_DEFAULT . $this->controller;
        } else {
            return CONF_NAMESPACE_DEFAULT . CONF_CONTROLLER_DEFAULT . CONF_NAME_CONTROLLER_DEFAULT;
        }
    }

    function getMethod() {
        if (method_exists(CONF_NAMESPACE_DEFAULT . $this->controller, $this->method)) {
            return $this->method;
        }
        return CONF_METHOD_DEFAULT;
    }

    function getParam() {
        if ($this->param) {
            return $this->param;
        }
        return array();
    }

}
