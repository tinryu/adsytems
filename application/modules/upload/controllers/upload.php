<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Upload extends CI_Controller {
	var $dir_userImg = './uploads/userImg/';
	var $dir_quesImg = './uploads/quesImg/';



	public  function __construct(){
		parent::__construct();

	}
	function index()
	{
		$this->system->is_logged();
		$ses = $this->session->userdata('username');
		$nameU = isset($ses) ? $ses : '';
		$data = array(
			'dir_sever' => base_url(),
			'dir_templace' => base_url('application/views/temp'),
			'dir_image' => base_url('application/views/temp/image'),
			'dir_vendor' => base_url('vendor'),
			'title_page'=> 'ADMIN',
		);
		//$this->system->viewHTML('upload',$data);
		$this->load->view('upload',$data);
	}

	public  function do_upload_user(){
        // Make sure file is not cached (as it happens for example on iOS devices)
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        // 5 minutes execution time
        @set_time_limit(5 * 60);
		$targetDir = $this->dir_userImg;
		if (!file_exists($targetDir)) {
			mkdir($targetDir, 0777);
		}
        $cleanupTargetDir = TRUE; // Remove old files
        $maxFileAge = 5 * 3600; // Temp file age in seconds
        // Create target dir
        if (!file_exists($targetDir)) {
            @mkdir($targetDir);
        }

        // Get a file name
        if (isset($_REQUEST["name"])) {
            $fileName = $_REQUEST["name"];
        } elseif (!empty($_FILES)) {
            $fileName = $_FILES["file"]["name"];
        } else {
            $fileName = uniqid("file_");
        }

        $filePath = $targetDir . DIRECTORY_SEPARATOR . $fileName;
        // Chunking might be enabled
        $chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
        $chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 0;
        // Remove old temp files
        if ($cleanupTargetDir) {
            if (!is_dir($targetDir) || !$dir = opendir($targetDir)) {
                die('{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "Failed to open temp directory."}, "id" : "id"}');
            }

            while (($file = readdir($dir)) !== false) {
                $tmpfilePath = $targetDir . DIRECTORY_SEPARATOR . $file;

                // If temp file is current file proceed to the next
                if ($tmpfilePath == "{$filePath}.part") {
                    continue;
                }

                // Remove temp file if it is older than the max age and is not the current file
                if (preg_match('/\.part$/', $file) && (filemtime($tmpfilePath) < time() - $maxFileAge)) {
                    @unlink($tmpfilePath);
                }
            }
            closedir($dir);
        }
        // Open temp file
        if (!$out = @fopen("{$filePath}.part", $chunks ? "ab" : "wb")) {
            die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
        }

        if (!empty($_FILES)) {
            if ($_FILES["file"]["error"] || !is_uploaded_file($_FILES["file"]["tmp_name"])) {
                die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
            }

            // Read binary input stream and append it to temp file
            if (!$in = @fopen($_FILES["file"]["tmp_name"], "rb")) {
                die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
            }
        } else {
            if (!$in = @fopen("php://input", "rb")) {
                die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
            }
        }

        while ($buff = fread($in, 4096)) {
            fwrite($out, $buff);
        }

        @fclose($out);
        @fclose($in);

        // Check if file has been uploaded
        if (!$chunks || $chunk == $chunks - 1) {
            // Strip the temp .part suffix off
            rename("{$filePath}.part", $filePath);

			/*encode and save to session */
			$im =  $this->lib->encode_base64_img($filePath);
			/*@session_save_path(APPPATH . 'session_store/');
			@session_start();
			$_SESSION[$this->session_userImg] = array(
				'filename' => $fileName,
				'file'     => $im,
				'filepath' => $filePath
			);*/

			echo $im;
			exit();
        }
        // Return Success JSON-RPC response
        die('{"jsonrpc" : "2.0", "result" : null, "id" : "id"}');
	}
	public  function do_upload_ques(){
        // Make sure file is not cached (as it happens for example on iOS devices)
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        // 5 minutes execution time
        @set_time_limit(5 * 60);
		$targetDir = $this->dir_quesImg;
		if (!file_exists($targetDir)) {
			mkdir($targetDir, 0777);
		}
        $cleanupTargetDir = TRUE; // Remove old files
        $maxFileAge = 5 * 3600; // Temp file age in seconds
        // Create target dir
        if (!file_exists($targetDir)) {
            @mkdir($targetDir);
        }

        // Get a file name
        if (isset($_REQUEST["name"])) {
            $fileName = $_REQUEST["name"];
        } elseif (!empty($_FILES)) {
            $fileName = $_FILES["file"]["name"];
        } else {
            $fileName = uniqid("file_");
        }

        $filePath = $targetDir . DIRECTORY_SEPARATOR . $fileName;
        // Chunking might be enabled
        $chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
        $chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 0;
        // Remove old temp files
        if ($cleanupTargetDir) {
            if (!is_dir($targetDir) || !$dir = opendir($targetDir)) {
                die('{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "Failed to open temp directory."}, "id" : "id"}');
            }

            while (($file = readdir($dir)) !== false) {
                $tmpfilePath = $targetDir . DIRECTORY_SEPARATOR . $file;

                // If temp file is current file proceed to the next
                if ($tmpfilePath == "{$filePath}.part") {
                    continue;
                }

                // Remove temp file if it is older than the max age and is not the current file
                if (preg_match('/\.part$/', $file) && (filemtime($tmpfilePath) < time() - $maxFileAge)) {
                    @unlink($tmpfilePath);
                }
            }
            closedir($dir);
        }
        // Open temp file
        if (!$out = @fopen("{$filePath}.part", $chunks ? "ab" : "wb")) {
            die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
        }

        if (!empty($_FILES)) {
            if ($_FILES["file"]["error"] || !is_uploaded_file($_FILES["file"]["tmp_name"])) {
                die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
            }

            // Read binary input stream and append it to temp file
            if (!$in = @fopen($_FILES["file"]["tmp_name"], "rb")) {
                die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
            }
        } else {
            if (!$in = @fopen("php://input", "rb")) {
                die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
            }
        }

        while ($buff = fread($in, 4096)) {
            fwrite($out, $buff);
        }

        @fclose($out);
        @fclose($in);

        // Check if file has been uploaded
        if (!$chunks || $chunk == $chunks - 1) {
            // Strip the temp .part suffix off
            rename("{$filePath}.part", $filePath);

			/*encode and save to session */
			$im =  $this->lib->encode_base64_img($filePath);
			/*@session_save_path(APPPATH . 'session_store/');
			@session_start();
			$_SESSION[$this->session_userImg] = array(
				'filename' => $fileName,
				'file'     => $im,
				'filepath' => $filePath
			);*/

			echo $im;
			exit();
        }
        // Return Success JSON-RPC response
        die('{"jsonrpc" : "2.0", "result" : null, "id" : "id"}');
	}
















	/*=== 2 ham nay xu ly upload cua jqueryupload*/
	public function do_upload() {
		$upload_path_url = base_url() . 'uploads/';
		$config['upload_path'] = FCPATH . 'uploads/';
		$config['allowed_types'] = 'jpg|jpeg|png|gif';
		$config['max_size'] = '30000';

		$dir_thumb_image = $config['upload_path'].'/thumbs';

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload()) {
			//$error = array('error' => $this->upload->display_errors());
			//$this->load->view('upload', $error);

			//Load the list of existing files in the upload directory
			$existingFiles = get_dir_file_info($config['upload_path']);
			$foundFiles = array();
			$f=0;
			foreach ($existingFiles as $fileName => $info) {
				if($fileName!='thumbs'){//Skip over thumbs directory
					//set the data for the json array
					$foundFiles[$f]['name'] = $fileName;
					$foundFiles[$f]['size'] = $info['size'];
					$foundFiles[$f]['url'] = $upload_path_url . $fileName;
					$foundFiles[$f]['thumbnailUrl'] = $upload_path_url . 'thumbs/' . $fileName;
					$foundFiles[$f]['deleteUrl'] = base_url() . 'upload/deleteImage/' . $fileName;
					$foundFiles[$f]['deleteType'] = 'DELETE';
					$foundFiles[$f]['error'] = null;
					$f++;
				}
			}
			$this->output->set_content_type('application/json')->set_output(json_encode(array('files' => $foundFiles)));
		} else {
			$data = $this->upload->data();

			if(!is_dir($dir_thumb_image)){
				mkdir($config['upload_path'].'/thumbs', 0700,true);
			}
			// to re-size for thumbnail images un-comment and set path here and in json array
			$config = array();
			$config['image_library'] = 'gd2';
			$config['source_image'] = $data['full_path'];
			$config['create_thumb'] = TRUE;
			$config['new_image'] = $data['file_path'].'thumbs/';
			$config['maintain_ratio'] = TRUE;
			$config['thumb_marker'] = '';
			$config['width'] = 75;
			$config['height'] = 50;
			$this->load->library('image_lib', $config);
			$this->image_lib->resize();
			//set the data for the json array
			$info = new StdClass;
			$info->name = $data['file_name'];
			$info->size = $data['file_size'] * 1024;
			$info->type = $data['file_type'];
			$info->url = $upload_path_url . $data['file_name'];
			// I set this to original file since I did not create thumbs.  change to thumbnail directory if you do = $upload_path_url .'/thumbs' .$data['file_name']
			$info->thumbnailUrl = $upload_path_url . 'thumbs/' . $data['file_name'];
			$info->deleteUrl = base_url() . 'upload/deleteImage/' . $data['file_name'];
			$info->deleteType = 'DELETE';
			$info->error = null;
			$files[] = $info;
			//this is why we put this in the constants to pass only json data
			if (IS_AJAX) {
				echo json_encode(array("files" => $files));
				//this has to be the only data returned or you will get an error.
				//if you don't give this a json array it will give you a Empty file upload result error
				//it you set this without the if(IS_AJAX)...else... you get ERROR:TRUE (my experience anyway)
				// so that this will still work if javascript is not enabled
			} else {
				$file_data['upload_data'] = $this->upload->data();
				$this->load->view('upload/upload_success', $file_data);
			}
		}
	}
	public function deleteImage($file) {//gets the job done but you might want to add error checking and security
		$success = unlink(FCPATH . 'uploads/' . $file);
		$success = unlink(FCPATH . 'uploads/thumbs/' . $file);
		//info to see if it is doing what it is supposed to
		$info = new StdClass;
		$info->sucess = $success;
		$info->path = base_url() . 'uploads/' . $file;
		$info->file = is_file(FCPATH . 'uploads/' . $file);

		if (IS_AJAX) {
			//I don't think it matters if this is set but good for error checking in the console/firebug
			echo json_encode(array($info));
		} else {
			//here you will need to decide what you want to show for a successful delete
			$file_data['delete_data'] = $file;
			$this->load->view('admin/delete_success', $file_data);
		}
	}
}