<?php

class Manage extends CI_Controller {

    function __construct() {
        parent::__construct();

        $action = $this->uri->segment(2);
        // if ( !$this->mylibrary->isAdmin() && $action != 'admin' ) {
        //     $this->mylibrary->reDirect($this->baseUrl);
        //     return;
        // }

        $this->mycss->addFile("{$this->baseUrl}assets/css/third_party/jquery-ui.css");
        $this->mycss->addFile("{$this->baseUrl}assets/css/application/my_manage.css");
        $this->mycss->addFile("{$this->baseUrl}assets/css/application/my_form.css");
        $this->mycss->addFile("{$this->baseUrl}assets/css/application/my_media.css");

        $this->myjs->addFile("{$this->baseUrl}assets/js/third_party/jquery-ui.js");
        $this->myjs->addFile("{$this->baseUrl}assets/js/third_party/jquery-ui-datepicker-lang-zh-TW.js");
        $this->myjs->addFile("{$this->baseUrl}assets/js/third_party/jquery.mousewheel-3.0.6.pack.js");
        $this->myjs->addFile("{$this->baseUrl}assets/js/third_party/ajaxfileupload.js");
        $this->myjs->addFile("{$this->baseUrl}assets/js/third_party/ckeditor/ckeditor.js");

        $this->load->library('MyForm');

        $this->load->model('manage/Mod_manage_html');
        $this->load->model('manage/Mod_manage_js');
        $this->load->model('manage/Mod_manage');
        $this->load->model('media/Mod_media');
        $this->load->model('media/Mod_media_html');
    }

    public function admin() {
        if ( TRUE ) {
            $this->mylibrary->reDirect($this->mylibrary->authUrl("{$this->baseUrl}manage/informationHome?user={$this->user['account']}"));
            return;
        }

        $this->myjs->addFile("{$this->baseUrl}assets/js/third_party/jquery.md5.js");

        $this->mylayout->add(SYS_HEADER_BOX, $this->Mod_manage_html->header());
        $this->mylayout->add(SYS_CONTENT_BOX, $this->Mod_manage_html->login());

        $this->Mod_manage_js->admin();


        $data = array(
            'webTitle' => $this->lang->line('manage_header')
        );
        $this->load->view('common', $data);
    }

    public function informationHome() {
        $this->load->model('home/Mod_home');

        $data = array(
            'action' => $this->uri->segment(2),
            'carousel' => $this->Mod_home->getCarousel(),
            'editCarouselUrl' => $this->mylibrary->authUrl("{$this->baseUrl}media/edit/2?user={$this->user['account']}"),
            'carouselMask' => $this->Mod_home->getCarouselMask(),
            'editMaskUrl' => $this->mylibrary->authUrl("{$this->baseUrl}manage/informationHomeCarouselMask?user={$this->user['account']}"),
            'concept' => $this->Mod_home->getConcept(),
            'editConceptUrl' => $this->mylibrary->authUrl("{$this->baseUrl}manage/informationHomeConcept?user={$this->user['account']}"),
            'lookbook' => $this->Mod_home->getLookbook(),
            'editLookbookUrl' => $this->mylibrary->authUrl("{$this->baseUrl}manage/informationHomeLookbook?user={$this->user['account']}"),
            'editorial' => $this->Mod_home->getEditorial(),
            'editEditorialUrl' => $this->mylibrary->authUrl("{$this->baseUrl}manage/informationHomeEditorial?user={$this->user['account']}")
        );


        $this->mylayout->add(SYS_HEADER_BOX, $this->Mod_manage_html->header());

        $this->mylayout->add(SYS_CONTENT_BOX, $this->Mod_manage_html->menu());

        $this->mylayout->add(SYS_CONTENT_BOX, $this->Mod_manage_html->breadcrumb($data));

        $this->mylayout->add(SYS_CONTENT_BOX, $this->Mod_manage_html->informationHome($data));
        $this->Mod_manage_js->informationHome($data);

        $this->mylayout->add(SYS_FOOTER_BOX, $this->Mod_manage_html->footer());


        $data = array(
            'webTitle' => $this->lang->line('manage_header')
        );
        $this->load->view('common', $data);
    }

