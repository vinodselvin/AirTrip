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
        
    } 
     
    /**
     * Update Employee end point
     *
     * @return Response
    */
    public function index_put($id)
    {
        
        
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