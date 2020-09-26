<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function index()
	{
		echo json_encode(["server_admin" => "Vinod Selvin Nadar"]);
	}
}
