<?php


class testController extends requestController {

    public function run($Campus = 'UCLA') {
        $Campus = 'UCLA';
        $courseHelperName = $Campus.'CourseHelper';
        $courseHelper = new $courseHelperName();
        return $courseHelper->getSubjects();
       
    }

}