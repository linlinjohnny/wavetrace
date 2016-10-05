<?php

class Home_service extends CI_Controller {

	function __construct() {
		parent::__construct();

		$this->load->model('home/Mod_home');
	}

    public function updateCarouselMask() {
        if ( !$this->mylibrary->isAuthUrl() ) {
            echo $this->mylibrary->serviceReturn(FALSE, $this->lang->line('noPermission'));
            return;
        }

        $param = array(
            'title' => $this->input->post('title', TRUE),
            'subTitle' => $this->input->post('subTitle', TRUE),
            'active' => $this->input->post('active', TRUE)
        );
        $this->Mod_home->updateCarouselMask(array('value' => json_encode($param)));


        echo $this->mylibrary->serviceReturn(TRUE);
    }

	public function uploadConceptCover() {
        if ( !$this->mylibrary->isAuthUrl() ) {
            echo $this->mylibrary->serviceReturn(FALSE, $this->lang->line('noPermission'));
            return;
        }


        $fileName = 'concept';
        $result = $this->mylibrary->uploadImage("data/temp/home", $fileName, $fileName);
        

        $srcPath = FCPATH . "data/temp/home/{$fileName}.png";


        echo $this->mylibrary->serviceReturn($result['status'], $result['msg'], array('url' => "{$this->baseUrl}data/temp/home/{$fileName}.png",
                                                                                      'filePath' => "data/temp/home/{$fileName}.png"));
    }

    public function deleteConceptCover() {
        if ( !$this->mylibrary->isAuthUrl() ) {
            echo $this->mylibrary->serviceReturn(FALSE, $this->lang->line('noPermission'));
            return;
        }


        $this->mylibrary->deleteImage("data/home", 'concept');


        echo $this->mylibrary->serviceReturn(TRUE);
    }

	public function updateConcept() {
		if ( !$this->mylibrary->isAuthUrl() ) {
            echo $this->mylibrary->serviceReturn(FALSE, $this->lang->line('noPermission'));
            return;
        }

        $param = array('updateTime' => date('Y-m-d H:i:s'));

        $title = $this->input->post('title', TRUE);
        if ( !$title ) {
            echo $this->mylibrary->serviceReturn(FALSE, "[" . $this->lang->line('title') . "] " . $this->lang->line('required'));
            return;
        }
        $param['title'] = $title;

        $value = $this->input->post('value', TRUE);
        if ( !$value ) {
            echo $this->mylibrary->serviceReturn(FALSE, "[" . $this->lang->line('description') . "] " . $this->lang->line('required'));
            return;
        }
        $param['description'] = $value;

        $this->Mod_home->updateConcept($param);


        ignore_user_abort(TRUE);
        set_time_limit(0);
        echo $this->mylibrary->serviceReturn(TRUE, 'success');


        $cover = $this->input->post('cover', TRUE);
        if ( $cover && file_exists(FCPATH . $cover) ) {
            copy(FCPATH . $cover, FCPATH ."data/home/concept.png");
        }
	}

	public function updateLookbook() {
		if ( !$this->mylibrary->isAuthUrl() ) {
            echo $this->mylibrary->serviceReturn(FALSE, $this->lang->line('noPermission'));
            return;
        }

        $param = array('updateTime' => date('Y-m-d H:i:s'));

        $title = $this->input->post('title', TRUE);
        if ( !$title ) {
            echo $this->mylibrary->serviceReturn(FALSE, "[" . $this->lang->line('title') . "] " . $this->lang->line('required'));
            return;
        }
        $param['title'] = $title;

        $subTitle = $this->input->post('subTitle', TRUE);
        if ( !$subTitle ) {
            echo $this->mylibrary->serviceReturn(FALSE, "[" . $this->lang->line('subTitle') . "] " . $this->lang->line('required'));
            return;
        }
        $param['subTitle'] = $subTitle;

        $value = $this->input->post('value', TRUE);
        if ( !$value ) {
            echo $this->mylibrary->serviceReturn(FALSE, "[" . $this->lang->line('description') . "] " . $this->lang->line('required'));
            return;
        }
        $param['description'] = $value;

        $url = $this->input->post('url', TRUE);
        if ( !$url ) {
            echo $this->mylibrary->serviceReturn(FALSE, "[" . $this->lang->line('url') . "] " . $this->lang->line('required'));
            return;
        }
        $param['url'] = $url;


        $this->Mod_home->updateLookbook($param);


        echo $this->mylibrary->serviceReturn(TRUE, 'success');
	}

	public function uploadEditorialCover() {
        if ( !$this->mylibrary->isAuthUrl() ) {
            echo $this->mylibrary->serviceReturn(FALSE, $this->lang->line('noPermission'));
            return;
        }


        $fileName = 'editorial';
        $result = $this->mylibrary->uploadImage("data/temp/home", $fileName, $fileName);
        

        $srcPath = FCPATH . "data/temp/home/{$fileName}.png";


        echo $this->mylibrary->serviceReturn($result['status'], $result['msg'], array('url' => "{$this->baseUrl}data/temp/home/{$fileName}.png",
                                                                                      'filePath' => "data/temp/home/{$fileName}.png"));
    }

    public function deleteEditorialCover() {
        if ( !$this->mylibrary->isAuthUrl() ) {
            echo $this->mylibrary->serviceReturn(FALSE, $this->lang->line('noPermission'));
            return;
        }


        $this->mylibrary->deleteImage("data/home", 'editorial');


        echo $this->mylibrary->serviceReturn(TRUE);
    }

	public function updateEditorial() {
		if ( !$this->mylibrary->isAuthUrl() ) {
            echo $this->mylibrary->serviceReturn(FALSE, $this->lang->line('noPermission'));
            return;
        }

        $param = array('updateTime' => date('Y-m-d H:i:s'));

        $title = $this->input->post('title', TRUE);
        if ( !$title ) {
            echo $this->mylibrary->serviceReturn(FALSE, "[" . $this->lang->line('title') . "] " . $this->lang->line('required'));
            return;
        }
        $param['title'] = $title;

        $value = $this->input->post('value', TRUE);
        if ( !$value ) {
            echo $this->mylibrary->serviceReturn(FALSE, "[" . $this->lang->line('description') . "] " . $this->lang->line('required'));
            return;
        }
        $param['description'] = $value;

        $url = $this->input->post('url', TRUE);
        if ( !$url ) {
            echo $this->mylibrary->serviceReturn(FALSE, "[" . $this->lang->line('url') . "] " . $this->lang->line('required'));
            return;
        }
        $param['url'] = $url;


        $this->Mod_home->updateEditorial($param);


        ignore_user_abort(TRUE);
        set_time_limit(0);
        echo $this->mylibrary->serviceReturn(TRUE, 'success');


        $cover = $this->input->post('cover', TRUE);
        if ( $cover && file_exists(FCPATH . $cover) ) {
            copy(FCPATH . $cover, FCPATH ."data/home/editorial.png");
        }
	}

}
