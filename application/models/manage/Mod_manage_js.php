<?php 

class Mod_manage_js extends CI_Model {

     function __construct() {
        parent::__construct();
    }

    public function admin($data=array()) {
        $js = <<<JAVASCRIPT

            $(function() {

                $('#sysContentBox').css('height', $(window).height());

            });

JAVASCRIPT;
        $this->myjs->add($js);
    }

    public function informationHome($data=array()) {
        $js = <<<JAVASCRIPT

            $(function() {

                $('.carousel').bind('click', function() {
                    mylibrary.modal.dialog({
                        title: myLang.manage_informationHomeCarousel,
                        url: '{$data['editCarouselUrl']}',
                        myClass: 'manageDialog',
                        width: 725,
                        height: 550,
                        onEscape: true
                    });
                });

                $('.carouselMask, .concept, .lookbook, .editorial').bind('click', function() {
                    window.location.href = $(this).attr('data-url');
                });

            });

JAVASCRIPT;
        $this->myjs->add($js);
    }

    public function informationHomeLookbook($data=array()) {
        $js = <<<JAVASCRIPT

            $(function() {

                $('.lookbookMedia').bind('click', function() {
                    mylibrary.modal.dialog({
                        title: myLang.manage_informationHomeLookbook,
                        url: '{$data['editMediaUrl']}',
                        myClass: 'manageDialog',
                        width: 725,
                        height: 550
                    });
                });

            });

JAVASCRIPT;
        $this->myjs->add($js);
    }

    public function informationPress($data=array()) {
        $js = <<<JAVASCRIPT

            $(function() {

                $('.managePress').bind('click', function() {
                    mylibrary.modal.dialog({
                        title: myLang.manage_informationPress,
                        url: '{$data['editUrl']}',
                        myClass: 'manageDialog',
                        width: 725,
                        height: 550,
                        onEscape: true
                    });  
                });

            });

JAVASCRIPT;
        $this->myjs->add($js);
    }

    public function messageSend($data=array()) {
        $js = <<<JAVASCRIPT

            $(function() {

                $("#form_sendToAll").bind('change', function() {
                    var checked = $(this).prop('checked');

                    $("#form_email").prop('disabled', checked);
                });

            });

JAVASCRIPT;
        $this->myjs->add($js);
    }

    public function messageRecord($data=array()) {
        $js = <<<JAVASCRIPT

            $(function() {

                $("a[data-role='deleteRecord']").bind('click', function() {
                    if ( !confirm(myLang.itemDeleteConfirm) ) {
                        return;
                    }

                    var url = $(this).attr('data-url');
                    $.post(url, {}, function(obj) {
                        if (obj.status === 'false') {
                            alert(obj.msg);
                            return;
                        }
                        
                        window.location.reload();
                    }, 'json');
                });

            });

JAVASCRIPT;
        $this->myjs->add($js);
    }

    public function messageEdm($data=array()) {
        $js = <<<JAVASCRIPT

        $(function() {

            $("a[data-role='deleteSubscriber']").bind('click', function() {
                if ( !confirm(myLang.itemDeleteConfirm) ) {
                    return;
                }

                var url = $(this).attr('data-url');
                $.post(url, {}, function(obj) {
                    if (obj.status === 'false') {
                        alert(obj.msg);
                        return;
                    }

                    window.location.reload();
                }, 'json');
            });

        });

JAVASCRIPT;
        $this->myjs->add($js);
    }

    public function informationCustomercare($data=array()) {
        $js = <<<JAVASCRIPT

        $(function() {

            $("a[data-role='deleteSubscriber']").bind('click', function() {
                if ( !confirm(myLang.itemDeleteConfirm) ) {
                    return;
                }

                var url = $(this).attr('data-url');
                $.post(url, {}, function(obj) {
                    if (obj.status === 'false') {
                        alert(obj.msg);
                        return;
                    }

                    window.location.reload();
                }, 'json');
            });

        });

JAVASCRIPT;
        $this->myjs->add($js);
    }

