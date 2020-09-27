<?php
   
require APPPATH . 'libraries/REST_Controller.php';
     
class Company extends REST_Controller {
    
    private $response_data = null;

    public function __construct() {
       parent::__construct();
       $this->load->model('Company_model');
    }
       
    /**
     * Get All Company Data from this method.
     *
     * @return Response
    */
	public function index_get($id = 0)
	{
        $resp = $this->Company_model->get($id);

        if($resp){
            success($this, $resp);
        }
        else{
            error($this, array(), 'No Records');
        }
    }
      
    /**
     * Add New Company End point
     * 
     * @return Response
    */
    public function index_post()
    {
        $input = $this->input->post();

        if(!empty($input['company_name'])){
            $id = $this->Company_model->insert_multiple($input['company_name']);

            success($this, ['company' => $id]);
        }
        else{
            error($this, array(), 'company_name field is missing');
        }
    } 
     
    /**
     * Update Company end point
     *
     * @return Response
    */
    public function index_put($id)
    {
        $input = $this->put();
        
        if($input && $id){

            if($this->Company_model->exists($id)){

                $resp = $this->Company_model->update_entry($id, $input);
            
                if($resp){
                    success($this, array(), 'Company updated successfully.');
                }
                else{
                    error($this, array(), 'Company Not updated! try again');
                }
            }
            else{
                error($this, array(), 'Company Not Found');
            }
        }
        else{
            error($this, array(), 'company_id is missing');
        }
    }
     
    /**
     * Delete company end point
     *
     * @return Response
    */
    public function index_delete($id)
    {
        if($id){
            if($this->Company_model->exists($id)){

                $this->Company_model->update_entry($id, array('status' => '0'));

                success($this, array(), 'Company Deleted successfully.');
            }
            else{
                error($this, array(), 'Company Not Found');
            }
        }
        else{
            error($this, array(), 'company_id is missing');
        }
    }
    	
}