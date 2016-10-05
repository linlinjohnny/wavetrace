<?php

class Media extends CI_Controller {

    public function __construct() {
        parent::__construct();
        

        $this->mycss->addFile("{$this->baseUrl}assets/css/application/my_media.css");


        $this->load->model('media/Mod_media');
        $this->load->model('media/Mod_media_html');
        $this->load->model('media/Mod_media_js');
    }


    public function edit($id) {
        $data = array(
            'uploadUrl' => $this->mylibrary->authUrl("{$this->baseUrl}media/uploadHandler/{$id}?user={$this->user['account']}&editInfo=" . $this->input->get('editInfo', TRUE)),
            'resortContentUrl' => $this->mylibrary->authUrl("{$this->baseUrl}media_service/resortContent/{$id}?user={$this->user['account']}"),
            'updateContentUrl' => $this->mylibrary->authUrl("{$this->baseUrl}media_service/updateContent?user={$this->user['account']}"),
            'deleteContentUrl' => $this->mylibrary->authUrl("{$this->baseUrl}media_service/deleteContent?user={$this->user['account']}"),
            'media' => $this->Mod_media->getMedia($id, 'id', TRUE),
            'mediaContents' => $this->Mod_media->getMediaContent($id, 'mediaID')
        );
        $config = explode(',', $this->input->get('editInfo', TRUE));
        

        $this->mylayout->add(SYS_DIALOG_BOX, $this->Mod_media_html->edit($data, $config));

        $this->Mod_media_js->edit($data);


        $this->load->view('dialog');
    }

    public function uploadHandler($id) {        
        if ( !$this->mylibrary->isAuthUrl() ) {
            echo $this->mylibrary->serviceReturn(FALSE, $this->lang->line('noPermission'));
            return;
        }

        $this->load->library('upload');

        $media = $this->Mod_media->getMedia($id, 'id', TRUE);
        $maxSn = $this->Mod_media->getMediaContentMaxSn($id) + 5;

        $resize = json_decode($meda['resize'], TRUE);


        $uploadConfig = array(
            'encrypt_name' => TRUE,
            'upload_path' => (FCPATH . $media['path']),
            'allowed_types' => join('|', explode(',', $media['allowType'])),
            'max_size' => MAX_UPLOAD_SIZE
        );


        $files = $_FILES;
        $errorMsg = array();
        $fileCnt = count($_FILES['userfile']['name']);
        for ( $i=0; $i<$fileCnt; $i++ ) {
            $_FILES['userfile']['name'] = $files['userfile']['name'][$i];
            $_FILES['userfile']['type'] = $files['userfile']['type'][$i];
            $_FILES['userfile']['tmp_name'] = $files['userfile']['tmp_name'][$i];
            $_FILES['userfile']['error'] = $files['userfile']['error'][$i];
            $_FILES['userfile']['size'] = $files['userfile']['size'][$i];    


            $this->upload->initialize($uploadConfig);
            if ( !$this->upload->do_upload() ) {
                $errorMsg[] = $this->upload->display_errors();
            } else {
                $dataInfo = $this->upload->data();
                $fileType = explode('.', $dataInfo['file_ext']);

                $param = array(
                    'mediaID' => $id,
                    'fileName' => $dataInfo['raw_name'],
                    'fileType' => $fileType[1],
                    'sn' => $maxSn,
                    'createTime' => date("Y-m-d H:i:s")
                );
                $this->Mod_media->createMediaContent($param);

                if ( $media['resize'] ) {
                    $this->Mod_media->resizeImage($resize, $dataInfo['full_path'], (FCPATH . $media['path']), $param['fileName'], $param['fileType']);
                }
               

                $maxSn += 5;
            }
        }


        if ( $errorMsg ) {
            echo "<div style='border:1px solid #ccc; border-radius:4px; padding:10px; line-height:2;'>" . join("<br/>", $errorMsg) . "</div>";
            return;
        }


        $this->mylibrary->reDirect($this->mylibrary->authUrl("{$this->baseUrl}media/edit/{$id}?user={$this->user['account']}&editInfo=" . $this->input->get('editInfo', TRUE)));
    }
        
}
