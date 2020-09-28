<?php

require APPPATH . 'libraries/REST_Controller.php';

class Employee_api extends REST_Controller
{

    /**
     * Get All Data from this method.
     *
     * @return Response
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Employee_model');
        $this->load->model('Department_model');
        $this->load->model('Company_model');
        $this->load->model('Address_model');
        $this->load->model('Contact_model');

        $this->company_id = (int)$this->uri->segments[3];
        
        if (!is_int($this->company_id) || empty($this->company_id)) {
            show_404();
        }
        else if(!$this->Company_model->exists($this->company_id)){
            show_404();
        }
        
    }

    /**
     * Get All Data from this method.
     *
     * @return Response
     */
    public function index_get($id_or_resource = 0, $employee_name = false)
    {

        //if search
        if (is_string($id_or_resource) && !empty($employee_name) && $id_or_resource == "search") {
            $id = $this->search($employee_name);

            if (empty($id)) {
                error($this, array(), "No Results Found");
                return false;
            }
        } else {
            $id = $id_or_resource;
        }
        
        $resp = $this->Employee_model->get($id);

        if ($resp) {
            success($this, $resp);
        } else {
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

        if (!empty($input['name'])) {
            $employee = array();
            $employee['name'] = $input['name'];
            $employee['department_id'] = $this->Department_model->exists($input['department_id']);
            $employee['id'] = $this->Employee_model->insert_entry($employee);

            $this->Contact_model->insert_multiple($input['contact'], $employee['id']);
            $this->Address_model->insert_multiple($input['address'], $employee['id']);

            success($this, ['employee_id' => $employee['id']], "Employee Created Successfully!");
        } else {
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

        if (!empty($id)) {

            if ($this->Employee_model->exists($id)) {

                if (isset($input['name'])) {
                    $employee['name'] = $input['name'];
                }
                if (isset($input['department_id'])) {
                    $employee['department_id'] = $this->Department_model->exists($input['department_id']);
                }

                $this->Employee_model->update_entry($id, $employee);

                $this->Contact_model->update_multiple($id, $input['contact']);
                $this->Address_model->update_multiple($id, $input['address']);

                success($this, ['employee_id' => $id], "Employee Details Updated Successfully!");
            } else {
                error($this, array(), "Employee Not Found!");
            }
        } else {
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
        $get = $this->delete();

        if (empty($id)) {
            error($this, array(), "Employee 'employee_id' field is missing!");
        } else {

            if ($this->Employee_model->exists($id)) {

                if (empty($get) && $id) {
                    $this->Employee_model->update_entry($id, array('status' => '0'));

                    success($this, array(), "Employee Deleted Successfully!");
                } else {
                    if (isset($get['department_id'])) {
                        $this->Employee_model->update_entry($id, array('department_id' => null));
                    }

                    if (isset($get['contact_id'])) {
                        $this->Contact_model->update_entry($id, $get['contact_id'], array('status' => '0'));
                    }

                    if (isset($get['address_id'])) {
                        $this->Address_model->update_entry($id, $get['address_id'], array('status' => '0'));
                    }

                    success($this, array(), "Employee Details partially Deleted!");
                }
            } else {
                error($this, array(), "Employee Not Found!");
            }
        }
    }

    /**
     * Search and get Data from this method.
     *
     * @return array
     */
    function search($employee_name)
    {
        $ids = $this->Employee_model->getIdsByName($employee_name);
        return $ids;
    }
}
