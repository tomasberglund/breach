<?php
# controller example
class homeController extends \Breach\Controller
{
    static function start()
    {
        $name = input_get('name', 'John Doe');
        return "homeController::start saying hello to {$name}!";
    }

    static function beforestart()
    {
        return '<b>im before home/start</b><br />';
    }

    static function afterstart()
    {
        return '<b>im after home/start</b><br />';
    }
}

# end