<?php
   
require APPPATH . 'libraries/REST_Controller.php';
     
class Employee extends REST_Controller {
    
	  /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function __construct() {
       parent::__construct();
       
       $this->load->model('Employee_model');
       $this->load->model('Department_model');
       $this->load->model('Address_model');
       $this->load->model('Contact_model');
    }
       
    /**
     * Get All Data from this method.
     *
     * @return Response
    */
	public function index_get($id = 0){
        $resp = $this->Employee_model->get($id);

        if($resp){
            success($this, $resp);
        }
        else{
            error($this, array(), "No Results Found");
        }
    }
      
    /**
     * Add New Employee End point
     * 
     * @return Response
    */
    public function index_post()
    {
        $input = $this->input->post();
        
        if(!empty($input['name'])){
            $employee = array();
            $employee['name'] = $input['name'];
            $employee['department_id'] = $this->Department_model->exists($input['department_id']);
            $employee['id'] = $this->Employee_model->insert_entry($employee);

            $this->Contact_model->insert_multiple($input['contact'], $employee['id']);
            $this->Address_model->insert_multiple($input['address'], $employee['id']);

            success($this, ['employee_id' => $employee['id']], "Employee Created Successfully!");
        }
        else{
            error($this, array(), "Employee 'name' field is missing!");
        }
    } 
     
    /**
     * Update Employee end point
     *
     * @return Response
    */
    public function index_put($id)
    {
        $input = $this->put();
        
        $employee = array();
        
        if(!empty($id)){

            if($this->Employee_model->exists($id)){

                if(isset($input['name'])){
                    $employee['name'] = $input['name'];
                }
                if(isset($input['department_id'])){
                    $employee['department_id'] = $this->Department_model->exists($input['department_id']);
                }
                
                $this->Employee_model->update_entry($id, $employee);
                
                $this->Contact_model->update_multiple($id, $input['contact']);
                $this->Address_model->update_multiple($id, $input['address']);

                success($this, ['employee_id' => $id], "Employee Details Updated Successfully!");
            }
            else{
                error($this, array(), "Employee Not Found!");
            }
        }
        else{
            error($this, array(), "Employee Not Found!");
        }

        
    }
     
    /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function index_delete($id)
    {
        
    }
    	
}