    public function informationHomeCarouselMask() {
        $this->load->model('home/Mod_home');

        $data = array(
            'action' => $this->uri->segment(2),
            'mask' => $this->Mod_home->getCarouselMask()
        );


        $this->mylayout->add(SYS_HEADER_BOX, $this->Mod_manage_html->header());

        $this->mylayout->add(SYS_CONTENT_BOX, $this->Mod_manage_html->menu());

        $this->mylayout->add(SYS_CONTENT_BOX, $this->Mod_manage_html->breadcrumb($data));

        $this->mylayout->add(SYS_CONTENT_BOX, $this->Mod_manage_html->informationHomeCarouselMask($data));


        $this->mylayout->add(SYS_FOOTER_BOX, $this->Mod_manage_html->footer());


        $data = array(
            'webTitle' => $this->lang->line('manage_header')
        );
        $this->load->view('common', $data);
    }

    public function informationHomeConcept() {
        $this->load->model('home/Mod_home');

        $data = array(
            'action' => $this->uri->segment(2),
            'concept' => $this->Mod_home->getConcept()
        );


        $this->mylayout->add(SYS_HEADER_BOX, $this->Mod_manage_html->header());

        $this->mylayout->add(SYS_CONTENT_BOX, $this->Mod_manage_html->menu());

        $this->mylayout->add(SYS_CONTENT_BOX, $this->Mod_manage_html->breadcrumb($data));

        $this->mylayout->add(SYS_CONTENT_BOX, $this->Mod_manage_html->informationHomeConcept($data));

        $this->mylayout->add(SYS_FOOTER_BOX, $this->Mod_manage_html->footer());


        $data = array(
            'webTitle' => $this->lang->line('manage_header')
        );
        $this->load->view('common', $data);
    }

    public function informationHomeLookbook() {
        $this->load->model('home/Mod_home');

        $data = array(
            'action' => $this->uri->segment(2),
            'lookbook' => $this->Mod_home->getLookbook(),
            'editMediaUrl' => $this->mylibrary->authUrl("{$this->baseUrl}media/edit/3?user={$this->user['account']}")
        );


        $this->mylayout->add(SYS_HEADER_BOX, $this->Mod_manage_html->header());

        $this->mylayout->add(SYS_CONTENT_BOX, $this->Mod_manage_html->menu());

        $this->mylayout->add(SYS_CONTENT_BOX, $this->Mod_manage_html->breadcrumb($data));

        $this->mylayout->add(SYS_CONTENT_BOX, $this->Mod_manage_html->informationHomeLookbook($data));
        $this->Mod_manage_js->informationHomeLookbook($data);

        $this->mylayout->add(SYS_FOOTER_BOX, $this->Mod_manage_html->footer());


        $data = array(
            'webTitle' => $this->lang->line('manage_header')
        );
        $this->load->view('common', $data);
    }

    public function informationHomeEditorial() {
        $this->load->model('home/Mod_home');

        $data = array(
            'action' => $this->uri->segment(2),
            'editorial' => $this->Mod_home->getEditorial()
        );


        $this->mylayout->add(SYS_HEADER_BOX, $this->Mod_manage_html->header());

        $this->mylayout->add(SYS_CONTENT_BOX, $this->Mod_manage_html->menu());

        $this->mylayout->add(SYS_CONTENT_BOX, $this->Mod_manage_html->breadcrumb($data));

        $this->mylayout->add(SYS_CONTENT_BOX, $this->Mod_manage_html->informationHomeEditorial($data));

        $this->mylayout->add(SYS_FOOTER_BOX, $this->Mod_manage_html->footer());


        $data = array(
            'webTitle' => $this->lang->line('manage_header')
        );
        $this->load->view('common', $data);
    }

    public function informationPress() {
        $this->load->model('press/Mod_press');

        $data = array(
            'action' => $this->uri->segment(2),
            'press' => $this->Mod_press->getAll(),
            'editUrl' => $this->mylibrary->authUrl("{$this->baseUrl}media/edit/1?user={$this->user['account']}&editInfo=description")
        );


        $this->mylayout->add(SYS_HEADER_BOX, $this->Mod_manage_html->header());

        $this->mylayout->add(SYS_CONTENT_BOX, $this->Mod_manage_html->menu());

        $this->mylayout->add(SYS_CONTENT_BOX, $this->Mod_manage_html->breadcrumb($data));

        $this->mylayout->add(SYS_CONTENT_BOX, $this->Mod_manage_html->informationPress($data));
        $this->Mod_manage_js->informationPress($data);

        $this->mylayout->add(SYS_FOOTER_BOX, $this->Mod_manage_html->footer());


        $data = array(
            'webTitle' => $this->lang->line('manage_header')
        );
        $this->load->view('common', $data);
    }

