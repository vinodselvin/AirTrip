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

        $this->db->where('company_id', $this->company_id);
        $this->db->where('status', '1');

        $query = $this->db->get('departments');

        if($query->num_rows() > 0){
            return $query->row()->department_id;
        }

        return null;
    }

    public function get($id = 0)
    {
        $this->db->select('department_id, department_name');

        if(!empty($id)){
            $this->db->where('department_id', $id);
        }

        $this->db->where('company_id', $this->company_id);

        $this->db->where("status", '1');

        $query = $this->db->get('departments');

        if($query->num_rows() > 0){
            return $id ? $query->row_array() : $query->result_array();
        }
    }

    public function insert_entry($department_name)
    {
        $this->db->insert('departments', array('department_name'=> $department_name, 'company_id' => $this->company_id));       
        
        return $this->db->insert_id();
    }

    public function insert_multiple($department_names){

        $resp = array();

        $department_names = is_array($department_names) ? $department_names : array($department_names);

        foreach($department_names as $department_name){
            
            $id = $this->exists(false, $department_name);
            
            if(empty($id)){
                $id = $this->insert_entry($department_name);
            }

            $resp[] = array('department_id' => $id, 'department_name' => $department_name);
        }

        return $resp;
    }

    public function update_entry($department_id, $department){

        $this->db->where('status', '1');
        $this->db->where('department_id', $department_id);
        $this->db->where('company_id', $this->company_id);

        $department['updated_at'] = date("Y-m-d H:i:s");

        return $this->db->update('departments', $department);
    }

}