<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Posts extends CI_Controller {

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
        $posts = $this->Posts_Model->get(); 
        $postsArray = array();

        foreach ($posts as $post) {

            //Check if post is liked by loggedUser
            $isPostLiked = false;
            $loggedUserId = $this->loggedUser['user_id'];
            $arrayLikes = unserialize($post->post_likes);
            if (in_array($loggedUserId, $arrayLikes)) {
                $isPostLiked = true;
            }
            
            $postStructureData = [
                'post' => $post,
                'post_comments' => $this->Post_Comments_Model->getByPostId($post->post_id),
                'isPostLiked' => $isPostLiked
            ];

            $postsArray[] = $postStructureData;
        }

        $data['posts'] = $postsArray;


        //Trending Posts
        $trendingPosts = $this->Posts_Model->getTrending(); 
        $data['trendingPosts'] = $trendingPosts;

        $this->load->view('posts', $data);
	}




    public function create_post_discussion()
	{       
        $data['channels'] = $this->Channels_Model->get();  
        $this->load->view('post-create-discussion', $data);
	}
    public function create_post_discussion_submit()
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
                redirect('posts/create_post_discussion');
            }
            
        } 
        else {
            $this->create_post_discussion();
        }
	}








    public function create_post_question()
	{       
        $data['channels'] = $this->Channels_Model->get();  
        $this->load->view('post-create-question', $data);
	}
    public function create_post_question_submit()
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
                redirect('posts/create_post_question');
            }
            
        } 
        else {
            $this->create_post_question();
        }
	}









    public function create_post_poll()
	{       
        $data['channels'] = $this->Channels_Model->get();  
        $this->load->view('post-create-poll', $data);
	}
    public function create_post_poll_submit()
    {       
        $this->form_validation->set_rules('post_title','Post Title','required');
        $this->form_validation->set_rules('post_opt1','Option 1', 'required');
        $this->form_validation->set_rules('post_opt2','Option 2', 'required');
        $this->form_validation->set_rules('post_opt3','Option 3', 'required');
        $this->form_validation->set_rules('post_ch_id', 'Post Channel', 'required|greater_than[0]');

        if ($this->form_validation->run() == TRUE) {

            $data['post_title'] = $this->input->post('post_title');

            $arrayOptions = [];
            array_push($arrayOptions, $this->input->post('post_opt1'));
            array_push($arrayOptions, $this->input->post('post_opt2'));
            array_push($arrayOptions, $this->input->post('post_opt3'));

            $data['post_body'] = serialize($arrayOptions);
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
                redirect('posts/create_post_poll');
            }
            
        } 
        else {
            $this->create_post_poll();
        }
	}
    













    public function create_post_gallery()
	{       
        $data['channels'] = $this->Channels_Model->get();  
        $this->load->view('post-create-gallery', $data);
	}
    public function create_post_gallery_submit()
	{       
        $this->form_validation->set_rules('post_title','Post Title','required');
        $this->form_validation->set_rules('post_body','Post Body', 'trim|xss_clean');
        $this->form_validation->set_rules('post_ch_id', 'Post Channel', 'required|greater_than[0]');

        if ($this->form_validation->run() == TRUE) {

            $data['post_title'] = $this->input->post('post_title');
            $data['post_ch_id'] = $this->input->post('post_ch_id');
            $data['post_type'] = $this->input->post('post_type');

            $data['post_user_id'] = $this->loggedUser['user_id'];
            $data['post_likes'] = serialize([]);
            $data['post_created'] = date('F j, Y');

            //Video Start
            $configVideo['upload_path'] = "./uploads/images"; //$this->config->item('upload_dir')."forum/videos/";
            $configVideo['max_size'] = '102400';
            $configVideo['allowed_types'] = 'jpg|png'; # add video extenstion on here
            $configVideo['overwrite'] = FALSE;
            $configVideo['remove_spaces'] = TRUE;
            $video_name = random_string('numeric', 5);
            $configVideo['file_name'] = $video_name;

            $this->load->library('upload', $configVideo);

            if (!$this->upload->do_upload('post_body')) # form input field attribute
            {
                # Upload Failed
                $this->session->set_flashdata('message', $this->upload->display_errors());
                redirect('posts/create_post_gallery');
            }
            else
            {
                # Upload Successfull
                $url = base_url()."uploads/images/".$this->upload->data('file_name');

                $data['post_body'] = $url;
                $result = $this->Posts_Model->create($data);

                if($result > 0) {
                    redirect('posts');
                } 
                else {
                    //assign returned data from model to session
                    $this->session->set_flashdata('message', $result);
                    redirect('posts/create_post_gallery');
                }
            }
            // Video End

            
        } 
        else {
            $this->create_post_gallery();
        }
	}

    












    public function create_post_video()
	{       
        $data['channels'] = $this->Channels_Model->get();  
        $this->load->view('post-create-video', $data);
	}
    public function create_post_video_submit()
	{       
        $this->form_validation->set_rules('post_title','Post Title','required');
        $this->form_validation->set_rules('post_ch_id', 'Post Channel', 'required|greater_than[0]');

        if( $this->input->post('post_body_URL') == null ) {

            $this->form_validation->set_rules('post_body','Post Body', 'trim|xss_clean');

            if ($this->form_validation->run() == TRUE) {

                $data['post_title'] = $this->input->post('post_title');
                $data['post_ch_id'] = $this->input->post('post_ch_id');
                $data['post_type'] = $this->input->post('post_type');
    
                $data['post_user_id'] = $this->loggedUser['user_id'];
                $data['post_likes'] = serialize([]);
                $data['post_created'] = date('F j, Y');
    
                //Video Start
                $configVideo['upload_path'] = "./uploads/videos"; //$this->config->item('upload_dir')."forum/videos/";
                $configVideo['max_size'] = '102400';
                $configVideo['allowed_types'] = 'mp4'; # add video extenstion on here
                $configVideo['overwrite'] = FALSE;
                $configVideo['remove_spaces'] = TRUE;
                $video_name = random_string('numeric', 5);
                $configVideo['file_name'] = $video_name;
    
                $this->load->library('upload', $configVideo);
    
                if (!$this->upload->do_upload('post_body')) # form input field attribute
                {
                    # Upload Failed
                    $this->session->set_flashdata('message', $this->upload->display_errors());
                    redirect('posts/create_post_video');
                }
                else
                {
                    # Upload Successfull
                    $url = base_url()."uploads/videos/".$this->upload->data('file_name');
    
                    $data['post_body'] = $url;
                    $result = $this->Posts_Model->create($data);
    
                    if($result > 0) {
                        redirect('posts');
                    } 
                    else {
                        //assign returned data from model to session
                        $this->session->set_flashdata('message', $result);
                        redirect('posts/create_post_video');
                    }
                }
                // Video End
    
                
            } 
            else {
                $this->create_post_video();
            }
        } else {

            $this->form_validation->set_rules('post_body_URL','Video URL', 'required');

            if ($this->form_validation->run() == TRUE) {

                $data['post_title'] = $this->input->post('post_title');
                $data['post_ch_id'] = $this->input->post('post_ch_id');
                $data['post_type'] = $this->input->post('post_type');
    
                $data['post_user_id'] = $this->loggedUser['user_id'];
                $data['post_likes'] = serialize([]);
                $data['post_created'] = date('F j, Y');

                $url = $this->input->post('post_body_URL');
                parse_str(parse_url($url, PHP_URL_QUERY));

                $data['post_body'] = "https://www.youtube.com/embed/".$v;

                


    
                $result = $this->Posts_Model->create($data);

                if($result > 0){
                    redirect('posts');
                } else {
                    //assign returned data from model to session
                    $this->session->set_flashdata('message', $result);
                    redirect('posts/create_post_video');
                }
    
                
            } 
            else {
                $this->create_post_video();
            }

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






    public function search()
	{        
        $ch_id = $this->input->get('channel', TRUE);
        
        $posts = $this->Posts_Model->getByChannelId($ch_id); 
        $postsArray = array();

        foreach ($posts as $post) {

            //Check if post is liked by loggedUser
            $isPostLiked = false;
            $loggedUserId = $this->loggedUser['user_id'];
            $arrayLikes = unserialize($post->post_likes);
            if (in_array($loggedUserId, $arrayLikes)) {
                $isPostLiked = true;
            }
            
            $postStructureData = [
                'post' => $post,
                'post_comments' => $this->Post_Comments_Model->getByPostId($post->post_id),
                'isPostLiked' => $isPostLiked
            ];

            $postsArray[] = $postStructureData;
        }

        $data['posts'] = $postsArray;


        //Trending Posts
        $trendingPosts = $this->Posts_Model->getTrending(); 
        $data['trendingPosts'] = $trendingPosts;

        $this->load->view('posts', $data);
	}

    
}
