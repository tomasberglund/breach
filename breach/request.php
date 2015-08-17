<?php namespace Breach;

class Request
{
    /**
     * holds the requests URI
     *
     * @var
     */
    public $uri;

    /**
     * holds the requests querystring
     *
     * @var string
     */
    public $querystring;

    /**
     * available http methods
     *
     * @var array
     */
    public $available_methods = ['GET', 'POST', 'PUT', 'DELETE'];

    /**
     * class constructor
     * stores URI and Querystring (if available)
     *
     */
    function __construct()
    {
        $this->uri = $_SERVER['REQUEST_URI'];
        $this->querystring = '';
        //
        if (strpos($this->uri, '?')) {
            $this->querystring = substr($this->uri, 0, strpos($this->uri, '?'));
        }
    }

    /**
     * helper for fetching input from GET
     *
     * @param $name
     * @param null $default
     * @return mixed
     */
    static function get($name, $default = null)
    {
        return filter_input(INPUT_GET, $name);
    }

    /**
     * helper for fetching input from POST
     *
     * @param $name
     * @param null $default
     * @return mixed
     */
    static function post($name, $default = null)
    {
        return filter_input(INPUT_POST, $name);
    }
}

# end