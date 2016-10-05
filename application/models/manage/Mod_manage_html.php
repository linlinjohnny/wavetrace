<?php 

class Mod_manage_html extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function header() {
        $info = ( !$this->mylibrary->isAdmin() ) ? '' : "<div class='info'>
            <span class='account'>{$this->user['account']}</span>
            <a href='{$this->baseUrl}home/logout' class='logout'>" . $this->lang->line('manage_logout') . "</a>   
        </div>";

        $result = "<div class='manageHeader clearfix'>
            <div class='topic'>" . $this->lang->line("manage_header") . "</div>
            {$info}
        </div>";


        return $result;
    }

    public function footer() {
        return "<div class='manageFooter'>" . $this->lang->line('manage_footer') . "</div>";
    }

    public function login() {
        $this->myform->addText('account', array(
            'type' => 'text',
            'placeholder' => $this->lang->line('manage_accountPlaceholder'),
            'required' => TRUE
        ));

        $this->myform->addText('password', array(
            'type' => 'password',
            'placeholder' => $this->lang->line('manage_passwordPlaceholder'),
            'required' => TRUE
        ));


        $this->myform->addSubmit(array(
            'submitText' => $this->lang->line('login'),
            'submitingText' => $this->lang->line('logining'),
            'url' => "{$this->baseUrl}manage_service/login",
            'onSuccess' => array('returnUrl'),
            'onCancel' => array(),
            'hideCancel' => TRUE
        ));

        $formResult = $this->myform->getResult();

        $footer = $this->footer();

        $result = "<div class='manageLogin'>
            <div class='loginForm'>
                <div class='title'>" . $this->lang->line('manage_login') . "</div>
                <div class='subTitle'>" . $this->lang->line('manage_loginForm') . "</div>
                {$formResult}
            </div>
            {$footer}
        </div>";

        return $result;
    }

    public function menu() {
        $action = $this->uri->segment(2);
        $curr = array($action => 'curr');

        $result = "<div class='manageMenu'>
            <div class='item dropdown'>
                <div class='dropdown-toggle' data-toggle='dropdown'>
                    <img src='{$this->baseUrl}assets/imgs/manage/information.svg' />
                    <div>" . $this->lang->line('manage_information') . "</div>
                </div>
                <ul class='dropdown-menu'>
                    <li><a href='" . $this->mylibrary->authUrl("{$this->baseUrl}manage/informationHome?user={$this->user['account']}") . "'>" . $this->lang->line('manage_informationHome') . "</a></li>
                    <li role='separator' class='divider'></li>
                    <li><a href='" . $this->mylibrary->authUrl("{$this->baseUrl}manage/informationCollection?user={$this->user['account']}") . "'>" . $this->lang->line('manage_informationCollection') . "</a></li>
                    <li role='separator' class='divider'></li>
                    <li><a href='" . $this->mylibrary->authUrl("{$this->baseUrl}manage/informationMind?user={$this->user['account']}") . "'>" . $this->lang->line('manage_informationMind') . "</a></li>
                    <li role='separator' class='divider'></li>
                    <li><a href='" . $this->mylibrary->authUrl("{$this->baseUrl}manage/informationPress?user={$this->user['account']}") . "'>" . $this->lang->line('manage_informationPress') . "</a></li>
                    <li role='separator' class='divider'></li>
                    <li><a href='" . $this->mylibrary->authUrl("{$this->baseUrl}manage/informationConcept?user={$this->user['account']}") . "'>" . $this->lang->line('manage_informationConcept') . "</a></li>
                    <li role='separator' class='divider'></li>
                    <li><a href='" . $this->mylibrary->authUrl("{$this->baseUrl}manage/informationCustomercare?user={$this->user['account']}") . "'>" . $this->lang->line('manage_informationCustomercare') . "</a></li>
                </ul>
            </div>
            <div class='item dropdown'>
                <div class='dropdown-toggle' data-toggle='dropdown'>
                    <img src='{$this->baseUrl}assets/imgs/manage/product.svg' />
                    <div>" . $this->lang->line('manage_shop') . "</div>
                </div>
                <ul class='dropdown-menu'>
                    <li><a href='" . $this->mylibrary->authUrl("{$this->baseUrl}manage/shopType?user={$this->user['account']}") . "'>" . $this->lang->line('manage_shopType') . "</a></li>
                    <li role='separator' class='divider'></li>
                    <li><a href='" . $this->mylibrary->authUrl("{$this->baseUrl}manage/shopItem?user={$this->user['account']}") . "'>" . $this->lang->line('manage_shopItem') . "</a></li>
                </ul>
            </div>
            <div class='item dropdown'>
                <div class='dropdown-toggle' data-toggle='dropdown'>
                    <img src='{$this->baseUrl}assets/imgs/manage/order.svg' />
                    <div>" . $this->lang->line('manage_order') . "</div>
                </div>
                <ul class='dropdown-menu'>
                    <li><a href='" . $this->mylibrary->authUrl("{$this->baseUrl}manage/orderList?user={$this->user['account']}") . "'>" . $this->lang->line('manage_orderList') . "</a></li>
                </ul>
            </div>
            <div class='item dropdown'>
                <div class='dropdown-toggle' data-toggle='dropdown'>
                    <img src='{$this->baseUrl}assets/imgs/manage/message.svg' />
                    <div>" . $this->lang->line('manage_message') . "</div>
                </div>
                <ul class='dropdown-menu'>
                    <li><a href='" . $this->mylibrary->authUrl("{$this->baseUrl}manage/messageSend?user={$this->user['account']}") . "'>" . $this->lang->line('manage_messageSend') . "</a></li>
                    <li role='separator' class='divider'></li>
                    <li><a href='" . $this->mylibrary->authUrl("{$this->baseUrl}manage/messageEdm?user={$this->user['account']}") . "'>" . $this->lang->line('manage_messageEdm') . "</a></li>
                    <li role='separator' class='divider'></li>
                    <li><a href='" . $this->mylibrary->authUrl("{$this->baseUrl}manage/messageContact?user={$this->user['account']}") . "'>" . $this->lang->line('manage_messageContact') . "</a></li>
                    <li role='separator' class='divider'></li>
                    <li><a href='" . $this->mylibrary->authUrl("{$this->baseUrl}manage/messageRecord?user={$this->user['account']}") . "'>" . $this->lang->line('manage_messageRecord') . "</a></li>
                </ul>
            </div>
            <div class='item dropdown'>
                <div class='dropdown-toggle' data-toggle='dropdown'>
                    <img src='{$this->baseUrl}assets/imgs/manage/system.svg' />
                    <div>" . $this->lang->line('manage_system') . "</div>
                </div>
                <ul class='dropdown-menu'>
                    <li><a href='" . $this->mylibrary->authUrl("{$this->baseUrl}manage/systemDiscount?user={$this->user['account']}") . "'>" . $this->lang->line('manage_systemDiscount') . "</a></li>
                    <li role='separator' class='divider'></li>
                    <li><a href='" . $this->mylibrary->authUrl("{$this->baseUrl}manage/systemStatistic?user={$this->user['account']}") . "'>" . $this->lang->line('manage_systemStatistic') . "</a></li>
                </ul>
            </div>
        </div>";


        return $result;  
    }

    public function breadcrumb($data=array()) {
        $category = '';
        if ( strpos($data['action'], 'message') !== FALSE ) {
            $category = $this->lang->line('manage_message');
        } else if ( strpos($data['action'], 'shop') !== FALSE ) { 
            $category = $this->lang->line('manage_shop');
        } else if ( strpos($data['action'], 'order') !== FALSE ) { 
            $category = $this->lang->line('manage_order');
        } else {
            $category = $this->lang->line('manage_information');
        }


        return "<div class='manageBreadcrumb'>{$category} / " . $this->lang->line("manage_{$data['action']}") . "</div>";
    }

    private function content($title, $content) {
        $result = "<div class='manageContent'>
            <div class='title'>{$title}</div>
            <div class='content'>{$content}</div>
        </div>";


        return $result;
    }

    public function informationHome($data=array()) {
        $carousel = "<div class='carousel'>" . $this->Mod_media_html->getMediaContentGrid($data['carousel']) . "</div>";


        $maskStatus = ( $data['carouselMask']['active'] ) ? $this->lang->line('active') : $this->lang->line('inactive');
        $carouselMask = "<div class='carouselMask' data-url='{$data['editMaskUrl']}'>
            <div>" . $this->lang->line('title') . "：" . $this->mylibrary->htmlChars($data['carouselMask']['title']) . "</div>
            <div>" . $this->lang->line('subTitle') . "：" . $this->mylibrary->htmlChars($data['carouselMask']['subTitle']) . "</div>
            <div>" . $this->lang->line('status') . "：{$maskStatus}</div>
        </div>";


        $concept = "<div class='concept' data-url='{$data['editConceptUrl']}'>
            <div class='pic'><img src='{$data['concept']['img']}' /></div>
            <div class='info'>
                <div>" . $this->lang->line('title') . "：" . $this->mylibrary->htmlChars($data['concept']['title']) . "</div>
                <div>" . $this->lang->line('description') . "：" . nl2br($this->mylibrary->htmlChars($data['concept']['description'])) . "</div>
            </div>
        </div>";


        $lookbookMediaContents = $this->Mod_media_html->getMediaContentGrid($data['lookbook']['imgs']);
        $lookbook = "<div class='lookbook' data-url='{$data['editLookbookUrl']}'>
            {$lookbookMediaContents}
            <div class='info'>
                <div>" . $this->lang->line('title') . "：" . $this->mylibrary->htmlChars($data['lookbook']['title']) . "</div>
                <div>" . $this->lang->line('subTitle') . "：" . $this->mylibrary->htmlChars($data['lookbook']['subTitle']) . "</div>
                <div>" . $this->lang->line('description') . "：" . nl2br($this->mylibrary->htmlChars($data['lookbook']['description'])) . "</div>
                <div>" . $this->lang->line('url') . "：" . $this->mylibrary->htmlChars($data['lookbook']['url']) . "</div>
            </div>
        </div>";


        $editorial = "<div class='editorial' data-url='{$data['editEditorialUrl']}'>
            <div class='pic'><img src='{$data['editorial']['img']}' /></div>
            <div class='info'>
                <div>" . $this->lang->line('title') . "：" . $this->mylibrary->htmlChars($data['editorial']['title']) . "</div>
                <div>" . $this->lang->line('description') . "：" . nl2br($this->mylibrary->htmlChars($data['editorial']['description'])) . "</div>
                <div>" . $this->lang->line('url') . "：" . $this->mylibrary->htmlChars($data['editorial']['url']) . "</div>
            </div>
        </div>";


        $result = "<div class='manageHome'>
            <div class='title'>" . $this->lang->line('home_carousel') . "</div>
            {$carousel}
            <div class='title'>" . $this->lang->line('home_carouselMask') . "</div>
            {$carouselMask}
            <div class='title'>" . $this->lang->line('home_concept') . "</div>
            {$concept}
            <div class='title'>" . $this->lang->line('home_lookbook') . "</div>
            {$lookbook}
            <div class='title'>" . $this->lang->line('home_editorial') . "</div>
            {$editorial}
        </div>";


        return $this->content($this->lang->line("manage_{$data['action']}"), $result);
    }

    public function informationHomeCarouselMask($data=array()) {
        $this->myform->addText('title', array(
            'title' => $this->lang->line('title'),
            'type' => 'text',
            'value' => $this->mylibrary->htmlChars($data['mask']['title']),
            'required' => TRUE
        ));

        $this->myform->addText('subTitle', array(
            'title' => $this->lang->line('subTitle'),
            'type' => 'text',
            'value' => $this->mylibrary->htmlChars($data['mask']['subTitle']),
            'required' => TRUE
        ));

        $this->myform->addCheckbox('active', array(
            'value' => $this->lang->line('active'),
            'checked' => $data['mask']['active']
        ));


        $this->myform->addSubmit(array(
            'submitText' => $this->lang->line('submit'),
            'submitingText' => $this->lang->line('submiting'),
            'cancelText' => $this->lang->line('cancel'),
            'url' => $this->mylibrary->authUrl("{$this->baseUrl}home_service/updateCarouselMask?user={$this->user['account']}"),
            'onSuccess' => array('back'),
            'onCancel' => array('back')
        ));


        $result = "<div class='manageMask'>" . $this->myform->getResult() . "</div>";


        return $this->content($this->lang->line("manage_{$data['action']}"), $result);
    }

    public function informationHomeConcept($data=array()) {
        $this->myform->addImage('cover',
                                array('title'        => $this->lang->line('clickToChangeImage'),
                                      'src'          => "{$this->baseUrl}data/home/concept.png?uniqid=" . uniqid(),
                                      'style'        => "display:inline-block; width:400px; height:278px;",
                                      'defaultImage' => "{$this->baseUrl}assets/imgs/default/home_concept.jpg",
                                      'uploadUrl'    => $this->mylibrary->authUrl("{$this->baseUrl}home_service/uploadConceptCover?user={$this->user['account']}"),
                                      'deleteUrl'    => $this->mylibrary->authUrl("{$this->baseUrl}home_service/deleteConceptCover?user={$this->user['account']}"),
                                      'validate'     => array()) );

        $this->myform->addBlock("<div class='dangerHint'>" . $this->lang->line('manage_uploadHint') . "w1352xh940</div>");

        $this->myform->addText('title', array(
            'title' => $this->lang->line('title'),
            'value' => $this->mylibrary->htmlChars($data['concept']['title']),
            'type' => 'text',
            'required' => TRUE,
        ));


        $this->myform->addTextArea('value', array(
            'title' => $this->lang->line('description'),
            'rows' => 8,
            'required' => TRUE,
            'value' => $this->mylibrary->htmlChars($data['concept']['description'])
        ));


        $this->myform->addSubmit(array(
            'submitText' => $this->lang->line('submit'),
            'submitingText' => $this->lang->line('submiting'),
            'cancelText' => $this->lang->line('cancel'),
            'url' => $this->mylibrary->authUrl("{$this->baseUrl}home_service/updateConcept?user={$this->user['account']}"),
            'onSuccess' => array('back'),
            'onCancel' => array('back')
        ));

        $result = "<div class='editHomeConcept'>" . $this->myform->getResult() . "</div>";


        return $this->content($this->lang->line("manage_{$data['action']}"), $result);
    }

    public function informationHomeLookbook($data=array()) {
        $this->myform->addBlock("<a class='lookbookMedia btn btn-primary'>" . $this->lang->line('manage_media') . "</a>");

        $this->myform->addText('title', array(
            'title' => $this->lang->line('title'),
            'value' => $this->mylibrary->htmlChars($data['lookbook']['title']),
            'type' => 'text',
            'required' => TRUE,
        ));

        $this->myform->addText('subTitle', array(
            'title' => $this->lang->line('subTitle'),
            'value' => $this->mylibrary->htmlChars($data['lookbook']['subTitle']),
            'type' => 'text',
            'required' => TRUE,
        ));

        $this->myform->addTextArea('value', array(
            'title' => $this->lang->line('description'),
            'rows' => 8,
            'required' => TRUE,
            'value' => $this->mylibrary->htmlChars($data['lookbook']['description'])
        ));

        $this->myform->addText('url', array(
            'title' => $this->lang->line('url'),
            'value' => $this->mylibrary->htmlChars($data['lookbook']['url']),
            'type' => 'url',
            'required' => TRUE,
        ));


        $backUrl = $this->mylibrary->authUrl("{$this->baseUrl}manage/informationHome?user={$this->user['account']}");
        $this->myform->addSubmit(array(
            'submitText' => $this->lang->line('submit'),
            'submitingText' => $this->lang->line('submiting'),
            'cancelText' => $this->lang->line('cancel'),
            'url' => $this->mylibrary->authUrl("{$this->baseUrl}home_service/updateLookbook?user={$this->user['account']}"),
            'onSuccess' => array('reDirect', $backUrl),
            'onCancel' => array('reDirect', $backUrl)
        ));

        $result = "<div class='editHomeLookbook'>" . $this->myform->getResult() . "</div>";


        return $this->content($this->lang->line("manage_{$data['action']}"), $result);
    }

    public function informationHomeEditorial($data=array()) {
        $this->myform->addImage('cover',
                                array('title'        => $this->lang->line('clickToChangeImage'),
                                      'src'          => "{$this->baseUrl}data/home/editorial.png?uniqid=" . uniqid(),
                                      'style'        => "display:inline-block; width:400px; height:267px;",
                                      'defaultImage' => "{$this->baseUrl}assets/imgs/default/home_editorial.jpg",
                                      'uploadUrl'    => $this->mylibrary->authUrl("{$this->baseUrl}home_service/uploadEditorialCover?user={$this->user['account']}"),
                                      'deleteUrl'    => $this->mylibrary->authUrl("{$this->baseUrl}home_service/deleteEditorialCover?user={$this->user['account']}"),
                                      'validate'     => array()) );

        $this->myform->addBlock("<div class='dangerHint'>" . $this->lang->line('manage_uploadHint') . "w1812xh1210</div>");

        $this->myform->addText('title', array(
            'title' => $this->lang->line('title'),
            'value' => $this->mylibrary->htmlChars($data['editorial']['title']),
            'type' => 'text',
            'required' => TRUE,
        ));

        $this->myform->addTextArea('value', array(
            'title' => $this->lang->line('description'),
            'rows' => 8,
            'required' => TRUE,
            'value' => $data['editorial']['description']
        ));

        $this->myform->addText('url', array(
            'title' => $this->lang->line('url'),
            'value' => $this->mylibrary->htmlChars($data['editorial']['url']),
            'type' => 'url',
            'required' => TRUE,
        ));


        $this->myform->addSubmit(array(
            'submitText' => $this->lang->line('submit'),
            'submitingText' => $this->lang->line('submiting'),
            'cancelText' => $this->lang->line('cancel'),
            'url' => $this->mylibrary->authUrl("{$this->baseUrl}home_service/updateEditorial?user={$this->user['account']}"),
            'onSuccess' => array('back'),
            'onCancel' => array('back')
        ));

        $result = "<div class='editHomeEditorial'>" . $this->myform->getResult() . "</div>";


        return $this->content($this->lang->line("manage_{$data['action']}"), $result);
    }

    public function informationPress($data=array()) {
        $result = "<div class='managePress'>" . $this->Mod_media_html->getMediaContentGrid($data['press']) . "</div>";


        return $this->content($this->lang->line("manage_{$data['action']}"), $result);
    }

    public function messageSend($data=array()) {
        $this->myform->addText('email', array(
            'title' => $this->lang->line('email'),
            'type' => 'email',
            'required' => TRUE
        ));

        $this->myform->addCheckbox('sendToAll', array(
            'value' => $this->lang->line('manage_messageSendToAll')
        ));

        $this->myform->addText('subject', array(
            'title' => $this->lang->line('subject'),
            'type' => 'text',
            'required' => TRUE
        ));

        $this->myform->addTextArea('message', array(
            'isEditor' => TRUE,
            'title' => $this->lang->line('content'),
            'required' => TRUE
        ));


        $this->myform->addSubmit(array(
            'submitText' => $this->lang->line('send'),
            'submitingText' => $this->lang->line('sending'),
            'hideCancel' => TRUE,
            'url' => $this->mylibrary->authUrl("{$this->baseUrl}manage_service/messageSend?user={$this->user['account']}"),
            'onSuccess' => array('reDirect', 'reload'),
            'onCancel' => array()
        ));


        $result = "<div class='manageMessageSend'>
            <div class='contentBox'>" . $this->myform->getResult() . "</div>
        </div>";


        return $this->content($this->lang->line("manage_{$data['action']}"), $result);
    }

    public function messageEdm($data=array()) {
        $header = array(
            array('title' => $this->lang->line('id'), 'width' => '8%', 'height' => '50px', 'align' => 'center'),
            array('title' => $this->lang->line('email'), 'width' => '75%', 'height' => '50px', 'align' => 'left'),
            array('title' => $this->lang->line('createTime'), 'width' => '10%', 'height' => '50px', 'align' => 'left'),
            array('title' => $this->lang->line('manage'), 'width' => '7%', 'height' => '50px', 'align' => 'center')
        );

        $content = array();
        foreach ( $data['subscribers']['items'] as $subscriber ) {
            $id = intval($subscriber['id']);
            $email = $this->mylibrary->htmlChars($subscriber['email']);
            $email = "<span title='{$email}'>{$email}</span>";
            $createTime = $this->mylibrary->timeSpan($subscriber['createTime']);
            $manage = "<a data-role='deleteSubscriber' data-url='" . $this->mylibrary->authUrl("{$this->baseUrl}newsletter_service/deleteSubscriber?id={$subscriber['id']}") . "'>" . $this->lang->line('delete') . "</a>";

            $content[] = array($id, $email, $createTime, $manage);
        }
        $table = $this->mytemplate->table($header, $content);


        $config = array(
            'base_url' => $this->mylibrary->authUrl("{$this->baseUrl}manage/messageEdm?user={$this->user['account']}"),
            'total_rows' => $data['subscribers']['totalRows'],
            'per_page' => 20
        );
        $pager = $this->mylibrary->getPager($config);


        $result = "<div class='manageTable'>
            <div class='contentBox'>
                {$table}
                {$pager}
            </div>
        </div>";


        return $this->content($this->lang->line("manage_{$data['action']}"), $result);
    }


    public function messageRecord($data=array()) {
        $header = array( 
            array('title' => $this->lang->line('id'), 'width' => '8%', 'height' => '50px', 'align' => 'center'),
            array('title' => $this->lang->line('email'), 'width' => '25%', 'height' => '50px', 'align' => 'left'),
            array('title' => $this->lang->line('subject'), 'width' => '30%', 'height' => '50px', 'align' => 'left'),
            array('title' => $this->lang->line('content'), 'width' => '20%', 'height' => '50px', 'align' => 'left'),
            array('title' => $this->lang->line('createTime'), 'width' => '10%', 'height' => '50px', 'align' => 'left'),
            array('title' => $this->lang->line('manage'), 'width' => '7%', 'height' => '50px', 'align' => 'center') 
        );

        $content = array();
        foreach ( $data['emails']['items'] as $email ) {
            $id = intval($email['id']);
            $to = $this->mylibrary->htmlChars($email['to']);
            $to = "<span title='{$to}'>{$to}</span>";
            $subject = $this->mylibrary->htmlChars($email['subject']);
            $subject = "<span title='{$subject}'>{$subject}</span>";
            $message = strip_tags($email['message']);
            $message = "<span title='{$message}'>{$message}</span>";
            $createTime = $this->mylibrary->timeSpan($email['createTime']);
            $manage = "<a data-role='deleteRecord' data-url='" . $this->mylibrary->authUrl("{$this->baseUrl}manage_service/deleteEmailRecord?id={$email['id']}") . "'>" . $this->lang->line('delete') . "</a>";

            $content[] = array($id, $to, $subject, $message, $createTime, $manage);
        }
        $table = $this->mytemplate->table($header, $content);


        $config = array(
            'base_url' => $this->mylibrary->authUrl("{$this->baseUrl}manage/messageRecord?user={$this->user['account']}"),
            'total_rows' => $data['emails']['totalRows'],
            'per_page' => 20
        );
        $pager = $this->mylibrary->getPager($config);


        $result = "<div class='manageTable'>
            <div class='contentBox'>
                {$table}
                {$pager}
            </div>
        </div>";


        return $this->content($this->lang->line("manage_{$data['action']}"), $result);
    }

    public function informationCustomercare($data=array()) {

        $this->myform->addTextArea('value', array(
            'isEditor' => TRUE,
            'title' => $this->lang->line('content'),
            'required' => TRUE,
            'value' => $data['customercare']
        ));

        $this->myform->addSubmit(array(
            'submitText' => $this->lang->line('submit'),
            'submitingText' => $this->lang->line('submiting'),
            'hideCancel' => TRUE,
            'url' => $this->mylibrary->authUrl("{$this->baseUrl}customercare_service/updateCustomercare?user={$this->user['account']}"),
            'onSuccess' => array('reDirect', 'reload'),
            'onCancel' => array()
        ));


        $result = "<div class='updateCustomerCare'>
            <div class='contentBox'>" . $this->myform->getResult() . "</div>
        </div>";


        return $this->content($this->lang->line("manage_{$data['action']}"), $result);
    }


    public function messageContact($data=array()) {
        $header = array(
            array('title' => $this->lang->line('id'), 'width' => '8%', 'height' => '50px', 'align' => 'center'),
            array('title' => $this->lang->line('name'), 'width' => '10%', 'height' => '50px', 'align' => 'left'),
            array('title' => $this->lang->line('email'), 'width' => '14%', 'height' => '50px', 'align' => 'left'),
            array('title' => $this->lang->line('subject'), 'width' => '15%', 'height' => '50px', 'align' => 'left'),
            array('title' => $this->lang->line('message'), 'width' => '13%', 'height' => '50px', 'align' => 'left'),
            array('title' => $this->lang->line('status'), 'width' => '8%', 'height' => '50px', 'align' => 'left'),
            array('title' => $this->lang->line('updateTime'), 'width' => '10%', 'height' => '50px', 'align' => 'center'),
            array('title' => $this->lang->line('createTime'), 'width' => '10%', 'height' => '50px', 'align' => 'left'),
            array('title' => $this->lang->line('manage'), 'width' => '12%', 'height' => '50px', 'align' => 'center') 

        );

        $content = array();
        foreach ( $data['contacts']['items'] as $contact ) {
            $id = intval($contact['id']);

            $name = $this->mylibrary->htmlChars($contact['name']);
            $name = "<span title='{$name}'>{$name}</span>";

            $email = $this->mylibrary->htmlChars($contact['email']);
            $email = "<span title='{$email}'>{$email}</span>";

            $subject = $this->mylibrary->htmlChars($contact['subject']);
            $subject = "<span title='{$subject}'>{$subject}</span>";

            $message = $this->mylibrary->htmlChars($contact['message']);
            $message = "<span title='{$message}'>{$message}</span>";

            $status = ( $contact['status'] ) 
                    ? "<span style='color:#228b22'>" . $this->lang->line('manage_contactComplete') . "</span>"
                    : "<span style='color:#f00'>" . $this->lang->line('manage_contactIncomplete') . "</span>";

            $updateTime = $this->mylibrary->timeSpan($contact['updateTime']);

            $createTime = $this->mylibrary->timeSpan($contact['createTime']);

            $manage = array();
            $editUrl = $this->mylibrary->authUrl("{$this->baseUrl}manage/messageEditContact/{$contact['id']}?user={$this->user['account']}");
            $manage[] = "<a data-role='editContact' data-url='{$editUrl}'>" . $this->lang->line('edit') . "</a>";
            $deleteUrl = $this->mylibrary->authUrl("{$this->baseUrl}contact_service/deleteContact?id={$contact['id']}");
            $manage[] = "<a data-role='deleteContact' data-url='{$deleteUrl}'>" . $this->lang->line('delete') . "</a>";
            $manage = join(' / ', $manage);

            $content[] = array($id, $name, $email, $subject, $message, $status, $updateTime, $createTime, $manage);
        }
        $table = $this->mytemplate->table($header, $content);


        $config = array(
            'base_url' => $this->mylibrary->authUrl("{$this->baseUrl}manage/messageContact?user={$this->user['account']}"),
            'total_rows' => $data['contacts']['totalRows'],
            'per_page' => 20
        );
        $pager = $this->mylibrary->getPager($config);


        $result = "<div class='manageTable'>
                        <div class='contentBox'>
                            {$table}
                            {$pager}
                        </div>
                    </div>";


        return $this->content($this->lang->line("manage_{$data['action']}"), $result);
    }


    public function messageEditContact($data=array()) {
        $this->myform->addText('name', array(
            'title' => $this->lang->line('name'),
            'type' => 'text',
            'required' => TRUE,
            'disabled' => TRUE,
            'value' => $data['contact'] -> name
        ));

        $this->myform->addText('email', array(
            'title' => $this->lang->line('email'),
            'type' => 'email',
            'required' => TRUE,
            'disabled' => TRUE,
            'value' => $data['contact'] -> email
        ));

        $this->myform->addText('subject', array(
            'title' => $this->lang->line('subject'),
            'type' => 'text',
            'required' => TRUE,
            'disabled' => TRUE,
            'value' => $data['contact'] -> subject
        ));

        $this->myform->addText('message', array(
            'title' => $this->lang->line('message'),
            'type' => 'text',
            'required' => TRUE,
            'disabled' => TRUE,
            'value' => $data['contact'] -> message
        ));

        $this->myform->addTextArea('response', array(
            'isEditor' => TRUE,
            'title' => $this->lang->line('response'),
            'required' => TRUE,
            'value' => $data['contact'] -> response
        ));


        $options = array();
        $slt = array(($data['contact'] -> status) => 'selected');        
        $options[] = array("text" => $this->lang->line('manage_contactIncomplete'), 'value' => 0, 'selected' => $slt[0]);
        $options[] = array("text" => $this->lang->line('manage_contactComplete'), 'value' => 1, 'selected' => $slt[1]);
        $this->myform->addSelect('status', array(
            'title' => $this->lang->line('status'),
            'options' => $options
        ));


        $backUrl = $this->mylibrary->authUrl("{$this->baseUrl}manage/messageContact?user={$this->user['account']}");
        $this->myform->addSubmit(array(
            'submitText' => $this->lang->line('submit'),
            'submitingText' => $this->lang->line('submiting'),
            'hideCancel' => false,
            'url' => $this->mylibrary->authUrl("{$this->baseUrl}contact_service/updateContact?id={$data['id']}"),
            'onSuccess' => array('reDirect', $backUrl),
            'onCancel' => array('reDirect', $backUrl)
        ));


        $result = "<div class='messageEditContact'>
            <div class='contentBox'>" . $this->myform->getResult() . "</div>
        </div>";


        return $this->content($this->lang->line("manage_{$data['action']}"), $result);
    }

    public function informationConcept($data=array()) {
        $this->myform->addImage('cover',
                                array('title'        => $this->lang->line('clickToChangeImage'),
                                      'src'          => "{$this->baseUrl}data/concept/concept.png?uniqid=" . uniqid(),
                                      'style'        => "display:inline-block; width:280px; height:361px;",
                                      'defaultImage' => "{$this->baseUrl}assets/imgs/default/concept.jpg",
                                      'uploadUrl'    => $this->mylibrary->authUrl("{$this->baseUrl}concept_service/uploadConceptCover?user={$this->user['account']}"),
                                      'deleteUrl'    => $this->mylibrary->authUrl("{$this->baseUrl}concept_service/deleteConceptCover?user={$this->user['account']}"),
                                      'validate'     => array()) );

        $this->myform->addBlock("<div class='dangerHint'>" . $this->lang->line('manage_uploadHint') . "w1120xh1444</div>");

        $this->myform->addTextArea('value', array(
            'isEditor' => TRUE,
            'title' => $this->lang->line('content'),
            'required' => TRUE,
            'value' => $data['concept']['value']
        ));


        $this->myform->addSubmit(array(
            'submitText' => $this->lang->line('submit'),
            'submitingText' => $this->lang->line('submiting'),
            'cancelText' => $this->lang->line('cancel'),
            'url' => $this->mylibrary->authUrl("{$this->baseUrl}concept_service/updateConcept?user={$this->user['account']}"),
            'hideCancel' => TRUE,
            'onSuccess' => array('reDirect', 'reload'),
            'onCancel' => array('back')
        ));

        $result = "<div class='editConcept'>" . $this->myform->getResult() . "</div>";


        return $this->content($this->lang->line("manage_{$data['action']}"), $result);
    }

    public function informationMind($data=array()) {
        $this->myform->addBlock("<a class='mindMedia btn btn-primary'>" . $this->lang->line('manage_media') . "</a>");

        $this->myform->addImage('cover',
                                array('title'        => $this->lang->line('clickToChangeImage'),
                                      'src'          => "{$this->baseUrl}data/mind/mind.png?uniqid=" . uniqid(),
                                      'style'        => "display:inline-block; width:237px; height:151px;",
                                      'defaultImage' => "{$this->baseUrl}assets/imgs/default/mind.jpg",
                                      'uploadUrl'    => $this->mylibrary->authUrl("{$this->baseUrl}mind_service/uploadMindCover?user={$this->user['account']}"),
                                      'deleteUrl'    => $this->mylibrary->authUrl("{$this->baseUrl}mind_service/deleteMindCover?user={$this->user['account']}"),
                                      'validate'     => array()) );

        $this->myform->addBlock("<div class='dangerHint'>" . $this->lang->line('manage_uploadHint') . "w1900xh1208</div>");

        $this->myform->addText('title', array(
            'title' => $this->lang->line('title'),
            'required' => TRUE,
            'value' => $data['mind']['title']
        ));

        $this->myform->addTextArea('value', array(
            'title' => $this->lang->line('content'),
            'required' => TRUE,
            'rows' => 8,
            'value' => $data['mind']['description']
        ));


        $this->myform->addSubmit(array(
            'submitText' => $this->lang->line('submit'),
            'submitingText' => $this->lang->line('submiting'),
            'cancelText' => $this->lang->line('cancel'),
            'url' => $this->mylibrary->authUrl("{$this->baseUrl}mind_service/updateMind?user={$this->user['account']}"),
            'hideCancel' => TRUE,
            'onSuccess' => array('reDirect', 'reload'),
            'onCancel' => array('back')
        ));

        $result = "<div class='editMind'>" . $this->myform->getResult() . "</div>";


        return $this->content($this->lang->line("manage_{$data['action']}"), $result);
    }

    public function shopType($data) {
        $header = array( 
            array('title' => $this->lang->line('sn'), 'width' => '7%', 'height' => '60px', 'align' => 'center'),
            array('title' => $this->lang->line('title'), 'width' => '63%', 'height' => '60px', 'align' => 'left'),
            array('title' => $this->lang->line('updateTime'), 'width' => '10%', 'height' => '60px', 'align' => 'left'),
            array('title' => $this->lang->line('createTime'), 'width' => '10%', 'height' => '60px', 'align' => 'left'),
            array('title' => $this->lang->line('manage'), 'width' => '10%', 'height' => '60px', 'align' => 'center')
        );

        $content = array();
        foreach ( $data['types'] as $t ) {
            $sn = intval($t['sn'] / 10);
            $title = $this->mylibrary->htmlChars($t['title']);
            $title = "<span title='{$title}'>{$title}</span>";
            $updateTime = $this->mylibrary->timeSpan($t['updateTime']);
            $createTime = $this->mylibrary->timeSpan($t['createTime']);
            $manage = array();
            $manage[] = "<a href='" . $this->mylibrary->authUrl("{$this->baseUrl}manage/shopTypeEdit?id={$t['id']}") . "'>" . $this->lang->line('edit') . "</a>";
            $manage[] = "<a data-role='deleteShopType' data-id='{$t['id']}'>" . $this->lang->line('delete') . "</a>";
            $manage = join(' / ', $manage);

            $content[] = array($sn, $title, $updateTime, $createTime, $manage);
        }
        $table = $this->mytemplate->table($header, $content);


        $result = "<div class='manageShopType'>
            <div class='contentBox'>
                <a class='add btn btn-primary' href='" . $this->mylibrary->authUrl("{$this->baseUrl}manage/shopTypeEdit?id=0") . "'>" . $this->lang->line('add') . "</a>
                {$table}
            </div>
        </div>";


        return $this->content($this->lang->line("manage_{$data['action']}"), $result);
    } 

    private function getShopTypeOrderOption($id, $types) {
        $result = array();
        $slt = array($types[$id]['sn'] => 'selected');
        $cnt = count($types);
        $i = 1;
        for ( $i; $i<=$cnt; $i++ ) {
            $sn = $i * 10;

            $result[] = array('value' => $sn, 'text' => $i, 'selected' => $slt[$sn]);
        }
        if ( !$id ) {
            $sn = $i * 10;

            $result[] = array('value' => $sn, 'text' => $i, 'selected' => 'selected');
        }


        return $result;
    }

    public function shopTypeEdit($data) {
        $this->myform->addText('title', array(
            'title' => $this->lang->line('title'),
            'value' => $this->mylibrary->htmlChars($data['types'][ $data['id'] ]['title']),
            'type' => 'text',
            'required' => TRUE,
        ));

        $orderOpt = $this->getShopTypeOrderOption($data['id'], $data['types']);
        $this->myform->addSelect('sn', array(
            'title' => $this->lang->line('sn'),
            'options' => $orderOpt
        ));


        $this->myform->addSubmit(array(
            'submitText' => $this->lang->line('submit'),
            'submitingText' => $this->lang->line('submiting'),
            'cancelText' => $this->lang->line('cancel'),
            'url' => $this->mylibrary->authUrl("{$this->baseUrl}shop_service/editType?id={$data['id']}"),
            'onSuccess' => array('back'),
            'onCancel' => array('back')
        ));

        $result = "<div class='shopTypeEdit'>" . $this->myform->getResult() . "</div>";


        return $this->content($this->lang->line("manage_{$data['action']}"), $result);
    }

    private function getProudctToolBox($data=array()) {
        $perPageSlt = array($data['perPage'] => 'selected');
        $perPage = "<select class='form-control perPage'>
            <option value='20' {$perPageSlt['20']}>20</option>
            <option value='50' {$perPageSlt['50']}>50</option>
            <option value='100' {$perPageSlt['100']}>100</option>
            <option value='all' {$perPageSlt['all']}>" . $this->lang->line('all') . "</option>
        </select>";

        $typeSlt = array($data['type'] => 'selected');
        $typeOpt = array();
        $typeOpt[] = "<option value='0'>" . $this->lang->line('all') . "</option>";
        foreach ( $data['types'] as $pt ) {
            $slt = $typeSlt[ $pt['id'] ];

            $typeOpt[] = "<option value='{$pt['id']}' {$slt}>" . $this->mylibrary->htmlChars($pt['title']) . "</option>";
        }
        $type = "<select class='form-control type'>" . implode('', $typeOpt) . "</select>";

        $search = "<div class='input-group searchBox'>
            <input type='text' class='form-control search' placeholder='Search for...' value='" . $this->mylibrary->htmlChars($data['search']) . "' />
            <span class='input-group-btn'>
                <button class='searchBtn btn btn-default' type='button'><span class='glyphicon glyphicon-search'></span></button>
            </span>
        </div>";

        $orderText = $this->lang->line('order_items');
        $data['order'] = ( $data['order'] ) ? $data['order'] : '2';
        $orderSlt = array($data['order'] => 'selected');
        $order ="<select class='form-control order'>
            <option value='1' {$orderSlt['1']}>{$orderText['timeASC']}</option>
            <option value='2' {$orderSlt['2']}>{$orderText['timeDESC']}</option>
            <option value='3' {$orderSlt['3']}>{$orderText['priceASC']}</option>
            <option value='4' {$orderSlt['4']}>{$orderText['priceDESC']}</option>
            <option value='5' {$orderSlt['5']}>{$orderText['cntASC']}</option>
            <option value='6' {$orderSlt['6']}>{$orderText['cntDESC']}</option>
        </select>";

        $result = "<div class='toolBox clearfix'>
            <div class='btnBox'>
                <a data-role='addShopItem' href='" . $this->mylibrary->authUrl("{$this->baseUrl}manage/shopItemEdit?id=0") . "' class='add btn btn-primary'>" . $this->lang->line('add') . "</a>
                <a class='btn btn-success' data-role='publish'>" . $this->lang->line('manage_shopItemPublish') . "</a>
                <a class='btn btn-danger' data-role='unpublish'>" . $this->lang->line('manage_shopItemUnpublish') . "</a>
            </div>
            <div class='pull-right'>
                <span>" . $this->lang->line('perPage') . ": </span>{$perPage}
                <span>" . $this->lang->line('manage_shopType') . ": </span>{$type}
                <div class='orderBox'><span>" . $this->lang->line('order') . ": </span>{$order}</div>
                {$search}
            </div>
        </div>";


        return $result;
    }

    public function shopItem($data) {
        $toolBox = $this->getProudctToolBox($data);


        $header = array( 
            array('checkbox' => TRUE, 'width' => '5%', 'height' => '60px', 'align' => 'center'),
            array('title' => $this->lang->line('manage_shopItemCode'), 'width' => '15%', 'height' => '60px', 'align' => 'left'),
            array('title' => $this->lang->line('title'), 'width' => '25%', 'height' => '60px', 'align' => 'left'),
            array('title' => $this->lang->line('size'), 'width' => '10%', 'height' => '60px', 'align' => 'center'),
            array('title' => $this->lang->line('color'), 'width' => '10%', 'height' => '60px', 'align' => 'center'),
            array('title' => $this->lang->line('price'), 'width' => '10%', 'height' => '60px', 'align' => 'center'),
            array('title' => $this->lang->line('count'), 'width' => '5%', 'height' => '60px', 'align' => 'center'),
            array('title' => $this->lang->line('manage'), 'width' => '20%', 'height' => '60px', 'align' => 'center') 
        );


        $content = array();
        foreach ( $data['items']['items'] as $p ) {
            $major = ( !$p['major'] ) ? '' : ("<span class='major'>(" . $this->lang->line('manage_shopItemMajorHint') . ") </span>");
            $code = $this->mylibrary->htmlChars($p['code']);
            $code = "<span title='{$code}'>{$major}{$code}</span>";
            $unpublish = ( $p['publish'] ) ? '' : ('<span class="unpublish">(' . $this->lang->line('manage_shopItemUnpublish') . ') </span>');
            $title = $this->mylibrary->htmlChars($p['title']);
            $title = "<span title='{$title}'>{$unpublish}{$title}</span>";
            $productCnt = intval($p['cnt']);
            $size = $this->mylibrary->htmlChars($p['size']);
            $size = "<span title='{$size}'>{$size}</span>";
            $color = $this->mylibrary->htmlChars($p['color']);
            $color = "<span title='{$color}'>{$color}</span>";
            $price = ( $p['specialPrice'] ) ? intval($p['specialPrice']) : intval($p['price']) ;
            $price = number_format($price);
            $manage = array();
            $manage[] = "<a data-role='itemMedia' data-url='" . $this->mylibrary->authUrl("{$this->baseUrl}media/edit/{$p['mediaID']}?user={$this->user['account']}") . "'>" . $this->lang->line('manage_mediaEdit') . "</a>";
            $manage[] = "<a data-role='copyItem' data-id='{$p['id']}'>" . $this->lang->line('copy') . "</a>";
            $manage[] = "<a href='" . $this->mylibrary->authUrl("{$this->baseUrl}manage/shopItemEdit?id={$p['id']}") . "'>" . $this->lang->line('edit') . "</a>";
            $manage[] = "<a data-role='deleteItem' data-id='{$p['id']}'>" . $this->lang->line('delete') . "</a>";
            $manage = join(' / ', $manage);

            $content[] = array($p['id'], $code, $title, $size, $color, $price, $productCnt, $manage);
        }
        $table = $this->mytemplate->table($header, $content);


        $config = array(
            'base_url'      => $this->mylibrary->authUrl("{$this->baseUrl}manage/product?user={$this->user['account']}&perPage={$data['perPage']}&type={$data['type']}&search={$data['search']}&order={$data['order']}"),
            'total_rows'    => $data['items']['totalRows'],
            'per_page'      => ( $data['perPage'] ) ? $data['perPage'] : 20
        );
        $pager = $this->mylibrary->getPager($config);


        $result = "<div class='manageShopItem'>
            <div class='contentBox'>
                {$toolBox}
                {$table}
                {$pager}
            </div>
        </div>";


        return $this->content($this->lang->line("manage_{$data['action']}"), $result);
    } 

    public function shopItemEdit($data) {
        $this->myform->addText('code', array(
            'title' => $this->lang->line('manage_shopItemCode'),
            'value' => $this->mylibrary->htmlChars($data['item']['code']),
            'type' => 'text',
            'required' => TRUE,
        ));

        $this->myform->addText('title', array(
            'title' => $this->lang->line('title'),
            'value' => $this->mylibrary->htmlChars($data['item']['title']),
            'type' => 'text',
            'required' => TRUE,
        ));

        $typeOpt = array();
        $typeSlt = array($data['item']['typeID'] => 'selected');
        foreach ( $data['types'] as $t ) {
            $typeOpt[] = array(
                'value' => $t['id'],
                'text' => $this->mylibrary->htmlChars($t['title']),
                'selected' => $typeSlt[ $t['id'] ]
            );
        }
        $this->myform->addSelect('typeID', array(
            'title' => $this->lang->line('manage_shopType'),
            'options' => $typeOpt
        ));

        $this->myform->addText('size', array(
            'title' => $this->lang->line('size'),
            'value' => $this->mylibrary->htmlChars($data['item']['size']),
            'type' => 'text',
            'required' => TRUE,
        ));

        $this->myform->addText('color', array(
            'title' => $this->lang->line('color'),
            'value' => $this->mylibrary->htmlChars($data['item']['color']),
            'type' => 'text',
            'required' => TRUE,
        ));

        $this->myform->addImage('colorImg',
                                array('title'        => $this->lang->line('clickToChangeImage'),
                                      'src'          => "{$this->baseUrl}{$data['item']['path']}/color.png?uniqid=" . uniqid(),
                                      'style'        => "display:inline-block; width:122px; height:40px;",
                                      'defaultImage' => "{$this->baseUrl}assets/imgs/default/color.jpg",
                                      'uploadUrl'    => $this->mylibrary->authUrl("{$this->baseUrl}shop_service/uploadColor?id={$data['id']}"),
                                      'deleteUrl'    => $this->mylibrary->authUrl("{$this->baseUrl}shop_service/deleteColor?id={$data['id']}"),
                                      'validate'     => array()) );

        $this->myform->addBlock("<div class='dangerHint'>" . $this->lang->line('manage_uploadHint') . "w244xh80</div>");

        $this->myform->addText('cnt', array(
            'title' => $this->lang->line('count'),
            'value' => ( $data['item']['cnt'] ) ? intval($data['item']['cnt']) : '',
            'type' => 'number',
            'required' => TRUE,
        ));

        $this->myform->addText('price', array(
            'title' => $this->lang->line('price'),
            'value' => ( $data['item']['price'] ) ? intval($data['item']['price']) : '',
            'type' => 'number',
            'required' => TRUE,
        ));

        $this->myform->addText('specialPrice', array(
            'title' => $this->lang->line('specialPrice'),
            'value' => ( $data['item']['specialPrice'] ) ? intval($data['item']['specialPrice']) : '',
            'type' => 'number'
        ));

        $this->myform->addTextArea('spec', array(
            'isEditor' => TRUE,
            'title' => $this->lang->line('sizeChart'),
            'required' => TRUE,
            'value' => $data['item']['spec']
        ));

        $this->myform->addTextArea('information', array(
            'title' => $this->lang->line('manage_shopItemInformation'),
            'required' => TRUE,
            'rows' => 6,
            'value' => $this->mylibrary->htmlChars($data['item']['information'])
        ));

        $this->myform->addTextArea('composition', array(
            'title' => $this->lang->line('manage_shopItemComposition'),
            'required' => TRUE,
            'rows' => 6,
            'value' => $this->mylibrary->htmlChars($data['item']['composition'])
        ));

        $this->myform->addTextArea('customercare', array(
            'title' => $this->lang->line('manage_shopItemCustomercare'),
            'required' => TRUE,
            'rows' => 6,
            'value' => $this->mylibrary->htmlChars($data['item']['customercare'])
        ));

        $this->myform->addCheckbox('major', array(
            'value' => $this->lang->line('manage_shopItemMajor'),
            'checked' => $data['item']['major']
        ));

        $this->myform->addCheckbox('publish', array(
            'value' => $this->lang->line('manage_shopItemPublish'),
            'checked' => $data['item']['publish']
        ));

        $this->myform->addSubmit(array(
            'submitText' => $this->lang->line('submit'),
            'submitingText' => $this->lang->line('submiting'),
            'cancelText' => $this->lang->line('cancel'),
            'url' => $this->mylibrary->authUrl("{$this->baseUrl}shop_service/editItem?id={$data['id']}"),
            'onSuccess' => array('back'),
            'onCancel' => array('back')
        ));

        $result = "<div class='shopTypeEdit'>" . $this->myform->getResult() . "</div>";


        return $this->content($this->lang->line("manage_{$data['action']}"), $result);
    }

    public function systemDiscount($data) {
        $header = array( 
            array('title' => $this->lang->line('title'), 'width' => '25%', 'height' => '60px', 'align' => 'left'),
            array('title' => $this->lang->line('manage_systemDiscount'), 'width' => '29%', 'height' => '60px', 'align' => 'left'),
            array('title' => $this->lang->line('manage_systemDiscountType'), 'width' => '8%', 'height' => '60px', 'align' => 'center'),
            array('title' => $this->lang->line('manage_systemDiscountValue'), 'width' => '8%', 'height' => '60px', 'align' => 'center'),
            array('title' => $this->lang->line('startTime'), 'width' => '10%', 'height' => '60px', 'align' => 'center'),
            array('title' => $this->lang->line('endTime'), 'width' => '10%', 'height' => '60px', 'align' => 'center'),
            array('title' => $this->lang->line('manage'), 'width' => '10%', 'height' => '60px', 'align' => 'center') 
        );

        $content = array();
        foreach ( $data['discounts'] as $d ) {
            $title = $this->mylibrary->htmlChars($d['title']);
            $title = "<span title='{$title}'>{$title}</span>";
            $code = $this->mylibrary->htmlChars($d['code']);
            $code = "<span title='{$code}'>{$code}</span>";
            $type = ( $d['type'] ) ? $this->lang->line('manage_systemDiscountValuePrice') : $this->lang->line('manage_systemDiscountValuePercent');
            $value = intval($d['value']);
            $startTime = $this->mylibrary->dateFormat($d['startTime']);
            $endTime = $this->mylibrary->dateFormat($d['endTime']);
            $manage = array();
            $manage[] = "<a href='" . $this->mylibrary->authUrl("{$this->baseUrl}manage/systemDiscountEdit?id={$d['id']}") . "'>" . $this->lang->line('edit') . "</a>";
            $manage[] = "<a data-role='deleteDiscount' data-id='{$d['id']}'>" . $this->lang->line('delete') . "</a>";
            $manage = join(' / ', $manage);

            $content[] = array($title, $code, $type, $value, $startTime, $endTime, $manage);
        }
        $table = $this->mytemplate->table($header, $content);

        $result = "<div class='manageDiscount'>
            <a class='add btn btn-primary' href='" . $this->mylibrary->authUrl("{$this->baseUrl}manage/systemDiscountEdit?id=0") . "'>" . $this->lang->line('add') . "</a>
            {$table}
        </div>";


        return $this->content($this->lang->line("manage_{$data['action']}"), $result);
    } 

    public function systemDiscountEdit($data) {
        $this->myform->addText('title', array(
            'title' => $this->lang->line('title'),
            'value' => $this->mylibrary->htmlChars($data['discount']['title']),
            'type' => 'text',
            'required' => TRUE,
        ));

        $code = ( $data['discount']['code'] ) ? $data['discount']['code'] : uniqid();
        $this->myform->addText('code', array(
            'title' => $this->lang->line('manage_systemDiscount'),
            'value' => $this->mylibrary->htmlChars($code),
            'type' => 'text',
            'required' => TRUE,
            'disabled' => ( $data['discount'] )
        ));

        
        $typeOpt = array();
        $typeSlt = array($data['discount']['type'] => 'selected');
        $typeOpt[] = array(
            'value' => '0',
            'text' => $this->lang->line('manage_systemDiscountValuePercent'),
            'selected' => $typeSlt['0']
        );
        $typeOpt[] = array(
            'value' => '1',
            'text' => $this->lang->line('manage_systemDiscountValuePrice'),
            'selected' => $typeSlt['1']
        );
        $this->myform->addSelect('type', array(
            'title' => $this->lang->line('manage_systemDiscountType'),
            'options' => $typeOpt
        ));

        $this->myform->addText('value', array(
            'title' => $this->lang->line('manage_systemDiscountValue'),
            'value' => $this->mylibrary->htmlChars($data['discount']['value']),
            'type' => 'text',
            'required' => TRUE,
        ));

        $this->myform->addDateRange('startTime', 'endTime', array(
            'title' => $this->lang->line('duration'),
            'required' => TRUE,
            'startTimeValue' => $this->mylibrary->dateFormat($data['discount']['startTime']),
            'endTimeValue' => $this->mylibrary->dateFormat($data['discount']['endTime']),
            'validate' => array('date')
        ));


        $this->myform->addSubmit(array(
            'submitText' => $this->lang->line('submit'),
            'submitingText' => $this->lang->line('submiting'),
            'cancelText' => $this->lang->line('cancel'),
            'url' => $this->mylibrary->authUrl("{$this->baseUrl}shop_service/editDiscount?id={$data['id']}"),
            'onSuccess' => array('back'),
            'onCancel' => array('back')
        ));

        $result = "<div class='systemDicountEdit'>" . $this->myform->getResult() . "</div>";


        return $this->content($this->lang->line("manage_{$data['action']}"), $result);
    }

    private function getOrderToolBox($data=array()) {
        $statusSlt = array($data['status'] => 'selected');
        $status = "<select class='status form-control'>
            <option value='all' {statusSlt['all']}>" . $this->lang->line('all') . "</option>
            <option value='pendding' {$statusSlt['pendding']}>" . $this->lang->line('order_status_pendding') . "</option>
            <option value='success' {$statusSlt['success']}>" . $this->lang->line('order_status_success') . "</option>
            <option value='sending' {$statusSlt['sending']}>" . $this->lang->line('order_status_sending') . "</option>
            <option value='arrive' {$statusSlt['arrive']}>" . $this->lang->line('order_status_arrive') . "</option>
        </select>";

        $search = "<div class='input-group searchBox'>
            <input type='text' class='form-control search' placeholder='Search for...' value='" . $this->mylibrary->htmlChars($data['search']) . "' />
            <span class='input-group-btn'>
                <button class='searchBtn btn btn-default' type='button'><span class='glyphicon glyphicon-search'></span></button>
            </span>
        </div>";

        $orderText = $this->lang->line('order_items');
        $data['order'] = ( $data['order'] ) ? $data['order'] : '2';
        $orderSlt = array($data['order'] => 'selected');
        $order ="<select class='form-control order'>
            <option value='1' {$orderSlt['1']}>{$orderText['timeASC']}</option>
            <option value='2' {$orderSlt['2']}>{$orderText['timeDESC']}</option>
        </select>";

        $result = "<div class='toolBox clearfix'>
            " . $this->lang->line('status') . ": {$status}
            <div class='orderBox'><span>" . $this->lang->line('order') . ": </span>{$order}</div>
            {$search}
        </div>";


        return $result;
    }

    public function orderList($data=array()) {
        $toolBox = $this->getOrderToolBox($data);

        $header = array( array('title' => $this->lang->line('manage_orderNumber'), 'width' => '16%', 'height' => '60px', 'align' => 'left'),
                         array('title' => $this->lang->line('name'), 'width' => '16%', 'height' => '60px', 'align' => 'left'),
                         array('title' => $this->lang->line('email'), 'width' => '24%', 'height' => '60px', 'align' => 'left'),
                         array('title' => $this->lang->line('manage_orderPrice'), 'width' => '10%', 'height' => '60px', 'align' => 'center'),
                         array('title' => $this->lang->line('status'), 'width' => '8%', 'height' => '60px', 'align' => 'center'),
                         array('title' => $this->lang->line('createTime'), 'width' => '10%', 'height' => '60px', 'align' => 'left'),
                         array('title' => $this->lang->line('manage'), 'width' => '16%', 'height' => '60px', 'align' => 'center') );


        $content = array();
        foreach ( $data['orders']['items'] as $o ) {
            $orderNum = "<a data-id='{$o['id']}' data-role='detail'>" . $this->mylibrary->htmlChars($o['id']) . "</a>";
            $name = $this->mylibrary->htmlChars($o['firstName']);
            $name = "<span title='{$name}'>{$name}</span>";
            $email = $this->mylibrary->htmlChars($o['email']);
            $email = "<span title='{$email}'>{$email}</span>";
            $price = number_format($o['total']);
            $status = $this->lang->line("order_status_{$o['status']}");
            $createTime = $this->mylibrary->timeSpan($o['createTime']);
            $manage = array();
            $manage[] = "<a href='" . $this->mylibrary->authUrl("{$this->baseUrl}manage/orderWaybill?id={$o['id']}") . "'>" . $this->lang->line('manage_orderWaybill') . "</a>";
            $manage[] = "<a href='" . $this->mylibrary->authUrl("{$this->baseUrl}manage/orderEdit?id={$o['id']}") . "'>" . $this->lang->line('edit') . "</a>";
            $manage[] = "<a data-id='{$o['id']}' data-role='delete'>" . $this->lang->line('delete') . "</a>";
            $manage = implode(' &bull; ', $manage);

            $content[] = array($orderNum, $name, $email, $price, $status, $createTime, $manage);
        }

        $table = $this->mytemplate->table($header, $content);

        $config = array(
            'base_url'      => ($this->mylibrary->authUrl("{$this->baseUrl}manage/order?cis=" . $this->input->cookie('ci_session', TRUE)) . "&status={$data['status']}&order={$data['order']}"),
            'total_rows'    => $data['orders']['totalRows'],
            'per_page'      => 20
        );
        $pager = $this->mylibrary->getPager($config);


        $result = "<div class='manageOrderList'>   
            {$toolBox}
            {$table}
            {$pager}
        </div>";


        return $this->content($this->lang->line("manage_{$data['action']}"), $result);
    }

    public function orderEdit($data=array()) {
        $statusSlt = array($data['order']['status'] => 'selected');
        $statusOpt = array( 
            array('value' => 'pendding', 'text' => $this->lang->line('order_status_pendding'), 'selected' => $statusSlt['pendding']),
            array('value' => 'success', 'text' => $this->lang->line('order_status_success'), 'selected' => $statusSlt['success']),
            array('value' => 'sending', 'text' => $this->lang->line('order_status_sending'), 'selected' => $statusSlt['sending']),
            array('value' => 'arrive', 'text' => $this->lang->line('order_status_arrive'), 'selected' => $statusSlt['arrive'])
        );
        $this->myform->addSelect('status', array(
            'title' => $this->lang->line('status'),
            'options' => $statusOpt
        ));


        $this->myform->addSubmit(array(
            'submitText'     => $this->lang->line('submit'),
            'submitingText'  => $this->lang->line('submiting'),
            'cancelText'     => $this->lang->line('cancel'),
            'url'            => $this->mylibrary->authUrl("{$this->baseUrl}shop_service/editOrder?id={$data['order']['id']}"),
            'onSuccess'      => array('back'),
            'onCancel'       => array('back')
        ));

        $result = "<div class='orderEdit'>" . $this->myform->getResult() . "</div>";


        return $this->content($this->lang->line("manage_{$data['action']}"), $result);
    }

    public function orderWaybill($data=array()) {
        $this->myform->addText('waybillNumber', array(
            'type' => 'text',
            'value' => '',
            'title' => $this->lang->line('manage_orderWaybillNumber'),
            'required' => TRUE 
        ));

        $this->myform->addText('url', array(
            'type' => 'url',
            'value' => '',
            'title' => $this->lang->line('url'),
            'required' => TRUE
        ));

        $this->myform->addText('date', array(
            'type' => 'datePicker',
            'value' => date("Y-m-d"),
            'title' => $this->lang->line('date'),
            'required' => TRUE
        ));


        $this->myform->addSubmit( array('submitText'     => $this->lang->line('submit'),
                                        'submitingText'  => $this->lang->line('submiting'),
                                        'cancelText'     => $this->lang->line('cancel'),
                                        'url'            => $this->mylibrary->authUrl("{$this->baseUrl}shop_service/sendWaybill?id={$data['id']}"),
                                        'onSuccess'      => array('back'),
                                        'onCancel'       => array('back')) );

        $result = "<div class='sendWaybill'>" . $this->myform->getResult() . "</div>";


        return $this->content($this->lang->line("manage_{$data['action']}"), $result);
    }

    public function orderDetail($data=array()) {
        $detail = $this->Mod_shop_html->getOrderTable($data['order']);


        return "<div class='orderDetail'>{$detail}</div>";
    }

    public function systemStatistic($data=array()) {

    }

    public function informationCollection($data) {
        $header = array( 
            array('title' => $this->lang->line('sn'), 'width' => '7%', 'height' => '60px', 'align' => 'center'),
            array('title' => $this->lang->line('title'), 'width' => '31%', 'height' => '60px', 'align' => 'left'),
            array('title' => $this->lang->line('subTitle'), 'width' => '31%', 'height' => '60px', 'align' => 'left'),
            array('title' => $this->lang->line('manage'), 'width' => '31%', 'height' => '60px', 'align' => 'center')
        );

        $content = array();
        foreach ( $data['collections'] as $t ) {
            $sn = intval($t['sn'] / 10);
            $title = $this->mylibrary->htmlChars($t['title']);
            $title = "<span title='{$title}'>{$title}</span>";
            $subTitle = $this->mylibrary->htmlChars($t['subTitle']);
            $subTitle = "<span title='{$subTitle}'>{$subTitle}</span>";

            $manage = array();

            $lookbookUrl = $this->mylibrary->authUrl("{$this->baseUrl}media/edit/".$t['lookbookMediaID']."?user={$this->user['account']}");
            $imagesUrl = $this->mylibrary->authUrl("{$this->baseUrl}media/edit/".$t['imageMediaID']."?user={$this->user['account']}");


            $manage[] = "<a data-role='images' data-id='{$imagesUrl}'>" . $this->lang->line('images') . "</a>";
            $manage[] = "<a data-role='lookbook' data-id='{$lookbookUrl}'>" . $this->lang->line('lookbook') . "</a>";
            $manage[] = "<a href='" . $this->mylibrary->authUrl("{$this->baseUrl}manage/informationCollectionEdit?id={$t['id']}") . "'>" . $this->lang->line('edit') . "</a>";
            $manage[] = "<a data-role='deleteCollection' data-id='{$t['id']}'>" . $this->lang->line('delete') . "</a>";
            $manage = join(' / ', $manage);

            $content[] = array($sn, $title, $subTitle, $manage);
        }
        $table = $this->mytemplate->table($header, $content);


        $result = "<div class='manageCollection'>
            <div class='contentBox'>
                <a class='add btn btn-primary' href='" . $this->mylibrary->authUrl("{$this->baseUrl}manage/informationCollectionEdit?id=0") . "'>" . $this->lang->line('add') . "</a>
                {$table}
            </div>
        </div>";


        return $this->content($this->lang->line("manage_{$data['action']}"), $result);
    } 

    public function informationCollectionEdit($data) {

        $this->myform->addImage('cover',
                                array('title'        => $this->lang->line('clickToChangeImage'),
                                      'src'          => "{$this->baseUrl}data/collection/cover_".$data['collections'][ $data['id'] ]['id'].".png?uniqid=" . uniqid(),
                                      'style'        => "display:inline-block; width:259px; height:91px;",
                                      'defaultImage' => "{$this->baseUrl}assets/imgs/default/collection.jpg",
                                      'uploadUrl'    => $this->mylibrary->authUrl("{$this->baseUrl}collection_service/uploadCollectionCover?user={$this->user['account']}"),
                                      'deleteUrl'    => $this->mylibrary->authUrl("{$this->baseUrl}collection_service/deleteCollectionCover/".$data['collections'][ $data['id'] ]['id']."?user={$this->user['account']}"),
                                      'validate'     => array()) );

        $this->myform->addBlock("<div class='dangerHint'>" . $this->lang->line('manage_uploadHint') . "w1810xh640</div>");

        $this->myform->addText('title', array(
            'title' => $this->lang->line('title'),
            'value' => $this->mylibrary->htmlChars($data['collections'][ $data['id'] ]['title']),
            'type' => 'text',
            'required' => TRUE,
        ));

        $this->myform->addText('subTitle', array(
            'title' => $this->lang->line('subTitle'),
            'value' => $this->mylibrary->htmlChars($data['collections'][ $data['id'] ]['subTitle']),
            'type' => 'text',
            'required' => TRUE,
        ));

        $this->myform->addTextArea('imageDescription', array(
            'title' => $this->lang->line('imageDescription'),
            'rows' => 8,
            'required' => TRUE,
            'value' => $data['collections'][ $data['id'] ]['imageDescription']
        ));

        $this->myform->addTextArea('lookbookDescription', array(
            'title' => $this->lang->line('lookbookDescription'),
            'rows' => 8,
            'required' => TRUE,
            'value' => $data['collections'][ $data['id'] ]['lookbookDescription']
        ));

        $orderOpt = $this->getShopTypeOrderOption($data['id'], $data['collections']);
        $this->myform->addSelect('sn', array(
            'title' => $this->lang->line('sn'),
            'options' => $orderOpt
        ));


        $this->myform->addSubmit(array(
            'submitText' => $this->lang->line('submit'),
            'submitingText' => $this->lang->line('submiting'),
            'cancelText' => $this->lang->line('cancel'),
            'url' => $this->mylibrary->authUrl("{$this->baseUrl}collection_service/editCollection?id={$data['id']}"),
            'onSuccess' => array('back'),
            'onCancel' => array('back')
        ));

        $result = "<div class='informationCollectionEdit'>" . $this->myform->getResult() . "</div>";


        return $this->content($this->lang->line("manage_{$data['action']}"), $result);
    }

}
