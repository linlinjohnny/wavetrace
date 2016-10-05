<?php

class Manage_service extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('manage/Mod_manage');
        $this->load->model('manage/Mod_manage_html');
        $this->load->model('media/Mod_media');
    }

    public function login() {
        $account = $this->input->post('account', TRUE);
        $password = $this->input->post('password', TRUE);

        if ( !$account ) {
            echo $this->mylibrary->serviceReturn(FALSE, $this->lang->line('error_account'));
            return;
        }

        if ( !$password ) {
            echo $this->mylibrary->serviceReturn(FALSE, $this->lang->line('error_password'));
            return;
        }


        $user = $this->Mod_manage->getUser($account, 'account', TRUE);
        if ( !$user ) {
            echo $this->mylibrary->serviceReturn(FALSE, $this->lang->line('error_accountNotExist'));
            return;
        }

        if ( !$this->Mod_manage->login($account, $password) ) {
            echo $this->mylibrary->serviceReturn(FALSE, $this->lang->line('error_passwordNotExist'));
            return;
        }


        echo $this->mylibrary->serviceReturn(TRUE, 'success', array('url' => $this->mylibrary->authUrl("{$this->baseUrl}manage/informationHome?user={$user['account']}")));
    }

    public function messageSend() {
        if ( !$this->mylibrary->isAuthUrl() ) {
            echo $this->mylibrary->serviceReturn(FALSE, $this->lang->line('noPermission'));
            return;
        }


        $email = $this->input->post('email', TRUE);
        $sendToAll = $this->input->post('sendToAll', TRUE);
        $subject = $this->input->post('subject', TRUE);
        $message = $this->input->post('message');

        if ( !$sendToAll && !$email ) {
            echo $this->mylibrary->serviceReturn(FALSE, "[" . $this->lang->line('email') . "] " . $this->lang->line('required'));
            return;
        }

        if ( !$subject ) {
            echo $this->mylibrary->serviceReturn(FALSE, "[" . $this->lang->line('subject') . "] " . $this->lang->line('required'));
            return;
        }

        if ( !$message ) {
            echo $this->mylibrary->serviceReturn(FALSE, "[" . $this->lang->line('content') . "] " . $this->lang->line('required'));
            return;
        }


        ignore_user_abort(TRUE);
        set_time_limit(0);
        echo $this->mylibrary->serviceReturn(TRUE);


        $emails = ( !$sendToAll ) ? explode(',', $email) : $this->Mod_manage->getSubscribers();
        foreach ( $emails as $e ) {
            $this->mylibrary->sendEmail(trim($e), $subject, $message);
        }
    }

    public function deleteEmailRecord() {
        if ( !$this->mylibrary->isAuthUrl() ) {
            echo $this->mylibrary->serviceReturn(FALSE, $this->lang->line('noPermission'));
            return;
        }


        $this->Mod_manage->deleteEmailRecord($this->input->get('id', TRUE));


        echo $this->mylibrary->serviceReturn(TRUE);
    }

}
