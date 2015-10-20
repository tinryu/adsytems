<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	public  function __construct(){
		parent::__construct();
	}
	function index(){
		$data = array(
			'dir_sever' => base_url(),
			'dir_templace' => base_url('application/views/temp'),
			'dir_image' => base_url('application/views/temp/image'),
			'dir_vendor' => base_url('vendor'),
			'title_page'=> 'login',
			'main_content' => $this->load->view('user',array(),true)
		);
		$this->load->view('user',$data);
	}
	function check_login()
	{
		$this->load->model('user_model');
		$query = $this->user_model->validate();
		if($query)
		{
			$data = array(
				'username' => $this->input->post('username'),
				'is_logged_in' => true
			);
			$this->session->set_userdata($data);
			header("Location:". base_url()."admin");
		}
		else
		{
			redirect(base_url().'user');
		}
	}

	function sign_up()
	{
		$this->system->is_logged();
		$data = array(
			'title_page'=> 'Sign up',
			'main_content' => $this->load->view('sign_up',array(
				'select_ditrict' => $this->system->select_district(),
				'select_ward' => $this->system->select_ward(),
				'select_province' => $this->system->select_province()
			),true)
		);
		$this->system->viewHTML('user',$data);
	}
	function create_member()
	{
		$this->system->is_logged();
		$data = array(
			'title_page'=> 'Add User',
			'main_content' => $this->load->view('sign_up',array(),true)
		);

			$this->load->model('user_model');
			if($query = $this->user_model->addUser())
			{
				header("Location:". base_url()."admin");
			}
			else
			{
				$this->system->viewHTML('sign_up',$data);
			}

	}
	function logout()
	{
		$this->session->unset_userdata('username');
		$this->session->unset_userdata('is_logged_in');
		$this->session->sess_destroy();
		$this->index();
	}

}
