<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class MyJS {

    private $jsArray = array();
    private $jsFileArray = array();
	
    public function __construct() {
        $this->CI = &get_instance();
    }


    public function add($js) {
		$this->jsArray[] = $js;
    }

    public function addFile($file) {
        $this->jsFileArray[] = $file;
    }

    private function unsetLang($lang) {
        // ex: unset($lang['category']);
        

        return $lang;
    }

	public function active() {
        $myJsLang = json_encode($this->unsetLang($this->CI->lang->language));
        echo "<script type='text/javascript'>
            var myLang = {$myJsLang};
        </script>";

        echo "<script type='text/javascript'>";
		foreach ( $this->jsArray as $js ) { 
			echo $js;
		}
        echo "</script>";


        /* for google analytics */
        if ( ENVIRONMENT == 'production' ) {
            echo "<script type='text/javascript'>
                (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
                })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

                ga('create', 'UA-79650279-2', 'auto');
                ga('send', 'pageview');
            </script>";
        }  
	}

    public function getAllFiles() {
        $result = array();
        foreach ( $this->jsFileArray as $file ) {
            $result[] = "<script type='text/javascript' src='{$file}'></script>";
        }
        $result = join('', $result);


        return $result;
    }
	
}