    public function messageContact($data=array()) {
        $js = <<<JAVASCRIPT

        $(function() {

            $("a[data-role='editContact']").bind('click', function() {
                var url = $(this).attr('data-url');
                window.location.replace(url);
            });

            $("a[data-role='deleteContact']").bind('click', function() {
                if ( !confirm(myLang.itemDeleteConfirm) ) {
                    return;
                }

                var url = $(this).attr('data-url');
                $.post(url, {}, function(obj) {
                    if (obj.status === 'false') {
                        alert(obj.msg);
                        return;
                    }

                    window.location.reload();
                }, 'json');
            });

        });

JAVASCRIPT;
        $this->myjs->add($js);
    }

    public function informationMind($data=array()) {
        $js = <<<JAVASCRIPT

            $(function() {

                $('.mindMedia').bind('click', function() {
                    mylibrary.modal.dialog({
                        title: myLang.manage_informationMind,
                        url: '{$data['editMediaUrl']}',
                        myClass: 'manageDialog',
                        width: 725,
                        height: 550
                    });
                });

            });

JAVASCRIPT;
        $this->myjs->add($js);
    }

    public function shopType($data) {
        $js = <<<JAVASCRIPT

            $(function() {

                $("[data-role='deleteShopType']").bind('click', function() {
                    if ( !confirm(myLang.itemDeleteConfirm) ) {
                        return;
                    }

                    var id = $(this).attr('data-id');
                    $.post('{$data['deleteShopTypeUrl']}', {id:id}, function(obj) {
                        if (obj.status === 'false') {
                            alert(obj.msg);
                            return;
                        }
                        
                        window.location.reload();
                    }, 'json');
                });

            });

JAVASCRIPT;
        $this->myjs->add($js);
    }

    public function shopItem($data) {
        $hasType = ( $data['types'] ) ? TRUE : FALSE;


        $js = <<<JAVASCRIPT

            $(function() {

                $("[data-role='publish']").bind('click', function() {
                    if ( $("[data-role='checkOne']:checked").length == 0 ) {
                        alert(myLang.itemNotChecked);
                        return;
                    }
                    

                    var ids = mylibrary.template.getTableChecked();
                    $.post('{$data['publishUrl']}', {id:ids}, function(obj) {
                        if (obj.status === 'false') {
                            alert(obj.msg);
                            return;
                        }
                        
                        window.location.reload();
                    }, 'json');
                });

                $("[data-role='unpublish']").bind('click', function() {
                    if ( $("[data-role='checkOne']:checked").length == 0 ) {
                        alert(myLang.itemNotChecked);
                        return;
                    }

                    var ids = mylibrary.template.getTableChecked();
                    $.post('{$data['unpublishUrl']}', {id:ids}, function(obj) {
                        if (obj.status === 'false') {
                            alert(obj.msg);
                            return;
                        }
                        
                        window.location.reload();
                    }, 'json');
                });

                function filter() {
                    window.location.href = "{$data['baseUrl']}&perPage=" + $('.perPage').val() + '&type=' + $('.type').val() + '&search=' + $('.search').val() + "&order=" + $('.order').val();
                }

                $(".perPage, .type, .order").bind('change', function() {
                    filter();
                });

                $(".searchBtn").bind('click', function() {
                    filter();
                });

                $("a[data-role='itemMedia']").bind('click', function() {
                    var url = $(this).attr('data-url');

                    mylibrary.modal.dialog({
                        title: myLang.manage_media,
                        url: url,
                        myClass: 'manageDialog',
                        width: 800,
                        height: 550
                    });
                });

                $("a[data-role='copyItem']").bind('click', function() {
                    if ( !confirm(myLang.itemCopyConfirm) ) {
                        return;
                    }

                    var id = $(this).attr('data-id');
                    $.post('{$data['copyItemUrl']}', {id:id}, function(obj) {
                        if (obj.status === 'false') {
                            alert(obj.msg);
                            return;
                        }
                        
                        window.location.reload();
                    }, 'json');
                });

                $("a[data-role='addShopItem']").bind('click', function(event) {
                    if ( !'{$hasType}' ) {
                        event.preventDefault();
                        alert(myLang.manage_shopItemTypeHint);
                        return;
                    }
                });

                $("a[data-role='deleteItem']").bind('click', function() {
                    if ( !confirm(myLang.itemDeleteConfirm) ) {
                        return;
                    }

                    var id = $(this).attr('data-id');
                    $.post('{$data['deleteItemUrl']}', {id:id}, function(obj) {
                        if (obj.status === 'false') {
                            alert(obj.msg);
                            return;
                        }
                        
                        window.location.reload();
                    }, 'json');
                });

            });

JAVASCRIPT;
        $this->myjs->add($js);
    }

