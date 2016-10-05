<?php

class Contact_service extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('contact/Mod_contact');
    }

    public function updateContact() {

        if ( !$this->mylibrary->isAuthUrl() ) {
            echo $this->mylibrary->serviceReturn(FALSE, $this->lang->line('noPermission'));
            return;
        }

        $id = $this->input->get('id', TRUE);
        $contact = $this->Mod_contact->getContact($id);
        $param = array(
            'response' => $this->input->post('response'),
            'status' => $this->input->post('status', TRUE),
            'updateTime' => date('Y-m-d H:i:s')
        );
        $this->Mod_contact->updateContact($id, $param);

        ignore_user_abort(TRUE);
        set_time_limit(0);
        echo $this->mylibrary->serviceReturn(TRUE);

        if ( $contact->response != $param['response'] ) {
            $this->mylibrary->sendEmail($contact->email, $this->lang->line('contact_replySubject'), strtr($this->lang->line('contact_replyMessage'), array('%REPLY%' => $param['response'])));
        }
    }


    public function deleteContact() {
        if ( !$this->mylibrary->isAuthUrl() ) {
            echo $this->mylibrary->serviceReturn(FALSE, $this->lang->line('noPermission'));
            return;
        }

        $this->Mod_contact->deleteContact($this->input->get('id', TRUE));


        echo $this->mylibrary->serviceReturn(TRUE);
    }

    public function sendMail() {
        $param = array(
            'name'       => $this->input->post('name', TRUE),
            'email'      => $this->input->post('email', TRUE),
            'subject'    => $this->input->post('subject', TRUE),
            'message'    => $this->input->post('message', TRUE),
            'updateTime' => date("Y-m-d H:i:s"),
            'createTime' => date("Y-m-d H:i:s")
        );

        $id = $this->Mod_contact->createContact($param);


        ignore_user_abort(TRUE);
        set_time_limit(0);
        echo $this->mylibrary->serviceReturn(TRUE);

        $message = strtr($this->lang->line('contact_customerMailContent'), array('%NAME%' => $param['name'], '%EMAIL%' => $param['email'], '%SUBJECT%' => $param['subject'], '%MESSAGE%' => $param['message']));
        $this->mylibrary->sendEmail($param['email'], $this->lang->line('contact_customerMailSubject'), $message);
        // $this->mylibrary->sendEmail("mex3300570@gmail.com", "TEST", "TEST");
    }
}