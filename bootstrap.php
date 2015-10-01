<?php
use Breach\Dispatcher;
use Breach\Request;

// define a dispatcher
$__d = new Dispatcher();

# map default routes
$__d->map(
    require(__DIR__.'/app/routes.php'),
    require(__DIR__.'/app/routes/app-routes.php')
);

# create a dispatcher and run against the requested uri
$__d->run( new Request );

# end