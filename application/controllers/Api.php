<?php
//defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . "/libraries/REST_Controller.php";

class Api extends REST_Controller {

	public function __construct()
	{
		if (isset($_SERVER['HTTP_ORIGIN'])) {
           header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
           header('Access-Control-Allow-Credentials: true');
           header('Access-Control-Max-Age: 86400');    // cache for 1 day
           header("Access-Control-Allow-Origin", "*");
 		header("Access-Control-Allow-Headers", "Origin, X-Requested-With, Content-Type, Accept");
       }

      // Access-Control headers are received during OPTIONS requests
       if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

           if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
               header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

           if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
               header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

           exit(0);
       }

     
       parent::__construct();
		$this->load->database();
		$this->load->model('api_model');
		//$this->load->library('jwt');
		$this->load->helpers('jwt');
		 
	}

	public function index_get()
	{
		$this->response('test');
	}

		
	public function loginCheck_post(){
		 $username=$this->post('username');
		  $password=$this->post('password');
		$emp_login=$this->api_model->loginCheck($username,$password);
		//print_r($emp_login);
		//echo $emp_login->reg_no;
		//echo $emp_login['reg_no'];

		if ($emp_login != false) {
				$token = array();
				$token['id'] = $emp_login->reg_no;
				$output['token'] = Jwt::encode($token, $this->config->item('jwt_key'));
				$token =$output['token'];
		  		$emp_login->token = $token;
		  		$emp_login->key = $this->config->item('jwt_key');
			}

	 	if($emp_login)
			{
				return $this->response($emp_login,200);
		   	}
		  else {
		      return $this->response("failure",200);
			}
		 
	} 

	


	function getData($type, $params=null) {
		 
		$success = true;
		$error = '';
		$result = '';
		$response = [];
				
		if(!$_SERVER['HTTP_TOKEN']) {
			$success = false;
			$error = "Token not provided";
			 
		}
		
		if ($success) {
		 
			try 
			{
				//echo "try block";
				$token = JWT::decode($_SERVER['HTTP_TOKEN'], $this->config->item('jwt_key'));
				  // echo 'after try block';
				//echo  $token['id'].'JI';
			  // if ($token->id) {
				if ($token->id) {		
					switch($type) {
						 
						case 'getRole'					: $result= $this->api_model->getRole($params); break; 
						case 'getCategories'			: $result= $this->api_model->getCategories($params); break; 
						case 'getIssuesListbyCategory'	: $result=$this->api_model->getIssuesListbyCategory($params);break; 
						case 'getIssuesListBySelection'	: $result=$this->api_model->getIssuesListBySelection($params); break; 
						case 'INSERTISSUE' : $result = $this->api_model->INSERTISSUE($params); break;
						case 'GETDETAILS' : $result =  $this->api_model->GETDETAILS($params); break;
								 
					}
				
					$success = true;
				}
			} 
			catch (Exception $e)
			{
				$success = false;
				$error = "Token authentication failed";
			}					
		}
		
		$response['success'] = $success;
		$response['error'] = $error;
		if ($success) {
			//$response['data'] = $result;
			 $this->response($result,200);
		}
	}
	
	public function getRole_post(){
		$reg_no= $this->post('reg_no');
	    $this->getData('getRole',$reg_no); 
		 
	}

	// public function getIssuesList_get(){
		 
	// 	  $result= $this->api_model->getActivites();
	// 	 $this->response($result,200);
	// 	// print_r($result);
	// 	// return $result;
	// 	//$this->getData('getIssuesList');
	// }


	public function getCategories_get(){
		$result=$this->api_model->getCategories();
		//$this->response($result,200);
		$this->getData('getCategories');
	}

	public function getIssuesListbyCategory_post(){
		$domain = $this->post('domain');
		//$result=$this->api_model->getIssuesListbyCategory($domain);
		// if($result){
		// 		return $result;
		// }else{
		// 	return false;
		// }
		$this->getData('getIssuesListbyCategory',$domain);

		//$this->response($result,200);
	}

	public function getIssuesListBySelection_post(){
	 
		$data = array(
			'category' => $this->post('category'),
			'status' => $this->post('status'),
			'from_date' => $this->post('from_date'),
			'to_date' =>$this->post('to_date'));
     $this->getData('getIssuesListBySelection',$data);
	}
	public function INSERTISSUE_post(){
	 
		$data = array(
			'domain' => $this->post('domain'),
			'issue_desc' => $this->post('issue_desc'),
			'location' => $this->post('location'),
			'problem' =>$this->post('problem'));
     $this->getData('INSERTISSUE',$data);
	}
 public function GETDETAILS_post()
 { 
//  	$data = array(
// 'reg_no' => $this->post('reg_no'),
//  		);
 	$reg_no = $this->post('reg_no');
 
 	$this->getData('GETDETAILS',$reg_no);

}

}