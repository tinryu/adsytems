<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Question_group extends CI_Controller {

	public  function __construct(){
		parent::__construct();
		$this->load->model('question_model');
	}
	function index(){

		$data = array(
			'dir_sever' => base_url(),
			'dir_templace' => base_url('application/views/temp'),
			'dir_image' => base_url('application/views/temp/image'),
			'dir_vendor' => base_url('vendor'),
			'title_page'=> 'login',
			'main_content' => $this->load->view('question',array(),true)
		);
		$this->load->view('question',$data);
	}
	public function add()
	{
		if(isset($_POST['add'])){
			$this->question_model->add();
		}
		$data = array(
			'title_page'=> 'Add question',
			'main_content' => $this->load->view('add_question',array(),true)
		);
		$this->system->viewHTML('add_question',$data);
	}
	public function edit($id){
		if(isset($_POST['saveArticle']) && $_POST['saveArticle'] != "" && $_POST['saveArticle'] == 'yes'){
			$this->marticle->addArticle();
			exit();
		}
		$data = array();
		$this->system->unset_uploadSession('filesupload_article');
		$mainData = array(
			'namepage'   => 'Sửa sản phẩm',
			'categories' => $this->marticle->getCategories(),
			'data'       => json_encode($this->marticle->loadArticles($id)),
			'templaceTiny:templaceTiny' => json_encode($this->marticle->getTemplaceTinymce()),
			'id'         => $id,
			'layout'     => LAYOUT_ADMIN
		);
		$this->system->parse('templace/article/article_edit.html',$data,$mainData);
	}
	public function delete()
	{
		echo $this->marticle->deleteArticle();
	}
	public function loadArticle(){
		echo json_encode($this->marticle->loadArticle());
		return true;
	}

}
