<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: ryu
 * Date: 8/16/2015
 * Time: 1:00 PM
 */
    class Xtemp
    {
        private $CI;
        public function __construct(){
            $this->CI =  &get_instance();
        }
        public function parse($temp_name,$data = array()){
            $data = array(
                'dir_templace' => base_url('application/views/temp'),
                'dir_image' => base_url('application/views/temp/image'),
                'dir_vendor' => base_url('vendor/')
            );
            $this->CI->load->library('parser');
            $this->CI->parser->parse($temp_name, $data);
        }

    }
?>