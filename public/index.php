<?php
# components
require __DIR__ . "/../breach/breach.php";

# autoload from folders
class_paths([
    __DIR__ . "/../",
    __DIR__ . "/../app/controllers",
    __DIR__ . "/../breach"
]);

# bootstrap
require __DIR__ . "/../bootstrap.php";

# end