    public function messageSend() {
        $data = array(
            'action' => $this->uri->segment(2)
        );


        $this->mylayout->add(SYS_HEADER_BOX, $this->Mod_manage_html->header());

        $this->mylayout->add(SYS_CONTENT_BOX, $this->Mod_manage_html->menu());

        $this->mylayout->add(SYS_CONTENT_BOX, $this->Mod_manage_html->breadcrumb($data));

        $this->mylayout->add(SYS_CONTENT_BOX, $this->Mod_manage_html->messageSend($data));
        $this->Mod_manage_js->messageSend($data);

        $this->mylayout->add(SYS_FOOTER_BOX, $this->Mod_manage_html->footer());


        $data = array(
            'webTitle' => $this->lang->line('manage_header')
        );
        $this->load->view('common', $data);
    }

    public function messageRecord() {
        $data = array(
            'action' => $this->uri->segment(2),
            'emails' => $this->Mod_manage->getEmailByPage($this->input->get('page', TRUE))
        );


        $this->mylayout->add(SYS_HEADER_BOX, $this->Mod_manage_html->header());

        $this->mylayout->add(SYS_CONTENT_BOX, $this->Mod_manage_html->menu());

        $this->mylayout->add(SYS_CONTENT_BOX, $this->Mod_manage_html->breadcrumb($data));

        $this->mylayout->add(SYS_CONTENT_BOX, $this->Mod_manage_html->messageRecord($data));
        $this->Mod_manage_js->messageRecord($data);

        $this->mylayout->add(SYS_FOOTER_BOX, $this->Mod_manage_html->footer());


        $data = array(
            'webTitle' => $this->lang->line('manage_header')
        );
        $this->load->view('common', $data);
    }


    public function messageEdm() {
        $data = array(
            'action' => $this->uri->segment(2),
            'subscribers' => $this->Mod_manage->getSubscribersByPage($this->input->get('page', TRUE))
        );

        $this->mylayout->add(SYS_HEADER_BOX, $this->Mod_manage_html->header());

        $this->mylayout->add(SYS_CONTENT_BOX, $this->Mod_manage_html->menu());

        $this->mylayout->add(SYS_CONTENT_BOX, $this->Mod_manage_html->breadcrumb($data));

        $this->mylayout->add(SYS_CONTENT_BOX, $this->Mod_manage_html->messageEdm($data));
        $this->Mod_manage_js->messageEdm($data);

        $this->mylayout->add(SYS_FOOTER_BOX, $this->Mod_manage_html->footer());


        $data = array(
            'webTitle' => $this->lang->line('manage_header')
        );
        $this->load->view('common', $data);
    }


    public function informationCustomercare() {
        $this->load->model('customercare/Mod_customercare');

        $data = array(
            'action' => $this->uri->segment(2),
            'customercare' => $this->Mod_customercare->getCustomercare()
        );

        $this->mylayout->add(SYS_HEADER_BOX, $this->Mod_manage_html->header());

        $this->mylayout->add(SYS_CONTENT_BOX, $this->Mod_manage_html->menu());

        $this->mylayout->add(SYS_CONTENT_BOX, $this->Mod_manage_html->breadcrumb($data));

        $this->mylayout->add(SYS_CONTENT_BOX, $this->Mod_manage_html->informationCustomercare($data));

        $this->mylayout->add(SYS_FOOTER_BOX, $this->Mod_manage_html->footer());


        $data = array(
            'webTitle' => $this->lang->line('manage_header')
        );
        $this->load->view('common', $data);
    }


    public function messageContact() {
        $data = array(
            'action' => $this->uri->segment(2),
            'contacts' => $this->Mod_manage->getContactsByPage($this->input->get('page', TRUE))
        );

        $this->mylayout->add(SYS_HEADER_BOX, $this->Mod_manage_html->header());

        $this->mylayout->add(SYS_CONTENT_BOX, $this->Mod_manage_html->menu());

        $this->mylayout->add(SYS_CONTENT_BOX, $this->Mod_manage_html->breadcrumb($data));

        $this->mylayout->add(SYS_CONTENT_BOX, $this->Mod_manage_html->messageContact($data));
        $this->Mod_manage_js->messageContact($data);

        $this->mylayout->add(SYS_FOOTER_BOX, $this->Mod_manage_html->footer());


        $data = array(
            'webTitle' => $this->lang->line('manage_header')
            );
        $this->load->view('common', $data);
    }

