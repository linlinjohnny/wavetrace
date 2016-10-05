<?php 

class Media_service extends CI_Controller {

	function __construct() {
		parent::__construct();
        
		$this->load->model('media/Mod_media');
	}

    public function deleteContent() {
        if ( !$this->mylibrary->isAuthUrl() ) {
            echo $this->mylibrary->serviceReturn(FALSE, $this->lang->line('noPermission'));
            return;
        }

        $id = $this->input->get('id', TRUE);

        $this->Mod_media->deleteMediaContent($id);


        echo $this->mylibrary->serviceReturn(TRUE, 'success');
    }

	public function resortContent($mediaID) {
        if ( !$this->mylibrary->isAuthUrl() ) {
            echo $this->mylibrary->serviceReturn(FALSE, $this->lang->line('noPermission'));
            return;
        }
    
        $targetID = $this->input->post('targetID', TRUE);
        $destID = $this->input->post('destID', TRUE);


        $sn = 5;
        if ( $destID ) {
            $dest = $this->Mod_media->getMediaContent($destID, 'id', TRUE);
            $sn = $dest['sn'] + 5;
        }

        $this->Mod_media->updateMediaContent($targetID, array('sn' => $sn));
        
        $this->mylibrary->reorderSN('media_content', 'mediaID=?', array($mediaID));
        

        echo $this->mylibrary->serviceReturn(TRUE, 'success');
    }

    public function updateContent() {
        if ( !$this->mylibrary->isAuthUrl() ) {
            echo $this->mylibrary->serviceReturn(FALSE, $this->lang->line('noPermission'));
            return;
        }

        $id = $this->input->get('id', TRUE);
        $param = array(
            'title' => $this->input->post('title', TRUE),
            'description' => $this->input->post('description', TRUE),
            'url' => $this->input->post('url', TRUE)
        );

        if ( mb_strlen($param['description'], 'UTF-8') > 60 ) {
            echo $this->mylibrary->serviceReturn(FALSE, $this->lang->line('error_mediaDescriptionLimit'));
            return;
        }

        $this->Mod_media->updateMediaContent($id, $param);


        echo $this->mylibrary->serviceReturn(TRUE, 'success');
    }
    

    public function uploadCkeditorImage() {
        if ( !$this->mylibrary->isAuthUrl() ) {
            echo $this->mylibrary->serviceReturn(FALSE, $this->lang->line('noPermission'));
            return;
        }
        
        $fileName = md5(uniqid());
        $result = $this->mylibrary->uploadImage("data/media/ckeditor", $fileName, $fileName);
        

        $script = '';
        if ( !$result['status'] ) {
            $script = "<script type='text/javascript'>alert(\"{$result['msg']}\");</script>";
        } else {
            $funcNum = $this->input->get('CKEditorFuncNum', TRUE);
            $filePath = "{$this->baseUrl}data/media/ckeditor/{$fileName}.png";

            $script = "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction({$funcNum}, '{$filePath}', '');</script>";
        }
        echo $script;
    }

}
