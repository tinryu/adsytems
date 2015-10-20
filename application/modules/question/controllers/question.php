<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Question extends CI_Controller {

	public  function __construct(){
		parent::__construct();
		$this->load->model('question_model');
	}
	function index(){
		$ques = $this->question_model->loadQuestion();
		$data = array(
			'title_page'=> 'Manage question',
			'main_content' => $this->load->view('manage_question',array(
				'data' => json_encode($ques),
				'dir_js' => base_url('application/modules/question/views'),
				'categoris' => $this->system->select_categolis('question_group','group_id','question group'),
			),true)
		);
		$this->system->viewHTML('manage_question',$data);
	}
	public function add()
	{
		if(isset($_POST['save'])){
			$this->question_model->add();
		}
		$data = array(
			'title_page'=> 'Add question',
			'main_content' => $this->load->view('add_question',array(
				'categoris' => $this->system->select_categolis('question_group','group_id','question group'),
				'related' => $this->system->select_relate('question_group','group_nav','question group related')
			),true)
		);
		$this->system->viewHTML('add_question',$data);
	}
	public function edit($id = ''){
		if(isset($_POST['save'])){
			$this->question_model->add();
			//exit();
		}
		else{
			$arr = $this->question_model->loadUpdate($id);
			$data = array(
				'title_page'=> 'Edit question',
				'main_content' => $this->load->view('edit_question',$arr,true)
			);
			$this->system->popupHTML('edit_question',$data);
		}
	}
	public function delete()
	{
		echo $this->question_model->deleteQuestion();
	}
	public function load(){
		echo json_encode($this->question_model->loadQuestion());
		return true;
	}

}