    public function messageEditContact($id) {

        $this->load->model('contact/Mod_contact');

        $data = array(
            'action' => $this->uri->segment(2),
            'id' => $id,
            'contact' => $this->Mod_contact->getContact($id)
        );


        $this->mylayout->add(SYS_HEADER_BOX, $this->Mod_manage_html->header());

        $this->mylayout->add(SYS_CONTENT_BOX, $this->Mod_manage_html->menu());

        $this->mylayout->add(SYS_CONTENT_BOX, $this->Mod_manage_html->breadcrumb($data));

        $this->mylayout->add(SYS_CONTENT_BOX, $this->Mod_manage_html->messageEditContact($data));

        $this->mylayout->add(SYS_FOOTER_BOX, $this->Mod_manage_html->footer());


        $data = array(
            'webTitle' => $this->lang->line('manage_header')
        );
        $this->load->view('common', $data);
    }

    public function informationConcept() {
        $this->load->model('concept/Mod_concept');

        $data = array(
            'action' => $this->uri->segment(2),
            'concept' => $this->Mod_concept->getConcept()
        );


        $this->mylayout->add(SYS_HEADER_BOX, $this->Mod_manage_html->header());

        $this->mylayout->add(SYS_CONTENT_BOX, $this->Mod_manage_html->menu());

        $this->mylayout->add(SYS_CONTENT_BOX, $this->Mod_manage_html->breadcrumb($data));

        $this->mylayout->add(SYS_CONTENT_BOX, $this->Mod_manage_html->informationConcept($data));

        $this->mylayout->add(SYS_FOOTER_BOX, $this->Mod_manage_html->footer());


        $data = array(
            'webTitle' => $this->lang->line('manage_header')
        );
        $this->load->view('common', $data);
    }

    public function informationMind() {
        $this->load->model('mind/Mod_mind');

        $data = array(
            'action' => $this->uri->segment(2),
            'mind' => $this->Mod_mind->getMind(),
            'editMediaUrl' => $this->mylibrary->authUrl("{$this->baseUrl}media/edit/4?user={$this->user['account']}")
        );


        $this->mylayout->add(SYS_HEADER_BOX, $this->Mod_manage_html->header());

        $this->mylayout->add(SYS_CONTENT_BOX, $this->Mod_manage_html->menu());

        $this->mylayout->add(SYS_CONTENT_BOX, $this->Mod_manage_html->breadcrumb($data));

        $this->mylayout->add(SYS_CONTENT_BOX, $this->Mod_manage_html->informationMind($data));

        $this->Mod_manage_js->informationMind($data);

        $this->mylayout->add(SYS_FOOTER_BOX, $this->Mod_manage_html->footer());


        $data = array(
            'webTitle' => $this->lang->line('manage_header')
        );
        $this->load->view('common', $data);
    }

    public function shopType() {
        $this->load->model('shop/Mod_shop');

        $data = array(
            'action' => $this->uri->segment(2),
            'types' => $this->Mod_shop->getAllTypes(),
            'deleteShopTypeUrl' => $this->mylibrary->authUrl("{$this->baseUrl}shop_service/deleteType?user={$this->user['account']}")
        );


        $this->mylayout->add(SYS_HEADER_BOX, $this->Mod_manage_html->header());

        $this->mylayout->add(SYS_CONTENT_BOX, $this->Mod_manage_html->menu());

        $this->mylayout->add(SYS_CONTENT_BOX, $this->Mod_manage_html->breadcrumb($data));

        $this->mylayout->add(SYS_CONTENT_BOX, $this->Mod_manage_html->shopType($data));
        $this->Mod_manage_js->shopType($data);

        $this->mylayout->add(SYS_FOOTER_BOX, $this->Mod_manage_html->footer());


        $data = array(
            'webTitle' => $this->lang->line('manage_header')
        );
        $this->load->view('common', $data);
    }

