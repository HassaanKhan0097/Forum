<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

    var $loggedUser;
    var $post_id;
    public function __construct() {
        parent::__construct();

        if(!$this->session->userdata('loggedUser')){
            redirect('Forum');
        }
        
        $this->load->model('Channels_Model');
        $this->load->model('Posts_Model');
        $this->load->model('Post_Comments_Model');
        $this->load->model('Post_Comments_Pledges_Model');

        
        

        $this->loggedUser = $this->session->userdata('loggedUser');
    }
	
	public function index()
	{        

        
       $data['pledge_list'] =  $this->Post_Comments_Pledges_Model->getByUserId($this->loggedUser['user_id']); 

    //    echo "<pre>";
    //    print_r( $data['pledge_list']);
        //$data['posts'] = $this->Posts_Model->get(); 
        $this->load->view('profile', $data);
	}

    public function create_post()
	{       
        $data['channels'] = $this->Channels_Model->get();  
        $this->load->view('post-create', $data);
	}

    public function create_post_submit()
	{       
        $this->form_validation->set_rules('post_title','Post Title','required');
        $this->form_validation->set_rules('post_body','Post Body', 'required');
        $this->form_validation->set_rules('post_ch_id', 'Post Channel', 'required|greater_than[0]');

        if ($this->form_validation->run() == TRUE) {

            $data['post_title'] = $this->input->post('post_title');
            $data['post_body'] = $this->input->post('post_body');
            $data['post_ch_id'] = $this->input->post('post_ch_id');
            $data['post_type'] = $this->input->post('post_type');

            $data['post_user_id'] = $this->loggedUser['user_id'];
            $data['post_likes'] = serialize([]);
            $data['post_created'] = date('F j, Y');

            $result = $this->Posts_Model->create($data);

            if($result > 0){
                redirect('posts');
            } else {
                //assign returned data from model to session
                $this->session->set_flashdata('message', $result);
                redirect('posts/create_post');
            }
            
        } 
        else {
            $this->create_post();
        }
	}

    public function post_detail()
	{        
        $this->post_id = $this->uri->segment(3); // need to change this logic
        $id = $this->uri->segment(3);
        $loggedUserId = $this->loggedUser['user_id'];
        $data['post'] = $this->Posts_Model->getById($id);

        //Check if post is liked by loggedUser
        $data['isPostLiked'] = false;
        $arrayLikes = unserialize($this->Posts_Model->getById($id)->post_likes);
        if (in_array($loggedUserId, $arrayLikes)) {
            $data['isPostLiked'] = true;
        }

        $data['post_comments'] = $this->Post_Comments_Model->getByPostId($this->post_id);
        

        $data['post_pledges'] = $this->Post_Comments_Pledges_Model->getByPostId($this->post_id);

        $this->load->view('post-detail', $data);
	}

    public function addlike($post_id)
    {
        $id = $post_id;
        $loggedUserId = $this->loggedUser['user_id'];
        $arrayLikes = unserialize($this->Posts_Model->getById($id)->post_likes);
        
        if (!in_array($loggedUserId, $arrayLikes)) {

            //add like to array
            $arrayLikes = [];
            array_push($arrayLikes, $loggedUserId);

            $data['post_id'] = $id;
            $data['post_likes'] = serialize($arrayLikes);
            $result = $this->Posts_Model->update($data);

            echo json_encode("Like Added");

        } else {

            //remove like from array
            if (($key = array_search($loggedUserId, $arrayLikes)) !== false) {
                unset($arrayLikes[$key]);
            }
            $data['post_id'] = $id;
            $data['post_likes'] = serialize($arrayLikes);
            $result = $this->Posts_Model->update($data);

            echo json_encode("Like Removed");

        }



        // echo json_encode($arrayLikes);

        // if($result > 0){
        //     redirect('posts');
        // } else {
        //     //assign returned data from model to session
        //     $this->session->set_flashdata('message', $result);
        //     redirect('posts/create_post');
        // }

        // if (in_array($loggedUserId, $arrayLikes))
        // {
        //     echo "found";
        // }
        // else
        // {
        //     echo "not found";
        // }

        // for($i=0; $i<count($arrayLikes); $i++) {

        // }


    }


    public function create_comment_submit()
	{       
        $this->form_validation->set_rules('pc_comment','Comment', 'required');

        if ($this->form_validation->run() == TRUE) {

            $data['pc_comment'] = $this->input->post('pc_comment');

            $data['pc_user_id'] = $this->loggedUser['user_id'];
            $data['pc_post_id'] = $this->input->post('pc_post_id');
            $data['pc_likes'] = serialize([]);
            // $data['pc_pledges'] = serialize([]);
            $data['pc_created'] = date('F j, Y');

            $result = $this->Post_Comments_Model->create($data);

            if($result > 0){
                redirect('posts/post_detail/'.$this->input->post('pc_post_id'));
            } else {
                //assign returned data from model to session
                $this->session->set_flashdata('message', $result);
                redirect('posts/post_detail/'.$this->input->post('pc_post_id'));
            }
            
        } 
        else {
            $this->post_detail();
        }
	}
    public function addLikeToComment($pc_id)
    {
        $id = $pc_id;
        $loggedUserId = $this->loggedUser['user_id'];
        $arrayLikes = unserialize($this->Post_Comments_Model->getById($id)->pc_likes);
        
        if (!in_array($loggedUserId, $arrayLikes)) {

            //add like to array
            $arrayLikes = [];
            array_push($arrayLikes, $loggedUserId);

            $data['pc_id'] = $id;
            $data['pc_likes'] = serialize($arrayLikes);
            $result = $this->Post_Comments_Model->update($data);

            echo json_encode("Like Added");

        } else {

            //remove like from array
            if (($key = array_search($loggedUserId, $arrayLikes)) !== false) {
                unset($arrayLikes[$key]);
            }
            $data['pc_id'] = $id;
            $data['pc_likes'] = serialize($arrayLikes);
            $result = $this->Post_Comments_Model->update($data);

            echo json_encode("Like Removed");

        }


    }

    public function addPledgeToComment($pc_id, $pledge, $pc_post_id)
    {
        $id = $pc_id;
        $loggedUserId = $this->loggedUser['user_id'];
        $PCP_Row = $this->Post_Comments_Pledges_Model->getByCommentId($id, $loggedUserId);

        //condition to check if already exist
        if($PCP_Row != null) {

            $data['pcp_user_id'] = $loggedUserId;
            $data['pcp_pc_id'] = $pc_id;
            $data['pcp_pledge'] = $pledge;
            $data['pcp_id'] = $PCP_Row->pcp_id;
            $data['pcp_post_id'] = $pc_post_id;
            $result = $this->Post_Comments_Pledges_Model->update($data);

            echo json_encode("Pledge Updated");

        } else {

            $data['pcp_user_id'] = $loggedUserId;
            $data['pcp_pc_id'] = $pc_id;
            $data['pcp_pledge'] = $pledge;
            $data['pcp_post_id'] = $pc_post_id;
            $result = $this->Post_Comments_Pledges_Model->create($data);

            if($result > 0){
                echo json_encode("Pledge Added");
            } else {
                //assign returned data from model to session
                echo json_encode("Pledge Failed");
            }

        }


    }

    
}
