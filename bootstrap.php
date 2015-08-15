<?php
use Breach\Dispatcher;
use Breach\Request;

# build routes
$__routes = [
    # /
    '\/' => function () {
        return 'Hello world!';
    },
    '\/number\/(\d+)' => [
        'callback' => function ($number) {
            return 'The number is: ' . $number;
        },
        'before' => function () {
            return 'im before number<br />';
        },
        'after' => function() {
            return '<br />now im done';
        }
    ],
    # error pages
    '404' => function () {
        return '404, page not found.';
    }
];

# create a dispatcher and run against the requested uri
$disp = new Dispatcher($__routes);
$disp->run(new Request());

# end
