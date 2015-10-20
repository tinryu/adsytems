<?php

class Question_model extends CI_Model {
	var $tablename = 'question';

	function add()
	{
		$datainsert = array(
			'group_id' => isset($_POST['group_id']) ? $_POST['group_id'] : "",
			'group_nav' => isset($_POST['group_nav']) ? $this->lib->arrayTostring($_POST['group_nav']) : "",
			'title' => 	isset($_POST['title']) ? $_POST['title'] : "",
			'short' => 	isset($_POST['short']) ? $_POST['short'] : "",
			'content' => 	isset($_POST['content']) ? $_POST['content'] : "",
			'is_show' 	=> '1',
		);

		//print_arr($datainsert); die();
		/*edit user*/
		if(isset($_POST['id']) && $_POST['id'] != ""){
			$datainsert['date_update'] = strtotime(date('d-m-Y'));
			if(isset($_POST['picture']) && $_POST['picture'] != "") {
				/*remove old file*/
				$arr_pic = $this->loadUpdate($_POST['id']);
				@unlink('./uploads/quesImg/' . $arr_pic['picture']);
			}
			if($this->db->update($this->tablename, $datainsert,array('id'=>$_POST['id']))) {
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
		$sql = "SELECT DISTINCT * FROM {$this->tablename} as t WHERE 1=1 ";
		$result = $this->db->query($sql);
		$result_return = array();
		foreach($result->result_array() as $row){
			$row = array(
				'id'                => $row['id'],
				'title'             => $this->lib->unescape($row['title']),
				'picture'	        => $row['picture'],
				'short'       		=> $this->lib->unescape($row['short']),
				'content'           => $this->lib->unescape($row['content']),
				'is_show'           => $row['is_show'],
				'show_order'        => $row['show_order'],
				'date_create'       => date('d/m/Y', $row['date_create']),
				'date_update'       => date('d/m/Y', $row['date_update']),
			);
			$result_return[] = $row;
		}
		return $result_return;
	}
	function loadUpdate($id)
	{
		$sql = "SELECT DISTINCT * FROM {$this->tablename} as t WHERE 1=1 and id= {$id} ORDER BY show_order DESC, date_create DESC ";
		$result = $this->db->query($sql);
		foreach($result->result_array() as $row){
			$row = array(
				'categoris' => $this->select_categolis($id,'question_group','group_id','question group'),
				'related' => $this->select_relate($id,'question_group','group_nav','question group related'),
				'id'                => $row['id'],
				'title'             => $this->lib->unescape($row['title']),
				'picture'	        => $row['picture'],
				'short'       		=> $this->lib->unescape($row['short']),
				'content'           => $this->lib->unescape($row['content']),
				'is_show'           => $row['is_show'],
				'show_order'        => $row['show_order'],
				'date_create'       => date('d/m/Y', $row['date_create']),
				'date_update'       => date('d/m/Y', $row['date_update']),
			);
		}
		return $row;
	}
	function select_categolis($id, $namedb, $name_select,$placeholder){
		$sql    = "select id, title from ".$namedb." where is_show = 1 and lang='vi' and id= {$id} order by title ASC , show_order DESC";
		$result = $this->db->query($sql);
		return $this->system->render_select($name_select, $result->result_array(),'','' ,'id="'.$name_select.'" class="chosen-select"', 'data-placeholder="Choose a '.$placeholder.'"', 1);
	}
	function select_relate($id,$namedb, $name_select,$placeholder){
		$sql    = "select id, title from ".$namedb." where is_show = 1 and lang='vi' and id= {$id} order by title ASC , show_order DESC";
		$result = $this->db->query($sql);
		return $this->system->render_select($name_select.'[]', $result->result_array(),'','' ,'id="'.$name_select.'"multiple class="chosen-select"', 'data-placeholder="Choose a '.$placeholder.'"', 1);
	}
}