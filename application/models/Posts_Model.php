<?php 

class Posts_Model extends CI_Model {

    public function get()
    {
        $this->db->select('*');
        $this->db->from('posts post'); 
        $this->db->join('channels ch', 'ch.ch_id=post.post_ch_id', 'left');
        $this->db->join('users user', 'user.user_id=post.post_user_id', 'left');
        // $this->db->join('post_comments pc', 'pc.pc_post_id=post.post_id', 'left');
        $this->db->order_by("post_id", "desc");
        $query = $this->db->get(); 
        return $query->result();
    }

    public function getByChannelId($ch_id)
    {
        $this->db->select('*');
        $this->db->from('posts post'); 
        $this->db->join('channels ch', 'ch.ch_id=post.post_ch_id', 'left');
        $this->db->join('users user', 'user.user_id=post.post_user_id', 'left');
        // $this->db->join('post_comments pc', 'pc.pc_post_id=post.post_id', 'left');
        $this->db->order_by("post_id", "desc");
        $this->db->where("ch_id =",$ch_id);
        $query = $this->db->get(); 
        return $query->result();
    }

    

    public function getTrending()
    {
        $this->db->select('*');
        $this->db->from('posts post'); 
        $this->db->join('channels ch', 'ch.ch_id=post.post_ch_id', 'left');
        $this->db->join('users user', 'user.user_id=post.post_user_id', 'left');
        $this->db->order_by("post_id", "desc");
        $this->db->limit(3);
        $query = $this->db->get(); 
        return $query->result();
    }

    public function getById($id)
    {
        $this->db->select('*');
        $this->db->from('posts post'); 
        $this->db->join('channels ch', 'ch.ch_id=post.post_ch_id', 'left');
        $this->db->join('users user', 'user.user_id=post.post_user_id', 'left');
        $this->db->where('post.post_id',$id);
        $query = $this->db->get(); 
        return $query->row();
    }

    public function create($data)
    {
       $this->db->insert("posts", $data);
       $result = $this->db->insert_id();
       return $result;
    }
    
    public function update($data)
    {
        $id = $data['post_id'];
        $this->db->where('post_id', $id);
        $this->db->update('posts', $data);
        $result = $this->db->affected_rows();
        return $result;
    }

}

?>    