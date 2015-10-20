<?php

class QuestionG_model extends CI_Model {
	var $tablename = 'question';

	function add()
	{
		$datainsert = array(
			'group_id' => isset($_POST['group_id']) ? $_POST['group_id'] : "",
			'title' => 	isset($_POST['title']) ? $_POST['title'] : "",
			'short' => 	isset($_POST['short']) ? $_POST['short'] : "",
			'content' => 	isset($_POST['content']) ? $_POST['content'] : "",
			'is_show' 	=> '1',
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
			$datainsert['date_create'] = strtotime(date('d-m-Y'));
			if(isset($_POST['picture']) && $_POST['picture'] != "") {
				$datainsert['picture'] = $_POST['picture'];
				//$this->lib->decodeAndReturnFileFromSession('filesupload', './uploads/userImg/');
			}
			if($this->db->insert($this->tablename, $datainsert)) {
				return true;
			}
		}
	}
	function deleteQuestion()
	{
		if(isset($_POST['id']) && $_POST['id'] != "" && is_numeric($_POST['id'])) {
			$id = $_POST['id'];
			$this->db->delete($this->tablename, array('id' => $id));

		}
	}
	function loadQuestion()
	{
		$sql = "SELECT DISTINCT *
                    FROM {$this->tablename} as t WHERE 1=1 {$this->wherequery()}";
		$total = $this->db->query($sql);
		$sql .= " {$this->paging()}";
		$result = $this->db->query($sql);
		$result_return = array();
		foreach($result->result_array() as $row){
			$row = array(
				'id'                => $row['id'],
				'title'             => $this->lib->unescape($row['title']),
				'title_unsigned'    => $this->lib->unescape($row['title_unsigned']),
				'description'       => $this->lib->unescape($row['description']),
				'content'           => $this->lib->unescape($row['content']),
				'created'           => $row['created'],
				'urlPicture'        => $row['urlPicture'],
				'views'             => $row['views'],
				'featured'          => $row['featured'],
				'status'            => $row['status']
			);
			$result_return[] = $row;
		}

		$_POST['paging']['pages'] = ceil($total->num_rows() / $_POST['paging']['rowPerPage']);

		return array(
			'paging' => isset($_POST['paging']) ? $_POST['paging'] : array(),
			'data'   => $result_return
		);
	}
}