    public function shopTypeEdit() {
        $this->load->model('shop/Mod_shop');

        $data = array(
            'action' => $this->uri->segment(2),
            'id' => $this->input->get('id', TRUE),
            'types' => $this->Mod_shop->getAllTypes()
        );


        $this->mylayout->add(SYS_HEADER_BOX, $this->Mod_manage_html->header());

        $this->mylayout->add(SYS_CONTENT_BOX, $this->Mod_manage_html->menu());

        $this->mylayout->add(SYS_CONTENT_BOX, $this->Mod_manage_html->breadcrumb($data));

        $this->mylayout->add(SYS_CONTENT_BOX, $this->Mod_manage_html->shopTypeEdit($data));

        $this->mylayout->add(SYS_FOOTER_BOX, $this->Mod_manage_html->footer());


        $data = array(
            'webTitle' => $this->lang->line('manage_header')
        );
        $this->load->view('common', $data);
    }

    public function shopItem() {
        $this->load->model('shop/Mod_shop');

        $data = array(
            'action' => $this->uri->segment(2),
            'types' => $this->Mod_shop->getAllTypes(),
            'items' => $this->Mod_shop->getManageItems($this->input->get('page', TRUE), $this->input->get('perPage', TRUE), $this->input->get('type', TRUE), $this->input->get('search', TRUE), $this->input->get('order', TRUE)),
            'baseUrl' => $this->mylibrary->authUrl("{$this->baseUrl}manage/shopItem?user={$this->user['account']}"),
            'perPage' => $this->input->get('perPage', TRUE),
            'type' => $this->input->get('type', TRUE),
            'search' => $this->input->get('search', TRUE),
            'order' => $this->input->get('order', TRUE),
            'publishUrl' => $this->mylibrary->authUrl("{$this->baseUrl}shop_service/publish?user={$this->user['account']}"),
            'unpublishUrl' => $this->mylibrary->authUrl("{$this->baseUrl}shop_service/unpublish?user={$this->user['account']}"),
            'copyItemUrl' => $this->mylibrary->authUrl("{$this->baseUrl}shop_service/copyItem?user={$this->user['account']}"),
            'deleteItemUrl' => $this->mylibrary->authUrl("{$this->baseUrl}shop_service/deleteItem?user={$this->user['account']}")
        );


        $this->mylayout->add(SYS_HEADER_BOX, $this->Mod_manage_html->header());

        $this->mylayout->add(SYS_CONTENT_BOX, $this->Mod_manage_html->menu());

        $this->mylayout->add(SYS_CONTENT_BOX, $this->Mod_manage_html->breadcrumb($data));

        $this->mylayout->add(SYS_CONTENT_BOX, $this->Mod_manage_html->shopItem($data));
        $this->Mod_manage_js->shopItem($data);

        $this->mylayout->add(SYS_FOOTER_BOX, $this->Mod_manage_html->footer());


        $data = array(
            'webTitle' => $this->lang->line('manage_header')
        );
        $this->load->view('common', $data);
    }

    public function shopItemEdit() {
        $this->load->model('shop/Mod_shop');

        $data = array(
            'action' => $this->uri->segment(2),
            'id' => $this->input->get('id', TRUE),
            'types' => $this->Mod_shop->getAllTypes(),
            'item' => $this->Mod_shop->getItem($this->input->get('id', TRUE), 'id', TRUE)
        );


        $this->mylayout->add(SYS_HEADER_BOX, $this->Mod_manage_html->header());

        $this->mylayout->add(SYS_CONTENT_BOX, $this->Mod_manage_html->menu());

        $this->mylayout->add(SYS_CONTENT_BOX, $this->Mod_manage_html->breadcrumb($data));

        $this->mylayout->add(SYS_CONTENT_BOX, $this->Mod_manage_html->shopItemEdit($data));

        $this->mylayout->add(SYS_FOOTER_BOX, $this->Mod_manage_html->footer());


        $data = array(
            'webTitle' => $this->lang->line('manage_header')
        );
        $this->load->view('common', $data);
    }

