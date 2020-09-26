<?php
class Address_model extends CI_Model {

    public function insert_multiple($addresses, $employee_id){

        $ids = array();

        if(!empty($addresses) && !empty($employee_id)){
            foreach($addresses as $address){
                if(!empty($address)){
                    $ids[] = $this->insert_entry(array(
                        'employee_id' => $employee_id,
                        'address' => $address
                    ));
                }
            }
        }

        return $ids;
    }

    public function insert_entry($address)
    {
        $this->db->insert('addresses', $address);

        return $this->db->insert_id();
    }

    public function update_multiple($employee_id, $addresses){
        
        if(!empty($addresses)){
            foreach($addresses as $address){
                $this->update_entry($employee_id, $address['address_id'], $address);
            }
        }

        return true;
    }

    public function update_entry($employee_id, $address_id, $address)
    {
        $this->db->where('employee_id', $employee_id);

        if(is_array($address_id)){
            $this->db->where_in('address_id', $address_id);
        }
        else{
            $this->db->where('address_id', $address_id);
        }
        
        $contact['updated_at'] = date("Y-m-d H:i:s");

        $this->db->where('status', "1");

        return $this->db->update('addresses', $address);
    }

}