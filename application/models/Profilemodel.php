<?php

class Profilemodel extends CI_Model {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set("Asia/Calcutta");
        $this->load->database();
    }

    public function update($user_id, $company_name, $address, $phone, $contact_name) {
        $data = array(
            'user_id' => $user_id,
            'company_name' => $company_name,
            'address' => $address,
            'phone' => $phone,
            'contact_name' => $contact_name
        );
        $this->db->replace('user_profile', $data);
        return TRUE;
    }

    public function get($user_id) {
        $this->db->from('user_profile');
        $this->db->where('user_id', $user_id);
        $query = $this->db->get();

        foreach ($query->result() as $row) {
            $profile[] = $row;
        }
        return $profile;
    }

}
