<?php

defined('BASEPATH') OR exit('No direct script access allowed');
header('Content-Type: application/json');

class Authorize extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('auth');
    }

    public function index() {
        $request_type = $this->input->server('REQUEST_METHOD');
        if ($request_type == 'POST') {
            if ($this->auth->authenticate($this->input->post('email'), $this->input->post('password'))) {
                $token = $this->auth->generate_token($this->input->post('email'));
                echo json_encode($token);
            } else {
                $token['error'] = 'Invalid Credentials';
                echo json_encode($token);
            }
        }
    }

    public function register() {
        $request_type = $this->input->server('REQUEST_METHOD');
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        if ($request_type == 'POST' && $email != NULL && $password != NULL) {
            $this->auth->register_new_user($this->input->post('email'), $this->input->post('password'));
        } else {
            $json['error'] = 'Missing parameters!';
            echo json_encode($json);
        }
    }

    public function verifytoken_post() {
        $request_type = $this->input->server('REQUEST_METHOD');
        $token = $this->input->post('token');
        if ($request_type == 'POST' && $token != NULL) {
            $this->auth->verify_token($this->input->post('token'));
        } else {
            $json['error'] = 'Missing parameters!';
            echo json_encode($json);
        }
    }

}
