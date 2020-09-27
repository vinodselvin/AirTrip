<?php
class Company_model extends CI_Model {

    public function exists($id = false, $name = false){

        $this->db->select("company_id");
        
        if(!empty($id)){
            $this->db->where('company_id', $id);
        }

        if(!empty($name)){
            $this->db->where('company_name', $name);
        }

        $this->db->where('status', '1');

        $query = $this->db->get('companies');

        if($query->num_rows() > 0){
            return $query->row()->company_id;
        }

        return null;
    }

    public function get($id = 0)
    {
        $this->db->select('company_id, company_name');

        if(!empty($id)){
            $this->db->where('company_id', $id);
        }

        $this->db->where("status", '1');

        $query = $this->db->get('companies');

        if($query->num_rows() > 0){
            return $id ? $query->row_array() : $query->result_array();
        }
    }

    public function insert_entry($company_name)
    {
        $this->db->insert('companies', array('company_name'=> $company_name));       
        
        return $this->db->insert_id();
    }

    public function insert_multiple($company_names){

        $resp = array();

        $company_names = is_array($company_names) ? $company_names : array($company_names);

        foreach($company_names as $company_name){
            
            $id = $this->exists(false, $company_name);
            
            if(empty($id)){
                $id = $this->insert_entry($company_name);
            }

            $resp[] = array('company_id' => $id, 'company_name' => $company_name);
        }

        return $resp;
    }

    public function update_entry($company_id, $company){

        $this->db->where('status', '1');
        $this->db->where('company_id', $company_id);

        $company['updated_at'] = date("Y-m-d H:i:s");

        return $this->db->update('companies', $company);
    }

}