    public function systemDiscount($data=array()) {
        $js = <<<JAVASCRIPT

            $(function() {

                $("a[data-role='deleteDiscount']").bind('click', function() {
                    if ( !confirm(myLang.itemDeleteConfirm) ) {
                        return;
                    }

                    var id = $(this).attr('data-id');
                    $.post('{$data['deleteDiscountUrl']}', {id:id}, function(obj) {
                        if (obj.status === 'false') {
                            alert(obj.msg);
                            return;
                        }
                        
                        window.location.reload();
                    }, 'json');
                });
                
            });

JAVASCRIPT;
        $this->myjs->add($js);
    }

    public function orderList($data=array()) {
        $js = <<<JAVASCRIPT

            $(function() {

                function filter() {
                    window.location.href = "{$data['baseUrl']}&status=" + $('.status').val() + '&search=' + $('.search').val() + "&order=" + $('.order').val();
                }

                $(".status, .order").bind('change', function() {
                    filter();
                });

                $(".searchBtn").bind('click', function() {
                    filter();
                });            

                $("a[data-role='detail']").bind('click', function() {
                    var url = '{$data['detailUrl']}' + "&id=" + $(this).attr('data-id');

                    mylibrary.modal.dialog({
                        title: myLang.manage_orderDetail,
                        url: url,
                        width: 660,
                        height: 550
                    });
                });

                $("a[data-role='delete']").bind('click', function() {
                    if ( !confirm(myLang.itemDeleteConfirm) ) {
                        return;
                    }

                    var id = $(this).attr('data-id');
                    $.post('{$data['deleteUrl']}', {id:id}, function(obj) {
                        if (obj.status === 'false') {
                            alert(obj.msg);
                            return;
                        }
                        
                        window.location.reload();
                    }, 'json');
                });

            });

JAVASCRIPT;
        $this->myjs->add($js);
    }

    public function systemStatistic($data=array()) {
        $js = <<<JAVASCRIPT

            $(function() {

            });

JAVASCRIPT;
        $this->myjs->add($js);
    }

    public function informationCollection($data) {
        $js = <<<JAVASCRIPT

            $(function() {

                $("[data-role='images']").bind('click', function() {

                    var id = $(this).attr('data-id');

                    mylibrary.modal.dialog({
                        title: myLang.images,
                        url: id,
                        myClass: 'manageDialog',
                        width: 725,
                        height: 550
                    });
                });

                $("[data-role='lookbook']").bind('click', function() {

                    var id = $(this).attr('data-id');

                    mylibrary.modal.dialog({
                        title: myLang.lookbook,
                        url: id,
                        myClass: 'manageDialog',
                        width: 725,
                        height: 550
                    });
                });


                $("[data-role='deleteCollection']").bind('click', function() {
                    if ( !confirm(myLang.itemDeleteConfirm) ) {
                        return;
                    }

                    var id = $(this).attr('data-id');
                    $.post('{$data['deleteCollectionUrl']}', {id:id}, function(obj) {
                        if (obj.status === 'false') {
                            alert(obj.msg);
                            return;
                        }
                        
                        window.location.reload();
                    }, 'json');
                });

            });

JAVASCRIPT;
        $this->myjs->add($js);
    }

}
