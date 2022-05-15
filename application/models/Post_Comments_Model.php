<?php 

class Post_Comments_Model extends CI_Model {

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

    public function getByPostId($id)
    {
        $this->db->select('*');
        $this->db->from('post_comments pc'); 
        $this->db->join('users user', 'user.user_id=pc.pc_user_id', 'left');
        $this->db->where('pc.pc_post_id',$id);
        $query = $this->db->get(); 
        return $query->result();
    }

    public function create($data)
    {
       $this->db->insert("post_comments", $data);
       $result = $this->db->insert_id();
       return $result;
    }

    public function update($data)
    {
        $id = $data['pc_id'];
        $this->db->where('pc_id', $id);
        $this->db->update('post_comments', $data);
        $result = $this->db->affected_rows();
        return $result;
    }

}

?>