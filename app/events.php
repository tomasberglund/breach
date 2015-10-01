<?php
# default events
event_register('app.start', function() {
    echo '<small>EVENT app started</small><br />';
});

event_register('app.done', function() {
    echo '<small><br />EVENT app ended</small><br />';
});

event_register('route.after', function() {
    $__r = new Request();
    var_dump($__r);
});

# end