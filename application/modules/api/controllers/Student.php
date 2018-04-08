<?php defined('BASEPATH') OR exit('No direct script access allowed');

require 'AUTH_Controller.php';

class Student extends AUTH_Controller {

	function __construct()
	{
		parent::__construct();
		
		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
		$this->load->library('ion_auth');
		$this->load->model('ion_auth_model');
		
		$this->load->model('students_m');
	}
	
	public function addstudent_post() {
		
		$message['status'] = false;
		$user_group = $this->ion_auth->get_users_groups()->row()->id;
		$userId = $this->ion_auth->get_user_id();
		//echo $user_group;exit;
		
		//validate form input
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$this->form_validation->set_rules('age', 'Age', 'trim|required|numeric');	
		$this->form_validation->set_rules('mathmarks', 'Marks in Math', 'trim|required|numeric');	
		$this->form_validation->set_rules('sciencemarks', 'Marks in Science', 'trim|required|numeric');	
		$this->form_validation->set_rules('englishmarks', 'Marks in English', 'trim|required|numeric');
		
		if($user_group != 3){
			
			if ($this->form_validation->run($this) == true) {		
				$name = trim($this->post('name'));
				$age = trim($this->post('age'));
				$mathmarks = trim($this->post('mathmarks'));
				$sciencemarks = trim($this->post('sciencemarks'));
				$englishmarks = trim($this->post('englishmarks'));
				
				$student_data = array(
					'name'	=>	$name,
					'age'	=>	$age,
					'mathmarks'	=>	$mathmarks,
					'sciencemarks'	=>	$sciencemarks,
					'englishmarks'	=>	$englishmarks
				);
				
				//echo $name;exit;
				$message['status'] = true;
				$message['message'] = $this->students_m->add_student($student_data);
				
				$status_code = 200;
			}else{
				$message['error'] = $this->validation_errors();
			}
		}else{
			$message['status'] = false;
			$message['error'] = "Access denied !!";
			$status_code = 404;
		}
		$this->response($message, $status_code);
	}
	
	public function editstudent_post() {		
		
		$message['status'] = false;
		$user_group = $this->ion_auth->get_users_groups()->row()->id;
		$userId = $this->ion_auth->get_user_id();
		
		//validate form input
		$this->form_validation->set_rules('student_id', 'Student ID', 'trim|required|numeric');
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$this->form_validation->set_rules('age', 'Age', 'trim|required|numeric');	
		$this->form_validation->set_rules('mathmarks', 'Marks in Math', 'trim|required|numeric');	
		$this->form_validation->set_rules('sciencemarks', 'Marks in Science', 'trim|required|numeric');	
		$this->form_validation->set_rules('englishmarks', 'Marks in English', 'trim|required|numeric');
		
		if($user_group != 3){
			
			if ($this->form_validation->run($this) == true) {
				$name = trim($this->post('name'));
				$student_id = trim($this->post('student_id'));
				$age = trim($this->post('age'));
				$mathmarks = trim($this->post('mathmarks'));
				$sciencemarks = trim($this->post('sciencemarks'));
				$englishmarks = trim($this->post('englishmarks'));
				
				$student_data = array(
					'name'	=>	$name,
					'student_id'	=>	$student_id,
					'age'	=>	$age,
					'mathmarks'	=>	$mathmarks,
					'sciencemarks'	=>	$sciencemarks,
					'englishmarks'	=>	$englishmarks
				);
				
				//echo $name;exit;
				$message['status'] = true;
				$message['message'] = $this->students_m->edit_student($student_data);
				
				$status_code = 200;
			}else{
				$message['error'] = $this->validation_errors();
			}
		}else{
			$message['status'] = false;
			$message['error'] = "Access denied !!";
			$status_code = 404;
		}
		$this->response($message, $status_code);
	}
	
	public function list_get() {
		
		$message['status'] = false;		
		$allstudents = $this->students_m->allstudents();
		$total_student = count($allstudents);
		
		foreach($allstudents as $key=>$allstudent){
			$total=$allstudent['math_marks']+$allstudent['science_marks']+$allstudent['english_marks'];
			$percentage= $total/3;
			$allstudents[$key]['total_marks']=$total;
			$allstudents[$key]['percentage']= round($percentage,2);
			$allstudents[$key]['rank']= $total_student;;
			$total_student--;
		}
		array_multisort(array_column($allstudents, 'total_marks'), SORT_DESC, $allstudents);
		
		$message['status'] = true;
		$message['student_data'] = $allstudents;
		$status_code = 200;
		
		echo $id;
		$this->response($message, $status_code);
		
	}
	
}
