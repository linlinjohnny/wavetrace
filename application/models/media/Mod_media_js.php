<?php 

class Mod_media_js extends CI_Model {

     function __construct() {
        parent::__construct();
    }

    public function edit($data) {
        $js = <<<JAVASCRIPT

        	$("#mediaUploader").bind('change', function() {
        		$('#mediaSubmit').trigger('click');

                $('.uploading').css('display', 'inline-block');
        	});
            

            $('.sortable').sortable({
                update: function(event, ui) {
                    var dest = ui.item.prev('li');
                    var targetID = ui.item.attr('data-id'),
                        destID = ( dest.attr('data-id') != null ) ? dest.attr('data-id') : 0;

                    $.post('{$data['resortContentUrl']}', {targetID:targetID, destID:destID}, function(obj) {
                        if (obj.status == 'false') {
                            alert(obj.msg);
                            return;
                        }

                        window.location.reload();
                    }, 'json');
                }
            });

            $( ".sortable" ).disableSelection();


            $('.delete').click(function(){
                if ( !confirm(myLang.itemDeleteConfirm) ) {
                    return;
                }

                var url = '{$data['deleteContentUrl']}' + "&id=" + $(this).attr('data-id');
                $.post(url, {}, function(obj){
                    if ( obj.status == 'false' ) {
                        alert(obj.msg);
                        return;           
                    }
                    
                    window.location.reload();
                }, 'json');
            });


            var gTimer;
            $('input, textarea').keyup(function() {
                window.clearTimeout(gTimer);

                var id = $(this).attr('data-id');
                var title = $("#media_title_" + id).val();
                var description = $("#media_description_" + id).val();
                var url = $("#media_url_" + id).val();
                var updateUrl = '{$data['updateContentUrl']}' + "&id=" + id;
                gTimer = window.setTimeout(function () {
                    $.post(updateUrl, {title:title, description:description, url:url}, function(obj){
                        if ( obj.status == 'false' ) {
                            alert(obj.msg);
                            return;           
                        }
                        
                        $('.saveHint').fadeIn(500, function() {
                            $('.saveHint').fadeOut(2500);
                        });
                    }, 'json');
                }, 1000);
            });

            $('input, textarea').blur(function() {
                $(this).keyup();
            });

JAVASCRIPT;
        $this->myjs->add($js);
    }

}
