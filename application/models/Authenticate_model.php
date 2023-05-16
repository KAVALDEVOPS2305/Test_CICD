<?php
class Authenticate_model extends CI_Model
{
    public function login($uname, $passkey)
    {
        $this->db->select('admin_uid,admin_username, admin_name,admin_role,role_name');
        $this->db->join('administrator_roles','admin_users.admin_role=administrator_roles.admin_role_id');
        $query = $this->db->get_where('admin_users', array('admin_username'=>$uname, 'admin_password'=>$passkey, 'admin_status'=>'1'));
        //print_r($this->db->last_query());
	    return $query->row_array();
    }
}
?>