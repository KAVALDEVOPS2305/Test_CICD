<?php
class Deletions_model extends CI_Model
{
    public function del_admin_role($record_id)
    {
        // return $this->db->where('category_id', $record_id)
        //                 ->delete('tbl_clg_category');
        
        return $this->db->set('role_status','2')
                        ->set('updated_by',$this->session->userdata['user_session']['admin_username'])
                        ->where('admin_role_id',$record_id)
                        ->update('administrator_roles');
    }

    public function del_clg_course($record_id)
    {
        return $this->db->set('course_status','2')
                        ->where('course_id',$record_id)
                        ->update('tbl_clg_course');
    }
}


?>