    public function systemDiscount() {
        $this->load->model('shop/Mod_shop');

        $data = array(
            'action' => $this->uri->segment(2),
            'discounts' => $this->Mod_shop->getAllDiscounts(),
            'deleteDiscountUrl' => $this->mylibrary->authUrl("{$this->baseUrl}shop_service/deleteDiscount?user={$this->user['account']}")
        );


        $this->mylayout->add(SYS_HEADER_BOX, $this->Mod_manage_html->header());

        $this->mylayout->add(SYS_CONTENT_BOX, $this->Mod_manage_html->menu());

        $this->mylayout->add(SYS_CONTENT_BOX, $this->Mod_manage_html->breadcrumb($data));

        $this->mylayout->add(SYS_CONTENT_BOX, $this->Mod_manage_html->systemDiscount($data));
        $this->Mod_manage_js->systemDiscount($data);

        $this->mylayout->add(SYS_FOOTER_BOX, $this->Mod_manage_html->footer());


        $data = array(
            'webTitle' => $this->lang->line('manage_header')
        );
        $this->load->view('common', $data);
    }

    public function systemDiscountEdit() {
        $this->load->model('shop/Mod_shop');

        $data = array(
            'action' => $this->uri->segment(2),
            'id' => $this->input->get('id', TRUE),
            'discount' => $this->Mod_shop->getDiscount($this->input->get('id', TRUE), 'id', TRUE),
        );


        $this->mylayout->add(SYS_HEADER_BOX, $this->Mod_manage_html->header());

        $this->mylayout->add(SYS_CONTENT_BOX, $this->Mod_manage_html->menu());

        $this->mylayout->add(SYS_CONTENT_BOX, $this->Mod_manage_html->breadcrumb($data));

        $this->mylayout->add(SYS_CONTENT_BOX, $this->Mod_manage_html->systemDiscountEdit($data));

        $this->mylayout->add(SYS_FOOTER_BOX, $this->Mod_manage_html->footer());


        $data = array(
            'webTitle' => $this->lang->line('manage_header')
        );
        $this->load->view('common', $data);
    }

    public function systemStatistic() {
        $this->load->model('shop/Mod_shop');

        $data = array(
            'action' => $this->uri->segment(2),
        );


        $this->mylayout->add(SYS_HEADER_BOX, $this->Mod_manage_html->header());

        $this->mylayout->add(SYS_CONTENT_BOX, $this->Mod_manage_html->menu());

        $this->mylayout->add(SYS_CONTENT_BOX, $this->Mod_manage_html->breadcrumb($data));

        $this->mylayout->add(SYS_CONTENT_BOX, $this->Mod_manage_html->systemStatistic($data));
        $this->Mod_manage_js->systemStatistic($data);

        $this->mylayout->add(SYS_FOOTER_BOX, $this->Mod_manage_html->footer());


        $data = array(
            'webTitle' => $this->lang->line('manage_header')
        );
        $this->load->view('common', $data);
    }

    public function orderList() {
        $this->load->model('shop/Mod_shop');

        $data = array(
            'action' => $this->uri->segment(2),
            'baseUrl' => ($this->mylibrary->authUrl("{$this->baseUrl}manage/orderList?user={$this->user['account']}")),
            'status' => $this->input->get('status', TRUE),
            'search' => $this->input->get('search', TRUE),
            'order' => $this->input->get('order', TRUE),
            'page' => $this->input->get('page', TRUE),
            'orders' => $this->Mod_shop->getOrders($this->input->get('page', TRUE), $this->input->get('status', TRUE), $this->input->get('search', TRUE), $this->input->get('order', TRUE)),
            'detailUrl' => $this->mylibrary->authUrl("{$this->baseUrl}manage/orderDetail?user={$this->user['account']}"),
            'sendWaybillUrl' => $this->mylibrary->authUrl("{$this->baseUrl}manage/sendWaybill?user={$this->user['account']}"),
            'deleteUrl' => $this->mylibrary->authUrl("{$this->baseUrl}shop_service/deleteOrder?user={$this->user['account']}")
        );

        $this->mylayout->add(SYS_HEADER_BOX, $this->Mod_manage_html->header());

        $this->mylayout->add(SYS_CONTENT_BOX, $this->Mod_manage_html->menu());

        $this->mylayout->add(SYS_CONTENT_BOX, $this->Mod_manage_html->breadcrumb($data));

        $this->mylayout->add(SYS_CONTENT_BOX, $this->Mod_manage_html->orderList($data));
        $this->Mod_manage_js->orderList($data);

        $this->mylayout->add(SYS_FOOTER_BOX, $this->Mod_manage_html->footer());


        $data = array(
            'webTitle' => $this->lang->line('manage_header')
        );
        $this->load->view('common', $data);
    }

