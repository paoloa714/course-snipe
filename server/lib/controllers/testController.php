<?php

require_once('vendor/autoload.php');

class testController extends requestController {

    public function run($Campus = 'UCLA') {
        $Campus = 'UCLA';
        $courseHelperName = $Campus.'CourseHelper';
        $courseHelper = new $courseHelperName();
        
        var_dump(Utils::getConfig('UCLA'));
    }

}