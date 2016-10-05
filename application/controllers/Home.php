<?php

class Home extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('home/Mod_home_html');
        $this->load->model('home/Mod_home_js');
        $this->load->model('home/Mod_home');

    }

    public function index() {
        $data = array(
            'sysconfigs' => array('copyright' => array('value' => 'copyright')),
            'carousel' => $this->Mod_home->getCarousel()
        );

        $this->mylayout->add(SYS_HEADER_BOX, $this->mytemplate->sysBar($data));
        $this->mylayout->add(SYS_CONTENT_BOX, $this->Mod_home_html->index($data));
        $this->mylayout->add(SYS_FOOTER_BOX, $this->mytemplate->sysFooter($data));
        $this->Mod_home_js->index();
        $this->mycss->addFile("{$this->baseUrl}assets/css/application/my_home.css");


        $data = array(
            'webTitle' => $this->lang->line('home_metaTitle'),
            'webDescription' => $this->lang->line('home_metaDescription'),
            'webKeywords' => $this->lang->line('home_metaKeywords')
        );
        $this->load->view('common', $data);
    }

    public function resultMessage($type) {
        $this->mylayout->add(SYS_CONTENT_BOX, $this->Mod_home_html->resultMessage($type));


        $data = array(
            'webTitle' => '',
            'webDescription' => '',
            'webKeywords' => '',
            'webImage' => '',
            'backgroundCfg' => ''
        );
        $this->load->view('common', $data);
    }

    public function logout(){
        $this->session->sess_destroy();

        $this->mylibrary->reDirect($this->baseUrl);
    }

}
