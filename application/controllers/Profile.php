<?php

defined('BASEPATH') OR exit('No direct script access allowed');
header('Content-Type: application/json');

class Profile extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('profilemodel');
        $this->load->model('auth');
    }

    public function index() {
        $json['error'] = 'Wrong URL endpoint.';
        $json['message'] = 'Supplier successfully registered!';
        echo json_encode($json);
    }

    public function update() {
        $token = $this->input->post('token');
        $json['token'] = $token;
        if ($this->auth->verify_token($token)) {
            $this->update_profile();
        } else {
            $json['success'] = FALSE;
            $json['error'] = 'Unauthorized Token!';
            echo json_encode($json);
        }
    }

    private function update_profile() {
        $token = $this->input->post('token');
        $user_id = $this->auth->getuser($token)->id;
        $request_type = $this->input->server('REQUEST_METHOD');
        $company_name = $this->input->post('company_name');
        $address = $this->input->post('address');
        $phone = $this->input->post('phone');
        $contact_name = $this->input->post('contact_name');

        if ($request_type == 'POST' && $user_id != '' && $company_name != NULL && $address != NULL && $contact_name != NULL && $phone != NULL) {
            if ($this->profilemodel->update($user_id, $company_name, $address, $phone, $contact_name)) {
                $json['success'] = TRUE;
                $json['message'] = 'Profile updated!';
                echo json_encode($json);
            } else {
                $json['success'] = FALSE;
                $json['error'] = 'Error while updating the profile!';
                echo json_encode($json);
            }
        } else {
            $json['error'] = 'Missing parameters!';
            echo json_encode($json);
        }
    }

    public function get() {
        $token = $this->input->post('token');
        $user_id = $this->auth->getuser($token)->id;
        if ($this->auth->verify_token($token)) {
            $json['profile'] = $this->profilemodel->get($user_id);
            $json['success'] = true;
            echo json_encode($json);
        } else {
            $json['success'] = FALSE;
            $json['error'] = 'Unauthorized Token!';
            echo json_encode($json);
        }
    }

}