    public function orderEdit() {
        $this->load->model('shop/Mod_shop');

        $data = array(
            'action' => $this->uri->segment(2),
            'order' => $this->Mod_shop->getOrder($this->input->get('id', TRUE), 'id', TRUE)
        );

        $this->mylayout->add(SYS_HEADER_BOX, $this->Mod_manage_html->header());

        $this->mylayout->add(SYS_CONTENT_BOX, $this->Mod_manage_html->menu());

        $this->mylayout->add(SYS_CONTENT_BOX, $this->Mod_manage_html->breadcrumb($data));

        $this->mylayout->add(SYS_CONTENT_BOX, $this->Mod_manage_html->orderEdit($data));

        $this->mylayout->add(SYS_FOOTER_BOX, $this->Mod_manage_html->footer());


        $data = array(
            'webTitle' => $this->lang->line('manage_header')
        );
        $this->load->view('common', $data);
    }

    public function orderDetail() {
        $this->load->model('shop/Mod_shop');
        $this->load->model('shop/Mod_shop_html');

        $data = array(
            'order' => $this->Mod_shop->getOrder($this->input->get('id', TRUE), 'id', TRUE)
        );

        $this->mylayout->add(SYS_DIALOG_BOX, $this->Mod_manage_html->orderDetail($data));


        $data = array(
            'webTitle' => $this->lang->line('webName') . ": " . $this->lang->line('manage_title')
        );
        $this->load->view('dialog', $data);
    }

    public function orderWaybill() {
        $this->load->model('shop/Mod_shop');

        $data = array(
            'action' => $this->uri->segment(2),
            'id' => $this->input->get('id', TRUE),
            'order' => $this->Mod_shop->getOrder($this->input->get('id', TRUE), 'id', TRUE)
        );

        $this->mylayout->add(SYS_HEADER_BOX, $this->Mod_manage_html->header());

        $this->mylayout->add(SYS_CONTENT_BOX, $this->Mod_manage_html->menu());

        $this->mylayout->add(SYS_CONTENT_BOX, $this->Mod_manage_html->breadcrumb($data));

        $this->mylayout->add(SYS_CONTENT_BOX, $this->Mod_manage_html->orderWaybill($data));

        $this->mylayout->add(SYS_FOOTER_BOX, $this->Mod_manage_html->footer());


        $data = array(
            'webTitle' => $this->lang->line('manage_header')
        );
        $this->load->view('common', $data);
    }

    public function informationCollection() {
        $this->load->model('collection/Mod_collection');

        $data = array(
            'action' => $this->uri->segment(2),
            'collections' => $this->Mod_collection->getAllCollections(),
            'deleteCollectionUrl' => $this->mylibrary->authUrl("{$this->baseUrl}collection_service/deleteCollection?user={$this->user['account']}")
        );


        $this->mylayout->add(SYS_HEADER_BOX, $this->Mod_manage_html->header());

        $this->mylayout->add(SYS_CONTENT_BOX, $this->Mod_manage_html->menu());

        $this->mylayout->add(SYS_CONTENT_BOX, $this->Mod_manage_html->breadcrumb($data));

        $this->mylayout->add(SYS_CONTENT_BOX, $this->Mod_manage_html->informationCollection($data));
        $this->Mod_manage_js->informationCollection($data);

        $this->mylayout->add(SYS_FOOTER_BOX, $this->Mod_manage_html->footer());


        $data = array(
            'webTitle' => $this->lang->line('manage_header')
        );
        $this->load->view('common', $data);
    }

    public function informationCollectionEdit() {
        $this->load->model('collection/Mod_collection');

        $data = array(
            'action' => $this->uri->segment(2),
            'id' => $this->input->get('id', TRUE),
            'collections' => $this->Mod_collection->getAllCollections()
        );


        $this->mylayout->add(SYS_HEADER_BOX, $this->Mod_manage_html->header());

        $this->mylayout->add(SYS_CONTENT_BOX, $this->Mod_manage_html->menu());

        $this->mylayout->add(SYS_CONTENT_BOX, $this->Mod_manage_html->breadcrumb($data));

        $this->mylayout->add(SYS_CONTENT_BOX, $this->Mod_manage_html->informationCollectionEdit($data));

        $this->mylayout->add(SYS_FOOTER_BOX, $this->Mod_manage_html->footer());


        $data = array(
            'webTitle' => $this->lang->line('manage_header')
        );
        $this->load->view('common', $data);
    }

}
