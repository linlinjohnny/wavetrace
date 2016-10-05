<?php

class Mod_home_html extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function index($data=array()) {
        $carousel = $this->indexCarousel($data);
        $concept = $this->indexConcept($data['concept']);
        $lookbook = $this->indexLookbook($data['lookbook']);
        $editorial = $this->indexEditorial($data['editorial']);
// $this->mylibrary->print_var($lookbook);
        $result = "<div class='index'>
            {$carousel}
            {$concept}
            {$lookbook}
            {$editorial}
            <div class='text-center'>
                <div class='backToTop'>
                </div>
            </div>
        </div>";

        return $result;
    }

    public function indexCarousel($data){
        $carouselImg = array();
        foreach ($data['carousel'] as $k=>$v) {
            $carouselImg[] = array('imgSrc' => $v['img']);
        }
// $this->mylibrary->print_var($data);
        $html = "<div class='homeCarousel'>" .
                    $this->mytemplate->carousel($carouselImg, array('mask' => $data['mask'],
                                                                    'interval' => 6000)).
                "</div>";
        return $html;
    }

    public function indexConcept($data) {
        $title = $this->mylibrary->htmlChars($data['title']);
        $description = $this->mylibrary->htmlChars($data['description']);
        $html = <<<CONCEPT

            <div class='concept clearfix'>
                <div class='conceptContent container-fluid clearfix'>
                    <div class='area area0 row clearfix hidden-sm hidden-xs'>
                        <div class='rowContainer col-lg-11 col-md-11'>
                            <div class='content clearfix'>
                            </div>
                        </div>
                    </div>
                    <div class='area area1 row clearfix hidden-sm hidden-xs'>
                        <div class='rowContainer col-lg-5 col-md-5 col-lg-offset- col-md-offset-3'>
                            <div class='content clearfix'>
                            </div>
                        </div>
                    </div>

                    <div class='area area2 row clearfix'>
                        <div class='rowContainer col-lg-5 col-md-5 col-sm-8 col-xs-8 col-lg-offset-2 col-md-offset-2 col-sm-offset-2 col-xs-offset-2'>
                            <div class='content clearfix'>
                                <div class='col-lg-8 col-md-8 col-sm-12 col-xs-12'>
                                    <div class='titleBox'>
                                        <div class='title'>
                                            {$title}
                                        </div>
                                    </div>
                                </div>
                                <div class='col-lg-4 col-md-4 hidden-sm hidden-xs'>
                                </div>
                                <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
                                    <div class='contentTxt'>
                                        {$description}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class='area area3 row clearfix'>
                        <div class='rowContainer col-lg-6 col-md-6 col-sm-10 col-xs-10 col-lg-offset-4 col-md-offset-4 col-sm-offset-1 col-xs-offset-1'>
                            <div class='content clearfix'>
                                <img src='{$data['img']}'>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
CONCEPT
;
        return $html;

    }


    public function indexLookbook($data) {
        $title = $this->mylibrary->htmlChars($data['title']);
        $subTitle = $this->mylibrary->htmlChars($data['subTitle']);
        $description = $this->mylibrary->htmlChars($data['description']);

        $carousel = $this->carouselMulti($data['imgs'], 'carouselMulti');
        $carouselSingle = $this->carouselMulti($data['imgs'], 'carouselSingle');
        $html = <<<LOOKBOOK
            <div class='lookbook clearfix'>
                <div class='lookbookContent container-fluid'>
                    <div class='row'>
                        <div class='detail col-lg-8 col-md-8 col-sm-8 col-xs-8 col-lg-offset-2 col-md-offset-2 col-sm-offset-2 col-xs-offset-2'>
                            <div>
                                <div class='area area1 col-lg-12 col-md-12'>
                                    <div>
                                        <div class='titleBox'>
                                            <div class='title'>
                                                {$title }
                                            </div>
                                            <div class='subtitle'>
                                                {$subTitle}
                                            </div>
                                        </div>
                                        <div class='description'>
                                            {$description}
                                        </div>
                                        <div class='viewMore'>
                                            <a href='{$data['url']}'>{$this->lang->line('viewMoreEn')}</a>
                                        </div>
                                    </div>
                                </div>
                                <div class='area area2 col-lg-12 col-md-12'>
                                    <div>
                                        <div class='carousel-multi hidden-sm hidden-xs'>
                                            {$carousel}
                                        </div>
                                        <div class='carousel-single hidden-lg hidden-md'>
                                            {$carouselSingle}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
LOOKBOOK
;
        return $html;
    }


    public function indexEditorial($data){
        $title = $this->mylibrary->htmlChars($data['title']);
        $description = $this->mylibrary->htmlChars($data['description']);

        $html = <<<EDITORIAL
            <div class='editorial clearfix'>
                <div class='editorialContent clearfix container-fluid'>
                    <div class='row area area1'>
                        <div class='col-lg-8 col-md-8 col-sm-6 col-xs-6 col-lg-offset-2 col-md-offset-2 col-sm-offset-3 col-xs-offset-3'>
                            <div>
                                <div class='title'>
                                    {$title}
                                </div>
                                <div class='description'>
                                    {$description}
                                </div>
                                <div class='viewMore'>
                                    <a href='{$data['url']}'>{$this->lang->line('viewMoreEn')}</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class='row area area3 hidden-sm hidden-xs'>
                        <div class='col-lg-6 col-md-6 col-sm-10 col-xs-10 col-lg-offset-6 col-md-offset-6 col-sm-offset-2 col-xs-offset-2'>
                            <div>
                                <div class='areaContent'>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class='row area area2 hidden-sm hidden-xs'>
                        <div class='col-lg-8 col-md-8 col-lg-offset-1 col-md-offset-1'>
                            <div class='areaContent'>
                                <img src='{$data['img']}'>
                            </div>
                        </div>
                    </div>




                    <div class='row area area2 hidden-lg hidden-md'>
                        <div class='col-lg-8 col-md-8 col-lg-offset-1 col-md-offset-1'>
                            <div class='areaContent'>
                                <img src='{$data['img']}'>
                            </div>
                        </div>
                    </div>
                    <div class='row area area3 hidden-lg hidden-md'>
                        <div class='col-lg-6 col-md-6 col-sm-10 col-xs-10 col-lg-offset-6 col-md-offset-6 col-sm-offset-2 col-xs-offset-2'>
                            <div>
                                <div class='areaContent'>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
EDITORIAL
;
        return $html;
    }


    public function carouselMulti($data, $id) {



        $imgHtml = array();
        $i = 1;
        foreach ($data as $d) {
            $actClass = ($i == 1) ? 'active' : '';
            $imgHtml[] = "<div class='item {$actClass}'>
                              <div class='col-lg-4 col-md-4 col-sm-6 col-xs-6 col-lg-offset-0 cpl-md-offset-0 col-sm-offset-3 col-xs-offset-3'>
                                <img src='{$d['img']}' class='img-responsive'>
                              </div>
                          </div>";
            $i++;

        }

        $imgHtml = implode('', $imgHtml);
        $html = <<<CAROUSELHTM
            <div id="{$id}" class="carousel slide">

                <div class="carousel-inner">
                    {$imgHtml}
                </div>

                <!-- Controls -->
                <a class="left carousel-control" href="#{$id}" role="button" data-slide="next">
                    <span class='carouselMulti-control'>
                        &lt PREVIOUS
                    </span>
                </a>
                <a class="right carousel-control" href="#{$id}" role="button" data-slide="prev">
                    <span class='carouselMulti-control'>
                        NEXT &gt
                    </span>
                </a>
            </div>
CAROUSELHTM
;
        return $html;
    }


}
