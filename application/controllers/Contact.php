<?php

class Contact extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('contact/Mod_contact_html');
        $this->load->model('contact/Mod_contact_js');
    }

    public function index() {
        $data = array(
            'sendMailUrl' => "{$this->baseUrl}contact_service/sendMail/"
        );       

        $this->mylayout->add(SYS_HEADER_BOX, $this->mytemplate->sysBar($data));
        $this->mylayout->add(SYS_CONTENT_BOX, $this->Mod_contact_html->index($data));
        $this->mylayout->add(SYS_FOOTER_BOX, $this->mytemplate->sysFooter($data));
        $this->Mod_contact_js->index($data);
        $this->mycss->addFile("{$this->baseUrl}assets/css/application/my_contact.css");

        $data = array(
            'webTitle' => $this->lang->line('contact_metaTitle'),
            'webDescription' => $this->lang->line('contact_metaKeywords'),
            'webKeywords' => $this->lang->line('contact_metaDescription')
        );
        $this->load->view('common', $data);
    }

}
