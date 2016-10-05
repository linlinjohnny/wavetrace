<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MyTemplate {

	private $CI;

	public function __construct() {
		$this->CI = &get_instance();

        $this->CI->load->helper('form');
	}

    public function sysBar($page='') {
        $html = <<< HTML
        <div class='sysBar'>
            <a class='logo' href='{$this->CI->baseUrl}'>
            </a>
            <ul class='sysMenuList'>
                <li class='sysMenuItem'>

                </li>
            </ul>
        </div>
HTML
        ;


        return $html;
    }

	public function sysFooter() {
        $html = 'footer';

        return $html;
	}

    public function newsletterHtml($data = array()){
        $submitUrl = $this->CI->mylibrary->authUrl("{$this->baseUrl}/Newsletter_service/customerEmail");


        $postUrl = $this->CI->mylibrary->authUrl("{$this->baseUrl}newsletter_service/home?id=0");
        $result = "<div class='newsletter'>\
                        <div class='text-right closeBlock'>\
                            <div class='letterClose clearfix'></div>\
                        </div>\
                        <div class='box'>\
                            <div class='edmTitle'>{$data['edmTitle']['value']}</div>\
                            <div class='edmText'>{$data['edmText']['value']}</div>\
                            <div class='form-horizontal'>\
                                <div class='form-group'>\
                                    <span class='sexHint'>{$this->CI->lang->line('newsletter_sex')}: </span>\
                                    <div class='sexRadio-inline'>\
                                        <input type='radio' name='sex' id='radio_male' value='1'><span class='radioTxt'>{$this->CI->lang->line('male')}</span>\
                                    </div>\
                                    <div class='sexRadio-inline'>\
                                        <input type='radio' name='sex' id='radio_female' value='0' checked><span class='radioTxt'>{$this->CI->lang->line('female')}</span>\
                                    </div>\
                                </div>\
                                <div class='form-group'>\
                                    <input type='text' id='email' placeholder='{$this->CI->lang->line('newsletter_mailPlaceHolder')}'/>\
                                    <button class='submit' js-url='{$postUrl}'>{$this->CI->lang->line('newsletter_submit')}</button>\
                                </div>\
                            </div>\
                            <div class='hintMsg'>\
                                <div class='icon wrong'></div>\
                                <div class='msg'>sdfsfd</div>\
                            </div>\
                        </div>\
                   </div>\
                   ";


        return $result;
    }

    public function photoswipe() {
        $result = <<<HTML
<!-- Root element of PhotoSwipe. Must have class pswp. -->
<div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">

    <!-- Background of PhotoSwipe.
         It's a separate element as animating opacity is faster than rgba(). -->
    <div class="pswp__bg"></div>

    <!-- Slides wrapper with overflow:hidden. -->
    <div class="pswp__scroll-wrap">

        <!-- Container that holds slides.
            PhotoSwipe keeps only 3 of them in the DOM to save memory.
            Don't modify these 3 pswp__item elements, data is added later on. -->
        <div class="pswp__container">
            <div class="pswp__item"></div>
            <div class="pswp__item"></div>
            <div class="pswp__item"></div>
        </div>

        <!-- Default (PhotoSwipeUI_Default) interface on top of sliding area. Can be changed. -->
        <div class="pswp__ui pswp__ui--hidden">

            <div class="pswp__top-bar">

                <!--  Controls are self-explanatory. Order can be changed. -->

                <div class="pswp__counter"></div>

                <button class="pswp__button pswp__button--close" title="Close (Esc)"></button>

                <button class="pswp__button pswp__button--share" title="Share"></button>

                <button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>

                <button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>

                <!-- Preloader demo http://codepen.io/dimsemenov/pen/yyBWoR -->
                <!-- element will get class pswp__preloader--active when preloader is running -->
                <div class="pswp__preloader">
                    <div class="pswp__preloader__icn">
                      <div class="pswp__preloader__cut">
                        <div class="pswp__preloader__donut"></div>
                      </div>
                    </div>
                </div>
            </div>

            <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                <div class="pswp__share-tooltip"></div>
            </div>

            <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)">
            </button>

            <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)">
            </button>

            <div class="pswp__caption">
                <div class="pswp__caption__center"></div>
            </div>

        </div>

    </div>

