<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bbs_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * レコードをid検索して配列として出力
     * 
     * @param int $id 
     * @return array
     */
    public function fetch_one_row($id)
    {
        return $this->db->where('id', $id)
            ->select('id, view_name, message')
            ->get('message')
            ->row_array();
    }

    /**
     * 全レコードを取得して配列として出力
     * 
     * @param int $limit=null 
     * @return array
     */
    public function fetch_all_rows($limit=null)
    {
        if (empty($limit)) { $this->db->limit($limit); }
        return $this->db->order_by('post_date', 'ASC')
            ->get('message')
            ->result_array();
    }

    /**
     * 掲示板データを入力
     * 
     * @param array $data
     * @return bool
     */
    public function insert_row($data)
    {
        return $this->db->insert('message', $data);
    }

    /**
     * idを指定して掲示板データを更新
     * 
     * @param array $data
     * @param int $id
     * @return bool
     */
    public function update_row($id, $data)
    {
        return $this->db->where('id', $id)
            ->update('message', $data);
    }

    /**
     * idを指定して掲示板データを削除
     * 
     * @param int $id
     * @return bool
     */
    public function delete_row($id)
    {
        return $this->db->where('id', $id)
            ->delete('message');
    }
}