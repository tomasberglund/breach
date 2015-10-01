<?php
/**
 * Base Autoloader
 *
 * @param $paths
 */
function class_paths($paths)
{
    foreach ($paths as $path) {
        set_include_path(get_include_path() . PATH_SEPARATOR . __DIR__ . PATH_SEPARATOR . $path . PATH_SEPARATOR);
    }

    spl_autoload_register(function ($c) {
        require preg_replace('#\\\|_(?!.*\\\)#', '/', strtolower($c)) . '.php';
    });
}

/**
 * Runs a callable with an array of arguments. Throws a RuntimeError on invalid
 * callables.
 *
 * @param callable $callable Callable to run
 * @param array    $args     Arguments for the callable
 *
 * @return mixed Any value returned from the callback
 */
function apply($callable, $args = array())
{
    if (!is_callable($callable)) {
        throw new \RuntimeException('invalid callable');
    }
    return call_user_func_array($callable, $args);
}

/**
 * Gets or sets event handlers. Pass two arguments as event name and handler to
 * register an event handler. Pass a single argument as event name to return its
 * handlers. Returns null for unrecognized event name.
 *
 * @param string   $event    Event name
 * @param callable $callback Event handler callback
 *
 * @return mixed
 */
function event_register($event = null, $callback = null)
{
    static $handlers = array();
    if (func_num_args() > 1) {
        $handlers[$event][] = $callback;
    } elseif (func_num_args()) {
        return isset($handlers[$event]) ? $handlers[$event] : null;
    } else {
        return $handlers;
    }
}
/**
 * Triggers a registered event.
 *
 * @param string $event Event name
 *
 * @return mixed
 */
function event_trigger($event)
{
    $data = func_get_args();
    array_shift($data);
    if ($handlers = event_register($event)) {
        foreach ($handlers as $callback) {
            apply($callback, $data);
        }
    }
}

# end