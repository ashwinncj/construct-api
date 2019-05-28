<?php

//This page is the controller for RFQ API endpoint.
defined('BASEPATH') OR exit('No direct script access allowed'); //Add code to restrict direct access to the file.
header('Content-Type: application/json'); //Setting the data return type as JSON to handle the JSON result from the API call.

class Rfq extends CI_Controller {

    //Constructor function to load RFQmodel and Auth model to the class
    public function __construct() {
        parent::__construct();
        $this->load->model('rfqmodel');
        $this->load->model('auth');
    }

    //Setting default message for wrong connection endpoint
    public function index() {
        $json['error'] = 'Wrong URL endpoint.';
        echo json_encode($json);
    }

    //Public method to access add new RFQ
    public function add() {
        //Check if the token is valid before proceeding to the addition of the RFQ to the database.
        $token = $this->input->post('token');
        $json['token'] = $token;
        if ($this->auth->verify_token($token)) {
            $this->add_rfq(); //If Token is valid, continue to add new RFQ to the database.
        } else {
            //Return error message if the token is invalid.
            $json['success'] = FALSE;
            $json['error'] = 'Unauthorized Token!';
            echo json_encode($json);
        }
    }

    //Private function to add RFQ to the database
    private function add_rfq() {
        $token = $this->input->post('token');
        $user_id = $this->auth->getuser($token)->id; //Getting the user ID based on the token supplied via API
        $request_type = $this->input->server('REQUEST_METHOD'); //Check for the request method
        $name = $this->input->post('name');
        $due_date = $this->input->post('due_date');
        $attachment = 'Attachment URL to be updated here...';
        $rfq_details = $this->input->post('rfq_details');

        //The add request to be processed only if request type is POST and all the fields are set.
        if ($request_type == 'POST' && $user_id != NULL && $name != NULL && $due_date != NULL && $attachment != NULL && $rfq_details != NULL) {
            //If all the pre-requisites are set, call the addition function from the RFQmodel
            if ($this->rfqmodel->add($user_id, $name, $due_date, $attachment, $rfq_details)) {
                $json['success'] = TRUE;
                $json['message'] = 'RFQ created!';
                echo json_encode($json);
            } else {
                //Set the error message if RFQ addition fails.
                $json['success'] = FALSE;
                $json['error'] = '';
                echo json_encode($json);
            }
        } else {//Return error message if the parameters are missing.
            $json['error'] = 'Missing parameters!';
            echo json_encode($json);
        }
    }

    //Public function to get the RFQ details using the ID of the RFQ
    public function get() {
        $token = $this->input->post('token');
        $user_id = $this->auth->getuser($token)->id;
        $rfq_id = $this->input->post('id'); //ID of the RFQ
        //Verify the token of the user before continuing to access the RFQ from the database.
        if ($this->auth->verify_token($token)) {
            $json['rfq'] = $this->rfqmodel->get($user_id, $rfq_id);
            $json['success'] = true;
            echo json_encode($json);
        } else {
            $json['success'] = FALSE;
            $json['error'] = 'Unauthorized Token!';
            echo json_encode($json);
        }
    }

    //Write a new function here to get all the RFQs of single user
    public function getall() {
        $token = $this->input->post('token');
        $user_id = $this->auth->getuser($token)->id;
        //Verify the token of the user before continuing to access the RFQ from the database.
        if ($this->auth->verify_token($token)) {
            $json['rfq'] = $this->rfqmodel->get_all($user_id);
            $json['success'] = true;
            echo json_encode($json);
        } else {
            $json['success'] = FALSE;
            $json['error'] = 'Unauthorized Token!';
            echo json_encode($json);
        }
    }

}
