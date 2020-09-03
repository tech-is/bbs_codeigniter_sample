<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bbs_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function fetch_one_row($id)
    {
        return $this->db->where('id', $id)
            ->select('id, view_name, message')
            ->get('message')
            ->row_array();
    }

    public function fetch_all_rows($limit=null)
    {
        !empty($limit)? $this->db->limit($limit): false;
        return $this->db->order_by('post_date', 'ASC')
            ->get('message')
            ->result_array();
    }

    public function insert_row($data)
    {
        return $this->db->insert('message', $data);
    }

    public function update_row($id, $data)
    {
        return $this->db->where('id', $id)
            ->update('message', $data);
    }

    public function delete_row($id)
    {
        return $this->db->where('id', $id)
            ->delete('message');
    }
}