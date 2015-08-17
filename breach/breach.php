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

# end