<?php 

class Mod_manage extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function getUser($value, $key='id', $getOne=FALSE) {
        if ( !$value ) {
            return array();
        }

        if ( !is_array($value) ) {
            $value = array($value);
        }
        
        $this->db->where_in($key, $value);
        $this->db->order_by('createTime', 'DESC');
        $query = $this->db->get('user');
        $query = ( !$getOne ) ? $query->result_array() : array_shift($query->result_array());


        return $query;
    }

    public function createUser($param) {
        $this->db->insert('user', $param);


        return $this->db->insert_id();
    }

    public function updateUser($id, $param) {
        $this->db->update('user', $param, array('id' => $id)); // table, param, where
    }

    public function login($account, $password) {
        $query = $this->db->query("SELECT * FROM user WHERE (account=? OR email=?) AND password=?", array($account, $account, $password));
        $query = $query->result_array();
        
        if ( !$query ) {
            return FALSE;
        }

        $query = array_shift($query);
        $this->mylibrary->refreshSession($query);
        
        
        $this->updateUser($query['id'], array('ip' => $this->input->ip_address(), 'loginTime' => date("Y-m-d H:i:s")));
        
        
        return TRUE;
    }

    public function getEmailByPage($currPage) {
        $currPage = intval($currPage);
        $currPage = ( $currPage ) ? $currPage : 1;

        $sqlParam = array(
            'query' => array(
                'sql'   => "SELECT * FROM email_record ORDER BY id DESC",
                'param' => array()
                ),
            'page'  => $currPage,
            'size'  => 20
            );
        $result = $this->mylibrary->getByPage($sqlParam);


        return $result;
    }

    public function deleteEmailRecord($id) {
        $this->db->delete('email_record', array('id' => $id));
    }



    public function getSubscribersByPage($currPage) {
        $currPage = intval($currPage);
        $currPage = ( $currPage ) ? $currPage : 1;

        $sqlParam = array(
            'query' => array(
                'sql'   => "SELECT * FROM edm_subscriber ORDER BY id DESC",
                'param' => array()
                ),
            'page'  => $currPage,
            'size'  => 20
            );
        $result = $this->mylibrary->getByPage($sqlParam);

        return $result;
    }

    public function getContactsByPage($currPage) {
        $currPage = intval($currPage);
        $currPage = ( $currPage ) ? $currPage : 1;

        $sqlParam = array(
            'query' => array(
                'sql'   => "SELECT * FROM contact ORDER BY id DESC",
                'param' => array()
                ),
            'page'  => $currPage,
            'size'  => 20
            );
        $result = $this->mylibrary->getByPage($sqlParam);

        return $result;
    }


}
