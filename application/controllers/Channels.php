<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Channels extends CI_Controller {

    public function __construct() {
        parent::__construct();

        if(!$this->session->userdata('loggedUser')){
            redirect('Forum');
        }
        
        $this->load->model('Channels_Model');
    }
	
	public function index()
	{        
        $data['channels'] = $this->Channels_Model->getWithPostsExists(); 
        $this->load->view('channels', $data);
	}
}
