<?php

class Mod_home extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->model('media/Mod_media');
    }

    public function getCarousel() {
    	$medias = $this->Mod_media->getAllMedias();
    	$mediaContents = $this->Mod_media->getMediaContent(2, 'mediaID');

    	$temp = array();
    	foreach ( $mediaContents as $mc ) {
    		$temp[] = $mc;
    	}

    	$result = array();
    	for ( $i=0; $i<6; $i++ ) {
    		if ( $temp[$i] ) {
    			$temp[$i]['img'] = "{$this->baseUrl}{$medias['2']['path']}/{$temp[$i]['fileName']}.{$temp[$i]['fileType']}";
    			$result[] = $temp[$i];
    		} else {
    			$result[] = array('img' => "{$this->baseUrl}assets/imgs/default/home_carousel.jpg");
    		}
    	}


    	return $result;
    }

    public function getCarouselMask() {
        $sysconfigs = $this->mylibrary->getAllSysconfigs();

        return json_decode($sysconfigs['home_carouselMask']['value'], TRUE);
    }

    public function updateCarouselMask($param) {
        $this->mylibrary->updateSysconfig('home_carouselMask', $param);
    }

    public function getConcept() {
    	$sysconfigs = $this->mylibrary->getAllSysconfigs();

    	$result = array(
            'title' => $sysconfigs['home_conceptTitle']['value'],
    		'description' => $sysconfigs['home_conceptDescription']['value'],
    		'img' => (( is_file(FCPATH . "data/home/concept.png") ) ? "{$this->baseUrl}data/home/concept.png" : "{$this->baseUrl}assets/imgs/default/home_concept.jpg")
    	);


    	return $result;
    }

    public function updateConcept($param) {
        $titleParam = array(
            'value' => $param['title'],
            'updateTime' => $param['updateTime']
        );
        $this->mylibrary->updateSysconfig('home_conceptTitle', $titleParam);

        $descriptionParam = array(
            'value' => $param['description'],
            'updateTime' => $param['updateTime']
        );
    	$this->mylibrary->updateSysconfig('home_conceptDescription', $descriptionParam);
    }

    public function getLookbook() {
        $sysconfigs = $this->mylibrary->getAllSysconfigs();
        $medias = $this->Mod_media->getAllMedias();
        $mediaContents = $this->Mod_media->getMediaContent(3, 'mediaID');

        $temp = array();
        foreach ( $mediaContents as $mc ) {
            $mc['img'] = "{$this->baseUrl}{$medias['3']['path']}/{$mc['fileName']}.{$mc['fileType']}";
            $temp[] = $mc;
        }
        $cnt = count($temp);
        for ( $i=$cnt; $i<3; $i++ ) {
            $temp[] = array('img' => "{$this->baseUrl}assets/imgs/default/home_lookbook.jpg");
        }
        

        $result = array(
            'title' => $sysconfigs['home_lookbookTitle']['value'],
            'subTitle' => $sysconfigs['home_lookbookSubTitle']['value'],
            'description' => $sysconfigs['home_lookbookDescription']['value'],
            'url' => $sysconfigs['home_lookbookUrl']['value'],
            'imgs' => $temp
        );


        return $result;
    }

    public function updateLookbook($param) {
        $titleParam = array(
            'value' => $param['title'],
            'updateTime' => $param['updateTime']
        );
        $this->mylibrary->updateSysconfig('home_lookbookTitle', $titleParam);

        $subTitleParam = array(
            'value' => $param['subTitle'],
            'updateTime' => $param['updateTime']
        );
        $this->mylibrary->updateSysconfig('home_lookbookSubTitle', $subTitleParam);

        $descriptionParam = array(
            'value' => $param['description'],
            'updateTime' => $param['updateTime']
        );
        $this->mylibrary->updateSysconfig('home_lookbookDescription', $descriptionParam);
    
        $urlParam = array(
            'value' => $param['url'],
            'updateTime' => $param['updateTime']
        );
        $this->mylibrary->updateSysconfig('home_lookbookUrl', $urlParam);

    }

    public function getEditorial() {
    	$sysconfigs = $this->mylibrary->getAllSysconfigs();

    	$result = array(
            'title' => $sysconfigs['home_editorialTitle']['value'],
    		'description' => $sysconfigs['home_editorialDescription']['value'],
            'url' => $sysconfigs['home_editorialUrl']['value'],
    		'img' => (( is_file(FCPATH . "data/home/editorial.png") ) ? "{$this->baseUrl}data/home/editorial.png" : "{$this->baseUrl}assets/imgs/default/home_editorial.jpg")
    	);


    	return $result;
    }

    public function updateEditorial($param) {
    	$titleParam = array(
            'value' => $param['title'],
            'updateTime' => $param['updateTime']
        );
        $this->mylibrary->updateSysconfig('home_editorialTitle', $titleParam);

        $descriptionParam = array(
            'value' => $param['description'],
            'updateTime' => $param['updateTime']
        );
        $this->mylibrary->updateSysconfig('home_editorialDescription', $descriptionParam);
    
        $urlParam = array(
            'value' => $param['url'],
            'updateTime' => $param['updateTime']
        );
        $this->mylibrary->updateSysconfig('home_editorialUrl', $urlParam);
    }

}
