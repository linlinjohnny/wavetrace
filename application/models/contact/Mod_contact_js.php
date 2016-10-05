<?php

class Mod_contact_js extends CI_Model {

     function __construct() {
        parent::__construct();
    }


    public function index($data=array()) {
        $js = <<<JAVASCRIPT

            $(function() {
            	$('.contactContent .submit').bind('click', function() {

	            	var haveEmpty = false;
	            	$('.require , .wrongEmail, .mailSent').hide();

	                $(".formValue").each(function() {
	                    if ( $(this).val() == '' ) {
	                        $('.require').show();
	                        haveEmpty = true;
	                        return false;
	                    }
	                });

	                if ( haveEmpty ) {
	                    return;
	                }

	                if ( !$(".email").val().match(/^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/) ) {
	                    $('.wrongEmail').show();
	                    return;
	                }

	                $('.require , .wrongEmail, .mailSent').hide();

	                var data = {};
                    $(".formValue").each(function() {
                        data[ $(this).attr('id') ] = $(this).val();
                    });

                    $.post("{$data['sendMailUrl']}", data, function(obj) {
                        if ( obj.status === 'false' ) {
                            return;
                        }

                        $('.formValue').val('');                        
                        $('.mailSent').show().fadeIn();
                        $('.mailSent').delay(3000).fadeOut();

                    }, 'json');

                });
            });
JAVASCRIPT;
        $this->myjs->add($js);
    }

}
