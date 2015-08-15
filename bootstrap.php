<?php
use Breach\Dispatcher;
use Breach\Request;

# build routes
$__routes = [
    # ?
    '\/auth' => [
        'callback' => function() {
            return 'Auth calling back!';
        },
        'before' => function() {
            return 'Always triggered before callback.';
        }
    ],
    /*
    # /
    '\/' => function () {
        return 'Hello world!';
    },
    # /count/{number}
    '\/number\/(\d+)' => function ($count) {
        return 'Number is: '.$count;
    },
    # 404 page
    '404' => function () {
        return '404, page not found.';
    }
    */
];

# create a dispatcher and run against the requested uri
$disp = new Dispatcher($__routes);
$disp->run(new Request());

# end
