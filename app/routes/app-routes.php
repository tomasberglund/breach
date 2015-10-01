<?php
# application routes
return [
    'GET \/number\/(\d+)' => [
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
    'POST \/number\/(\d+)' =>  function ($number) {
        return 'POST The number is: ' . $number;
    },
    'PUT \/number\/(\d+)' =>  function ($number) {
        return 'PUT The number is: ' . $number;
    },
];

# end