</div>
HTML;


        return $result;
    }

	public function table($header, $content) {
        $CI = &get_instance();

        $result = $tempHeader = $tempContent = $config = array();

        $hsaCheckbox = FALSE;
        $cnt = 0;
        foreach ( $header as $item ) {
            if ( $item['checkbox'] ) {
                $hsaCheckbox = TRUE;
            }

            $width  = ( !$item['width'] ) ? '' : "width:{$item['width']};";
            $height = ( !$item['height'] ) ? '' : "height:{$item['height']};";
            $align  = ( !$item['align'] ) ? '' : "text-align:{$item['align']};";
            $lineHeight = ( !$item['height'] ) ? '' : "line-height:" . ($item['height'] - 20) . "px;";
            $config[] = array('width' => $width, 'height' => $height, 'line-height' => $lineHeight, 'align' => $align);

            $title = ( !$item['checkbox'] ) ? $item['title'] : "<input type='checkbox' data-role='checkAll' />";
            $tempHeader[] = "<div class='item' style='{$width}{$align}'>{$title}</div>";
        }


        foreach ( $content as $item ) {
            $cnt = 0;
            $temp = array();
            foreach ( $item as $subItem ) {
                $subItem = ( $cnt == 0 && $hsaCheckbox )
                         ? "<input type='checkbox' data-id='{$subItem}' data-role='checkOne' />"
                         : $subItem;
                $temp[] = "<div class='item' style='" . join('', $config[$cnt]) . "'>{$subItem}</div>";

                $cnt++;
            }

            $tempContent[] = "<div class='clearfix'>" . join('', $temp) . "</div>";
        }

        if ( count($tempContent) == 0 ) {
            $tempContent[] = "<div class='noData'>" . $CI->lang->line('noData') . "</div>";
        }


        $reuslt = "<div class='myTable clearfix'>
            <div class='header clearfix'>" . join('', $tempHeader) . "</div>
            <div class='content clearfix'>" . join('', $tempContent) . "</div>
        </div>";


        $js = <<<JAVASCRIPT

            $(function() {

                $("[data-role='checkAll']").bind('click', function() {
                    var val = $(this).prop('checked');

                    $("[data-role='checkOne']").prop('checked', val);
                });

                $("[data-role='checkOne']").bind('click', function() {
                    var total = $("[data-role='checkOne']").length;
                    var checkedNum = $("[data-role='checkOne']:checked").length;

                    $("[data-role='checkAll']").prop('checked', ( total == checkedNum ));
                });

            });

JAVASCRIPT;
        $this->CI->myjs->add($js);


        return $reuslt;
    }

    /**
    ***  $carousel = array(array('imgSrc', 'link'),
    ***                    array('imgSrc', 'link')
    ***              );
    ***  $config = array('dataRole', 'dataUrl')
    */
    public function carousel($carousel, $config=array()) {
        $i = 0;
        $item = array();
        $indicators = array();

        $mask = $config['mask'];

        foreach ($carousel as $data) {

            $active = ($i==0) ? "active" : '';
            if ($data['link'] != '') {
                $item[] = "<a style='width:100%; height:100%;' href='{$data['link']}' class='item {$active}'>
                              <img src='{$data['imgSrc']}' alt='' style='width:100%; height:100%;'>
                              <div class='descBox'>
                                  <div class='descContent'>
                                      {$data['desc']}
                                  </div>
                              </div>
                            </a>";
            }
            else {
                $item[] = "<div style='width:100%; height:100%;' class='item {$active}'>
                              <img src='{$data['imgSrc']}' alt='' style='width:100%; height:100%;'>
                              <div class='descBox'>
                                  <div class='descContent'>
                                      {$data['desc']}
                                  </div>
                              </div>
                           </div>";
            }
            $indicators[] = "<li data-target='#carousel-example-generic' data-slide-to='{$i}' class='{$active}'></li>";
            $i++;
        }

        $item = join('', $item);
        $indicators = join('', $indicators);


        $nextBtn = $this->CI->baseUrl . "assets/imgs/arrow_left.svg";
        $prevBtn = $this->CI->baseUrl . "assets/imgs/arrow_right.svg";

        $dataRide = $config['notAutoPlay'] == TRUE ? '' : 'data-ride="carousel"';
        $dataInterval = ($config['dataInterval']) ? "data-interval='{$config['dataInterval']}'" : "";
        $enableActive = $mask['active'] ? 'active' : '';
        $carousel = <<<HTML
        <div id="carousel-example-generic" class="carousel slide clearfix" {$dataRide} style='width:100%; height:100%;' {$dataInterval}>
            <div class='rightTool'>
                <!-- Indicators -->
                <ol class="carousel-indicators">
                    {$indicators}
                </ol>
                <div class='explore'>
                    EXPLORE
                </div>
                <div class='decorationLine'>
                </div>
            </div>

            <!-- Wrapper for slides -->
            <div style='width:100%; height:100%;' class="carousel-inner" role="listbox">
                {$item}
            </div>
            <div class='mask {$enableActive}'>
                <div class='maskContent text-center'>
                    <div class='title'>
                        {$mask['title']}
                    </div>
                    <div class='subtitle'>
                        {$mask['subTitle']}
                    </div>
                    <a class='maskBtn' href='{$this->CI->baseUrl}shop'>
                        SHOP
                    </a>
                </div>
            </div>

        </div>
HTML;
        return $carousel;
    }



    public function selector($config=array(), $options=array()){

        $items = array();
        foreach($options as $o) {
            $soldOutTxt = ($o['isSoldOut']) ? "<span> ( SOLD OUT )</span>" : '';
            $items[] = "<li class='dropdownItem {$o['class']}' value='{$o['value']}'>{$o['text']}{$soldOutTxt}</li>";
        }
// $this->CI->mylibrary->print_var($items);
        $items = implode('', $items);
        $js = <<<JAVASCRIPT

            $(function() {
                $('.dropdownSelctor ul.dropdown-menu li:not(".banSelect")').click(function(){

                    var that = $(this),
                        selector = that.closest('.dropdownSelctor');

                    selector.find('ul.dropdown-menu>li').removeClass('act');
                    that.addClass('act');

                    selector.find('.selectorHead .title').text(that.text());
                    selector.find('.selectorInput').val(that.attr('value'));
                })


            });

JAVASCRIPT;
        $this->CI->myjs->add($js);


        return "
        <div class='dropdown dropdownSelctor'>
            <div class='selectorHead' data-toggle='dropdown' aria-haspopup='true' aria-expanded='true'>
                <span class='title'>{$config['selectedTitle']}</span>
                <span class='caret'></span>
            </div>
            <ul class='dropdown-menu' aria-labelledby='dropdownMenu1'>
                {$items}
            </ul>
            <input class='selectorInput' type='hidden' id=selector_{$config['id']} value='{$config['selectedValue']}'>
        </div>
        ";


    }

}
