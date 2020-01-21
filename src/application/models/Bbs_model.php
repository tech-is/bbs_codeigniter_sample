<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bbs_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_record($id)
    {
        return $this->db->where('id', $id)
            ->select('id, view_name, message')
            ->get('message')
            ->row_array();
    }

    public function get_all_record($limit=null)
    {
        !empty($limit)? $this->db->limit($limit): false;
        return $this->db->order_by('post_date', 'ASC')
            ->get('message')
            ->result_array();
    }

    public function insert_record($data)
    {
        return $this->db->insert('message', $data);
    }

    public function update_record($id, $data)
    {
        return $this->db->where('id', $id)
            ->update('message', $data);
    }

    public function delete_record($id)
    {
        return $this->db->where('id', $id)
            ->delete('message');
    }
}