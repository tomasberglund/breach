<?php namespace Breach;

class Dispatcher
{
    public $routes;

    public function __construct($routes)
    {
        $this->routes = $routes;
    }

    private function match($uri)
    {

    }

    public function run(Request $request)
    {
        // try to match a route based on Request
        foreach ($this->routes as $route => $action) {
            if (preg_match('/^' . $route . '$/', $request->uri, $matches)) {
                // is there a before callback defined?
                if(isset($action['before'])) {
                    if(is_callable($action['before'])) {
                        echo call_user_func_array($action['before'], []);
                    }
                }
                // get the parameters, if any, skip first part
                $parameters = array_slice($matches, 1);
                // define the action
                $response = $action['callback'];
            }
        }

        // not found, 4040
        if ($response === false) {
            $response = $this->routes['404'];
        }

        // respond
        echo call_user_func_array($response, $parameters);
    }
}

# end