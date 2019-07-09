<?php

defined('BASEPATH') OR exit('No direct script access allowed');
header('Content-Type: application/json');

class Suppliers extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('suppliersmodel');
        $this->load->model('auth');
    }

    public function index() {
        $json['error'] = 'Wrong URL endpoint.';
        echo json_encode($json);
    }

    public function add() {
        $token = $this->input->post('token');
        $json['token'] = $token;
        if ($this->auth->verify_token($token)) {
            $this->add_supplier();
        } else {
            $json['success'] = FALSE;
            $json['error'] = 'Unauthorized Token!';
            echo json_encode($json);
        }
    }

    private function add_supplier() {
        $token = $this->input->post('token');
        $user_id = $this->auth->getuser($token)->id;
        $request_type = $this->input->server('REQUEST_METHOD');
        $name = $this->input->post('name');
        $contact_name = $this->input->post('contact_name');
        $email = $this->input->post('email');
        $address = $this->input->post('address');
        $phone = $this->input->post('phone');

        if ($request_type == 'POST' && $email != NULL && $name != NULL && $contact_name != NULL && $address != NULL && $phone != NULL) {
            if ($this->suppliersmodel->add($user_id, $name, $contact_name, $email, $address, $phone)) {
                $json['success'] = TRUE;
                $json['message'] = 'Supplier successfully registered!';
                echo json_encode($json);
            } else {
                $json['success'] = FALSE;
                $json['error'] = 'User email already exists!';
                echo json_encode($json);
            }
        } else {
            $json['error'] = 'Missing parameters!';
            echo json_encode($json);
        }
    }

    //Function to get all the suppliers who belong to the logged in user.
    public function get() {
        $token = $this->input->post('token');
        $user_id = $this->auth->getuser($token)->id;
        if ($this->auth->verify_token($token)) {
            $json['suppliers'] = $this->suppliersmodel->get($user_id);
            $json['success'] = true;
            echo json_encode($json);
        } else {
            $json['success'] = FALSE;
            $json['error'] = 'Unauthorized Token!';
            echo json_encode($json);
        }
    }

}
