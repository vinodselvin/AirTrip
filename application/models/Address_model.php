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


}