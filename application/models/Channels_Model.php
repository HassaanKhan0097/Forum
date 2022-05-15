<?php 

class Channels_Model extends CI_Model {

    public function get()
    {
            $query = $this->db->get('channels');
            return $query->result();
    }
    
    public function getWithPostsExists()
    {
            $query = $this->db->query('SELECT *, COUNT(ch.ch_id) AS posts_count FROM channels ch INNER JOIN posts p ON ch.ch_id = p.post_ch_id GROUP BY ch.ch_id');
            $this->db->get('channels');
            return $query->result();
    }

    // public function getById($id)
    // {
    //     $query = $this->db->where("pr_id =",$id)->get("products");
    //     return $query->row();
    // }

}

?>