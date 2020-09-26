<?php
class Contact_model extends CI_Model {

    public function insert_multiple($contacts, $employee_id){

        $ids = array();

        if(!empty($contacts) && !empty($employee_id)){
            foreach($contacts as $contact){
                if(!empty($contact)){
                    $ids[] = $this->insert_entry(array(
                        'employee_id' => $employee_id,
                        'contact' => $contact
                    ));
                }
            }
        }

        return $ids;
    }

    public function insert_entry($contact)
    {
        $this->db->insert('contacts', $contact);

        return $this->db->insert_id();
    }

}