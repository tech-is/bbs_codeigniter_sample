<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Bbs extends CI_Controller
{

    public function __construct()
    {
        // CI_Model constructor の呼び出し
        parent::__construct();
        $this->load->library('session');
        $this->load->model('Bbs_model');
        $this->load->helper('url');
        $this->load->library('form_validation');
        date_default_timezone_set('Asia/Tokyo');
    }

    /**
     * CodeIgniterではコントローラーにindexメソッドを指定すると自動でそのメソッドを実行します
     *
     * urlにindexメソッドを指定するかコントローラー名だけを記述した場合に実行されます
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     *	- or -
     * 		http://example.com/index.php/welcome/index
     *	- or -
     *
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     */

     /**
      * 掲示板ページを出力
      *
      * @return void
      */
    public function index()
    {
        $data = null;
        $data['message_array'] = $this->Bbs_model->fetch_all_rows();

        if (!empty($_SESSION['success_message'])) {
            $data['success_message'] = $_SESSION['success_message'];
            unset($_SESSION['success_message']);
        }
        if (!empty($_SESSION['error_message'])) {
            $data['error_message'] = $_SESSION['error_message'];
            unset($_SESSION['error_message']);
        }

        $this->load->view('header_view');
        $this->load->view('bbs_view', $data);
    }

     /**
     * httpリクエストのパラメータの正当性を検証
     * 
     * @return void
     */
    private function request_validation() {
        $config = [
            [
                'field' => 'view_name',
                'label' => '表示名',
                'rules' => 'required',
                'errors' => [
                    'required' => '%sを入力してください。'
                ]
            ],
            [
                'field' => 'message',
                'label' => 'ひと言メッセージ',
                'rules' => 'required',
                'errors' => [
                    'required' => '%sを入力してください。',
                ]
            ]
        ];
        $this->form_validation->set_rules($config);
        return $this->form_validation->run();
    }

    /**
     * POSTされてきたデータをDBにinsert
     *
     * @return void
     */
    public function add_bbs()
    {
        if (!$this->request_validation()) {
            $errors = $this->form_validation->error_array();
            $_SESSION['error_message'] = $errors;
            redirect();
        }

        $name = $this->input->post('view_name', true);
        $message = $this->input->post('message', true);        

        $data = [
            'view_name' => $name,
            'message' => $message,
            'post_date' => date("Y-m-d H:i:s")
        ];

        if ($this->Bbs_model->insert_row($data)) {
            $_SESSION['success_message'] = 'メッセージを書き込みました。';
        } else {
            $_SESSION['error_message'] = '登録に失敗しました。';
        }
        redirect();
    }
    
}
