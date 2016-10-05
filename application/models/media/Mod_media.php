<?php 

class Mod_media extends CI_Model {

	function __construct() {
        parent::__construct();
    }

    public function getMedia($value, $key='id', $getOne=FALSE) {
        if ( !$value ) {
            return array();
        }
        
        if ( !is_array($value) ) {
            $value = array($value);
        }
    
        $this->db->where_in($key, $value);
        $this->db->order_by('createTime', 'DESC');
        $query = $this->db->get('media');

        $result = array();
        foreach ( $query->result_array() as $q ) {
            $result[ $q['id'] ] = $q;
        }

        $result = ( !$getOne ) ? $result : array_shift($result);
 

        return $result;
    }

    private $medias = array();
    public function getAllMedias() {
        if ( $this->medias ) {
            return $this->medias;
        }

        $query = $this->db->query("SELECT * FROM media ORDER BY createTime DESC");
        $query = $query->result_array();
        foreach ( $query as $q ) {
            $this->medias[ $q['id'] ] = $q;
        }


        return $this->medias;
    }

    public function getMediaContent($value, $key='id', $getOne=FALSE, $limit=0) {
        if ( !$value ) {
            return array();
        }
        
        if ( !is_array($value) ) {
            $value = array($value);
        }
    
        $this->db->where_in($key, $value);
        $this->db->order_by('sn', 'ASC');
        if ( $limit ) {
            $this->db->limit($limit);
        }
        $query = $this->db->get('media_content');
        $query = ( !$getOne ) ? $query->result_array() : array_shift($query->result_array());
        

        return $query;
    }

    public function getMediaContentMaxSn($mediaID) {
        $temp = $this->db->query("SELECT MAX(sn) as maxSn FROM media_content WHERE mediaID=?", $mediaID);
        $temp = array_shift($temp->result_array());

        return $temp['maxSn'];
    }

    public function createMedia($param) {
        $path = '';
        do {
            $md5Type = substr(md5(uniqid()), 0, 1);
            $md5Dir = md5(uniqid());
            $path = "data/media/{$md5Type}/{$md5Dir}";
        } while ( is_dir($path) );
        $param['path'] = $path;

        $this->mylibrary->mkdir(FCPATH . $path);

        $this->db->insert('media', $param);
        
        
        return $this->db->insert_id();
    }

    public function createMediaContent($param) {
        $this->db->insert('media_content', $param);
        
        $this->mylibrary->reorderSN('media_content', 'mediaID=?', array($param['mediaID']));


        return $this->db->insert_id();
    }

    public function updateMedia($id, $param) {
        $this->db->update('media', $param, array('id' => $id));
    }

    public function updateMediaContent($id, $param) {
        $this->db->update('media_content', $param, array('id' => $id));
    }

    public function deleteMedia($id) {
        $media = $this->getMedia($id, 'id', TRUE);

        if ( $media['path'] && file_exists((FCPATH . $media['path'])) ) {
            $this->mylibrary->deleteDir(FCPATH . $media['path']);
        }

        $this->db->delete('media', array('id' => $id));
    }

    public function deleteMediaContent($val, $key='id') {
        $mediaContent = $this->getMediaContent($val, $key, TRUE);
        $media = $this->getMedia($mediaContent['mediaID'], 'id', TRUE);


        $this->db->delete('media_content', array($key => $val));

        if ( $media ) {
            @unlink(FCPATH . "{$media['path']}/{$mediaContent['fileName']}.{$mediaContent['fileType']}");
            @unlink(FCPATH . "{$media['path']}/{$mediaContent['fileName']}_l.{$mediaContent['fileType']}");
            @unlink(FCPATH . "{$media['path']}/{$mediaContent['fileName']}_m.{$mediaContent['fileType']}");
            @unlink(FCPATH . "{$media['path']}/{$mediaContent['fileName']}_s.{$mediaContent['fileType']}");
        }

        $this->mylibrary->reorderSN('media_content', 'mediaID=?', array($media['id']));
    }
	
    /** 
    ** size format 
    ** $size = array( 'l' => array('width' => 800, 'height' => 600),
    **                'm' => array('width' => 400, 'height' => 300),
    **                's' => array('width' => 200, 'height' => 150) );
    */
    public function resizeImage($size, $srcPath, $desPath, $fileName, $fileType) {
        foreach ( $size as $key=>$value ) {
            $finalPath =  "{$desPath}/{$fileName}_{$key}.{$fileType}";
        
            $this->mylibrary->resizeImage($srcPath, $finalPath, $value['width'], $value['height']);
        }
    }

}