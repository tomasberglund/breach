<?php namespace Breach;

class Dispatcher
{
    /**
     * routes container
     *
     * @var
     */
    public $routes;

    /**
     * class constructor
     * defines available routes
     *
     * @param $routes
     */
    public function __construct($routes)
    {
        $this->routes = $routes;
    }

    /**
     * match routes against Request
     *
     * @param Request $request
     */
    public function run(Request $request)
    {
        $response = false;

        // try to match a route based on Request
        foreach ($this->routes as $route => $action) {
            // get http method and remove if available else set GET as default
            $__request_method = explode(' ', $route);
            $__method = 'GET';

            if (isset($__request_method[0])) {
                if(in_array($__request_method[0], $request->available_methods)) {
                    $__method = $__request_method[0];
                    # remove method from $route
                    $route = mb_substr($route, mb_strlen($__request_method[0])+1);
                }
            }

            // match route
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
                /*
                if (!is_callable($action['after'])) {
                    if (isset($action['after'])) {
                        if (is_callable($action['after'])) {
                            echo call_user_func_array($action['after'], []);
                        }
                    }
                }*/
            }
        }

        // not found, 404
        if ($response === false) {
            $response = $this->routes['404'];
        }
    }
}

# end