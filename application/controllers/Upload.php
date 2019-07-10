<?php

//Controller class to handle the uploads for the RFQ
defined('BASEPATH') OR exit('No direct script access allowed');
header('Content-Type: application/json');

class Upload extends CI_Controller {

    public function __construct() {
        parent::__construct();
        //Load Auth models here for the verificatio of the user.
        $this->load->model('auth');
        $this->load->helper(array('form', 'url'));
    }

    public function index() {
        $json['error'] = 'Wrong URL endpoint.';
        echo json_encode($json);
    }

    public function file() {
        $token = $this->input->post('token');
        $json['token'] = $token;

        //Verify the tokem before continuining with the upload of the file.
        if ($this->auth->verify_token($token)) {
            $this->uploadFile();
        } else {
            $json['success'] = FALSE;
            $json['error'] = 'Unauthorized Token!';
            echo json_encode($json);
        }
    }

    private function uploadFile() {
        //Setting the parameters of the file for the upload.
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = '*';
        $config['max_size'] = 0;
        $config['max_width'] = 0;
        $config['max_height'] = 0;

        //Load the library for handling the upload of the file in the codeigniter
        $this->load->library('upload', $config);

        //Getting the information of the user to insert in the database,.
        $token = $this->input->post('token');
        $user_id = $this->auth->getuser($token)->id;
        $request_type = $this->input->server('REQUEST_METHOD');

        if ($request_type == 'POST') {
            if ($this->upload->do_upload('userfile')) {
                $json['success'] = TRUE;
                $json['file'] = $this->upload->data('file_name');
                $json['message'] = 'File uploaded successfully!';
                echo json_encode($json);
            } else {
                $json['success'] = FALSE;
                $json['message'] = array('error' => $this->upload->display_errors());
                $json['error'] = 'Error while uploading the file!';
                echo json_encode($json);
            }
        } else {
            $json['error'] = 'Missing parameters!';
            echo json_encode($json);
        }
    }

}
