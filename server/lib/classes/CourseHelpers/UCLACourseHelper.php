<?php

class UCLACourseHelper extends BaseCourseHelper {

    public function __construct() {
        
    }

    public function getTerms() {
        return 'terms';
    }

    public function getQuarters() {
        return 'quarters';
    }

    public function getCourses($term, $quarter) {
        return 'Given term and quarter, return courses';
    }

    public function getClasses($course, $term, $quarter) {
        return 'Classes';
    }

    public function getSections($class, $course, $term, $quarter) {
        return 'Sections';
    }

}
