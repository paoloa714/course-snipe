<?php

class UCLACourseHelper extends BaseCourseHelper {

    public function __construct() {
        $this->_config = Utils::getConfig('UCLA');
    }

    public function getTerms() {
        $html = new simple_html_dom();
        $html->load_file($this->_config['url']['terms']);
        
        $something = $html->find('[id$=TermDisp] option');
        
        $return = array();
        foreach($something as $element){
            $return[$element->value] = $element->innertext;
        }
        
        return $return;
        
    }

    public function getCourses($term, $quarter) {
        return 'Courses';
    }

    public function getClasses($course, $term, $quarter) {
        return 'Classes';
    }

    public function getSections($class, $course, $term, $quarter) {
        return 'Sections';
    }

}
