<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	public  function __construct(){
		parent::__construct();
	}
	function index()
	{
		$this->system->is_logged();
		$data = array(
			'title_page'=> 'ADMIN',
			'main_content' => $this->load->view('admin',array(),true)
		);
		//tam thoi chua noi may cai phia tren nha
		//layyout tao lam ben system
		$this->system->viewHTML('admin',$data);
	}
}
