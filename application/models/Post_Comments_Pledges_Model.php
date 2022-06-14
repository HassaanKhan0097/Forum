<?php 

class Post_Comments_Pledges_Model extends CI_Model {

    public function get()
    {
        $query = $this->db->get('post_comments');
        return $query->result();
    }

    public function getById($id)
    {
        $query = $this->db->where("pc_id =",$id)->get("post_comments");
        return $query->row();
    }

    public function getByCommentId($id, $loggedUserId)
    {
        $this->db->select('*');
        $this->db->from('post_comments_pledges pcp'); 
        $this->db->join('post_comments pc', 'pc.pc_id=pcp.pcp_pc_id', 'left');
        $this->db->where('pcp.pcp_pc_id',$id);
        $this->db->where('pcp.pcp_user_id',$loggedUserId);
        $query = $this->db->get(); 
        return $query->row();
    }

    public function getByPostId($id)
    {
        $this->db->select('*');
        $this->db->from('post_comments_pledges pcp'); 
        $this->db->join('posts post', 'post.post_id=pcp.pcp_post_id', 'left');
        $this->db->where('pcp.pcp_post_id',$id);
        $query = $this->db->get(); 
        return $query->result();
    }
    // $this->db->join('users user', 'user.user_id=pcp.pcp_user_id', 'left');
    public function getByUserId($id)
    {
        $this->db->select('*');
        $this->db->from('post_comments_pledges pcp'); 
        $this->db->join('posts post', 'post.post_id=pcp.pcp_post_id', 'left');
        $this->db->join('post_comments pc', 'pc.pc_id=pcp.pcp_pc_id', 'left');
        $this->db->where('pcp.pcp_user_id',$id);
        // $this->db->order_by('DATE(pc.pc_created)', 'desc');
        $query = $this->db->get(); 
        return $query->result();
    }

    public function create($data)
    {
       $this->db->insert("post_comments_pledges", $data);
       $result = $this->db->insert_id();
       return $result;
    }

    public function update($data)
    {
        $id = $data['pcp_id'];
        $this->db->where('pcp_id', $id);
        $this->db->update('post_comments_pledges', $data);
        $result = $this->db->affected_rows();
        return $result;
    }

}

?>