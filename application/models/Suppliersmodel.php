<?php

class Suppliersmodel extends CI_Model {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set("Asia/Calcutta");
        $this->load->database();
    }

    public function add($user_id, $name, $contact_name, $email, $address, $phone) {
        $data = array(
            'name' => $name,
            'user_id' => $user_id,
            'email' => $email,
            'contact_name' => $contact_name,
            'address' => $address,
            'phone' => $phone
        );
        $this->db->insert('suppliers', $data);
        return TRUE;
    }

    public function exists($email) {
        $this->db->from('suppliers');
        $this->db->where('email', $email);
        $records = $this->db->count_all_results();
        return $records >= 1 ? TRUE : FALSE;
    }

}
