<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct() {

        parent::__construct();

        if ( false == $this->session->userdata('uid')) {
            redirect(base_url('portal/'));
        }
        else if ( 'admin' != $this->session->userdata('level')){
            redirect(base_url('page/no_permission'));
        }

        $this->load->model('admin_model');
        $this->load->model('user_model');


    }

    public function index() {
        $this->manage();
    }

    public function manage() {


        $action['create'] = base_url('admin/api_create_admin');
        $action['list'] = base_url('admin/api_read_admin_list');

        $data['action'] = $action;

        $this->load->view('header');
        $this->load->view('admin/manage', $data);
        $this->load->view('footer');
    }

    public function api_create_admin() {

        $username = $this->input->post('name');
        $comment  = $this->input->post('comment');

        if ($username == false) {
            $status = false;
            $$msg   = "您輸入的資料不完整。";
        }
        else {
            $user = $this->user_model->read_user_by_name($username);
            $user_exist = !empty($user);

            if (!$user_exist) {
                $status = false;
                $msg    = "查無此帳號。";
            }
            else {
                $id = $user->uId;

                $admin = $this->admin_model->read($id);
                $admin_exist = !empty($admin);

                if ($admin_exist) {
                    $status = false;
                    $msg    = "此人已經是管理員了！";
                }
                else {
                    $this->admin_model->create($id, $comment);

                    $status = true;
                    $msg    = "已經成功新增帳號！";
                }

            }
        }

        $data['status'] = $status;
        $data['msg']    = $msg;

        echo json_encode($data);
    }

    public function api_read_admin() {
        $id = $this->input->post('id');

        $user = $this->admin_model->read($id);
        $user_exist = empty($user);

        if ($user_exist) {
            $status = false;
            $msg    = "查無此帳號。";
        }
        else {
            $status = true;
            $msg    = $user;
        }

        $data['status'] = $status;
        $data['msg']    = $msg;

        echo json_encode($data);
    }

    public function api_read_admin_list() {

        $list_arr = $this->admin_model->read_list();
        $admim  = array();

        foreach ($list_arr as $key => $row) {

            $id = $row->uId;
            $username = $this->user_model->read_user($row->uId)->uName;
            $comment  = $row->adminComment;

            $admim[] = array('id' => $id, 'username' => $username, 'comment' => $comment);
        }

        $data['status'] = true;
        $data['msg']    = $admim;

        echo json_encode($data);
    }

    public function api_update_admin() {
        $id = $this->input->post('id');
        $comment = $this->input->post('comment');

        $this->admin_model->update($id, $comment);

        $data['status'] = true;

        echo json_encode($data);
    }

    public function api_delete_admin() {
        $id = $this->input->post('id');
        $this->admin_model->delete($id);

        $data['status'] = true;

        echo json_encode($data);
    }



}

/* End of file organization.php */
/* Location: ./application/controllers/organization.php */