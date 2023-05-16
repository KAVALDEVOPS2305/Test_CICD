<?php
class Autocomplete_model extends CI_Model
{
    function for_usernames()
    {
        return array_column($this->db->select('username')->get('users')->result_array(),"username");
    }

    function for_businessname()
    {
        return array_column($this->db->select('business_name')->get('users')->result_array(),"business_name");
    }


}
?>