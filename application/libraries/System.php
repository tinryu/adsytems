<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class System
{
    private $CI;
    function __construct(){
        $this->CI = &get_instance();
    }
    function viewHTML($ten_templace,$MangDuLieuThem = array()){
        $ses = CI::$APP->session->userdata('username');
        $nameU = isset($ses) ? $ses : '';
        $MangDuLieuThem['nameU'] = $nameU;
        $MangDuLieuThem['dir_sever'] = base_url();
        $MangDuLieuThem['dir_templace'] = base_url('application/views/temp');
        $MangDuLieuThem['dir_image'] = base_url('application/views/temp/image');
        $MangDuLieuThem['dir_vendor'] = base_url('vendor');
        /*round 1 (insert data)*/
        $MangDuLieuChinh = array();
        $MangDuLieuChinh['title_page'] = 'Trang không title';
        $MangDuLieuChinh['main_content'] = $this->CI->load->view($ten_templace,$MangDuLieuThem,true);
        $MangDuLieuChinh['main_header'] = $this->CI->load->view('includes/header',array(),true);
        $MangDuLieuChinh['main_footer'] = $this->CI->load->view('includes/footer',array(),true);
        $MangDuLieuChinh['main_menu'] = $this->get_menu();
        /*round 2 (insert data)*/
        //CI::$APP->load->view('');
        $MangDuLieuChinh = array_merge($MangDuLieuChinh,$MangDuLieuThem);
        return CI::$APP->load->view('layout',$MangDuLieuChinh);
    }
    function popupHTML($ten_templace,$MangDuLieuThem = array()){
        $ses = CI::$APP->session->userdata('username');
        $nameU = isset($ses) ? $ses : '';
        $MangDuLieuThem['nameU'] = $nameU;
        $MangDuLieuThem['dir_sever'] = base_url();
        $MangDuLieuThem['dir_templace'] = base_url('application/views/temp');
        $MangDuLieuThem['dir_image'] = base_url('application/views/temp/image');
        $MangDuLieuThem['dir_vendor'] = base_url('vendor');
        /*round 1 (insert data)*/
        $MangDuLieuChinh = array();
        $MangDuLieuChinh['title_page'] = 'Trang không title';
        $MangDuLieuChinh['main_content'] = $this->CI->load->view($ten_templace,$MangDuLieuThem,true);
        /*round 2 (insert data)*/
        //CI::$APP->load->view('');
        $MangDuLieuChinh = array_merge($MangDuLieuChinh,$MangDuLieuThem);
        return CI::$APP->load->view('popupHtml',$MangDuLieuChinh);
    }
    function print_arr($array){
        echo "<div style=\"background:#ffffff; color:#000000\">";
        echo "<pre>";
        print_r($array);
        echo "</pre>";
        echo "</div>";
    }
    function is_logged()
    {
        $is_logged_in = CI::$APP->session->userdata('is_logged_in');
        if(!isset($is_logged_in) || $is_logged_in != true)
        {
            echo 'You don\'t have permission to access this page. <a href="'.base_url().'user">Login</a>';
            redirect(base_url().'user');
            die();
            //$this->load->view('login_form');
        }
    }
    //-----------------get_menu_admin
    function get_menu(){
        $menu="";
        $menu .= "<li class='header'>MAIN NAV</li>";
        $arr_menu = array();
        $sql = "select * from admin_menu where is_show=1 order by show_order desc, date_create asc";
        $result = $this->CI->db->query($sql);
        foreach ($result->result_array() as $row) {
            $row["arr_title"] = unserialize($row["arr_title"]);
            $arr_menu[$row["parent_id"]][$row["menu_id"]] = $row;
        }

        if ($result->num_rows() <= 0) return FALSE;
        foreach ($arr_menu[0] as $main) {
            $main["title"] = $main["arr_title"]['vi'];
            $main["link"] = "";
            //$this->print_arr($main["arr_title"]['vi']); die();
            $menu .= "<li class='treeview'>";
            $menu .= "<a title='".$main["arr_title"]["vi"]."' href='".$main['link']."'>
                        <i class='fa ".$main["icon_menu"]."'></i> ".$main["arr_title"]['vi']."
                        <i class='fa fa-angle-left pull-right'></i>
                    </a>";
                $menu .= "<ul class='treeview-menu'>";
                foreach($arr_menu[$main["menu_id"]] as $sub){
                        $sub["title"] = $sub["arr_title"]["vi"];
                        $sub["link"] = "";
                        //$this->print_arr($sub["arr_title"]['vi']); die();
                        $menu .= "<li>";
                        $menu .= "<a title='".$sub["arr_title"]['vi']."' href='".$sub['link']."'>
                                <i class='fa ".$sub["icon_menu"]."'></i>
                                <span class='title'>".$sub["arr_title"]['vi']."</span>
                            </a>";
                        $menu .= "</li>";
                }
                $menu .= "</ul>";
            $menu .= "</li>";
        }
        return $menu;

    }
    function get_menu_admin (){
        $menu="";
        $menu .= "<li class='header'>MAIN NAV</li>";
        $arr_menu = array();
        $sql = "select * from admin_menu where is_show=1 order by show_order desc, date_create asc";
        $result = $this->CI->db->query($sql);
        /*while($row = $ttH->db->fetch_row($result)){
            $row["arr_title"] = unserialize($row["arr_title"]);
            $arr_menu[$row["parent_id"]][$row["menu_id"]] = $row;
        }*/
        if ($result->num_rows() <= 0) return FALSE;
        foreach ($result->result_array() as $main) {
            $main["arr_title"] = unserialize($main["arr_title"]);
            $main["link"] = "";
            //$this->print_arr($main["arr_title"]['vi']); die();
            $menu .= "<li class='treeview'>";
            $menu .= "<a title='".$main["arr_title"]['vi']."' href='".$main['link']."'>
                        <i class='fa ".$main["icon_menu"]."'></i> ".$main["arr_title"]['vi']."
                        <i class='fa fa-angle-left pull-right'></i>
                    </a>";
            $this->sub_menu_admin($main, $menu, $main['parent_id']);
            $menu .= "</li>";
        }
        return $menu;

    }
    function  sub_menu_admin($parent,&$menu,$parent_id){
        $sqlsub = "select * from admin_menu where is_show=1 and parent_id = ".$parent_id." order by show_order desc, date_create asc";
        $resultsub = $this->CI->db->query($sqlsub);
        $menu .= "<ul class='treeview-menu'>";
        foreach($resultsub->result_array() as $sub){
            $sub["arr_title"] = unserialize($sub["arr_title"]);
            $sub["link"] = "";
            //$this->print_arr($sub["arr_title"]['vi']); die();
            $menu .= "<li>";
            $menu .= "<a title='".$sub["arr_title"]['vi']."' href='".$sub['link']."'>
                                <i class='fa ".$sub["icon_menu"]."'></i>
                                <span class='title'>".$sub["arr_title"]['vi']."</span>
                            </a>";
            $menu .= "</li>";
        }
        $menu .= "</ul>";
        return $menu;
    }
    //-----------------render select
    //=================select===============
    function render_select ($select_name="id", $array=array(), $cur="", $ext="",$arr_more=array(),$placeholder= "",$chosen = 0)
    {
        global $ttH;

        //$arr_cur = (!empty($cur)) ? explode(",",$cur) : array();
        $text = "<select $placeholder name=\"".$select_name."\" $arr_more> ";
        $text .= "<option value=\"\"></option>";
        if(isset($arr_more["title"]))
            /*$selected = (count($arr_cur) == 0) ? " selected='selected'" : " ";
            $text .= "<option value=\"\" ".$selected."> " . $arr_more["title"] . " </option>";*/
            $text .= "<option value=\"\"> " . $arr_more["title"] . " </option>";
        foreach($array as $key => $value)
        {
            $title = $chosen === 1 ? $title = $value['id'] : $title = $value['code'];
            if(is_array($value)){
                /*$selected = ($key == $cur) ? " selected='selected'" : " ";*/
                $disabled = "";
                $arr_tmp["is_disabled"] = 0;
                if(isset($arr_more["disabled"]) && $key == $arr_more["disabled"]){
                    $disabled = " disabled='disabled'";
                    $arr_tmp["is_disabled"] = 1;
                }
                //$text .= "<option value=\"".$key ."\" ".$selected.$disabled."> " . $value['title'] . " </option>";
                $text .= "<option value=\"".$title ."\" ".$disabled."> " . $value['title'] . " </option>";
                if(isset($value['arr_sub'])){
                    $text .= $this->select_op ($value['arr_sub'], $cur, '',$arr_more,$arr_tmp);
                }
            }else{
                //$selected = ($key == $cur) ? " selected='selected'" : " ";
                $disabled = "";
                if(isset($arr_more["disabled"]) && $key == $arr_more["disabled"]){
                    $disabled = " disabled='disabled'";
                }
                //$text .= "<option value=\"".$key ."\" ".$selected.$disabled."> " . $value . " </option>";
                $text .= "<option value=\"".$title ."\" ".$disabled."> " . $value . " </option>";
            }
        }
        $text .= "</select>";

        return $text;
    }
    function select_op ($array=array(), $cur="", $lv_text="",$arr_more=array(),$arr_tmp=array())
    {
        global $ttH;

        $text = '';

        $arr_tmp1 = array();

        $lv_text .= '|-- ';

        foreach($array as $key => $value)
        {
            if(is_array($value)){
                $selected = ($key == $cur) ? " selected='selected'" : "";
                $disabled = "";
                $arr_tmp1["is_disabled"] = 0;
                if((isset($arr_more["disabled"]) && $key == $arr_more["disabled"]) || $arr_tmp["is_disabled"] == 1){
                    $disabled = " disabled='disabled'";
                    $arr_tmp1["is_disabled"] = 1;
                }
                $text .= "<option value=\"".$key ."\" ".$selected.$disabled."> " . $lv_text.$value['title'] . " </option>";
                if(isset($value['arr_sub'])){
                    $text .= $this->select_op ($value['arr_sub'], $cur, $lv_text,$arr_more,$arr_tmp1);
                }
            }else{
                $selected = ($key == $cur) ? " selected='selected'" : "";
                $disabled = "";
                if((isset($arr_more["disabled"]) && $key == $arr_more["disabled"]) || $arr_tmp["is_disabled"] == 1){
                    $disabled = " disabled='disabled'";
                }
                $text .= "<option value=\"".$key ."\" ".$selected.$disabled."> " . $value . " </option>";
            }
        }

        return $text;
    }
    function select_district(){
        $sql    = "select title, code from location_district where is_show = 1 and lang='vi' order by title ASC , show_order DESC";
        $result = $this->CI->db->query($sql);
        return $this->render_select('district', $result->result_array(),'','' ,'id="district" class="chosen-select"','data-placeholder="Choose a district"');
    }
    function select_ward(){
        $sql    = "select title, code from location_ward where is_show = 1 and lang='vi' order by title ASC , show_order DESC";
        $result = $this->CI->db->query($sql);
        return $this->render_select('ward', $result->result_array(),'','' ,'id="ward" class="chosen-select"', 'data-placeholder="Choose a ward"');
    }
    function select_province(){
        $sql    = "select code, title from location_province where is_show = 1 and lang='vi' order by title ASC , show_order DESC";
        $result = $this->CI->db->query($sql);
        return $this->render_select('city', $result->result_array(),'','' ,'id="city" class="chosen-select"', 'data-placeholder="Choose a province"');
    }
    function select_categolis($namedb, $name_select,$placeholder){
        $sql    = "select id, title from ".$namedb." where is_show = 1 and lang='vi' order by title ASC , show_order DESC";
        $result = $this->CI->db->query($sql);
        return $this->render_select($name_select, $result->result_array(),'','' ,'id="'.$name_select.'" class="chosen-select"', 'data-placeholder="Choose a '.$placeholder.'"', 1);
    }
    function select_relate($namedb, $name_select,$placeholder){
        $sql    = "select id, title from ".$namedb." where is_show = 1 and lang='vi' order by title ASC , show_order DESC";
        $result = $this->CI->db->query($sql);
        return $this->render_select($name_select.'[]', $result->result_array(),'','' ,'id="'.$name_select.'"multiple class="chosen-select"', 'data-placeholder="Choose a '.$placeholder.'"', 1);
    }

}