<?php
# default routes
return [
    # /
    '\/' => function () {
        return 'Hello world!';
    },
    # callable function
    '\/callme' => 'me_callable',
    # callable class
    '\/classact' => 'classact::index',
    # error pages
    '404' => function () {
        return '404, page not found.';
    }
];

# end