<?php
   
require APPPATH . 'libraries/REST_Controller.php';
     
class Department extends REST_Controller {
    
    private $response_data = null;

    public function __construct() {
       parent::__construct();
       $this->load->model('Department_model');
    }
       
    /**
     * Get All Department Data from this method.
     *
     * @return Response
    */
	public function index_get($id = 0)
	{
        $resp = $this->Department_model->get($id);

        if($resp){
            success($this, $resp);
        }
        else{
            error($this, array(), 'No Records');
        }
    }
      
    /**
     * Add New Department End point
     * 
     * @return Response
    */
    public function index_post()
    {
        $input = $this->input->post();

        if(!empty($input['department_name'])){
            $id = $this->Department_model->insert_multiple($input['department_name']);

            success($this, ['department' => $id]);
        }
        else{
            error($this, array(), 'department_name field is missing');
        }
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