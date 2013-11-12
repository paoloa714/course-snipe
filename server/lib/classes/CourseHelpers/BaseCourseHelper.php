<?php

abstract class BaseCourseHelper{
    protected $_config;
    
    abstract public function getTerms();
    abstract public function getSubjects();
    abstract public function getClasses($course,$term,$quarter);
    abstract public function getSections($class,$course,$term,$quarter);
}
