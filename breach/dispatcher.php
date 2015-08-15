<?php namespace Breach;

class Dispatcher
{
    public $routes;

    public function __construct($routes)
    {
        $this->routes = $routes;
    }

    public function run(Request $request)
    {
        // try to match a route based on Request
        foreach ($this->routes as $route => $action) {
            if (preg_match('/^' . $route . '$/', $request->uri, $matches)) {
                // is there a before callback defined?
                if (!is_callable($action)) {
                    if (isset($action['before'])) {
                        if (is_callable($action['before'])) {
                            echo call_user_func_array($action['before'], []);
                        }
                    }
                }

                // get the parameters, if any, skip first part
                $parameters = array_slice($matches, 1);
                // define the action
                $response = (!is_callable($action)) ? $action['callback'] : $action;
                // trigger main callback
                echo call_user_func_array($response, $parameters);

                // is there a after callback defined?
                if (!is_callable($action)) {
                    if (isset($action['after'])) {
                        if (is_callable($action['after'])) {
                            echo call_user_func_array($action['after'], []);
                        }
                    }
                }
            }
        }

        // not found, 4040
        if ($response === false) {
            $response = $this->routes['404'];
        }
    }
}

# end