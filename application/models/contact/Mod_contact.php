<?php 

class Mod_contact extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function getContact($id) {

       $query = $this->db->get_where('contact', array('id' => $id));
       $row = $query->row();

       return $row;

    }

    public function updateContact($id, $param) {
        $this->db->update('contact', $param, array('id' => $id));
    }

    public function deleteContact($id) {
        $this->db->delete('contact', array('id' => $id));
    }

    public function createContact($param) {
        $this->db->insert('contact', $param);
        
        
        return $this->db->insert_id();
    }
}
