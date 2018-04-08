<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Students_m extends CI_Model {
	
	/**
	 * message (uses lang file)
	 *
	 * @var string
	 **/
	protected $messages;
	
	/**
	 * error message (uses lang file)
	 *
	 * @var string
	 **/
	protected $errors;
	
    function __construct() {
        parent::__construct();
		
		$this->messages    = array();
		$this->errors      = array();
    }
	
	
	
	/**
	 * set_error
	 *
	 * Set an error message
	 *
	 * @return void
	 **/
	public function set_error($error) {
		$this->errors[$error] = $error;

		return $error;
	}
	/**
	 * errors
	 *
	 * Get the error message
	 *
	 * @return void
	 **/
	public function errors() {
		$_output = '';
		foreach ($this->errors as $error)
		{
			$_output .= $error . '<br>';
		}

		return $_output;
	}
	/**
	 * set_message
	 *
	 * Set a message
	 *
	 * @return void
	 **/
	public function set_message($message) {
		$this->messages[$message] = $message;

		return $message;
	}

	/**
	 * messages
	 *
	 * Get the messages
	 *
	 * @return void
	 **/
	public function messages() {
		$_output = '';
		foreach ($this->messages as $message)
		{
			$_output .= $message . '<br>';
		}

		return $_output;
	}
	
	public function add_student($student_data=array()) {
		
		if( isset($student_data['name']) && isset($student_data['age']) && isset($student_data['mathmarks'])&& isset($student_data['sciencemarks'])&& isset($student_data['englishmarks'])){
			$student_info=array('name'=>$student_data['name'],
								'age'=>$student_data['age']);
			
			$this->db->insert('student_info', $student_info);
			
			$student_id=$this->db->insert_id();	
			
			$student_marks=array('user_id'=>$student_id,
								'math_marks'=>$student_data['mathmarks'],
								'science_marks'=>$student_data['sciencemarks'],
								'english_marks'=>$student_data['englishmarks']);			
			
			$this->db->insert('marks', $student_marks);		
			
			return "Student Added Successfully!!";
		}
		return false;
	}
	
	public function edit_student($student_data=array()) {
		
		$this->db->where('id', $student_data['student_id']);
		$check = $this->db->get('student_info');
		
		$valid_student= $check->result_array();
		
		if (empty($valid_student)) {
			
			return "Student is not Available!!";
			
		}else{
			
			if( isset($student_data['student_id']) && isset($student_data['name']) && isset($student_data['age']) && isset($student_data['mathmarks'])&& isset($student_data['sciencemarks'])&& isset($student_data['englishmarks'])){
				
				$student_info=array('name'=>$student_data['name'],
									'age'=>$student_data['age']);
				
				$this->db->where('id', $student_data['student_id'])->update('student_info', $student_info);
				
				$student_marks=array('math_marks'=>$student_data['mathmarks'],
									'science_marks'=>$student_data['sciencemarks'],
									'english_marks'=>$student_data['englishmarks']);			
				
				$this->db->where('user_id', $student_data['student_id'])->update('marks', $student_marks);
				
				return "Student Updated Successfully!!";
			}
		}		
	}
	
	public function allstudents($id=false) {
			
		$this->db->select('*');
		$this->db->from('student_info');
		$this->db->join('marks', 'marks.user_id = student_info.id');
		$query = $this->db->get();
		return $query->result_array();
		
	}
	
}