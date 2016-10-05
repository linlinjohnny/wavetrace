<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class MyCss {

    private $cssFileArray = array();

    public function __construct() {
        $this->CI = &get_instance();
    }


    public function addFile($file) {
        $this->cssFileArray[] = $file;
    }

    public function getAllFiles() {
        $result = array();
        foreach ( $this->cssFileArray as $file ) {
            $result[] = "<link rel='stylesheet' href='{$file}' />";
        }
        $result = join('', $result);


        return $result;
    }
    
}