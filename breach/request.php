<?php namespace Breach;

class Request
{
    public $uri;

    public $querystring;

    function __construct()
    {
        $this->uri = $_SERVER['REQUEST_URI'];
        $this->querystring = '';
        //
        if (strpos($this->uri, '?')) {
            $this->querystring = substr($this->uri, 0, strpos($this->uri, '?'));
        }
    }

    static function get($name, $default = null)
    {
        return filter_input(INPUT_GET, $name);
    }

    static function post($name, $default = null)
    {
        return filter_input(INPUT_POST, $name);
    }
}

# end