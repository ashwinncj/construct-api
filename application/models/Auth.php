<?php

class Auth extends CI_Model {

    private $salt = 'wUECQL7BvV0xw0tald3wlW706ytR5y2u';

    public function __construct() {
        parent::__construct();
        date_default_timezone_set("Asia/Calcutta");
        $this->load->database();
    }

    public function authenticate($user, $pwd) {
        $this->db->from('user_credentials');
        $this->db->where('email', $user);
        $this->db->where('password', $this->password_encode($pwd));
        $records = $this->db->count_all_results();
        return $records == 1 ? TRUE : FALSE;
    }

    public function generate_token($email) {
        $now = new DateTime();
        $now->add(new DateInterval('PT2H'));
        $token['expiry'] = $now->format('Y-m-d H:i:s');
        $token['token'] = sha1($this->salt . $token['expiry'] . $email) . sha1($this->salt . $email);
        $token['success'] = true;
        $this->register_tokens($email, $token['token'], $token['expiry']);
        return $token;
    }

    public function register_new_user($email, $pwd) {
        $token = $this->generate_token($email);
        $data = array(
            'email' => $email,
            'password' => $this->password_encode($pwd),
            'token' => $token['token'],
            'expiry' => $token['expiry']
        );
        if (!$this->check_if_user_exists($email)) {
            $this->db->insert('user_credentials', $data);
            $json['success'] = TRUE;
            $json['message'] = 'User successfully registered!';
            echo json_encode($json);
        } else {
            $json['success'] = FALSE;
            $json['error'] = 'User email already exists!';
            echo json_encode($json);
        }
    }

    private function password_encode($x) {
        return sha1('radel' . $x);
    }

    public function check_if_user_exists($user) {
        $this->db->from('user_credentials');
        $this->db->where('email', $user);
        $records = $this->db->count_all_results();
        return $records >= 1 ? TRUE : FALSE;
    }

    private function register_tokens($email, $token, $expiry) {
        $data = array(
            'token' => $token,
            'expiry' => $expiry
        );
        $this->db->where('email', $email);
        $this->db->update('user_credentials', $data);
    }

    public function verify_token($token) {
        $this->db->from('user_credentials');
        $this->db->where('token', $token);
//        $this->db->select('id,expiry');
        $records = $this->db->count_all_results();
        if ($records == 1) {
            $query = $this->db->get('user_credentials');
            foreach ($query->result() as $row) {
                $expiry = new DateTime($row->expiry);
                if ($expiry > new DateTime()) {
                    return TRUE;
                } else {
                    return false;
                }
            }
        } else {
            return FALSE;
        }
    }

    public function getuser($token) {
        $this->db->from('user_credentials');
        $this->db->where('token', $token);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $user = $row;
        }
        return $user;
    }

    public function renew_token($token) {
        
    }

}
