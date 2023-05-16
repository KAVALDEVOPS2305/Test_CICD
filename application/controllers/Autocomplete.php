<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Autocomplete extends CI_Controller
{
    public function __construct()
    {
      parent::__construct();
      $this->load->model('Autocomplete_model','autocomplete');
    }

    public function username()
    {
        echo json_encode($this->autocomplete->for_usernames());
    }

    public function businessname()
    {
        echo json_encode($this->autocomplete->for_businessname());
    }



}
?>