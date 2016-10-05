<?php

class Mod_media_html extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function getMediaContentGrid($items=array()) {
        $result = array();
        foreach ( $items as $item ) {
            $result[] = "<div class='mcItem'>
                <div class='image' style='background-image:url(\"{$item['img']}\")'></div>
            </div>";
        }
        $result = ( !$result ) ? ("<div class='noData'>" . $this->lang->line('noMedia') . "</div>") : implode('', $result);


        return "<div class='mediaContentGrid'>{$result}</div>";
    }

    private function getUploadForm($data) {
        $temp = explode(',', $data['media']['allowType']);

        $type = array();
        foreach ( $temp as $t ) {
            $type[] = ".{$t}";
        }
        $type = join(',', $type);

        $sizeHint = ( !$data['media']['recommendSize'] ) ? '' : ($this->lang->line('manage_uploadHint') . " {$data['media']['recommendSize']}");
        $limitHint = ( !$data['media']['maxCnt'] ) ? '' : ", " . $this->lang->line('showPictureHintStart') . " {$data['media']['maxCnt']} " . $this->lang->line('showPictureHintEnd');
        $hint = ( !$sizeHint && !$limitHint ) ? '' : "<div class='dangerHint'>{$sizeHint}{$limitHint}";
        $result = "<div class='uploadForm'>
            <form action='{$data['uploadUrl']}' method='POST' enctype='multipart/form-data'>
                <input id='mediaUploader' class='btn btn-file' type='file' name='userfile[]' size='16' accept='{$type}' multiple />
                <div class='uploading dangerHint'>" . $this->lang->line('uploading') . " <img src='{$this->baseUrl}assets/imgs/loading.gif'></div>
                <input id='mediaSubmit' class='submit' type='submit' />
            </form>
            {$hint}
        </div>";


        return $result;
    }

    private function getMediaContent($data, $config) {
        $media = $data['media'];


        $items = array();
        foreach ( $data['mediaContents'] as $content ) {
            $title = ( !in_array('title', $config) ) ? '' : "<input id='media_title_{$content['id']}' type='text' class='form-control' data-id='{$content['id']}' placeholder='" . $this->lang->line('title') . "' value='" . $this->mylibrary->htmlChars($content['title']) . "' />";
            $description = ( !in_array('description', $config) ) ? '' : "<textarea id='media_description_{$content['id']}' class='form-control' data-id='{$content['id']}' placeholder='" . $this->lang->line('description') . "'>" . $this->mylibrary->htmlChars($content['description']) . "</textarea>";
            $url = ( !in_array('url', $config) ) ? '' : "<input id='media_url_{$content['id']}' type='text' class='form-control' data-id='{$content['id']}' placeholder='" . $this->lang->line('url') . "' value='" . $this->mylibrary->htmlChars($content['url']) . "' />";
            $src = ( strtolower($content['fileType']) == 'mp4' ) ? "{$this->baseUrl}assets/imgs/default/mp4.png" : "{$this->baseUrl}{$media['path']}/{$content['fileName']}.{$content['fileType']}";

            $items[] = "<li data-id='{$content['id']}'>
                <div class='itemBox'>
                    <div class='sn'>" . ($content['sn'] / 10) . "</div>
                    <div style='background-image:url(\"{$src}\")' class='image'></div>
                    <div class='delete' data-id='{$content['id']}''><img src='{$this->baseUrl}assets/imgs/cross.svg' /></div>
                    {$title}
                    {$description}
                    {$url}
                </div>
            </li>";
        }
        

        $sortable = ( !$data['media']['sortable'] ) ? '' : 'sortable';
        $displayHint = ( !$items ) ? '' : 'display:block;';
        $result = "<div class='mediaBox'>
            <div style='{$displayHint}' class='sortHint dangerHint'>" . $this->lang->line('sortable') . "</div>
            <div class='saveHint'>" . $this->lang->line('saveHint') . "</div>
            <ul class='{$sortable}'>" . join('', $items) . "</ul>
        </div>";


        return $result;
    }

    public function edit($data, $config=array()) {
        $form = $this->getUploadForm($data);
        $media = $this->getMediaContent($data, $config);

        $result = "<div class='myMedia'>
            {$form}
            {$media}
        </div>";


        return $result;
    }

}
