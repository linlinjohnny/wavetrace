<?php

class Mod_contact_html extends CI_Model {

     function __construct() {
        parent::__construct();
    }


    public function index($data=array()) {
        $result['contactBanner'] = "
        <div class='row'>
            <div class='contactBanner col-lg-9 col-md-9 col-sm-12 col-xs-12 col-lg-offset-2 col-md-offset-2'>
                <img style='width:100%;' src='./assets/imgs/default/contact.jpg'/>
            </div>
        </div>        
        ";

        $result['contact'] = "
        <div class='row contact'>
            <div class='col-lg-4 col-md-4 col-sm-10 col-xs-10 col-lg-offset-2 col-md-offset-2 col-sm-offset-1 col-xs-offset-1'>
                <p class='title'>INFORMATION</p>
                <div class='row'>
                    <div class='col-lg-6 col-md-6 col-sm-6 col-xs-6'>
                        <p class='lead'>General Inquiries</p>
                        <p>info@recluse-official.com</p>
                        <p class='lead'>Sales</p>
                        <p>Ron Chen</p>
                        <p>rc@recluse-official.com</p>
                    </div>
                    <div class='col-lg-6 col-md-6 col-sm-6 col-xs-6'>
                        <p class='lead'>Press</p>
                        <p>press@recluse-official.com</p>
                        <p class='lead'>Recluse Studio</p>
                        <p>+886-2-82853109</p>
                    </div>
                </div>
            </div>
            <div class='sendus col-lg-5 col-md-5 col-sm-10 col-xs-10 col-lg-offset-0 col-md-offset-0 col-sm-offset-1 col-xs-offset-1'>
                <p class='title'>SEND US A MESSAGE</p>
                <div class='form clearfix'>
                    <input id='name' class='text formValue' type='text' placeholder='Name' />
                    <input id='email' class='text formValue email' type='text' placeholder='E-Mail' />
                    <input id='subject' class='text formValue' type='text' placeholder='Subject' />
                    <textarea id='message' class='message formValue' placeholder='Message'></textarea>
                    <button class='submit'>SEND</button>
                    <div class='hintMsg'>
                        <div class='require'>Please complete all required fields.</div>
                        <div class='wrongEmail'>Please enter a valid E-mail address.</div>
                        <div class='mailSent'>Your E-mail has been sent.</div>
                    </div>
                </div>
            </div>
        </div>        
        ";

        $result = "<div class='contactContent container-fluid'>" . join('', $result) . "</div>";


        return $result;
    }

}
