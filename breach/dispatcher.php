<?php namespace Breach;

class Dispatcher
{
    /**
     * routes container
     *
     * @var
     */
    public static $routes;

    /**
     * map routes to dispatcher
     *
     * @param $routes
     */
    public static function map(...$routes)
    {
        # add route to static::$routes
        foreach ($routes as $route) {
            if (count($route) === 1) {
                static::$routes[array_keys($route)[0]] = array_values($route)[0];
            } else {
                foreach ($route as $__r => $__c) {
                    static::$routes[$__r] = $__c;
                }
            }
        }
    }

    /**
     * match routes against Request
     *
     * @param Request $request
     */
    public static function run(Request $request)
    {
        $response = false;
        # events
        event_trigger('app.start');
        # try to match a route based on Request
        foreach (static::$routes as $route => $action) {
            # get http method and remove if available else set GET as default
            $__request_method = explode(' ', $route);
            $__method = 'GET';
            # method
            if (isset($__request_method[0])) {
                if (in_array($__request_method[0], $request->available_methods)) {
                    $__method = $__request_method[0];
                    # remove method from $route
                    $route = mb_substr($route, mb_strlen($__request_method[0]) + 1);
                }
            }
            # match route
            if (preg_match('/^' . $route . '$/', $request->uri, $matches)) {
                if ($request->http_method === $__method) {
                    # is there a before callback defined?
                    if (!is_callable($action)) {
                        if (isset($action['before'])) {
                            if (is_callable($action['before'])) {
                                echo apply($action['before'], []);
                            }
                        }
                    }
                    # get the parameters, if any, skip first part
                    $parameters = array_slice($matches, 1);
                    # define the action
                    $response = (!is_callable($action)) ? $action['callback'] : $action;
                    # trigger main callback
                    echo apply($response, $parameters);
                    # events
                    event_trigger('route.after');
                    event_trigger('app.done');
                    # matched so bail out
                    exit;
                }
            }
        }
        # not found, 404
        if ($response === false) {
            if (isset(static::$routes['404'])) {
                echo apply(static::$routes['404'], []);
            } else {
                # set response code and headers
                http_response_code(404);
                echo '404 man';
            }
        }
        # done event
        event_trigger('app.done');
    }
}
# end