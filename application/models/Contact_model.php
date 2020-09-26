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

    public function update_multiple($employee_id, $contacts){

        if(!empty($contacts)){
            foreach($contacts as $contact){
                $this->update_entry($employee_id, $contact['contact_id'], $contact);
            }
        }

        return true;
    }

    public function update_entry($employee_id, $contact_id, $contact)
    {
        $this->db->where('employee_id', $employee_id);
        
        if(is_array($contact_id)){
            $this->db->where_in('contact_id', $contact_id);
        }
        else{
            $this->db->where('contact_id', $contact_id);
        }
        
        $contact['updated_at'] = date("Y-m-d H:i:s");

        $this->db->where('status', "1");

        return $this->db->update('contacts', $contact);
    }

}