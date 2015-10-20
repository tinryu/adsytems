<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Lib {
    public function __construct() {
        $this->CI =& get_instance();
    }
    /*Chống sqlinjection*/
    function escape($str) {
        $str = trim($str);

        if (is_string($str)) {
            $str = htmlentities($str, ENT_QUOTES, 'utf-8');
        } elseif (is_bool($str)) {
            $str = ($str === FALSE) ? 0 : 1;
        } elseif (is_null($str)) {
            $str = 'NULL';
        }
        return $str;
    }
    function unescape($str){
        $str = trim($str);
        $str = html_entity_decode($str, ENT_QUOTES, 'utf-8');
        return $str;
    }
    function arrayTostring($array){
        $tmp = '';
        foreach($array as $v){
            $tmp .= $tmp ==''? $v :','.$v;
        }
        return $tmp;
    }
    /*tạo chuỗi ngầu nhiên*/
    function randomString($length) {
        $valid_chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
        $random_string = "";
        $num_valid_chars = strlen($valid_chars);
        for ($i = 0; $i < $length; $i++) {
            $random_pick = mt_rand(1, $num_valid_chars);
            $random_char = $valid_chars[$random_pick - 1];
            $random_string .= $random_char;
        }
        return $random_string;
    }

    /*Mã hóa*/
    function hashPass($str){
        $md5 = md5($str);
        $md5 = str_replace("0","z",$md5);
        $md5 = str_replace("b","2",$md5);
        $md5 = str_replace("7","0",$md5);
        return $md5;
    }
    /* input is a $_SESSION['abc'] have base64 encoded file,and directory on server where you want to save file  */
    function encode_base64_img($filePath){
         $im = @file_get_contents($filePath);
         $im = base64_encode($im);
         return $im;
    }
    function decodeAndReturnFileFromSession($sessionname,$server_dir){
        /*file path include filename like C:/asdsad/file.jpg */
        @session_save_path(APPPATH.'session_store/');
        @session_start();
        $session = $_SESSION[$sessionname];
        $img     = $session['file'];
        $img     = str_replace('data:image/png;base64,', '', $img);
        $img     = str_replace(' ', '+', $img);
        $img     = base64_decode($img);
        $success = @file_put_contents($server_dir.$session['filename'], $img);
        CI::$APP->load->library('image_lib');
        	//cropped thumbnail
        $link_thumb = $server_dir.'thumbimg/';
        if (!file_exists($link_thumb)) {
            mkdir($link_thumb, 0777);
        }
        $config['image_library'] = 'gd2';
        $config['source_image'] = $server_dir.$session['filename'];
        $config['new_image']	= $server_dir.'thumbimg/'.$session['filename'];
        $config['maintain_ratio'] = TRUE;
        $config['width'] = 250;
        $config['height'] = 250;

        CI::$APP->image_lib->initialize($config);
        CI::$APP->image_lib->resize();
        CI::$APP->image_lib->clear();
        @session_unset($_SESSION[$sessionname]);
        return true;
    }
    function decodeAndReturnFilesFromSessionProduct($sessionImg,$server_dir){
        $session = $sessionImg;
        $img     = $session['file'];
        $img     = str_replace('data:image/png;base64,', '', $img);
        $img     = str_replace(' ', '+', $img);
        $img     = base64_decode($img);
        $success = file_put_contents($server_dir.$session['filename'], $img);
        $this->CI->load->library('image_lib');
        	//cropped thumbnail
        if (!file_exists($server_dir.'thumbimg/')) {
            @mkdir($server_dir.'thumbimg/', 0777);
        }
        //$config_thumb = json_decode(IMG_PRODUCT_UPLOAD_OPTION);
        $config['image_library'] = 'gd2';
        $config['source_image'] = $server_dir.$session['filename'];
        $config['new_image']	= $server_dir.'thumbimg/'.$session['filename'];
        $config['maintain_ratio'] = TRUE;
        $config['width'] = 50;
        $config['height'] = 50;
        $this->CI->image_lib->initialize($config);
        $this->CI->image_lib->resize();
        $this->CI->image_lib->clear();
        if (!file_exists($server_dir.'thumbimg_mini/')) {
            @mkdir($server_dir.'thumbimg_mini/', 0777);
        }
        $config['image_library'] = 'gd2';
        $config['source_image'] = $server_dir.$session['filename'];
        $config['new_image']	= $server_dir.'thumbimg_mini/'.$session['filename'];
        $config['maintain_ratio'] = TRUE;
        $config['width'] = 50;
        $config['height'] = 50;
        $this->CI->image_lib->initialize($config);
        $this->CI->image_lib->resize();
        $this->CI->image_lib->clear();
        return true;
    }

    /*kiểm tra quyền truy cập đối với action của controller */
    function isAccess($controller,$action){
        if($this->CI->session->userdata('objlogin')){
            $session = $this->CI->session->userdata('objlogin');
            $permissions = $session['permissions'];
            foreach($permissions as $perm){
                if(strtolower($perm['c']) == trim(strtolower($controller))){
                    if(is_array($perm['a']) && count($perm['a']) > 0){
                          if(in_array(trim($action),$perm['a'])){
                              return true;
                          }
                    }
                }
            }
        }
        return false;
    }
    /*Truyền vào tên file abc.jpg => trả ra 1 object gồm tên và đuôi file */
    function getNameAndExtFile($fileFullName) {
        $temp = explode('.', $fileFullName);
        $ext  = array_pop($temp);
        $name   = implode('.', $temp);
        return array(
            'name' => $name,
            'ext'  => $ext
        );
    }
    /*Kiểm tra đường dẫn folder nếu chưa có folder thì tạo*/
    function checkAndCreateFolder($targetDir) {
        if (!file_exists($targetDir)) {
            @mkdir($targetDir, 0777);
        }
    }

    /* hỗ trợ tạo nhanh mấy cái SQL,thực ra CI nó có hết rồi, tại màu mè thích viết câu sql nên phải làm mí cái này */
    /*START*/
    function makeLimitSQL($startpage,$limit){
        $sql_limit = '';
        if (isset($limit) && $limit != "") {
            $limit = (int)$limit;
            $startpage = ($startpage > 1) ? $startpage : 1;
            if ($limit > 0) {
                $start     = isset($startpage) ? (((int)$startpage - 1) * $limit) : 0;
                $sql_limit = " LIMIT  {$start}, {$limit} ";
            }
        }
        return $sql_limit;
    }
    function makeOrderSQL($field,$sort){
        $field = checkVariable($field,false);
        $sort = checkVariable($sort,false);
        $sql_order = '';
        if($field != false && $sort != false){
            $sql_order .=" order by {$field} {$sort} ";
        }
        return $sql_order;
    }
    /*END*/

    /*truyền vào tổng số record, số record trên 1 trang, và trang hiện tại => nhận dc mảng chứa các thông số cần thiết phân trang */
    function makePagination($totalRow,$limitPerRow,$currentPage)
    {
        $pagination                 = array();
        $pagination['totalRows']    = (int)checkVariableNumeric($totalRow,0);
        $pagination['limitPerRows'] = (int)checkVariableNumeric($limitPerRow,2);
        $pagination['totalPages']   = ceil((int)$totalRow / (int)$limitPerRow);
        $pagination['currentPage']  = (int)checkVariableNumeric($currentPage,1);
        return $pagination;
    }
    /*hàm tạo tên không dấu, nếu muốn tạo tên ko dấu chữ thường thì $tolower = TRUE*/
    function khongDau($str,$space = false)
    {
        if (!$str)
            return FALSE;
        $unicode = array(
            'a' => 'á|à|ả|ã|ạ|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ',
            'A' => 'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ằ|Ẳ|Ẵ|Ặ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
            'd' => 'đ',
            'D' => 'Đ',
            'e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
            'E' => 'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
            'i' => 'í|ì|ỉ|ĩ|ị',
            'I' => 'Í|Ì|Ỉ|Ĩ|Ị',
            'o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
            'O' => 'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
            'u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
            'U' => 'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
            'y' => 'ý|ỳ|ỷ|ỹ|ỵ',
            'Y' => 'Ý|Ỳ|Ỷ|Ỹ|Ỵ'
        );;
        foreach ($unicode as $khongdau => $codau) {
            $arr = explode("|", $codau);
            $str = str_replace($arr, $khongdau, $str);
        }
        
        $str = str_replace("?", "", $str);
        $str = str_replace("&", "", $str);
        $str = str_replace("'", "", $str);
        $str = str_replace("\\", "", $str);
        $str = str_replace(" ", " ", $str);
        $str = trim($str);
        if($space == false)
            $str = str_replace(" ", "-", $str);
        return $str;
    }

}

/* End of file Someclass.php */