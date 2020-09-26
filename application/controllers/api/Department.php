<?php
   
require APPPATH . 'libraries/REST_Controller.php';
     
class Department extends REST_Controller {
    
    private $response_data = null;

    public function __construct() {
       parent::__construct();
    }
       
    /**
     * Get All Department Data from this method.
     *
     * @return Response
    */
	public function index_get($id = 0)
	{
        
    }
      
    /**
     * Add New Department End point
     * 
     * @return Response
    */
    public function index_post()
    {
        
    } 
     
    /**
     * Update Department end point
     *
     * @return Response
    */
    public function index_put($id)
    {
        
    }
     
    /**
     * Delete department end point
     *
     * @return Response
    */
    public function index_delete($id)
    {
        
    }
    	
}