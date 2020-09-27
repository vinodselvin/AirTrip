<?php
class Employee_model extends CI_Model {

    public function exists($id){

        $this->db->select("employee_id");
        $this->db->where('employee_id', $id);
        $this->db->where('status', '1');

        $query = $this->db->get('employees');
        
        if($query->num_rows() > 0){
            return $query->row()->employee_id;
        }

        return null;
    }

    public function get($id = 0)
    {

        $this->db->select("e.employee_id, e.name, d.department_id, d.department_name, c.contact_id, c.contact, a.address_id, a.address");

        if(!empty($id)){
            
            if(is_array($id)){
                $this->db->where_in('e.employee_id', $id);
            }
            else{
                $this->db->where('e.employee_id', $id);
            }
        }

        $this->db->where("e.status", '1');

        $this->db->join("departments d", "d.department_id = e.department_id AND d.status = 1", "left");
        $this->db->join("contacts c", "c.employee_id = e.employee_id AND c.status = 1", "left");
        $this->db->join("addresses a", "a.employee_id = e.employee_id AND a.status = 1", "left");

        $query = $this->db->get('employees e');
        
        if($query->num_rows() > 0){

            $result = $query->result_array();

            foreach($result as $row){
                
                $resp[$row['employee_id']]['name'] = $row['name'];
                $resp[$row['employee_id']]['employee_id'] = $row['employee_id'];

                if(!empty($row['contact_id'])){
                    $resp[$row['employee_id']]['contact'][$row['contact_id']] = array(
                        'contact_id' => $row['contact_id'],
                        'contact' => $row['contact'],
                    );
                }

                if(!empty($row['department_id'])){
                    $resp[$row['employee_id']]['department'][$row['department_id']] = array(
                        'department_id' => $row['department_id'],
                        'department_name' => $row['department_name'],
                    );
                }

                if(!empty($row['address_id'])){
                    $resp[$row['employee_id']]['address'][$row['address_id']] = array(
                        'address_id' => $row['address_id'],
                        'address' => $row['address'],
                    );
                }
            }

            foreach($resp as $employee_id => $e_employee){
                
                $resp[$employee_id]['department'] = !empty($e_employee['department']) ? array_values($e_employee['department']) : null;
                $resp[$employee_id]['contact'] = !empty($e_employee['contact']) ? array_values($e_employee['contact']) : null;
                $resp[$employee_id]['address'] = !empty($e_employee['address']) ? array_values($e_employee['address']) : null;
            }

            return (is_int($id) && !empty($id)) ? $resp[$id] : array_values($resp);
        }
        else{
            return false;
        }
    }

    public function insert_entry($employee)
    {
        $this->db->insert('employees', $employee);

        return $this->db->insert_id();
    }

    public function update_entry($id, $employee)
    {
        $this->db->where('status', '1');
        $this->db->where('employee_id', $id);

        $employee['updated_at'] = date("Y-m-d H:i:s");
        
        $this->db->update('employees', $employee);
    }

    function getIdsByName($employee_name){

        $this->db->select('employee_id');
        $this->db->like('name', $employee_name);
        $this->db->where('status', '1');

        $query = $this->db->get('employees');
        
        if($query->num_rows() > 0){
            foreach($query->result_array() as $key => $row){
                $ids[] = $row['employee_id'];
            }
            return $ids;
        }

        return false;
    }

}