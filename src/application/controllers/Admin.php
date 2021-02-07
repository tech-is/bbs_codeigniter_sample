<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{

    const ADMIN = "admin/";
    const LOGIN = self::ADMIN."login";

    //「adminPassword」という文字列を暗号化したものが入っています
    const PASSWORD = '$2y$10$SbdHurka6tRt02PSRxfNMOOFUnCSSPnnFmq8RWjoTIpTTfLTKdCr6';

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
     * ログイン済みなら管理画面を出力
     * 
     * @return void
     */
    public function index()
    {
        $this->isSession();
        $data = null;

        if (!empty($_SESSION['success_message'])) {
            $data['success_message'] = $_SESSION['success_message'];
            unset($_SESSION['success_message']);
        }

        if (!empty($_SESSION['error_message'])) {
            $data['error_message'] = $_SESSION['error_message'];
            unset($_SESSION['error_message']);
        }

        $data['message_array'] = $this->Bbs_model->fetch_all_rows();
        $this->load->view('header_view');
        $this->load->view(self::ADMIN.'admin_view', $data);
    }

    /**
     * セッションがなければログイン画面にリダイレクト
     * 
     * @return void
     */
    private function isSession() {
        if (empty($_SESSION['admin_login'])) {
            redirect(self::LOGIN);
        }
    }

    /**
     * ログイン画面を出力
     * 
     * @return void
     */
    public function login()
    {
        $this->load->view('header_view');
        $this->load->view(self::ADMIN.'login_view');
    }

    /**
     * httpリクエストのパラメータの正当性を検証
     * 
     * @return void
     */
    private function request_validation($target) {
        $config = [
            "update" => [
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
            ]
        ];
        $this->form_validation->set_rules($config[$target]);
        return $this->form_validation->run();
    }

    /**
     * セッションを削除してログイン画面にリダイレクト
     * 
     * @return void
     */
    public function logout()
    {
        if (!empty($_SESSION['admin_login'])) {
            session_destroy();
        }
        redirect(self::LOGIN);
    }

    /**
     * 編集画面を出力
     * 
     * @return void
     */
    public function edit()
    {
        $this->isSession();

        if (!($id = $this->input->get('message_id')) || !is_numeric($id)) {
            $_SESSION['error_message'][] = '更新に必要なパラメータが含まれていません';
            redirect(self::ADMIN);
        }

        if (empty($data['message_data'] = $this->Bbs_model->fetch_one_row($id))) {
            $_SESSION['error_message'][] = '存在しないレコードです。';
            redirect(self::ADMIN);
        }

        if (!empty($_SESSION['error_message'])) {
            $data['error_message'] = $_SESSION['error_message'];
            unset($_SESSION['error_message']);
        }

        $this->load->view('header_view');
        $this->load->view(self::ADMIN.'admin_edit_view', $data);
    }

    /**
     * 削除画面を出力
     * 
     * @return void
     */
    public function delete()
    {
        $data = null;
        if (empty($_SESSION['admin_login'])) {
            redirect(self::LOGIN);
        }
    
        if (empty($id = $this->input->get('message_id')) || !is_numeric($id)) {
            $_SESSION['error_message'][] = '更新に必要なパラメータが含まれていません';
            redirect(self::ADMIN);
        }
                
        if (empty($data['message_data'] = $this->Bbs_model->fetch_one_row($id))) {
            $_SESSION['error_message'][] = '存在しないレコードです。';
            redirect(self::ADMIN);
        }

        if (!empty($_SESSION['error_message'])) {
            $data['error_message'] = $_SESSION['error_message'];
            unset($_SESSION['error_message']);
        }

        $this->load->view('header_view');
        $this->load->view(self::ADMIN.'admin_delete_view', $data);    
    }

    /**
     * ログインの正当性を判定
     * 
     * @return string
     */
    public function attempt_login()
    {
        header("Content-Type: application/json; charset=utf-8");

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('HTTP/1.1 405 Method Not Allowed');
            echo json_encode(['message' => '許可されていないメソッドです']);
            exit;
        }

        if (empty($this->input->post('admin_password', true))) {
            header('HTTP/1.1 401 Unauthorized');
            echo json_encode(['message' => 'パスワードが間違っています']);
            exit();
        }

        $password = $this->input->post('admin_password', true);

        if (!password_verify($password, self::PASSWORD)) {
            header('HTTP/1.1 401 Unauthorized');
            echo json_encode(['message' => 'パスワードが間違っています']);
            exit();
        }

        $_SESSION['admin_login'] = true;
        echo json_encode(['message' => '認証成功']);
        exit();
    }

    /**
     * 掲示板の書き込みデータをCSV出力
     * 
     * @return binary
     */
    public function download_csv()
    {
        header("Content-Type: application/octet-stream");
        header("Content-Disposition: attachment; filename=メッセージデータ.csv");
        header("Content-Transfer-Encoding: binary");

        $limit = null;

        if (!empty($this->input->get('limit', null)) && is_numeric($this->input->get('limit', null))) {
            $limit = $this->input->get('limit');
        }

        $message_array = $this->Bbs_model->fetch_all_rows($limit);

        if (empty($message_array)) {
            $_SESSION['error_message'][] = 'csvの出力に失敗しました。';
            redirect(self::ADMIN);
        }

        $csv_data = null;
        $csv_data .= '"ID","表示名","メッセージ","投稿日時"' . "\n";

        foreach ($message_array as $value) {
            $csv_data .= '"' . $value['id'] . '","' . $value['view_name'] . '","' . $value['message'] . '","' . $value['post_date'] . "\"\n";
        }

        $csv_data = mb_convert_encoding($csv_data, "SJIS", "UTF-8");
        echo $csv_data;
        exit();
    }

    /**
     * 掲示板の書き込みデータを更新する
     *
     * @return void
     */
    public function update()
    {
        $error_message = [];

        if (!($id = $this->input->post('message_id', true))) {
            $_SESSION['error_message'][] = '更新に必要なパラメータが含まれていません';
            redirect(self::ADMIN);
        }

        if (!$this->request_validation('update')) {
            $errors = $this->form_validation->error_array();
            $_SESSION['error_message'] = $errors;
            redirect(self::ADMIN."update?message_id={$id}");
        }

        $name = $this->input->post('view_name', true);
        $message = $this->input->post('message', true);

        $data = [
            'view_name' => $name,
            'message' => $message,
            'post_date' => date("Y-m-d H:i:s")
        ];
            
        if ($this->Bbs_model->update_row($id, $data)) {
            $_SESSION['success_message'] = 'メッセージを更新しました。';
            redirect(self::ADMIN);
        } else {
            $_SESSION['error_message'][] = '更新に失敗しました。';
            redirect(self::ADMIN."update?message_id={$id}");
        }   
    }

    /**
     * 掲示板の書き込みデータを削除する
     *
     * @return void
     */
    public function delete_bbs()
    {
        if (!($id = $this->input->post('message_id', true))) {
            $_SESSION['error_message'][] = '削除に必要なパラメータが含まれていません';
        }

        if ($this->Bbs_model->delete_row($id)) {
            $_SESSION['success_message'] = 'メッセージを削除しました。';
            redirect(self::ADMIN);
        } else {
            $_SESSION['error_message'][] = '削除に失敗しました。';
            redirect(self::ADMIN."delete?message_id={$id}");
        }
    }
    
}