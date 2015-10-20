<?php

class User_model extends CI_Model {
	var $tablename = 'admin_user';
	function validate()
	{
		$username = $this->input->post('username');
		$password = md25($this->input->post('password'));
		$query = $this->db->query('SELECT * FROM admin_user WHERE username="'.$username.'" and password="'.$password.'" ');

		if($query->num_rows() == 1)
		{
			return true;
		}
	}
	function addUser()
	{
		$datainsert = array(
			'email' => 		isset($_POST['email']) ? $_POST['email'] : "",
			'username' => 	isset($_POST['username']) ? $_POST['username'] : "",
			'password' => 	isset($_POST['password']) ? md25($_POST['password']) : "",
			'full_name' => 	isset($_POST['full_name']) ? $_POST['full_name'] : "",
			'birthday'  => 	isset($_POST['birthday']) ? strtotime($_POST['birthday']) : "",
			'sex'       => 	isset($_POST['sex']) ? $this->lib->escape($_POST['sex']) : "",
			'mobile'    => 	isset($_POST['mobile']) ? $this->lib->escape($_POST['mobile']) : "",
			'address'   => 	isset($_POST['address']) ? $this->lib->escape($_POST['address']) : "",
			'ward'     => 	isset($_POST['ward']) ? $_POST['ward'] : "",
			'district'  => 	isset($_POST['district']) ? $_POST['district'] : "",
			'city'      => 	isset($_POST['city']) ? $_POST['city'] : "",
			'status'    => 	isset($_POST['status']) ? $_POST['status'] : 0,
			'rid'       => 	'1',
			'rd'		=> $this->lib->randomString(10)
		);

		//print_arr($datainsert); die();
		/*edit user*/
		if(isset($_POST['uid']) && $_POST['uid'] != ""){
			if(isset($_POST['picture']) && $_POST['picture'] != "") {
				$datainsert['picture'] = $_POST['picture'];
				if($this->lib->decodeAndReturnFileFromSession('filesupload', './uploads/userImg/')){
					/*remove old file*/
					$user = $this->loadUser($_POST['uid']);
					@unlink('./uploads/userImg/'.$user[0]['picture']);
					@unlink('./uploads/userImg/thumbimg/'.$user[0]['picture']);
				};
			}
			if($this->db->update($this->tablename, $datainsert,array('uid'=>$_POST['uid']))) {
				return true;
			}
		} else {
			$datainsert['created'] = strtotime(date('d-m-Y'));
			if(isset($_POST['picture']) && $_POST['picture'] != "") {
				$datainsert['picture'] = $_POST['picture'];
				//$this->lib->decodeAndReturnFileFromSession('filesupload', './uploads/userImg/');
			}
			if($this->db->insert($this->tablename, $datainsert)) {
				return true;
			}
		}
	}
}