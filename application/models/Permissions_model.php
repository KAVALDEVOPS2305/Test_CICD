<?php
class Permissions_model extends CI_Model
{
    public function insert_update($formdata)
    {
        if(isset($formdata['roles_id']))
		{
            $where = ["roles_id" => $formdata['roles_id']];
            $table = "adminusers_roles_permissions";
		}
		else
		{
            $where = ["admin_id" => $formdata['admin_id']];
            $table = "adminusers_custom_permissions";
		}
        unset($formdata['permission_type']);
        $formdata['modules_id'] = implode(',',$formdata['modules_id']);
        
        //insert or update data
        if($this->db->where($where)->get($table)->result())
            return $this->db->where($where)->update($table,$formdata);
        else
            return $this->db->insert($table,$formdata);
    }

    public function getPermission($where,$table)
    {
        return $this->db->select('modules_id')->where($where)->get($table)->result();
    }

    public function role_permission($route)
    {
        return $this->db->query("SELECT * FROM adminusers_roles_permissions ARP LEFT JOIN administrator_modules AM ON find_in_set(AM.admin_module_id, ARP.modules_id) where AM.module_route = '$route' and ARP.roles_id=".$this->session->userdata('user_session')['admin_role'])->result();
    }

    public function custom_permission($route)
    {
        // $admin_id = $this->session->userdata('user_session')['admin_uid'];

        return $this->db->query("SELECT * FROM adminusers_custom_permissions ACP LEFT JOIN administrator_modules AM ON find_in_set(AM.admin_module_id, ACP.modules_id) where AM.module_route = '$route' and ACP.admin_id=".$this->session->userdata('user_session')['admin_uid'])->result();
    }

    public function check_permission($route)
    {
        $role_access = $this->db->query("SELECT * FROM adminusers_roles_permissions ARP LEFT JOIN administrator_modules AM ON find_in_set(AM.admin_module_id, ARP.modules_id) where AM.module_route = '$route' and ARP.roles_id=".$this->session->userdata('user_session')['admin_role'])->result();

        $user_access = $this->db->query("SELECT * FROM adminusers_custom_permissions ACP LEFT JOIN administrator_modules AM ON find_in_set(AM.admin_module_id, ACP.modules_id) where AM.module_route = '$route' and ACP.admin_id=".$this->session->userdata('user_session')['admin_uid'])->result();

        // echo "<pre>";
        // print_r($this->session->userdata());
        // print_r("<br/><br/>".$this->db->last_query());
        // print_r($role_access);
        // print_r($user_access);

        if(!empty($role_access) || !empty($user_access))
            return true;
        else
            return false;
    }

    public function get_modules()
    {
        // $modules_ids = $this->db->query("SELECT CONCAT(ARP.modules_id,',',ACP.modules_id) as PERMISSIONS from adminusers_roles_permissions ARP JOIN adminusers_custom_permissions ACP WHERE roles_id = ".$this->session->userdata('user_session')['admin_role']." AND admin_id =".$this->session->userdata('user_session')['admin_uid'])->row_array();
        $modules_ids = $this->db->query("SELECT TRIM(BOTH ',' FROM CONCAT(IFNULL(MAX(a),''),',', IFNULL(MAX(b),''))) as data FROM( SELECT COALESCE(ACP.modules_id,'') AS a, NULL AS b FROM adminusers_custom_permissions AS ACP WHERE admin_id=".$this->session->userdata('user_session')['admin_uid']." UNION ALL SELECT NULL AS a , COALESCE(ARP.modules_id,'') AS b FROM adminusers_roles_permissions  AS ARP WHERE roles_id =".$this->session->userdata('user_session')['admin_role'].") AS main")->row_array();
        // print_r("<br/><br/>".$this->db->last_query());



        // print_r($modules_ids['data']);
        // die();
        if(!empty($modules_ids['data']))
            $modules = $this->db->select('module_route')->where_in('admin_module_id',$modules_ids['data'],false)->where('module_status','1')->get('administrator_modules')->result_array();
            // print_r("<br/><br/>".$this->db->last_query());
        if(!empty($modules))
            return array_column($modules,'module_route');
        else
            return ;
    }
}
?>