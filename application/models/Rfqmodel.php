<?php

//Model and database function for RFQ functions
class Rfqmodel extends CI_Model {

    //Constructor function to import database functions to the model
    public function __construct() {
        parent::__construct();
        date_default_timezone_set("Asia/Calcutta"); //Set the timezone of the intended use-location
        $this->load->database();
    }

    //Function to insert the RFQ deatails into the database
    public function add($user_id, $name, $due_date, $attachment, $rfq_details) {
        $data = array(
            'name' => $name,
            'user_id' => $user_id,
            'due_date' => $due_date,
            'attachment' => $attachment,
            'rfq_details' => $rfq_details
        );
        $this->db->insert('rfq', $data); //Set the table name of the RFQ
        return TRUE;
    }

    public function exists($email) {
        $this->db->from('suppliers');
        $this->db->where('email', $email);
        $records = $this->db->count_all_results();
        return $records >= 1 ? TRUE : FALSE;
    }

    public function get($user_id, $id) {
        $this->db->from('rfq');
        $this->db->where('user_id', $user_id);
        $this->db->where('id', $id);
        $query = $this->db->get();

        foreach ($query->result() as $row) {
            $rfq[] = $row;
        }
        return $rfq;
    }

}
