<?php
class Department_model extends CI_Model {

    public function exists($id = false, $name = false){

        $this->db->select("department_id");
        
        if(!empty($id)){
            $this->db->where('department_id', $id);
        }

        if(!empty($name)){
            $this->db->where('department_name', $name);
        }

        $this->db->where('status', '1');

        $query = $this->db->get('departments');

        if($query->num_rows() > 0){
            return $query->row()->department_id;
        }

        return null;
    }


}